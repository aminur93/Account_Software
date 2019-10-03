<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Installment;
use App\Category;
use Auth;

class IncomeReportController extends Controller
{
    public function incomeSummary()
    {

        $category = Category::get();
        $ins_years = DB::table('installments')
                    ->select(DB::raw('YEAR(install_date) year'))
                    ->groupBy('year')
                    ->get();
        $customers = DB::table('installments')
                    ->select(
                        'customers.id',
                        'customers.customer_name'
                    )
                    ->leftJoin('customers','customers.id','=','installments.customerId')
                    ->groupBy('customerId')
                    ->get();

        $cat_month = array();
        $cat_month_total = array();

        if(Auth::user()->type == 'admin'){
            if(request()->has('year_id')){
                $year_id = request()->year_id;
                $customer_id = request()->customer_id;
                $category_id = request()->category_id;

                if($customer_id != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('customerId', $customer_id)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->whereYear('install_date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('customerId', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($customer_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('customerId', $customer_id)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->whereYear('install_date', $year_id)
                                ->where('customerId', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($customer_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->where('categoryId', $category_id)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->whereYear('install_date', $year_id)
                                ->where('categoryId', $category_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->where('categoryId', $level->id)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }

            }else{
                $current_year = date('Y');
                foreach ($category as $key => $level){
                    for($i=1; $i<=12; $i++){
                       $cat_month[$level->name][$i] = DB::table('installments')
                            ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                            ->whereMonth('install_date', $i)
                            ->whereYear('install_date', $current_year)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('installments')
                            ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                            ->whereMonth('install_date', $i)
                            ->whereYear('install_date', $current_year)
                            ->groupBy('categoryId', 'month')
                            ->get();
                }
            }
        }else{
            $branch_id = Auth::user()->branchId;
            if(request()->has('year_id')){
                $year_id = request()->year_id;
                $customer_id = request()->customer_id;
                $category_id = request()->category_id;

                if($customer_id != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('customerId', $customer_id)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->whereYear('install_date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('customerId', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($customer_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('customerId', $customer_id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->whereYear('install_date', $year_id)
                                ->where('branchId',  $branch_id)
                                ->where('customerId', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($customer_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->where('categoryId', $category_id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->whereYear('install_date', $year_id)
                                ->where('branchId',  $branch_id)
                                ->where('categoryId', $category_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->where('categoryId', $level->id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('installments')
                                ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                                ->whereMonth('install_date', $i)
                                ->where('branchId',  $branch_id)
                                ->whereYear('install_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }

            }else{
                $current_year = date('Y');
                foreach ($category as $key => $level){
                    for($i=1; $i<=12; $i++){
                       $cat_month[$level->name][$i] = DB::table('installments')
                            ->select(DB::raw('sum(payment) as `total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                            ->whereMonth('install_date', $i)
                            ->whereYear('install_date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('installments')
                            ->select(DB::raw('sum(payment) as `all_m_total_payment`'), DB::raw('YEAR(install_date) year, MONTH(install_date) month'), 'categoryId')
                            ->whereMonth('install_date', $i)
                            ->whereYear('install_date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                }
            }
        }
        return view('admin.report.income.income', compact('cat_month_total','cat_month', 'ins_years', 'customers', 'category'));
    }

    public function bookingSummary()
    {
        $category = Category::get();
        $ins_years = DB::table('bookings')
                    ->select(DB::raw('YEAR(booking_date) year'))
                    ->groupBy('year')
                    ->get();
        $customers = DB::table('bookings')
                    ->select(
                        'customers.id',
                        'customers.customer_name'
                    )
                    ->leftJoin('customers','customers.id','=','bookings.customerid')
                    ->groupBy('customerid')
                    ->get();
        $cat_month = array();
        $cat_month_total = array();

        if(Auth::user()->type == 'admin'){
            if(request()->has('year_id')){
                $year_id = request()->year_id;
                $customer_id = request()->customer_id;
                $category_id = request()->category_id;

                if($customer_id != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('customerid', $customer_id)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->whereYear('booking_date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('customerid', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($customer_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('customerid', $customer_id)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->whereYear('booking_date', $year_id)
                                ->where('customerid', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($customer_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->where('categoryId', $category_id)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->whereYear('booking_date', $year_id)
                                ->where('categoryId', $category_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->where('categoryId', $level->id)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }

            }else{
                $current_year = date('Y');
                foreach ($category as $key => $level){
                    for($i=1; $i<=12; $i++){
                       $cat_month[$level->name][$i] = DB::table('bookings')
                            ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                            ->whereMonth('booking_date', $i)
                            ->whereYear('booking_date', $current_year)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('bookings')
                            ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                            ->whereMonth('booking_date', $i)
                            ->whereYear('booking_date', $current_year)
                            ->groupBy('categoryId', 'month')
                            ->get();
                }
            }
        }else{
            $branch_id = Auth::user()->branchId;
            if(request()->has('year_id')){
                $year_id = request()->year_id;
                $customer_id = request()->customer_id;
                $category_id = request()->category_id;

                if($customer_id != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('customerid', $customer_id)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->whereYear('booking_date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('customerid', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($customer_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('customerid', $customer_id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->whereYear('booking_date', $year_id)
                                ->where('branchId',  $branch_id)
                                ->where('customerid', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($customer_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->where('categoryId', $category_id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->whereYear('booking_date', $year_id)
                                ->where('branchId',  $branch_id)
                                ->where('categoryId', $category_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->where('categoryId', $level->id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('bookings')
                                ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                                ->whereMonth('booking_date', $i)
                                ->where('branchId',  $branch_id)
                                ->whereYear('booking_date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }

            }else{
                $current_year = date('Y');
                foreach ($category as $key => $level){
                    for($i=1; $i<=12; $i++){
                       $cat_month[$level->name][$i] = DB::table('bookings')
                            ->select(DB::raw('sum(total_price) as `total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                            ->whereMonth('booking_date', $i)
                            ->whereYear('booking_date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('bookings')
                            ->select(DB::raw('sum(total_price) as `all_m_total_booking`'), DB::raw('YEAR(booking_date) year, MONTH(booking_date) month'), 'categoryId')
                            ->whereMonth('booking_date', $i)
                            ->whereYear('booking_date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                }
            }
        }

        return view('admin.report.income.booking', compact('cat_month_total','cat_month', 'ins_years', 'customers', 'category'));
    }

    public function otherSummary()
    {
        $category = Category::get();
        $ins_years = DB::table('other')
                    ->select(DB::raw('YEAR(date) year'))
                    ->groupBy('year')
                    ->get();
        $sources = DB::table('other')
                    ->select('source_name')
                    ->groupBy('source_name')
                    ->get();
        $cat_month = array();
        $cat_month_total = array();

        if(Auth::user()->type == 'admin'){
            if(request()->has('year_id')){
                $year_id = request()->year_id;
                $source_name = request()->source_name;
                $category_id = request()->category_id;

                if($source_name != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('source_name', $source_name)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('source_name', $source_name)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($source_name != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('source_name', $source_name)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('source_name', $source_name)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($source_name == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $category_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('categoryId', $category_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $level->id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }

            }else{
                $current_year = date('Y');
                foreach ($category as $key => $level){
                    for($i=1; $i<=12; $i++){
                       $cat_month[$level->name][$i] = DB::table('other')
                            ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('other')
                            ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->groupBy('categoryId', 'month')
                            ->get();
                }
            }
        }else{
            $branch_id = Auth::user()->branchId;
            if(request()->has('year_id')){
                $year_id = request()->year_id;
                $source_name = request()->source_name;
                $category_id = request()->category_id;

                if($source_name != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('source_name', $source_name)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('source_name', $source_name)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($source_name != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('source_name', $source_name)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('branchId',  $branch_id)
                                ->where('source_name', $source_name)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($source_name == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $category_id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('branchId',  $branch_id)
                                ->where('categoryId', $category_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $level->id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('other')
                                ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }

            }else{
                $current_year = date('Y');
                foreach ($category as $key => $level){
                    for($i=1; $i<=12; $i++){
                       $cat_month[$level->name][$i] = DB::table('other')
                            ->select(DB::raw('sum(amount) as `total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('other')
                            ->select(DB::raw('sum(amount) as `all_m_total_other`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                }
            }
        }
        
        return view('admin.report.income.other', compact('cat_month_total','cat_month', 'ins_years', 'sources', 'category'));
    }
    
}
