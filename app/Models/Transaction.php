<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $type_id
 * @property int $account_id
 * @property float $amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @see Transaction::type()
 * @property TransactionType $type
 *
 * @method static static|Builder query()
 * */
class Transaction extends Model
{
    const TABLE = "transactions";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    public function type(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    public static function handleDebit(int $accountId, float $amount): ?self
    {
        $creditTypeId = TransactionType::ID_CREDIT;
        $debitTypeId = TransactionType::ID_DEBIT;
        $table = static::TABLE;
        $date = Carbon::now();

        DB::affectingStatement("
            INSERT INTO $table (`account_id`, `type_id`, `amount`, `created_at`, `updated_at`)
            select $accountId, $debitTypeId, $amount, '$date', '$date'
            WHERE(
                SELECT SUM(IF(`type_id` = $creditTypeId, amount, -amount)) as balance FROM $table WHERE `account_id` = $accountId GROUP BY `account_id`
            ) >= $amount
        ");

        $id = DB::connection()->getPdo()->lastInsertId();

        return static::query()->find($id);
    }

    public static function handleCredit(int $accountId, float $amount): self
    {
        return static::query()->forceCreate([
            "account_id" => $accountId,
            "type_id" => TransactionType::ID_CREDIT,
            "amount" => $amount,
        ]);
    }
}
