<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NotEnoughBalanceValidationException extends ValidationException
{
    public function __construct(string $message = "Not enough balance.")
    {
        $validator = Validator::make([], []);
        $validator->errors()->add("balance", $message);
        parent::__construct($validator);
    }

}
