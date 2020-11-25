<?php

namespace App\Http\Controllers;

use App\Actions\ValidateDebitTransactionAction;
use App\Http\Resources\TransactionResource;
use App\Jobs\HandleTransactionJob;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Providers\AuthServiceProvider;
use Database\Seeders\AccountsTableSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserAccountTransactionsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/users/{user_id}/accounts/{account_id}/transactions",
     *      tags={"[Transactions]"},
     *      summary="Fetches transactions history",
     *      description="Fetches transactions history",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          description="Id of client",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="account_id",
     *          in="path",
     *          required=true,
     *          description="Id client account",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Transactions history",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Items(ref="#/components/schemas/user-account-transaction")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized. Not applied in current test mode",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. Not applied in current test mode",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found. Not applied in current test mode",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=429,
     *          description="Error messages",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Too Many Attempts.")
     *          )
     *      )
     * )
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        // some authorization logic
        // just an example. It could be much more complicated, of course
        // $this->authorize(AuthServiceProvider::USER_ACCOUNT_TRANSACTION_INDEX, $account);

        /**
         * @var Account $account
         * this is just for testing purpose. Real account instance would be retrieved via $request class
         * @see https://laravel.com/docs/8.x/routing#route-model-binding as an example
         * */
        $account = Account::query()->findOrFail(AccountsTableSeeder::TEST_ACCOUNT_ID);

        return TransactionResource::collection(
            $account->transactions()
                ->select(['*'])
                ->with(['type'])
                ->orderBy("id", "desc")
                ->paginate(
                    (int)$request->per_page, null, null, (int)$request->page
                )
        );
    }

    /**
     * @OA\Get(
     *      path="/api/users/{user_id}/accounts/{account_id}/transactions/{transaction_id}",
     *      tags={"[Transactions]"},
     *      summary="Fetches transaction by id",
     *      description="Fetches transaction by id",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          description="Id of client",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="account_id",
     *          in="path",
     *          required=true,
     *          description="Id client account",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="transaction_id",
     *          in="path",
     *          required=true,
     *          description="Id of transaction",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Transactions history",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/user-account-transaction"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized. Not applied in current test mode",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. Not applied in current test mode",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found. Not applied in current test mode",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=429,
     *          description="Error messages",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Too Many Attempts.")
     *          )
     *      )
     * )
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request)
    {
        // some authorization logic
        // just an example. It could be much more complicated, of course
        // $this->authorize(AuthServiceProvider::USER_ACCOUNT_TRANSACTION_INDEX, $account);

        /**
         * @var Account $account
         * this is just for testing purpose. Real account instance would be retrieved via $request class
         * @see https://laravel.com/docs/8.x/routing#route-model-binding as an example
         * */
        $account = Account::query()->findOrFail(AccountsTableSeeder::TEST_ACCOUNT_ID);

        $transaction = $account->transactions()->findOrFail($request->transaction_id);

        return [
            "data" => new TransactionResource($transaction),
        ];
    }

    /**
     * @OA\Post(
     *      path="/api/users/{user_id}/accounts/{account_id}/transactions",
     *      tags={"[Transactions]"},
     *      summary="Create new transaction",
     *      description="Create new transaction",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          description="Id of client",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="account_id",
     *          in="path",
     *          required=true,
     *          description="Id client account",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="type", type="string", description="debit or credit"),
     *                  @OA\Property(property="amount", type="number")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=203,
     *          description="Message about newly handling transaction",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized. Not applied in current test mode",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. Not applied in current test mode",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found. Not applied in current test mode",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error messages",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Summary of all error messages"),
     *              @OA\Property(
     *                  property="errors",
     *                  type="array",
     *                  @OA\Items(type="string")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=429,
     *          description="Error messages",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Too Many Attempts.")
     *          )
     *      )
     * )
     *
     * @param Request $request
     * @param ValidateDebitTransactionAction $validateDebitTransactionAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, ValidateDebitTransactionAction $validateDebitTransactionAction)
    {
        // some authorization logic
        // just an example. It could be much more complicated, of course
        // $this->authorize(AuthServiceProvider::USER_ACCOUNT_TRANSACTION_INDEX, $account);

        /**
         * @var Account $account
         * this is just for testing purpose. Real account instance would be retrieved via $request class
         * @see https://laravel.com/docs/8.x/routing#route-model-binding as an example
         * */
        $account = Account::query()->findOrFail(AccountsTableSeeder::TEST_ACCOUNT_ID);

        $validator = Validator::make($request->all(), [
            "type" => "required|in:debit,credit",
            "amount" => "required|numeric|gt:0",
        ]);

        $params = $validator->validated();
        $typeId = $params['type'] === "credit"
                    ? TransactionType::ID_CREDIT
                    : TransactionType::ID_DEBIT
        ;
        if ($typeId === TransactionType::ID_DEBIT) $validateDebitTransactionAction->execute($account, $params["amount"]);

        HandleTransactionJob::dispatch(
            $account->id,
            $params['amount'],
            $typeId
        );

        return Response::json([
            "message" => "Transaction have been handled."
        ], 203);
    }
}
