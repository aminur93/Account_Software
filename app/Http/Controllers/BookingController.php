<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Installment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Category;
use App\Branch;
use App\Company;
use App\Customer;
use App\SalesPerson;
use App\SubCategory;
use Auth;

class BookingController extends Controller
{

    public function index()
    {
        return view('admin.booking.booking');
    }

    public function insert()
    {
        $categories = Category::get();
        $dataCategory = [];
        foreach ($categories as $category)
        {
            $dataCategory[$category->type][] = $category;

        }
        if(Auth::user()->type == 'admin'){
            $branches = Branch::select('id', 'branch_name')->get();
            $company = Company::select('id', 'company_name')->get();
            $customers = Customer::select('id', 'customer_name')->get();
        }else{
            $branch_id = Auth::user()->branchId;
            $branches = Branch::select('id', 'branch_name')->where('id', $branch_id)->get();
            $company = Company::select('id', 'company_name','branchId')->where('branchId', $branch_id)->get();
            $customers = Customer::select('id', 'customer_name', 'branchId')->where('branchId', $branch_id)->get();
        }
        $sellers = SalesPerson::select('id', 'seller_name')->get();

        return view('admin.booking.insert', compact('categories','dataCategory', 'branches', 'customers', 'sellers', 'company'));
    }

    public function subcategory(Request $request)
    {
        if (!$request->categoryId) {
            $html = '<option value="">'.'-Select One-'.'</option>';
        } else {
            $html = '<option value="">'.'-Select One-'.'</option>';
            $sub_categories = SubCategory::where('categoryId', $request->categoryId)->get();
            foreach ($sub_categories as $sub_category) {
                $html .= '<option value="'.$sub_category->id.'">'.$sub_category->sname.'</option>';
            }
        }
        return response()->json(['html' => $html]);
    }

    public function company(Request $request)
    {
        if (!$request->branchId) {
            $html = '<option value="">'.'-Select One-'.'</option>';
        } else {
            $html = '<option value="">'.'-Select One-'.'</option>';
            $companies = Company::where('branchId', $request->branchId)->get();
            foreach ($companies as $company) {
                $html .= '<option value="'.$company->id.'">'.$company->company_name.'</option>';
            }
        }
        return response()->json(['html' => $html]);
    }

    public function sqft(Request $request)
    {
        $sub_category = SubCategory::where('id', $request->id)->first();
        echo $sub_category->sqft;
    }

    public function store(Request $request)
    {

        if ($request->isMethod('post'))
        {
            $booking = new Booking();

            $booking->booking_no = $request->booking_no;
            $booking->booking_type = $request->booking_type;
            $booking->sellerId = $request->seller_name;
            $booking->customerid = $request->customer_name;
            $booking->branchId = $request->branch_name;
            $booking->companyId = $request->company_name;
            $booking->categoryId = $request->category_name;
            $booking->subcategoryId = $request->sub_category_name;
            $booking->sqfit = $request->sqft;
            $booking->price = $request->price;
            $booking->total_price = $request->total_price;
            $booking->booking_date = $request->booking_date;

            $booking->save();

            return redirect('/booking')->with('flash_message_success','Booking Added Successfully!!');
        }
    }

    public function getData()
    {

        if(Auth::user()->type == 'admin'){
            $booking = DB::table('bookings')
                        ->leftJoin('sales_people','bookings.sellerId','=','sales_people.id')
                        ->leftJoin('customers','bookings.customerid','=','customers.id')
                        ->leftJoin('branches','bookings.branchId','=','branches.id')
                        ->leftJoin('companies','bookings.companyId','=','companies.id')
                        ->leftJoin('categories','bookings.categoryId','=','categories.id')
                        ->leftJoin('sub_categories','bookings.subcategoryId','=','sub_categories.id')
                        ->select('bookings.*', 'sales_people.seller_name', 'customers.customer_name', 'customers.father_name', 'branches.branch_name','companies.company_name', 'categories.name', 'sub_categories.sname','sub_categories.sqft' )
                        ->latest()->get();
        }else{
            $branch_id = Auth::user()->branchId;

            $booking = DB::table('bookings')
                        ->leftJoin('sales_people','bookings.sellerId','=','sales_people.id')
                        ->leftJoin('customers','bookings.customerid','=','customers.id')
                        ->leftJoin('branches','bookings.branchId','=','branches.id')
                        ->leftJoin('companies','bookings.companyId','=','companies.id')
                        ->leftJoin('categories','bookings.categoryId','=','categories.id')
                        ->leftJoin('sub_categories','bookings.subcategoryId','=','sub_categories.id')
                        ->select('bookings.*', 'sales_people.seller_name', 'customers.customer_name', 'customers.father_name', 'branches.branch_name','companies.company_name', 'categories.name', 'sub_categories.sname','sub_categories.sqft' )
                        ->where('bookings.branchId', $branch_id)
                        ->latest()->get();
        }


        return DataTables::of($booking)
            ->addIndexColumn()

            ->addColumn('cus', function ($booking) {
                return '<a href="/customer/installment/info/'.$booking->customerid.'">'.$booking->customer_name.'</a>';
            })

            ->addColumn('bno', function ($booking) {
                return '<a href="/booking/customer/installment/'.$booking->id.'">'.$booking->booking_no.'</a>';
            })

            ->editColumn('action', function ($booking) {
                $return = "<div class=\"btn-group\">";
                $return .= "<button type=\"button\" class=\"btn btn-xs btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> Action <span class=\"caret\"></span> </button><ul class=\"dropdown-menu\" style='margin-left: -100px;'>";
                if (!empty($booking->id))
                {
                    $return .= "
                                <li class=\"dropdown-item\"><a href=\"installment/insert\">
                                    Add new installment
                                </a></li>
                                <li  class=\"dropdown-item\"><a href=\"booking/edit/$booking->id\" >Edit
                                </a></li>
                                <li  class=\"dropdown-item\"><a style='text-align:left;' rel=\"$booking->id\" rel1=\"delete-booking\" href=\"javascript:\"  class=\"deleteRecord\">
                                    Delete
                                </a></li>";

                }
                $return .= "</ul></div>";
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action',
                'bno',
                'cus'
            ])
            ->make(true);
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);

        if(Auth::user()->type == 'admin'){
            $branches = Branch::select('id', 'branch_name')->get();
            $company = Company::select('id', 'company_name')->get();
            $customers = Customer::select('id', 'customer_name')->get();
        }else{
            $branch_id = Auth::user()->branchId;
            $branches = Branch::select('id', 'branch_name')->where('id', $branch_id)->get();
            $company = Company::select('id', 'company_name','branchId')->where('branchId', $branch_id)->get();
            $customers = Customer::select('id', 'customer_name', 'branchId')->where('branchId', $branch_id)->get();
        }

        $categories = Category::select('id','type', 'name')->get();
        foreach ($categories as $category)
        {
            $dataCategory[$category->type][] = $category;

        }
        $sub_categories = SubCategory::select('id', 'sname', 'sqft', 'categoryid')->get();
        $sellers = SalesPerson::select('id', 'seller_name')->get();

        return view('admin.booking.edit', compact('booking','company','dataCategory', 'categories', 'sub_categories', 'branches', 'customers', 'sellers'));

    }


    public function update(Request $request, Booking $booking)
    {
        if ($request->isMethod('post'))
        {
            $booking = Booking::findOrFail($request->id);

            $booking->booking_no = $request->booking_no;
            $booking->booking_type = $request->booking_type;
            $booking->sellerId = $request->seller_name;
            $booking->customerid = $request->customer_name;
            $booking->branchId = $request->branch_name;
            $booking->companyId = $request->company_name;
            $booking->categoryId = $request->category_name;
            $booking->subcategoryId = $request->sub_category_name;
            $booking->sqfit = $request->sqft;
            $booking->price = $request->price;
            $booking->total_price = $request->total_price;
            $booking->booking_date = $request->booking_date;

            $booking->update();

            return redirect('/booking')->with('flash_message_success','Booking Updated Successfully!!');
        }
    }


    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->back()->with('flash_message_success','Booking Deleted Successfully!!');
    }

    public function getCI($id)
    {
        $book = Booking::where('id',$id)->first();

        $booking = DB::table('installments')
            ->groupBy('installments.bookingId')
            ->selectRaw('sum(installments.payment) as sum')

            ->leftJoin('bookings','installments.bookingId','=','bookings.id')
            ->where('installments.bookingId',$id)
            ->get();
        //dd($booking);die;

        $bookings = Booking::where('id',$id)->first();

        return view('admin.booking.installment_info',compact('book','booking','bookings'));
    }

    public function getBookingData(Request $request)
    {
        $id = $request->input('id');

        $bi = DB::table('installments')
            ->select(
                'installments.id',
                'installments.install_name',
                'installments.install_date',
                'bookings.booking_no',
                'installments.payment'
            )
            ->leftJoin('customers','installments.customerId','=','customers.id')
            ->leftJoin('branches','installments.branchId','=','branches.id')
            ->leftJoin('bookings','installments.bookingId','=','bookings.id')
            ->where('installments.bookingId',$id)
            ->get();

        return DataTables::of($bi)
            ->addIndexColumn()
            ->make(true);
    }

}
