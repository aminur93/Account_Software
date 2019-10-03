<?php

namespace App\Http\Controllers;

use App\Account;
use App\Branch;
use App\Category;
use App\Payment;
use App\Transaction;
use App\Vendor;
use App\VendorPayment;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use Image;
use Auth;

class VendorPaymentController extends Controller
{
    public function index()
    {
        return view('admin.vendorPayment.vendor_payment');
    }

    public function create()
    {
        if(Auth::user()->type == 'admin'){
            $branch = Branch::all();
        }else{
            $branch_id = Auth::user()->branchId;
            $branch = Branch::where('id', $branch_id)->get();
        }
        $vendor = Vendor::all();
        $categories = Category::get();
        $payment = Payment::all();
        $account = Account::all();
        $dataCategory[]='';
        foreach ($categories as $category)
        {
            $dataCategory[$category->type][] = $category;

        }
        return view('admin.vendorPayment.create',compact('vendor','dataCategory','branch','payment','account'));
    }

    public function check(Request $request)
    {
        $account = Account::findOrFail($request->account);
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

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $vendor = new VendorPayment();

            $vendor->date = $request->date;
            $vendor->vendor_id = $request->vendor;
            $vendor->category_id = $request->category;
            $vendor->branch_id = $request->branch;
            $vendor->amount = $request->amount;
            $vendor->account = $request->account;
            $vendor->payment_method = $request->payment_method;

            //upload image
            if($request->hasFile('attachment')){
                $image_tmp = Input::file('attachment');
                if($image_tmp->isValid()){
                    $extenson = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $image_path = public_path().'/incomeFile';
                    $request->file('attachment')->move($image_path, $filename);
                    //store product image in data table
                    $vendor->attachment = $filename;
                }
            }

            $vendor->save();

            $last_id = DB::getPdo()->lastInsertId();

            //update account table
            $id = $request->account;
            $account = Account::where('id',$id)->first();
            $current_balance = $account['current_balance'];
            //dd($current_balance);die;
            $grant_total = $current_balance - $request->amount;

            Account::where('id',$id)->update([
                'current_balance' => $grant_total
            ]);

            //insert transaction table
            Transaction::insert([
                'date' => $request->date,
                'member_id' => 'vendor-'.$last_id,
                'account_name' => $request->account,
                'category' => $request->category,
                'type' => $request->type,
                'ammount' => $request->amount,
            ]);

            return redirect(route('vendorPayment.index'))->with('flash_message_success','Payment Added Successfully!!');
        }
    }

    public function getData()
    {
        if(Auth::user()->type == 'admin'){
            $vendor = DB::table('vendor_payments')
                  ->select(
                      'vendor_payments.id',
                      'vendor_payments.date',
                      'vendor_payments.vendor_id',
                      'vendors.vendor_name',
                      'categories.name',
                      'branches.branch_name',
                      'accounts.account_name',
                      'payments.payment_name',
                      'vendor_payments.amount'
                  )
                  ->leftJoin('vendors','vendor_payments.vendor_id','=','vendors.id')
                  ->leftJoin('categories','vendor_payments.category_id','=','categories.id')
                  ->leftJoin('branches','vendor_payments.branch_id','=','branches.id')
                  ->leftJoin('accounts','vendor_payments.account','=','accounts.id')
                  ->leftJoin('payments','vendor_payments.payment_method','=','payments.id')
                  ->get();
        }else{
            $branch_id = Auth::user()->branchId;

            $vendor = DB::table('vendor_payments')
                  ->select(
                      'vendor_payments.id',
                      'vendor_payments.date',
                      'vendor_payments.vendor_id',
                      'vendors.vendor_name',
                      'categories.name',
                      'branches.branch_name',
                      'accounts.account_name',
                      'payments.payment_name',
                      'vendor_payments.amount'
                  )
                  ->leftJoin('vendors','vendor_payments.vendor_id','=','vendors.id')
                  ->leftJoin('categories','vendor_payments.category_id','=','categories.id')
                  ->leftJoin('branches','vendor_payments.branch_id','=','branches.id')
                  ->leftJoin('accounts','vendor_payments.account','=','accounts.id')
                  ->leftJoin('payments','vendor_payments.payment_method','=','payments.id')
                  ->where('vendor_payments.branch_id', $branch_id)
                  ->get();
        }

        return DataTables::of($vendor)
            ->addIndexColumn()

            ->addColumn('vus', function ($vendor) {
                return '<a href="/vendor/info/'.$vendor->vendor_id.'">'.$vendor->vendor_name.'</a>';
            })

            ->editColumn('action', function ($vendor) {
                $return = "<div class=\"btn-group\">";
                if (!empty($vendor->id))
                {
                    $return .= "
                               <a href=\"vendor/edit/$vendor->id\"  style='margin-right: 5px' class=\"btn btn-xs btn-default\">Edit</a>
                           
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action',
                'vus'
            ])

            ->make(true);
    }

    public function edit($id)
    {
        if(Auth::user()->type == 'admin'){
            $branch = Branch::all();
        }else{
            $branch_id = Auth::user()->branchId;
            $branch = Branch::where('id', $branch_id)->get();
        }

        $vendors = VendorPayment::findOrFail($id);
        $vendor = Vendor::all();
        $categories = Category::get();
        $payment = Payment::all();
        $account = Account::all();
        foreach ($categories as $category)
        {
            $dataCategory[$category->type][] = $category;

        }

        //explode memberid
        $transaction = Transaction::get();
        foreach ($transaction as $trans)
        {
            $t_explode = explode('-',$trans->member_id);
            $tr = $t_explode[1];
            
        }
        return view('admin.vendorPayment.edit',compact('vendors','vendor','tr','branch','categories','payment','account','dataCategory'));
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $vendor = VendorPayment::findOrFail($request->id);

            //update account table
            $id = $request->account;
            $account = Account::where('id',$id)->first();
            $current_balance = $account['current_balance'];
            $total = $vendor->amount + $current_balance;
            //dd($total);die;
            $grant_total = $current_balance - $request->amount;

            if($vendor->account != $request->account){
                //dd("account change");

                $otherAccount = Account::findOrFail($vendor->account);
                $otherAccount->current_balance = $otherAccount->current_balance + $vendor->amount;
                $otherAccount->update();

                $reqAccount = Account::findOrFail($request->account);
                $reqAccount->current_balance = $reqAccount->current_balance - $request->amount;
                $reqAccount->update();

            }else{
                $account = Account::findOrFail($request->account);
                //Amount From other Table
                $current = $vendor->amount;
                //Amount from Submit
                $change = $request->amount;
                //Amount from Bank Account
                $current_balance = $account->current_balance;

                if($current != $change){
                    $account->current_balance = $current_balance + $current;
                    $account->update();

                    $account->current_balance = $account->current_balance - $change;
                    $account->update();
                }
            }

            $vendor->date = $request->date;
            $vendor->vendor_id = $request->vendor;
            $vendor->category_id = $request->category;
            $vendor->branch_id = $request->branch;
            $vendor->amount = $request->amount;
            $vendor->account = $request->account;
            $vendor->payment_method = $request->payment_method;

            if($request->attachment){
                if($vendor->attachment != null){
                    $image_path = public_path().'/incomeFile/'.$vendor->attachment;
                    unlink($image_path);
                }
            }else{
                $current_images = $vendor->attachment;
                $vendor->attachment = $current_images;
            }

            if($request->hasFile('attachment')){
                $image_tmp = Input::file('attachment');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = public_path().'/incomeFile/'.$filename;
                    //Resize Image
                    Image::make($image_tmp)->resize(400,400)->save($image_path);
                    //store new image in data table
                    $vendor->attachment = $filename;
                }
            }

            $vendor->save();

            //insert transaction table
            Transaction::where('member_id','vendor-'.$request->memberId)->update([
                'date' => $request->date,
                'member_id' => 'vendor-'.$request->vendor,
                'account_name' => $request->account,
                'category' => $request->category,
                'type' => $request->type,
                'ammount' => $request->amount,
            ]);

            return redirect(route('vendorPayment.index'))->with('flash_message_success','Payment Updated Successfully!!');
        }
    }
}
