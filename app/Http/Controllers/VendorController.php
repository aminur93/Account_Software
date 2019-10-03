<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;
use Yajra\DataTables\Facades\DataTables;
use DB;

class VendorController extends Controller
{
    public function index()
    {
      return view('admin.vendor.index');
    }


    public function store(Request $request)
    {
        Vendor::insert([
          'vendor_name' => $request->vendor_name,
          'phone' => $request->vendor_phone,
          'address' => $request->vendor_address,
          'email' => $request->email,
        ]);
        return back();


    }

    public function getData()
    {
        $vendor = Vendor::get();

        return DataTables::of($vendor)
            ->addIndexColumn()

            ->addColumn('vus', function ($vendor) {
                return '<a href="/vendor/info/'.$vendor->id.'">'.$vendor->vendor_name.'</a>';
            })

            ->editColumn('action', function ($vendor) {
                $return = "<div class=\"btn-group\">";
                $return .= "<button type=\"button\" class=\"btn btn-xs btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> Action <span class=\"caret\"></span> </button><ul class=\"dropdown-menu\" style='margin-left: -100px;'>";
                if (!empty($vendor->id))
                {
                    $return .= "
                            <li class=\"dropdown-item\"><button data-id='$vendor->id'
                             data-name='$vendor->vendor_name'
                             data-phone='$vendor->phone'
                             data-address='$vendor->address'
                             data-email='$vendor->email'

                         style='background-color: transparent; margin-right: 5px' class=\"btn\" data-toggle=\"modal\" data-target=\"#editModal\">
                             Edit</button></li>
                             <li class=\"dropdown-item\">
                              <a rel=\"$vendor->id\" rel1=\"delete-vendor\" href=\"javascript:\"  class=\"deleteRecord\">
                                Delete
                                </a></li>
                              ";
                }
                $return .= "</ul></div>";
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action',
                'vus'
            ])

            ->make(true);
    }

    public function getVendor($id)
    {
        $vendor = Vendor::where('id',$id)->first();
        $vendor_total = DB::table('vendor_payments')
            ->groupBy('vendor_payments.vendor_id')
            ->selectRaw('sum(vendor_payments.amount) as sum')

            ->leftJoin('vendors','vendor_payments.vendor_id','=','vendors.id')
            ->where('vendor_payments.vendor_id',$id)
            ->get();
        return view('admin.vendor.vendor_info',compact('vendor','vendor_total'));
    }

    public function getVendorData(Request $request)
    {
        $id = $request->input('id');
        $vus = DB::table('vendor_payments')
            ->select(
                'vendor_payments.id',
                'vendor_payments.date',
                'categories.name',
                'branches.branch_name',
                'vendor_payments.amount',
                'accounts.account_name',
                'payments.payment_name'
            )
            ->leftJoin('vendors','vendor_payments.vendor_id','=','vendors.id')
            ->leftJoin('categories','vendor_payments.category_id','=','categories.id')
            ->leftJoin('branches','vendor_payments.branch_id','=','branches.id')
            ->leftJoin('accounts','vendor_payments.account','=','accounts.id')
            ->leftJoin('payments','vendor_payments.payment_method','=','payments.id')
            ->where('vendor_payments.vendor_id',$id)
            ->get();
        //dd($vus);die;
        return DataTables::of($vus)
            ->addIndexColumn()
            ->make(true);
    }


    public function update(Request $request)
    {
      Vendor::findOrFail($request->id)->update([
        'vendor_name' => $request->vendor_name,
        'phone' => $request->vendor_phone,
        'address' => $request->vendor_address,
        'email' => $request->email,
      ]);
      return back();
    }

    public function destroy($id)
    {
      Vendor::findOrFail($id)->delete();
      return back();

    }

}
