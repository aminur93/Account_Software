<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Branch;
use App\Customer;
use App\CustomerCommision;
use App\Installment;
use App\SalesIncome;
use App\SalesPerson;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Payment;
use App\Company;
use App\Category;
use App\SubCategory;
use App\Account;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class CustomersController extends Controller
{
    public function index(){
        $seller = SalesPerson::all();

        if(Auth::user()->type == 'admin'){
            $customers = Customer::all();
            $branch = Branch::all();
        }else{
            $branch_id = Auth::user()->branchId;
            $branch = Branch::where('id', $branch_id)->get();
            $customers = Customer::where('branchId', $branch_id)->get();
        }

        return view('admin.customers.customer',compact('branch','seller','customers'));
    }

    public function store(Request $request){
        if ($request->isMethod('post'))
        {
            $customer = new Customer();

            $customer->branchId = $request->customer_branch;
            $customer->sellerId = $request->customer_seller;
            $customer->customer_name = $request->customer_name;
            $customer->father_name = $request->customer_father;
            $customer->email = $request->customer_email;
            $customer->phone = $request->customer_phone;
            $customer->address = $request->customer_address;
            $customer->zip_code = $request->customer_zcode;
            $customer->city = $request->customer_city;

            //upload image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extenson = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $image_path = 'cimage/'.$filename;

                    //Resize Image
                    Image::make($image_tmp)->resize(400,400)->save($image_path);

                    //store product image in data table
                    $customer->image = $filename;
                }
            }

            $customer->save();

            return redirect()->back()->with('flash_message_success','Customer Added Successfully!!!');
        }
    }

    public function getData()
    {
        if(Auth::user()->type == 'admin'){
            $customer = DB::table('customers')
            ->select(
                'customers.id',
                'customers.branchId',
                'customers.sellerId',
                'sales_people.seller_name',
                'branches.branch_name',
                'customers.customer_name',
                'customers.father_name',
                'customers.email',
                'customers.phone',
                'customers.address',
                'customers.zip_code',
                'customers.city',
                'customers.image',
                'customers.created_at',
                'customers.updated_at',
                DB::raw('count(bookings.id) as total_booking')
            )
            ->leftJoin('bookings','customers.id','=','bookings.customerid')
            ->leftJoin('branches','customers.branchId','=','branches.id')
            ->leftJoin('sales_people','customers.sellerId','=','sales_people.id')
            ->groupBy('customers.id')
            ->get();

        }else{
            $branch_id = Auth::user()->branchId;

            $customer = DB::table('customers')
            ->select(
                'customers.id',
                'customers.branchId',
                'customers.sellerId',
                'sales_people.seller_name',
                'branches.branch_name',
                'customers.customer_name',
                'customers.father_name',
                'customers.email',
                'customers.phone',
                'customers.address',
                'customers.zip_code',
                'customers.city',
                'customers.image',
                'customers.created_at',
                'customers.updated_at',
                DB::raw('count(bookings.id) as total_booking')
            )
            ->leftJoin('bookings','customers.id','=','bookings.customerid')
            ->leftJoin('branches','customers.branchId','=','branches.id')
            ->leftJoin('sales_people','customers.sellerId','=','sales_people.id')
            ->groupBy('customers.id')
            ->where('customers.branchId', $branch_id)
            ->get();
        }

        return DataTables::of($customer)
            ->addIndexColumn()


            ->addColumn('picture', function ($customer) {
                return '<img style="width: 50px;" src="./cimage/'.$customer->image.'"/>';
            })

            ->addColumn('cus', function ($customer) {
                return '<a href="/customer/installment/info/'.$customer->id.'">'.$customer->customer_name.'</a>';
            })

            ->editColumn('action', function ($customer) {
                $return = "<div class=\"btn-group\">";
                $return .= "<button type=\"button\" class=\"btn btn-xs btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> Action <span class=\"caret\"></span> </button><ul class=\"dropdown-menu\" style='margin-left: -100px;'>";
                if (!empty($customer->customer_name))
                {
                    $return .= "
                            <li class=\"dropdown-item\"><button
                            data-cid='$customer->id'
                            data-bid='$customer->branchId'
                            data-branch_name='$customer->branch_name'
                            data-sellerid='$customer->sellerId'
                            data-seller_name='$customer->seller_name'
                            data-cname='$customer->customer_name'
                            data-cfname='$customer->father_name'
                            data-cemail='$customer->email'
                            data-cphone='$customer->phone'
                            data-caddress='$customer->address'
                            data-czcode='$customer->zip_code'
                            data-ccity='$customer->city'
                            data-cimage='$customer->image'

                            style='background-color: transparent; margin-right: 5px' class=\"btn\" data-toggle=\"modal\" data-target=\"#editModal\">
                                    Edit
                                  </button>
                                  </li>
                                  ";
                }
                $return .= "</ul></div>";
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'cus',
                'action',
                'picture'
            ])

            ->make(true);
    }

    public function update(Request $request){

        if($request->isMethod('post')){

            $customer = Customer::findOrfail($request->customer_id);

            $customer->branchId = $request->customer_branch;
            $customer->sellerId = $request->customer_seller;
            $customer->customer_name = $request->customer_name;
            $customer->father_name = $request->customer_father;
            $customer->email = $request->customer_email;
            $customer->phone = $request->customer_phone;
            $customer->address = $request->customer_address;
            $customer->zip_code = $request->customer_zcode;
            $customer->city = $request->customer_city;

            if($request->image){
                if($customer->image != "default.png"){
                    $image_path = public_path().'/cimage/'.$customer->image;
                    unlink($image_path);
                }
            }

            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'cimage/'.$filename;
                    //Resize Image
                    Image::make($image_tmp)->resize(400,400)->save($image_path);
                    //store new image in data table
                    $customer->image = $filename;
                }
            }

            $customer->save();
            return redirect()->back()->with('flash_message_success','Customer Updated Successfully!!!');
        }
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if($customer->image != "default.png"){
            $image_path = public_path().'/uimage/'.$customer->image;
            if(file_exists($image_path)){
                 unlink($image_path);
            }
         }
         
        $customer->delete();

        return redirect()->back()->with('flash_message_success','Customer Deleted Successfully!!!');
    }


    public function getCu($id)
    {
        $customsers = Customer::where('id',$id)->first();

        $customer = DB::table('installments')
            ->groupBy('installments.bookingId')
            ->selectRaw('sum(installments.payment) as sum, installments.total as total,bookings.booking_no')
            ->leftJoin('customers','installments.customerId','=','customers.id')
            ->leftJoin('bookings','installments.bookingId','=','bookings.id')
            ->where('installments.customerId',$id)
            ->get();

        return view('admin.customers.customer_ino',compact('customer','customsers'));
    }

    public function getCustomerData(Request $request)
    {
        $id = $request->input('id');
        $cus = DB::table('installments')
            ->select(
                'installments.install_name',
                'installments.install_date',
                'bookings.booking_no',
                'installments.payment'
            )
            ->leftJoin('customers','installments.customerId','=','customers.id')
            ->leftJoin('bookings','installments.bookingId','=','bookings.id')
            ->where('installments.customerId',$id)
            ->get();
        return DataTables::of($cus)
            ->addIndexColumn()
            ->make(true);
    }


    //end Customer Route //

// Cutomer Commision all method //

public function CustomerCommision()
{
  return view('admin.customers.customer_commision');
}

public function CustomerCommisionInsert()
{ 
    if(Auth::user()->type == 'admin'){
        $booking_no = Booking::all();
    }else{
        $branch_id = Auth::user()->branchId;
        $booking_no = Booking::where('branchId', $branch_id)->get();
    }

    $accounts      = Account::all();
    $payment_methods = Payment::all();

    return view('admin.customers.customerCommisonInsert',compact('payment_methods','booking_no','accounts'));
}

public function CustomerDeitels(Request $request)
  {
        $booking_no  = Booking::where('booking_no',$request->id)->first();
        $customer    = Installment::where('customerId',$booking_no->customerid)->first();
        $installment = Installment::where('customerId',$booking_no->customerid)->where('status',1)->get();

        $install = '';
          foreach ($installment as $value) {
            $install .=  '<option value="'.$value->id.'">'.$value->install_name;
          }
          $member = '<option value="'.$customer->customerId.'">'.$customer->Customer_relation->customer_name;
          $html  = '<option value="'.$customer->branchId.'">'.$customer->Branch->branch_name;
          $html2 = '<option value="'.$customer->categoryId.'">'.$customer->category->name;
          $html3 = '<option value="'.$customer->subcategoryId.'">'.$customer->subcategory->sname;
          $html4 = $customer->square_fit;
          $html5 = $customer->payment;

          $companys = Company::where('branchId',$customer->branchId)->get();
          $html8 = '';

           foreach ($companys as $company) {
            $html8 .= '<option value="'.$company->id.'">'.$company->company_name;
          };

            return response()->json(['customer' => $member,
            'html'  => $html,'html2' => $html2,
            'html3' => $html3,'html4'=> $html4
          ,'html5'  => $html5,'html8'=>$html8,'install'=>$install]);
            }

public function CustomerCommisionstore(Request $request)
{
   
     CustomerCommision::insert([
        'booking_no'    => $request->booking_no,
        'customer_id'   => $request->customer,
        'branchId'      => $request->branch_id,
        'categoryId'    => $request->category_id,
        'subcategoryId' => $request->sub_cotegoryid,
        'square_fit'    => $request->sqft,
        'parcentage'    => $request->parcentage,
        'company'       => $request->company,
        'installment'   => $request->installment,
        'date'          => $request->date,
        'grand_total'   => $request->grand_total,
        'type'          => $request->customer_commsion,
        'payment_method' => $request->payment_method,
        'account'        => $request->account,

    ]);

      Installment::find($request->install)->update([
        'status' => 0
      ]);

    $type           = $request->customer_commsion;
    $category       = Category::find($request->category_id)->name;
    $date           = $request->date;
    $payment_method = $request->payment_method;
    $ammount        = $request->grand_total;

    Transaction::insert([
        'date'          => $date,
        'member_id'     => 'customer-'.$request->customer,
        'account_name'  => $payment_method,
        'category'      => $request->category_id,
        'type'          => $type,
        'ammount'       => $ammount,
        'created_at'    => Carbon::now(),
    ]);

    $account         =  $request->account;
    $carrent_balance = Account::findOrFail($account)->current_balance;
    $sub             = $carrent_balance - $request->grand_total;

    Account::findOrFail($account)->update([
      'current_balance' => $sub

    ]);

    return redirect('/customer/commision')->with('flash_message_success','Booking Commission Insert Successfully!!');

}

public function CustomerCommisionGetData(SalesIncome $customerCommision)
{
    if(Auth::user()->type == 'admin'){
        $customerCommision = DB::table('customer_commisions')
                ->leftJoin('customers','customer_commisions.customer_id','=','customers.id')
                ->leftJoin('branches','customer_commisions.branchId','=','branches.id')
                ->leftJoin('categories','customer_commisions.categoryId','=','categories.id')
                ->leftJoin('sub_categories','customer_commisions.subcategoryId','=','sub_categories.id')
                ->select('customer_commisions.*', 'customers.customer_name','branches.branch_name', 'categories.name', 'sub_categories.sname')
                ->latest()->get();
    }else{
        $branch_id = Auth::user()->branchId;

        $customerCommision = DB::table('customer_commisions')
                ->leftJoin('customers','customer_commisions.customer_id','=','customers.id')
                ->leftJoin('branches','customer_commisions.branchId','=','branches.id')
                ->leftJoin('categories','customer_commisions.categoryId','=','categories.id')
                ->leftJoin('sub_categories','customer_commisions.subcategoryId','=','sub_categories.id')
                ->select('customer_commisions.*', 'customers.customer_name','branches.branch_name', 'categories.name', 'sub_categories.sname')
                ->where('customer_commisions.branchId', $branch_id)
                ->latest()->get();
    }


    return DataTables::of($customerCommision)
        ->addIndexColumn()

        ->editColumn('action', function ($customerCommision) {
            $return = "<div class=\"btn-group\">";
            $return .= "<button type=\"button\" class=\"btn btn-xs btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> Action <span class=\"caret\"></span> </button><ul class=\"dropdown-menu\" style='margin-left: -100px;'>";
            if (!empty($customerCommision->id))
            {
                
                $return .= "
                            <li class=\"dropdown-item\"><a href=\"commission/edit/$customerCommision->id\">
                            
                         Edit </a></li>
                             <li class=\"dropdown-item\">
                              <a rel=\"$customerCommision->id\" rel1=\"delete-customer-commision\" href=\"javascript:\"  class=\"deleteRecord\">
                                Delete
                                </a></li>
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

public function DeleteCostomerCommision($id)
{
    CustomerCommision::find($id)->delete();
    return back();
}

public function EditCustomerCommision($id)
{
    $accounts          = Account::all();
    $CostomerCommision = CustomerCommision::findOrFail($id)->first();
    $payment_method    = Payment::all();
    $transaction       = Transaction::get();

    foreach ($transaction as $trans)
    {
        $t_explode = explode('-',$trans->member_id);
        $tr = $t_explode[1];
        
    }

    return view('admin.customers.customerCommisionUpdate',compact('CostomerCommision','payment_method','accounts','tr'));

    }


    public function checks( Request $request)
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

public function CustomerCommisionUpdate(Request $request)
{

    $all_value   = CustomerCommision::findOrfail($request->id);
    $old_account = $all_value->account;

   if ($old_account == $request->account) {

   $old_blance          = $all_value->grand_total;
   $Sum_account_balance = Account::findOrfail($old_account)->current_balance;
    $now_amount         = $request->grand_total;
   $sum                 = $Sum_account_balance + $old_blance;

   Account::findOrfail($old_account)->update([
       'current_balance' => $sum
   ]);

   $all_summ = Account::findOrfail($old_account)->current_balance - $request->grand_total;

   Account::findOrfail($old_account)->update([
       'current_balance' => $all_summ
   ]);

   }else {

   $old_blance = $all_value->grand_total;

    $sum = Account::findOrfail($old_account)->current_balance + $old_blance;

   $x = Account::findOrfail($old_account)->update([
       'current_balance' => $sum
   ]);

    $account   = $request->account;
       $amount = $request->grand_total;
       $update = Account::findOrfail($account)->current_balance - $amount;

       Account::findOrfail($account)->update([
           'current_balance' =>  $update
       ]);
   }

  CustomerCommision::where('id', $request->id)->update([
    'booking_no'    => $request->booking_no,
    'customer_id'   => $request->customer,
    'branchId'      => $request->branch_id,
    'categoryId'    => $request->category_id,
    'subcategoryId' => $request->sub_cotegoryid,
    'square_fit'    => $request->sqft,
    'parcentage'    => $request->parcentage,
    'company'       => $request->company,
    'installment'   => $request->installment,
    'date'          => $request->date,
    'grand_total'   => $request->grand_total,
    'payment_method' => $request->payment_method,
    'account'       => $request->account,
  ]);

  $type     = 'Customer Expenses';
  $category = Category::find($request->category_id)->name;
  $date     = $request->date;
  $payment_method = $request->payment_method;
  $amount         = $request->grand_total;

  $transaction = Transaction::where('member_id', 'customer-'.$request->transaction)->update([
      'date'         => $date,
      'account_name' => $payment_method,
      'category'     => $request->category_id,
      'type'         => $type,
      'ammount'      => $amount,
      'created_at'   => Carbon::now(),
  ]);

  return redirect(url('/customer/commision'))->with('flash_message_success','Booking Commission Update Successfully!!');

}
    // End Cutomer Commision all method //
}
