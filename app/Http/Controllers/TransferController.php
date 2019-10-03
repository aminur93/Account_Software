<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transfer;
use App\Account;
use App\Payment;
use DB;
use Yajra\DataTables\Facades\DataTables;

class TransferController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        $payments = Payment::all();
        return view('admin.banking.transfer', compact('accounts', 'payments'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $trasnfer = new Transfer();

            $trasnfer->fromId = $request->from;
            $trasnfer->toId = $request->to;
            $trasnfer->paymentId = $request->payment;
            $trasnfer->tAmount = $request->amount;
            $trasnfer->tDate = $request->date;
            $trasnfer->description = $request->description;
            $trasnfer->save();

            $fromAccount = Account::findOrFail($request->from);
            $fromBalance = $fromAccount->current_balance - $request->amount;
            $fromAccount->current_balance = $fromBalance;
            $fromAccount->update();

            $toAccount = Account::findOrFail($request->to);
            $toBalance = $toAccount->current_balance + $request->amount;
            $toAccount->current_balance = $toBalance;
            $toAccount->update();

            return redirect()->back()->with('flash_message_success','Tranfer Amount Successfully!!');

        }
    }

    public function getData()
    {

        $trasnfer = DB::table('transfers')
                        ->leftJoin('accounts AS A', 'A.id', '=', 'transfers.fromId')
                        ->leftJoin('accounts AS B', 'B.id', '=', 'transfers.toId')
                        ->leftJoin('payments','transfers.paymentId','=','payments.id')
                        ->select('transfers.*', 'A.account_name AS from', 'B.account_name AS to', 'payment_name' )
                        ->latest()->get();

        return DataTables::of($trasnfer)
            ->addIndexColumn()
            ->rawColumns([
                'action'
            ])
            ->make(true);
    }

    public function checkBalance(Request $request)
    {
        $account = Account::findOrFail($request->from);
        $currentAmount = $account->current_balance;
        $submitAmount = $request->amount;

        $data = "Your current balance is " .$currentAmount. " in " .$account->account_name. " Account";

        $null = '';
        if($submitAmount > $currentAmount){
            echo json_encode($data);
        }else{
            echo json_encode($null);
        }

    }

}
