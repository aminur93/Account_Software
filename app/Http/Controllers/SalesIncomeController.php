<?php

namespace App\Http\Controllers;
use App\SalesIncome;
use Illuminate\Http\Request;
use App\SalesPerson;
use App\Branch;
use App\SubCategory;
use App\Booking;
use App\Payment;
use App\Company;
use App\Transaction;
use App\Account;
use URL;
use App\Category;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Carbon\Carbon;
use Auth;

class SalesIncomeController extends Controller
{
    
    public function sallerdetiels(Request $request)
   {
         $seller_info = Booking::where('booking_no',$request->id)->first();

         $percentage = SalesPerson::where('id',$seller_info->sellerId)->first();

           $seller  = '<option value="'.$seller_info->sellerId.'">'.$seller_info->Seller->seller_name;
           $html  = '<option value="'.$seller_info->branchId.'">'.$seller_info->Branch->branch_name;
           $html2 = '<option value="'.$seller_info->categoryId.'">'.$seller_info->category->name;
           $html3 = '<option value="'.$seller_info->subcategoryId.'">'.$seller_info->subcategory->sname;
           $html4 = $seller_info->sqfit;
           $html5 = $seller_info->total_price;
           $html7 = $percentage->sales_parcentage;
           $html6 = ($html7/100)*$html5;
           $companys = Company::where('branchId',$seller_info->branchId)->get();
           $html8 = '';
            foreach ($companys as $company) {
             $html8 .= '<option value="'.$company->id.'">'.$company->company_name;
           };
             return response()->json(['seller' => $seller,'html' => $html,'html2' => $html2,'html3' => $html3,'html4' => $html4
           ,'html5' => $html5,'html6'=>$html6,'html7'=>$html7,'html8'=>$html8]);

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

     public function store(Request $request)
     {
         $seller_id = SalesIncome::insertGetId([
           'booking_no'    => $request->booking_no,
           'sellerId'      => $request->seller_id,
           'branchId'      => $request->branch_id,
           'categoryId'    => $request->category_id,
           'subcategoryId' => $request->sub_cotegoryid,
           'square_fit'    => $request->sqft,
           'total'         => $request->total,
           'parcentage'    => $request->parcentage,
           'seller_income' => $request->seller_income,
           'companyId'     => $request->company,
           'date'          => $request->date,
           'Type'          => $request->sales_commision,
           'payment_method' => $request->payment_method,
            'account'       => $request->account,
         ]);

       $type = 'Sales Expenses';
       $category = Category::find($request->category_id)->name;
       $date = $request->date;
      
       $payment_method = $request->payment_method;
       $amount = $request->seller_income;

       Transaction::insert([
         'date'         => $date,
         'member_id'    => 'seller-'.$seller_id,
         'account_name' => $payment_method,
         'category'     => $request->category_id,
         'type'         => $type,
         'ammount'      => $amount,
         'created_at'   => Carbon::now(),
       ]);

       $account =  $request->account;
       $carrent_balance = Account::findOrFail($account)->current_balance;
       $sub = $carrent_balance - $request->seller_income;
       Account::findOrFail($account)->update([
         'current_balance' => $sub
       ]);
       return redirect(url('/seller/commission'))->with('flash_message_success','Seller Commission Insert Successfully!!');

     }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesIncome  $salesIncome
     * @return \Illuminate\Http\Response
     */
     public function getdata(SalesIncome $salesIncome)
     {
        if(Auth::user()->type == 'admin'){
                $sales_income = DB::table('sales_incomes')
                        ->leftJoin('sales_people','sales_incomes.sellerId','=','sales_people.id')
                        ->leftJoin('branches','sales_incomes.branchId','=','branches.id')
                        ->leftJoin('categories','sales_incomes.categoryId','=','categories.id')
                        ->leftJoin('sub_categories','sales_incomes.subcategoryId','=','sub_categories.id')
                        ->select('sales_incomes.*', 'sales_people.seller_name','branches.branch_name', 'categories.name', 'sub_categories.sname' )
                        ->latest()
                        ->get();
        }else{
            $branch_id = Auth::user()->branchId;
            $sales_income = DB::table('sales_incomes')
                        ->leftJoin('sales_people','sales_incomes.sellerId','=','sales_people.id')
                        ->leftJoin('branches','sales_incomes.branchId','=','branches.id')
                        ->leftJoin('categories','sales_incomes.categoryId','=','categories.id')
                        ->leftJoin('sub_categories','sales_incomes.subcategoryId','=','sub_categories.id')
                        ->select('sales_incomes.*', 'sales_people.seller_name','branches.branch_name', 'categories.name', 'sub_categories.sname' )
                        ->where('sales_incomes.branchId', $branch_id)
                        ->latest()
                        ->get();
        }

           return DataTables::of($sales_income)
               ->addIndexColumn()

               ->editColumn('action', function ($sales_income) {
                   $return = "<div class=\"btn-group\">";
                   $return .= "<button type=\"button\" class=\"btn btn-xs btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> Action <span class=\"caret\"></span> </button><ul class=\"dropdown-menu\" style='margin-left: -100px;'>";
               if (!empty($sales_income->id))
               {
                  $return .= "
                  <li class=\"dropdown-item\"><a href=\"commission/edit/$sales_income->id\">
                  
               Edit </a></li>
                   <li class=\"dropdown-item\">
                    <a rel=\"$sales_income->id\" rel1=\"delete-saleincome\" href=\"javascript:\"  class=\"deleteRecord\">
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

    public function edit($id)
    {
		$accounts       = Account::all();
		$sales_detiels  = SalesIncome::findOrFail($id)->first();
		$payment_method = Payment::all();
		$transaction    = Transaction::get();
		foreach ($transaction as $trans)
		{
			$t_explode = explode('-',$trans->member_id);
			$tr = $t_explode[1];
		}
            
      	return view('admin.sales_income.saleIncome_edit',compact('sales_detiels','payment_method','accounts','tr'));

    }

       public function update(Request $request)

        {
          
        $all_value    = SalesIncome::findOrfail($request->id);
        $old_account  = $all_value->account;
          
       if ($old_account != $request->account) {
    
       $old_blance = $all_value->seller_income;
       $Sum_account_balance = Account::findOrfail($old_account)->current_balance;
        $now_amount = $request->seller_income;
       $sum = $Sum_account_balance+$old_blance;
        
       Account::findOrfail($old_account)->update([
           'current_balance' => $sum
       ]);
    
       $all_summ = Account::findOrfail($request->account)->current_balance - $request->seller_income;
       
       Account::findOrfail($request->account)->update([
           'current_balance' => $all_summ
       ]);
      
        }
       
           SalesIncome::where('id',$request->id)->update([
             'booking_no'    => $request->booking_no,
             'sellerId'      => $request->seller_id,
             'branchId'      => $request->branch_id,
             'categoryId'    => $request->category_id,
             'subcategoryId' => $request->sub_cotegoryid,
             'square_fit'    => $request->sqft,
             'total'         => $request->total,
             'parcentage'    => $request->parcentage,
             'seller_income' => $request->seller_income,
             'companyId'     => $request->company,
             'date'          => $request->date,
             'payment_method' => $request->payment_method,
             'account'        => $request->account
           ]);


         $type            = 'Seller Expenses';
         $category        = Category::find($request->category_id)->name;
         $date            = $request->date;
          $payment_method = $request->payment_method;
         $amount          = $request->seller_income;

         $transaction = Transaction::where('member_id','seller-'.$request->tranaction_id)->update([
           'date'         => $date,
           'account_name' => $payment_method,
           'category'     => $request->category_id,
           'type'         => $type,
           'ammount'      => $amount,
           'created_at'   => Carbon::now(),
         ]);

            return redirect(url('/seller/commission'))->with('flash_message_success','Sales Commision Update Successfully!!');

        }

       public function destroy($id)
       {
         $saleIncom = SalesIncome::findOrFail($id);
         $saleIncom->delete();
         return redirect()->back()->with('flash_message_success','Seller Income Deleted Successfully!!');
       }

       public function salesShow()
       {
        	return view('admin.sales_income.sales_incomes');
       }

       public function Showinsertform()
       {
			if(Auth::user()->type == 'admin'){
				$booking_no = Booking::all();
			}else{
				$branch_id = Auth::user()->branchId;
				$booking_no = Booking::where('branchId', $branch_id)->get();
			}

			$bank_accounts   = Account::all();
			$payment_methods = Payment::all();
			return view('admin.sales_income.insert',compact('booking_no','payment_methods','bank_accounts'));
        }
    
}
