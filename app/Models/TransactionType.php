<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * */
class TransactionType extends Model
{
    const TABLE = "transaction_types";

    const ID_CREDIT = 1;
    const ID_DEBIT = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
