<?php

namespace App\Http\Controllers;

use Charts;
use Illuminate\Http\Request;
use App\Installment;
use App\Booking;
use App\Customer;
use App\Account;
use DB;
use Auth;

class DashBoardController extends Controller
{
    public function index()
    {
        if(Auth::user()->type == 'admin'){
            $Installment_income = DB::table('installments')->sum('installments.payment');
            $other_income = DB::table('other')->sum('other.amount');

            $sales_expenses = DB::table('sales_incomes')->sum('sales_incomes.seller_income');
            $customer_expenses = DB::table('customer_commisions')->sum('customer_commisions.grand_total');
            $vendor_expenses = DB::table('vendor_payments')->sum('vendor_payments.amount');

            $total_customer = DB::table('customers')->count('customers.id');

            $latest_customer = Customer::latest()->limit(5)->get();

            $latest_booking = DB::table('bookings')
                ->leftJoin('customers','bookings.customerid','=','customers.id')
                ->select('bookings.*', 'customers.customer_name')
                ->latest()
                ->limit(5)
                ->get();
        }else{
            $branch_id = Auth::user()->branchId;

            $Installment_income = DB::table('installments')->where('installments.branchId', $branch_id)->sum('installments.payment');
            $other_income = DB::table('other')->where('other.branchId', $branch_id)->sum('other.amount');

            $sales_expenses = DB::table('sales_incomes')->where('sales_incomes.branchId', $branch_id)->sum('sales_incomes.seller_income');
            $customer_expenses = DB::table('customer_commisions')->where('customer_commisions.branchId', $branch_id)->sum('customer_commisions.grand_total');
            $vendor_expenses = DB::table('vendor_payments')->where('vendor_payments.branch_id', $branch_id)->sum('vendor_payments.amount');

            $total_customer = DB::table('customers')->where('customers.branchId', $branch_id)->count('customers.id');

            $latest_customer = Customer::latest()->where('customers.branchId', $branch_id)->limit(5)->get();

            $latest_booking = DB::table('bookings')
                ->leftJoin('customers','bookings.customerid','=','customers.id')
                ->select('bookings.*', 'customers.customer_name')
                ->where('bookings.branchId', $branch_id)
                ->latest()
                ->limit(5)
                ->get();
        }

        $total_income = $Installment_income + $other_income;

        $total_expenses = $sales_expenses + $customer_expenses + $vendor_expenses;

        $total_profit =  $total_income - $total_expenses;
        
       $accounts = Account::all();
       
  
    $pie  =	 Charts::create('pie', 'highcharts')
				    ->title('Income Expenses Profit')
				    ->labels(['Income', 'Expenses', 'Profit'])
				    ->values([$total_income, $total_expenses, $total_profit])
				    ->dimensions(1000,500)
				    ->responsive(false);
        return view('admin.dashboard')
            ->with(compact('pie','total_income','total_expenses','total_profit','total_customer','latest_customer','latest_booking','accounts'));
           
        
    }
}
