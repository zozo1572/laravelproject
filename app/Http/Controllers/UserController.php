<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
{
    $user = auth()->user();
    return $user->transactions;
}
// store credit/debit transaction
public function store(Request $request)
{
     $user = auth()->user();
       $data = ['type'  =>  'credit',
             'amount' => $request->amount,
             'description' =>  $request->description,
             'status' => 1,
            ];
                      $transactions= DB::transactions();
            $wallet = $user -> $transactions
                    ->create($data);
                    return $wallet;
}
//withdraw request
public function withdraw(Request $request)
{
     $user = auth()->user();
        if(!$user->User::allowWithdraw($request->amount)) {
        // return error
        return 'Invalid request';
     }
      $data = ['type'  =>  'debit',
              'amount' => $request->amount,
              'description' =>  $request->description,
              'status' => 1,
             ];


             $transactions= DB::transactions();
             $wallet = $user->$transactions
                   ->create($data);
                   return $wallet;
}
//check available
public function checkBalance()
{
     $user = auth()->user();
     $balance=DB::balance();
     return $user->$balance;
}
}
