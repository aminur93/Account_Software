<?php

namespace App\Http\Controllers;

use App\SalesPerson;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Image;
use Illuminate\Support\Facades\Input;


class SalesPersonController extends Controller
{
    public function index()
    {
        return view('admin.sales_person.sales_person');
    }

    public function store(Request $request)
    {

        if ($request->isMethod('post'))
        {
            $salesperson = new SalesPerson();

            $salesperson->seller_name = $request->sales_person_name;
            $salesperson->phone = $request->phone;
            $salesperson->email = $request->email;
            $salesperson->national_id = $request->national_id;
            $salesperson->address = $request->address;
            $salesperson->city = $request->city;
            $salesperson->postal_code = $request->postal_code;
            $salesperson->country = $request->country;
            $salesperson->sales_parcentage = $request->sales_parcentage;

            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'images/'.$filename;
                    //Resize Image
                    Image::make($image_tmp)->resize(400,400)->save($image_path);
                    //store image in data table
                    $salesperson->image = $filename;
                }
            }

            $salesperson->save();

            return redirect()->back()->with('flash_message_success','Sales Person Added Successfully!!');
        }
    }

    public function getData()
    {
        $salesperson = SalesPerson::latest()->get();

        return DataTables::of($salesperson)
            ->addIndexColumn()

            ->editColumn('action', function ($salesperson) {
                $return = "<div class=\"btn-group\">";
                $return .= "<button type=\"button\" class=\"btn btn-xs btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> Action <span class=\"caret\"></span> </button><ul class=\"dropdown-menu\" style='margin-left: -100px;'>";
                if (!empty($salesperson->id))
                {

                    $return .= "   <li  class=\"dropdown-item\">
                                    <a href=\"\"
                                    data-sales_person_id='$salesperson->id'
                                    data-sales_person_name='$salesperson->seller_name'
                                    data-phone='$salesperson->phone'
                                    data-email='$salesperson->email'
                                    data-national_id='$salesperson->national_id'
                                    data-address='$salesperson->address'
                                    data-city='$salesperson->city'
                                    data-postal_code='$salesperson->postal_code'
                                    data-country='$salesperson->country'
                                    data-sales_parcentage='$salesperson->sales_parcentage'
                                    data-image='$salesperson->image'
                                    style='margin-right: 5px' data-toggle=\"modal\" data-target=\"#editModal\">
                                         Edit
                                          </a></li>
                                <li  class=\"dropdown-item\"><a rel=\"$salesperson->id\" rel1=\"delete-salesperson\" href=\"javascript:\"  class=\"deleteRecord\">
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


    public function update(Request $request, SalesPerson $salesPerson)
    {
        if ($request->isMethod('post'))
        {
            $salesPerson = SalesPerson::findOrFail($request->sales_person_id);

            $salesPerson->seller_name = $request->sales_person_name;
            $salesPerson->phone = $request->phone;
            $salesPerson->email = $request->email;
            $salesPerson->national_id = $request->national_id;
            $salesPerson->address = $request->address;
            $salesPerson->city = $request->city;
            $salesPerson->postal_code = $request->postal_code;
            $salesPerson->country = $request->country;
            $salesPerson->sales_parcentage = $request->sales_parcentage;

            if($request->image){
                if($salesPerson->image != "default.png"){
                    $image_path = public_path().'/images/'.$salesPerson->image;
                    unlink($image_path);
                }
            }

            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'images/'.$filename;
                    //Resize Image
                    Image::make($image_tmp)->resize(400,400)->save($image_path);
                    //store new image in data table
                    $salesPerson->image = $filename;
                }
            }

            $salesPerson->update();

            return redirect()->back()->with('flash_message_success','Sales Person Updated Sucessfully');
        }
    }


    public function destroy($id)
    {
        $salesperson = SalesPerson::findOrFail($id);

        if($salesperson->image != "default.png"){
           $image_path = public_path().'/images/'.$salesperson->image;
           if(file_exists($image_path)){
                unlink($image_path);
           }
        }
        
        $salesperson->delete();

        return redirect()->back()->with('flash_message_success','Sales Person Deleted Successfully!!');
    }
}
