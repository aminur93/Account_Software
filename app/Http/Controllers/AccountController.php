<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.banking.account');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $account = new Account();

            $account->account_name = $request->account_name;
            $account->account_no = $request->number;
            $account->current_balance = $request->balance;
            $account->bank_name = $request->bank_name;
            $account->bank_phone = $request->phone;
            $account->bank_address = $request->address;

            $account->save();

            return redirect()->back()->with('flash_message_success','Account Added Successfully!!');
        }
    }

    public function getData()
    {
        $account = Account::latest()->get();

        return DataTables::of($account)
            ->addIndexColumn()

            ->editColumn('action', function ($account) {
                $return = "<div class=\"btn-group\">";
                $return .= "<button type=\"button\" class=\"btn btn-xs btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> Action <span class=\"caret\"></span> </button><ul class=\"dropdown-menu\" style='margin-left: -100px;'>";
                if (!empty($account->id))
                {
                    $return .= "
                            <li class=\"dropdown-item\"><button
                            data-account_id='$account->id'
                            data-account_name='$account->account_name'
                            data-number='$account->account_no'
                            data-balance='$account->current_balance'
                            data-bank_name='$account->bank_name'
                            data-phone='$account->bank_phone'
                            data-address='$account->bank_address'
                             style='background-color: transparent; margin-right: 5px' data-toggle=\"modal\" class=\"btn\" data-target=\"#editModal\">Edit</button></li>
                                  ";
                }
                $return .= "</ul></div>";
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action'
            ])

            ->make(true);
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $account = Account::findOrFail($request->account_id);

            $account->account_name = $request->account_name;
            $account->account_no = $request->number;
            $account->current_balance = $request->balance;
            $account->bank_name = $request->bank_name;
            $account->bank_phone = $request->phone;
            $account->bank_address = $request->address;

            $account->update();

            return redirect()->back()->with('flash_message_success','Account Updated Sucessfully');
        }
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()->back()->with('flash_message_success','Account Deleted Successfully!!');
    }
}
