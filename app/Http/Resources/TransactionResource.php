<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="user-account-transaction")
 */
class TransactionResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Transaction
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @OA\Property(property="id", type="integer")
     * @OA\Property(property="type", type="string")
     * @OA\Property(property="amount", type="number")
     * @OA\Property(property="effectiveDate", type="string", description="2020-10-24T17:15:36.000000Z")
     */
    public function toArray($request)
    {
        return [
            "id" => $this->resource->id,
            "type" => $this->resource->type->name,
            "amount" => $this->resource->amount,
            "effectiveDate" => $this->resource->created_at,
        ];
    }
}
