<?php

namespace App\Actions;

use App\Exceptions\NotEnoughBalanceValidationException;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;

class ValidateDebitTransactionAction
{
    /**
     * @param Account $account
     * @param float $amount
     *
     * @return bool
     *
     * @throws \Exception
     * */
    public function execute(Account $account, float $amount): bool
    {
        if ($account->balance < $amount) throw new NotEnoughBalanceValidationException();

        return true;
    }
}
