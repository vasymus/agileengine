<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(Request $request)
    {


        DB::transaction(function() {

            $entity = Transaction::handleCredit(1, 222);

            dump($entity);

            $result = Transaction::handleDebit(1, 111);

            dump($result);
        });



        return view("welcome");
    }
}
