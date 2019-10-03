<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{

    public function index()
    {
        return view('admin.branch.branch');
    }


    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $branch = new Branch();

            $branch->branch_name = $request->branch_name;

            $branch->save();

            return redirect()->back()->with('flash_message_success','Branch Added Successfully!!');
        }
    }
    public function getData()
    {
        $branch = Branch::latest()->get();

        return DataTables::of($branch)
            ->addIndexColumn()->editColumn('action', function ($branch) {
                $return = "<div class=\"btn-group\">";
                if (!empty($branch->branch_name))
                {
                    $return .= "<button data-branchid='$branch->id' data-branchname='$branch->branch_name' style='margin-right: 5px' class=\"btn btn-xs btn-default\" data-toggle=\"modal\" data-target=\"#editModal\">Edit</button>";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action'
            ])

            ->make(true);
    }

    public function update(Request $request, Branch $branch)
    {
        if ($request->isMethod('post'))
        {
            $branch = Branch::findOrFail($request->branch_id);

            $branch->branch_name = $request->branch_name;

            $branch->update();

            return redirect()->back()->with('flash_message_success','Branch Updated Sucessfully');
        }
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->back()->with('flash_message_success','Branch Deleted Successfully!!');
    }
}
