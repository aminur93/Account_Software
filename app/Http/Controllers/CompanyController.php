<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use DB;
use App\Branch;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    public function index()
    {
        if(Auth::user()->type == 'admin'){
            $branches = Branch::select('id', 'branch_name')->get();
        }else{
            $branch_id = Auth::user()->branchId;
            $branches = Branch::select('id', 'branch_name')->where('id', $branch_id)->get();
        }

        return view('admin.company.company', compact('branches'));
    }

    public function getData()
    {

        if(Auth::user()->type == 'admin'){
            $company = DB::table('companies')
                ->leftJoin('branches','companies.branchId','=','branches.id')
                        ->select('companies.*','branches.branch_name')
                        ->latest()->get();
        }else{
            $branch_id = Auth::user()->branchId;
            $company = DB::table('companies')
                    ->leftJoin('branches','companies.branchId','=','branches.id')
                    ->select('companies.*','branches.branch_name')
                    ->where('companies.branchId', $branch_id)->get();
        }
        

        return DataTables::of($company)
            ->addIndexColumn()

            ->editColumn('action', function ($company) {
                $return = "<div class=\"btn-group\">";
                if (!empty($company->id))
                {
                    $return .= "
                            <button data-company_id='$company->id' data-company_name='$company->company_name' data-branch_name='$company->branch_name' style='margin-right: 5px' class=\"btn btn-xs btn-default\" data-toggle=\"modal\" data-target=\"#editModal\">
                                    Edit
                                  </button>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action'
            ])

            ->make(true);


    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $company = new Company();

            $company->company_name = $request->company_name;
            $company->branchId = $request->branch_name;

            $company->save();

            return redirect()->back()->with('flash_message_success','Company Added Successfully!!');
        }
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $company = Company::findOrFail($request->company_id);

            $company->company_name = $request->company_name;
            $company->branchId = $request->branch_name;

            $company->update();

            return redirect()->back()->with('flash_message_success','Company Updated Successfully!!');
        }
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->back()->with('flash_message_success','Company Deleted Successfully!!');
    }
}
