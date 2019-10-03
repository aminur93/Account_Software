<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
      $branches = Branch::all();
      $users = User::where("type" , "user")->orWhere('type' , "admin")->get();
      return view('admin.permission.index',compact('users','branches'));
    }

    public function insert(Request $request)
    {
      User::where(['branchid'=> $request->branch_id, 'id'=>$request->user_id])->update(['type' => $request->role_id]);
      return back()->with('flash_message_success','Role Name Insert Successfully');
    }

    public function Permissioninsert(Request $request)
    {
      if($request->role_id == 'admin'){
        User::where(['id'=>$request->user_id])->update(['type' => $request->role_id, 'branchid'=> 0 ]);
      }else{
        User::where(['branchid'=> $request->branch_id, 'id'=>$request->user_id])->update(['type' => $request->role_id]);
      }
      
      return back()->with('flash_message_success','Permission Select Successfully');
    }

    public function getUser(Request $request){
      $requestData = $request->bid;
      $data = User::where('branchid', $requestData)->where('type', '')->get();
      echo json_encode($data);
    }
}
