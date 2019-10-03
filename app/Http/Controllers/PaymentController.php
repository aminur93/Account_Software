<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index()
    {
        return view('admin.payment.payment');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $payment = new Payment();

            $payment->payment_name = $request->payment_name;

            $payment->save();

            return redirect()->back()->with('flash_message_success','payment Added Successfully!!');
        }
    }

    public function getData()
    {
        $payment = Payment::latest()->get();

        return DataTables::of($payment)
            ->addIndexColumn()

            ->editColumn('action', function ($payment) {
                $return = "<div class=\"btn-group\">";
                if (!empty($payment->id))
                {
                    $return .= "<button data-payment_id='$payment->id' data-payment_name='$payment->payment_name' style='margin-right: 5px' class=\"btn btn-xs btn-default\" data-toggle=\"modal\" data-target=\"#editModal\">Edit</button>";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action'
            ])

            ->make(true);
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $payment = Payment::findOrFail($request->payment_id);

            $payment->payment_name = $request->payment_name;

            $payment->update();

            return redirect()->back()->with('flash_message_success','Payment Updated Sucessfully');
        }
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->back()->with('flash_message_success','Payment Deleted Successfully!!');
    }
}
