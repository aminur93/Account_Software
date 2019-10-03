<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\SalesIncome;
use App\Category;
use Auth;

class ExpenseReportController extends Controller
{
    public function sales()
    {

        $category = Category::get();
        $ins_years = DB::table('sales_incomes')
                    ->select(DB::raw('YEAR(date) year'))
                    ->groupBy('year')
                    ->get();
        $sellers = DB::table('sales_incomes')
                    ->select(
                        'sales_people.id',
                        'sales_people.seller_name'
                    )
                    ->leftJoin('sales_people','sales_people.id','=','sales_incomes.sellerId')
                    ->groupBy('sellerId')
                    ->get();

        $cat_month = array();
        $cat_month_total = array();

        if(Auth::user()->type == 'admin'){
            if(request()->has('year_id')){
                $year_id = request()->year_id;
                $seller_id = request()->seller_id;
                $category_id = request()->category_id;

                if($seller_id != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('sellerId', $seller_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('sellerId', $seller_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($seller_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('sellerId', $seller_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('sellerId', $seller_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($seller_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $category_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('categoryId', $category_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $level->id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
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
                       $cat_month[$level->name][$i] = DB::table('sales_incomes')
                            ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('sales_incomes')
                            ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
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
                $seller_id = request()->seller_id;
                $category_id = request()->category_id;

                if($seller_id != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('sellerId', $seller_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('sellerId', $seller_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($seller_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('sellerId', $seller_id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('branchId',  $branch_id)
                                ->where('sellerId', $seller_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($seller_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $category_id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
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
                           $cat_month[$level->name][$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $level->id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('sales_incomes')
                                ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
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
                       $cat_month[$level->name][$i] = DB::table('sales_incomes')
                            ->select(DB::raw('sum(seller_income) as `total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('sales_incomes')
                            ->select(DB::raw('sum(seller_income) as `all_m_total_sales`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                }
            }
        }
        return view('admin.report.expense.sales_commission', compact('cat_month_total','cat_month', 'ins_years', 'sellers', 'category'));
    }

    public function customer()
    {

        $category = Category::get();
        $ins_years = DB::table('customer_commisions')
                    ->select(DB::raw('YEAR(date) year'))
                    ->groupBy('year')
                    ->get();
        $customers = DB::table('customer_commisions')
                    ->select(
                        'customers.id',
                        'customers.customer_name'
                    )
                    ->leftJoin('customers','customers.id','=','customer_commisions.customer_id')
                    ->groupBy('customer_id')
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
                           $cat_month[$category_name[0]][$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('customer_id', $customer_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('customer_id', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($customer_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('customer_id', $customer_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('customer_id', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($customer_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $category_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('categoryId', $category_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $level->id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
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
                       $cat_month[$level->name][$i] = DB::table('customer_commisions')
                            ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('customer_commisions')
                            ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
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
                $customer_id = request()->customer_id;
                $category_id = request()->category_id;

                if($customer_id != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('customer_id', $customer_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('categoryId',  $category_id)
                                ->where('branchId',  $branch_id)
                                ->where('customer_id', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }
                }else if($customer_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId',  $level->id)
                                ->where('customer_id', $customer_id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('branchId',  $branch_id)
                                ->where('customer_id', $customer_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                    }

                }else if($customer_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $category_id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
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
                           $cat_month[$level->name][$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('categoryId', $level->id)
                                ->where('branchId',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('categoryId', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('customer_commisions')
                                ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
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
                       $cat_month[$level->name][$i] = DB::table('customer_commisions')
                            ->select(DB::raw('sum(grand_total) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->where('categoryId', $level->id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('customer_commisions')
                            ->select(DB::raw('sum(grand_total) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('branchId',  $branch_id)
                            ->groupBy('categoryId', 'month')
                            ->get();
                }
            }
        }
        return view('admin.report.expense.customer_commission', compact('cat_month_total','cat_month', 'ins_years', 'customers', 'category'));
    }
    
    public function vendor()
    {

        $category = Category::get();
        $ins_years = DB::table('vendor_payments')
                    ->select(DB::raw('YEAR(date) year'))
                    ->groupBy('year')
                    ->get();
        $vendors = DB::table('vendor_payments')
                    ->select(
                        'vendors.id',
                        'vendors.vendor_name'
                    )
                    ->leftJoin('vendors','vendors.id','=','vendor_payments.vendor_id')
                    ->groupBy('vendor_id')
                    ->get();

        $cat_month = array();
        $cat_month_total = array();

        if(Auth::user()->type == 'admin'){
            if(request()->has('year_id')){
                $year_id = request()->year_id;
                $vendor_id = request()->vendor_id;
                $category_id = request()->category_id;

                if($vendor_id != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'categoryId')
                                ->whereMonth('date', $i)
                                ->where('category_id',  $category_id)
                                ->where('vendor_id', $vendor_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('category_id',  $category_id)
                                ->where('vendor_id', $vendor_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                    }
                }else if($vendor_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->where('category_id',  $level->id)
                                ->where('vendor_id', $vendor_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('vendor_id', $vendor_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                    }

                }else if($vendor_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->where('category_id', $category_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('category_id', $category_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->where('category_id', $level->id)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                    }
                }

            }else{
                $current_year = date('Y');
                foreach ($category as $key => $level){
                    for($i=1; $i<=12; $i++){
                       $cat_month[$level->name][$i] = DB::table('vendor_payments')
                            ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('category_id', $level->id)
                            ->groupBy('category_id', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('vendor_payments')
                            ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->groupBy('category_id', 'month')
                            ->get();
                }
            }
        }else{
            $branch_id = Auth::user()->branchId;
            if(request()->has('year_id')){
                $year_id = request()->year_id;
                $vendor_id = request()->vendor_id;
                $category_id = request()->category_id;

                if($vendor_id != '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->where('category_id',  $category_id)
                                ->where('branch_id',  $branch_id)
                                ->where('vendor_id', $vendor_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('category_id',  $category_id)
                                ->where('branch_id',  $branch_id)
                                ->where('vendor_id', $vendor_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                    }
                }else if($vendor_id != '' && $category_id ==''){

                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->where('category_id',  $level->id)
                                ->where('vendor_id', $vendor_id)
                                ->where('branch_id',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('branch_id',  $branch_id)
                                ->where('vendor_id', $vendor_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                    }

                }else if($vendor_id == '' && $category_id !=''){
                    $category_name = Category::where('id', $category_id)->pluck('name');
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$category_name[0]][$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->where('category_id', $category_id)
                                ->where('branch_id',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->whereYear('date', $year_id)
                                ->where('branch_id',  $branch_id)
                                ->where('category_id', $category_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                    }

                }else{
                    foreach ($category as $key => $level){
                        for($i=1; $i<=12; $i++){
                           $cat_month[$level->name][$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->where('category_id', $level->id)
                                ->where('branch_id',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                        }
                    }

                    for($i=1; $i<=12; $i++){
                        $cat_month_total[$i] = DB::table('vendor_payments')
                                ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                                ->whereMonth('date', $i)
                                ->where('branch_id',  $branch_id)
                                ->whereYear('date', $year_id)
                                ->groupBy('category_id', 'month')
                                ->get();
                    }
                }

            }else{
                $current_year = date('Y');
                foreach ($category as $key => $level){
                    for($i=1; $i<=12; $i++){
                       $cat_month[$level->name][$i] = DB::table('vendor_payments')
                            ->select(DB::raw('sum(amount) as `total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('branch_id',  $branch_id)
                            ->where('category_id', $level->id)
                            ->groupBy('category_id', 'month')
                            ->get();
                    }
                }

                for($i=1; $i<=12; $i++){
                    $cat_month_total[$i] = DB::table('vendor_payments')
                            ->select(DB::raw('sum(amount) as `all_m_total`'), DB::raw('YEAR(date) year, MONTH(date) month'), 'category_id')
                            ->whereMonth('date', $i)
                            ->whereYear('date', $current_year)
                            ->where('branch_id',  $branch_id)
                            ->groupBy('category_id', 'month')
                            ->get();
                }
            }
        }
        return view('admin.report.expense.other', compact('cat_month_total','cat_month', 'ins_years', 'vendors', 'category'));
    }
}
