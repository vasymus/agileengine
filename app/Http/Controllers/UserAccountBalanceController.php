<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Database\Seeders\AccountsTableSeeder;
use Illuminate\Http\Request;

class UserAccountBalanceController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/users/{user_id}/accounts/{account_id}/balance",
     *      tags={"[Balance]"},
     *      summary="Fetches current account balance",
     *      description="Fetches current account balance",
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
     *                  type="number"
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
    public function __invoke(Request $request)
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

        return [
            "data" => $account->balance,
        ];
    }
}
