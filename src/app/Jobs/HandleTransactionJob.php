<?php

namespace App\Jobs;

use App\Actions\ValidateDebitTransactionAction;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class HandleTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $accountId;

    private $amount;

    private $typeId;

    /**
     * Create a new job instance.
     *
     * @param int $accountId
     * @param float $amount
     * @param int $typeId
     */
    public function __construct(int $accountId, float $amount, int $typeId)
    {
        $this->accountId = $accountId;
        $this->amount = $amount;
        $this->typeId = $typeId;
    }

    /**
     * Execute the job.
     *
     * @param ValidateDebitTransactionAction $validateDebitTransactionAction
     * @return void
     *
     * @throws \Exception
     */
    public function handle(ValidateDebitTransactionAction $validateDebitTransactionAction)
    {
        /** @var Account $account */
        $account = Account::query()->findOrFail($this->accountId);

        if ($this->typeId === TransactionType::ID_DEBIT) $validateDebitTransactionAction->execute($account, $this->amount);

        Transaction::query()->forceCreate([
            "account_id" => $account->id,
            "amount" => $this->amount,
            "type_id" => $this->typeId,
        ]);
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [new WithoutOverlapping($this->accountId)];
    }
}
