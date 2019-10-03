<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Session;

class UserController extends Controller
{
    public function index()
    {
        $branch = Branch::all();
        $users = User::all();
        //dd($users);
        return view('admin.users.user',compact('branch','users'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $user = new User();
            if($request->user_branch != ''){
                $user->branchId = $request->user_branch;
            }else{
                $user->branchId = 0;
            }

            $user->uname = $request->user_name;
            $user->email = $request->user_email;
            $user->password = Hash::make($request->user_password);
            $user->phone = $request->user_phone;
            $user->address = $request->user_address;
            $user->zip_code = $request->user_zcode;
            $user->city = $request->user_city;

            //upload image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extenson = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extenson;
                    $image_path = 'uimage/'.$filename;

                    //Resize Image
                    Image::make($image_tmp)->resize(400,400)->save($image_path);

                    //store product image in data table
                    $user->image = $filename;
                }
            }

            $user->save();

            return redirect()->back()->with('flash_message_success','User Added Successfully!!!');
        }
    }

    public function getData()
    {
        $user = DB::table('users')
                ->select(
                    'users.id',
                    'users.branchId',
                    'branches.branch_name',
                    'users.uname',
                    'users.email',
                    'users.phone',
                    'users.address',
                    'users.zip_code',
                    'users.city',
                    'users.image'
                )
                ->leftJoin('branches','users.branchId','=','branches.id')
                ->get();

        return DataTables::of($user)
            ->addIndexColumn()

            ->addColumn('picture', function ($user) {
                return '<img style="width: 50px;" src="./uimage/'.$user->image.'"/>';
            })

            ->editColumn('action', function ($user) {
                $return = "<div class=\"btn-group\">";
                $return .= "<button type=\"button\" class=\"btn btn-xs btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> Action <span class=\"caret\"></span> </button><ul class=\"dropdown-menu\" style='margin-left: -100px;'>";
                if (!empty($user->uname))
                {
                    $return .= "
                            <li  class=\"dropdown-item\">
                            <a href=\"\"
                            data-uid='$user->id'
                            data-branch_name='$user->branch_name'
                            data-bid = '$user->branchId'
                            data-uname='$user->uname'
                            data-uemail='$user->email'
                            data-uphone='$user->phone'
                            data-uaddress='$user->address'
                            data-uzcode='$user->zip_code'
                            data-ucity='$user->city'
                            data-uimage='$user->image'
                            style='margin-right: 5px' data-toggle=\"modal\" data-target=\"#editModal\">
                                 Edit
                                  </a></li>
                                <li  class=\"dropdown-item\"><a rel=\"$user->id\" rel1=\"delete-user\" href=\"javascript:\"  class=\"deleteRecord\">
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
                'picture'
            ])

            ->make(true);
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $user = User::findOrFail($request->user_id);

            $user->branchId = $request->user_branch;
            $user->uname = $request->user_name;
            $user->email = $request->user_email;
            $user->password = Hash::make($request->user_password);
            $user->phone = $request->user_phone;
            $user->address = $request->user_address;
            $user->zip_code = $request->user_zcode;
            $user->city = $request->user_city;

            if($request->image){
                if($user->image != "default.png"){
                    $image_path = public_path().'/uimage/'.$user->image;
                    unlink($image_path);
                }
            }

            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'uimage/'.$filename;
                    //Resize Image
                    Image::make($image_tmp)->resize(400,400)->save($image_path);
                    //store new image in data table
                    $user->image = $filename;
                }
            }

            $user->save();

            return redirect()->back()->with('flash_message_success','User Added Successfully!!!');
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->image != "default.png"){
            $image_path = public_path().'/uimage/'.$user->image;
            if(file_exists($image_path)){
                 unlink($image_path);
            }
         }

        $user->delete();

        return redirect()->back()->with('flash_message_success','User Deleted Successfully!!!');
    }

    public function getPassword()
    {
        return view('admin.users.change_password');
    }

    public function chkPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>";print_r($data);die;
        $current_password = $data['current_pwd'];
        $user_id = Auth::user()->id;
        $check_password = User::where('id',$user_id)->first();
        if (Hash::check($current_password, $check_password->password)) {
            echo "true";die;
        }else {
            echo "false";die;
        }
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo"<pre>";print_r($data);die;
            $old_pwd = User::where('id',Auth::user()->id)->first();
            $current_pwd = $data['current_pwd'];
            if (Hash::check($current_pwd, $old_pwd->password)) {
                //update password
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id',Auth::user()->id)->update(['password' => $new_pwd]);
                return redirect()->back()->with('flash_message_success',' password is Updated Successfully');
            }else {
                return redirect()->back()->with('flash_message_error','Current password is Incorrect');
            }
        }
    }
}
