<?php

namespace App\Http\Controllers;

use App\Category;
use App\OtherIncome;
use App\Payment;
use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use DB;
use File;
use Auth;
use App\Branch;

class OtherIncomeController extends Controller
{
    public function index()
    {
        return view('admin.incomeother.other');
    }

    public function create()
    {
        if(Auth::user()->type == 'admin'){
            $branches = Branch::select('id', 'branch_name')->get();
        }else{
            $branch_id = Auth::user()->branchId;
            $branches = Branch::select('id', 'branch_name')->where('id', $branch_id)->get();
        }
        $account = Account::get();
        $payment = Payment::get();
        $categories = Category::get();
        foreach ($categories as $category)
        {
            $dataCategory[$category->type][] = $category;

        }
        return view('admin.incomeother.create',compact('account', 'payment','dataCategory', 'branches'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $other = new OtherIncome();

            $other->date = $request->income_date;
            $other->amount = $request->amount;
            $other->account = $request->account;
            $other->source_name = $request->source_name;
            $other->description = $request->description;
            $other->categoryId = $request->category_id;
            $other->branchId = $request->branch;
            $other->payment_method = $request->payment_method;

            //upload image
            if($request->hasFile('attachment')){
                $image_tmp = Input::file('attachment');
                if($image_tmp->isValid()){
                    $extenson = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $image_path = public_path().'/incomeFile';
                    $request->file('attachment')->move($image_path, $filename);
                    //store product image in data table
                    $other->attachment = $filename;
                }
            }

            $other->save();

            $account = Account::findOrFail($request->account);
            $balance = $account->current_balance + $request->amount;
            $account->current_balance = $balance;
            $account->update();

            return redirect('/other/income')->with('flash_message_success','Other Income Added Successfully');
        }
    }

    public function getData()
    {
        if(Auth::user()->type == 'admin'){
            $other = DB::table('other')
                    ->select(
                        'other.id',
                        'other.date',
                        'other.amount',
                        'accounts.account_name',
                        'other.source_name',
                        'categories.name',
                        'branches.branch_name',
                        'payments.payment_name'
                    )
                    ->leftJoin('categories','other.categoryId','=','categories.id')
                    ->leftJoin('branches','other.branchId','=','branches.id')
                    ->leftJoin('payments','other.payment_method','=','payments.id')
                    ->leftJoin('accounts','other.account','=','accounts.id')
                    ->get();
        }else{
            $branch_id = Auth::user()->branchId;

            $other = DB::table('other')
                    ->select(
                        'other.id',
                        'other.date',
                        'other.amount',
                        'accounts.account_name',
                        'other.source_name',
                        'categories.name',
                        'branches.branch_name',
                        'payments.payment_name'
                    )
                    ->leftJoin('categories','other.categoryId','=','categories.id')
                    ->leftJoin('branches','other.branchId','=','branches.id')
                    ->leftJoin('payments','other.payment_method','=','payments.id')
                    ->leftJoin('accounts','other.account','=','accounts.id')
                    ->where('other.branchId', $branch_id)
                    ->get();
        }

        return DataTables::of($other)
            ->addIndexColumn()


            ->editColumn('action', function ($other) {
                $return = "<div class=\"btn-group\">";

                    $return .= "
                              <a href=\"/other/income/edit/$other->id\" class=\"btn btn-xs btn-default\">
                                 Edit
                              </a>
                                  
                                  ";

                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action'
            ])

            ->make(true);
    }

    public function edit($id)
    {
        $other = OtherIncome::findOrFail($id);

        if(Auth::user()->type == 'admin'){
            $branches = Branch::select('id', 'branch_name')->get();
        }else{
            $branch_id = Auth::user()->branchId;
            $branches = Branch::select('id', 'branch_name')->where('id', $branch_id)->get();
        }

        $account = Account::get();
        $payment = Payment::all();
        $categories = Category::get();
        foreach ($categories as $category)
        {
            $dataCategory[$category->type][] = $category;

        }
        return view('admin.incomeother.edit',compact('account', 'payment','categories','other','dataCategory', 'branches'));
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $other = OtherIncome::findOrFail($request->id);

            if($other->account != $request->account){

                $otherAccount = Account::findOrFail($other->account);
                $otherAccount->current_balance = $otherAccount->current_balance - $other->amount;
                $otherAccount->update();

                $reqAccount = Account::findOrFail($request->account);
                $reqAccount->current_balance = $reqAccount->current_balance + $request->amount;
                $reqAccount->update();

            }else{
                $account = Account::findOrFail($request->account);
                //Amount From other Table
                $current = $other->amount;
                //Amount from Submit
                $change = $request->amount;
                //Amount from Bank Account
                $current_balance = $account->current_balance;
                
            
                if($current != $change){
                    $account->current_balance = $current_balance - $current;
                    $account->update();

                    $account->current_balance = $account->current_balance + $change;
                    $account->update();
                }
            }

            

            $other->date = $request->income_date;
            $other->amount = $request->amount;
            $other->account = $request->account;
            $other->source_name = $request->source_name;
            $other->description = $request->description;
            $other->categoryId = $request->category_id;
            $other->branchId = $request->branch;
            $other->payment_method = $request->payment_method;

            if($request->attachment){
                if($other->attachment != null){
                    $image_path = public_path().'/incomeFile/'.$other->attachment;
                    unlink($image_path);
                }
            }else{
                $current_images = $other->attachment;
                $other->attachment = $current_images;
            }

            //upload image
            if($request->hasFile('attachment')){
                $image_tmp = Input::file('attachment');
                if($image_tmp->isValid()){
                    $extenson = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $image_path = public_path().'/incomeFile';
                    $request->file('attachment')->move($image_path, $filename);
                    //store product image in data table
                    $other->attachment = $filename;
                }
            }

            $other->update();

            

            return redirect('/other/income')->with('flash_message_success','Other Income Updated Successfully');
        }
    }

    public function destroy($id)
    {
        $other = OtherIncome::findOrFail($id);
        if($other->attachment){
            $image_path = public_path().'/incomeFile/'.$other->attachment;
            unlink($image_path);
        }
        $other->delete();

        return redirect()->back()->with('falsh_message_success','Other Incomne Deleted Sucesfully!!');
    }

}
