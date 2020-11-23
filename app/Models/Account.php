<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @see Account::getBalanceAttribute()
 * @property float $balance
 *
 * @see Account::transactions()
 * @property Collection|Transaction[] $transactions
 * */
class Account extends Model
{
    const TABLE = "accounts";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getBalanceAttribute(): int
    {
        $creditTypeId = TransactionType::ID_CREDIT;

        return Transaction
            ::query()
            ->select([
                DB::raw("SUM(IF(`type_id` = $creditTypeId, amount, -amount)) as balance")
            ])
            ->where("account_id", $this->id)
            ->groupBy("account_id")
            ->first()
            ->balance ?? 0;
    }
}
