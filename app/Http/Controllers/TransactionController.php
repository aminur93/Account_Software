<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Transaction;
use DB;
use Carbon\Carbon;


class TransactionController extends Controller
{
    public function index()
    {
      return view('admin.transaction.index');
    }

    public function getData()
    {

    $transaction  = DB::table('transactions')
                      ->select('transactions.*', 'payments.payment_name','categories.name' )
                      ->leftJoin('payments','transactions.account_name','=','payments.id')
                      ->leftJoin('categories','transactions.category','=','categories.id')
                      ->latest()->get();

        return DataTables::of($transaction)
            ->addIndexColumn()
            ->rawColumns([
                'action'
            ])

            ->make(true);
    }


}
