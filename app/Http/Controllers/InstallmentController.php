<?php

namespace App\Http\Controllers;

use App\Installment;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;
use App\Category;
use App\Branch;
use App\Customer;
use App\SalesPerson;
use App\SubCategory;
use App\Booking;
use App\Payment;
use App\Account;
use PDF;
use Illuminate\Support\Facades\Auth;

class InstallmentController extends Controller
{

    public function index()
    {
        return view('admin.installment.installment');
    }

    public function getdata()
    {

        if(Auth::user()->type == 'admin'){
            $installment = DB::table('installments')
                        ->leftJoin('customers','installments.customerId','=','customers.id')
                        ->leftJoin('branches','installments.branchId','=','branches.id')
                        ->leftJoin('sales_people','installments.sellerId','=','sales_people.id')
                        ->leftJoin('categories','installments.categoryId','=','categories.id')
                        ->leftJoin('sub_categories','installments.subcategoryId','=','sub_categories.id')
                        ->leftJoin('bookings','installments.bookingId','=','bookings.id')
                        ->leftJoin('payments','installments.payement_method_id','=','payments.id')
                        ->select('installments.*', 'customers.customer_name', 'customers.father_name', 'branches.branch_name', 'sales_people.seller_name', 'payments.payment_name', 'categories.name', 'sub_categories.sname','sub_categories.sqft', 'bookings.booking_no', 'bookings.total_price' )
                        ->latest()->get();
        }else{
            $branch_id = Auth::user()->branchId;

            $installment = DB::table('installments')
                        ->leftJoin('customers','installments.customerId','=','customers.id')
                        ->leftJoin('branches','installments.branchId','=','branches.id')
                        ->leftJoin('sales_people','installments.sellerId','=','sales_people.id')
                        ->leftJoin('categories','installments.categoryId','=','categories.id')
                        ->leftJoin('sub_categories','installments.subcategoryId','=','sub_categories.id')
                        ->leftJoin('bookings','installments.bookingId','=','bookings.id')
                        ->leftJoin('payments','installments.payement_method_id','=','payments.id')
                        ->select('installments.*', 'customers.customer_name', 'customers.father_name', 'branches.branch_name', 'sales_people.seller_name', 'payments.payment_name', 'categories.name', 'sub_categories.sname','sub_categories.sqft', 'bookings.booking_no', 'bookings.total_price' )
                        ->where('installments.branchId', $branch_id)
                        ->latest()->get();
        }


        

        return DataTables::of($installment)
            ->addIndexColumn()

            ->addColumn('cus', function ($installment) {
                return '<a href="/customer/installment/info/'.$installment->customerId.'">'.$installment->customer_name.'</a>';
            })

            ->editColumn('action', function ($installment) {
                $return = "<div class=\"btn-group\">";
                    $return .= "<button type=\"button\" class=\"btn btn-xs btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> Action <span class=\"caret\"></span> </button><ul class=\"dropdown-menu\" style='margin-left: -100px;'>";
                        $return .= "
                                <li class=\"dropdown-item\"><a href=\"installment/edits/$installment->id\" >
                                    Edit
                                </a></li>
                                <li class=\"dropdown-item\"><a href=\"installment/invoice/$installment->id\" target=\"_blank\">
                                    Invoice 
                                </a></li>
                                ";

                    $return .= "</ul></div>";
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action',
                'cus'
            ])
            ->make(true);
    }


    public function insert(Request $request)
    {
        if(Auth::user()->type == 'admin'){
            $bookings = DB::table('bookings')
                ->leftJoin('customers', 'bookings.customerid','=','customers.id')
                ->leftJoin('sales_people','bookings.sellerId','=','sales_people.id')
                ->leftJoin('branches','bookings.branchId','=','branches.id')
                ->leftJoin('categories','bookings.categoryId','=','categories.id')
                ->leftJoin('sub_categories','bookings.subcategoryId','=','sub_categories.id')
                ->select('bookings.*', 'sales_people.seller_name', 'customers.customer_name', 'customers.father_name', 'branches.branch_name', 'categories.name', 'sub_categories.sname','sub_categories.sqft')
                ->get();
        }else{
            $branch_id = Auth::user()->branchId;
            $bookings = DB::table('bookings')
                ->leftJoin('customers', 'bookings.customerid','=','customers.id')
                ->leftJoin('sales_people','bookings.sellerId','=','sales_people.id')
                ->leftJoin('branches','bookings.branchId','=','branches.id')
                ->leftJoin('categories','bookings.categoryId','=','categories.id')
                ->leftJoin('sub_categories','bookings.subcategoryId','=','sub_categories.id')
                ->select('bookings.*', 'sales_people.seller_name', 'customers.customer_name', 'customers.father_name', 'branches.branch_name', 'categories.name', 'sub_categories.sname','sub_categories.sqft')
                ->where('bookings.branchId', $branch_id)
                ->get();
        }
        $payments = DB::table('payments')->get();
        $accounts = DB::table('accounts')->get();

        return view('admin.installment.insert', compact('bookings', 'payments', 'accounts'));
    }

    public function getfield(Request $request)
    {

        $bookings = DB::table('bookings')
                        ->leftJoin('customers', 'bookings.customerid','=','customers.id')
                        ->leftJoin('sales_people','bookings.sellerId','=','sales_people.id')
                        ->leftJoin('branches','bookings.branchId','=','branches.id')
                        ->leftJoin('categories','bookings.categoryId','=','categories.id')
                        ->leftJoin('sub_categories','bookings.subcategoryId','=','sub_categories.id')
                        ->select('bookings.*', 'sales_people.seller_name', 'customers.customer_name', 'customers.father_name', 'branches.branch_name', 'categories.name', 'sub_categories.sname','sub_categories.sqft')
                        ->where('bookings.id', $request->id)
                        ->first();

        $branch_name = $bookings->branch_name;
        $branchId = $bookings->branchId;
        $sales_person_name = $bookings->seller_name;
        $sales_person_id = $bookings->sellerId;
        $category_name = $bookings->name;
        $category_id = $bookings->categoryId;
        $sub_category_name = $bookings->sname;
        $sub_category_id = $bookings->subcategoryId;
        $sqft = $bookings->sqfit;
        $total = $bookings->total_price;
        $customer = $bookings->customer_name;
        $customerId = $bookings->customerid;
        
        return response()->json([
                        'branch_name' => $branch_name,
                        'branchId' => $branchId,
                        'sales_person_name' => $sales_person_name,
                        'sales_person_id' => $sales_person_id,
                        'category_name' => $category_name,
                        'category_id' => $category_id,
                        'sub_category_name' => $sub_category_name,
                        'sub_category_id' => $sub_category_id,
                        'sqft' => $sqft,
                        'total' => $total,
                         'customer' => $customer,
                         'customerId' => $customerId
                        ]);
    }


    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $installment = new Installment();

            $installment->install_name = $request->install_name;
            $installment->install_date = $request->installment_date;
            $installment->customerId = $request->customer_id;
            $installment->sellerId = $request->sales_person_id;
            $installment->branchId = $request->branch_id;
            $installment->categoryId = $request->category_id;
            $installment->subcategoryId = $request->sub_category_id;
            $installment->bookingId = $request->booking_no;
            $installment->square_fit = $request->sqft;
            $installment->total = $request->total_price;
            $installment->payment = $request->payment;
            $installment->accountId = $request->account_id;
            $installment->payement_method_id = $request->payement_method_id;

            $installment->save();

            $account = Account::findOrFail($request->account_id);
            $balance = $account->current_balance + $request->payment;
            $account->current_balance = $balance;
            $account->update();

            return redirect('/installment')->with('flash_message_success','Installment Added Successfully!!');
        }
    }


    public function edit($id)
    {
        
        if(Auth::user()->type == 'admin'){
            $bookings = Booking::get();
        }else{
            $branch_id = Auth::user()->branchId;
            $bookings = Booking::where('bookings.branchId', $branch_id)->get();
        }

        $installment = DB::table('installments')
                            ->select('installments.*', 'sales_people.seller_name', 'customers.customer_name', 'customers.father_name', 'branches.branch_name', 'categories.name', 'sub_categories.sname','sub_categories.sqft')
                            ->leftJoin('customers','installments.customerId','=','customers.id')
                            ->leftJoin('sales_people','installments.sellerId','=','sales_people.id')
                            ->leftJoin('bookings','installments.bookingId','=','bookings.id')
                            ->leftJoin('branches','installments.branchId','=','branches.id')
                            ->leftJoin('categories','installments.categoryId','=','categories.id')
                            ->leftJoin('sub_categories','installments.subcategoryId','=','sub_categories.id')
                            ->where('installments.id',$id)
                            ->first();

        $customer = DB::table('customers')->get();
        $payments = DB::table('payments')->get();
        $accounts = DB::table('accounts')->get();

        return view('admin.installment.edit', compact('installment','bookings','customer','payments', 'accounts'));
    }


    public function update(Request $request)
    {
        if ($request->isMethod('post')) {

            $installment = Installment::findOrFail($request->id);

            //dd($request->id);

            if($installment->accountId != $request->account_id){
                //dd("account change");

                $installAccount = Account::findOrFail($installment->accountId);
                $installAccount->current_balance = $installAccount->current_balance - $installment->payment;
                $installAccount->update();

                $reqAccount = Account::findOrFail($request->account_id);
                $reqAccount->current_balance = $reqAccount->current_balance + $request->payment;
                $reqAccount->update();

            }else{
                $account = Account::findOrFail($request->account_id);
                //Amount From install Table
                $current = $installment->payment;
                //Amount from Submit
                $change = $request->payment;
                //Amount from Bank Account
                $current_balance = $account->current_balance;

                if($current != $change){

                    $account->current_balance = $current_balance - $current;
                    $account->update();

                    $account->current_balance = $account->current_balance + $change;
                    $account->update();
                }
            }


            $installment->install_name = $request->install_name;
            $installment->install_date = $request->installment_date;
            $installment->customerId = $request->customer_id;
            $installment->sellerId = $request->sales_person_id;
            $installment->branchId = $request->branch_id;
            $installment->categoryId = $request->category_id;
            $installment->subcategoryId = $request->sub_category_id;
            $installment->bookingId = $request->booking_no;
            $installment->square_fit = $request->sqft;
            $installment->total = $request->total_price;
            $installment->payment = $request->payment;
            $installment->accountId = $request->account_id;
            $installment->payement_method_id = $request->payement_method_id;

            $installment->update();
        }

        return redirect('/installment')->with('flash_message_success','Installment Updated Successfully!!');
    }

    public function invoice($id)
    {
        $installment = DB::table('installments')
                    ->leftJoin('customers','installments.customerId','=','customers.id')
                    ->leftJoin('bookings','installments.bookingId','=','bookings.id')
                    ->leftJoin('branches','installments.branchId','=','branches.id')
                    ->leftJoin('categories','installments.categoryId','=','categories.id')
                    ->leftJoin('sub_categories','installments.subcategoryId','=','sub_categories.id')
                    ->select('installments.*', 'customers.customer_name','customers.phone', 'customers.Address', 'customers.email', 'categories.name', 'sub_categories.sname', 'bookings.booking_no', 'bookings.booking_type')
                    ->where('installments.id',$id)
                    ->first();

        $due = $installment->total - $installment->payment;
        return view('admin.installment.invoice', compact('installment', 'due'));
    }

    public function invoiceDownload($id){
        $installment = DB::table('installments')
                    ->leftJoin('customers','installments.customerId','=','customers.id')
                    ->leftJoin('bookings','installments.bookingId','=','bookings.id')
                    ->leftJoin('categories','installments.categoryId','=','categories.id')
                    ->leftJoin('sub_categories','installments.subcategoryId','=','sub_categories.id')
                    ->select('installments.*', 'customers.customer_name','customers.phone', 'customers.Address', 'customers.email', 'categories.name', 'sub_categories.sname', 'bookings.booking_no', 'bookings.booking_type')
                    ->where('installments.id',$id)
                    ->first();
                    
        $due = $installment->total - $installment->payment;

        $pdf = PDF::loadView('admin.installment.download', compact('installment', 'due'));
        $file_name = 'invoice_' . time() . '.pdf';
        return $pdf->download($file_name);
  
      }


    public function destroy($id)
    {
        $installment = Installment::findOrFail($id);
        $installment->delete();

        return redirect()->back()->with('flash_message_success','Installment Deleted Successfully!!');
    }
}
