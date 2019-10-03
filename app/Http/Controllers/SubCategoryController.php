<?php

namespace App\Http\Controllers;

use App\SubCategory;
use App\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;

class SubCategoryController extends Controller
{
    public function index()
    {
      $category = Category::where('type','item')->get();
      $sub_category = SubCategory::get();
      //dd($sub_category);
      return view('admin.subcategory.index',compact('category','sub_category'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $category = new SubCategory();
            $category->categoryid = $request->categoryid;
            $category->sname = $request->sname;
            $category->sqft = $request->sqft;
            $category->save();
            return redirect()->back()->with('flash_message_success','Sub Category Added Successfully!!');
        }
    }

    public function getData()
    {
        $sub_category = DB::table('sub_categories')
                        ->select('sub_categories.id','sub_categories.categoryid','sub_categories.sname','categories.name','sub_categories.sqft')
                        ->leftJoin('categories','sub_categories.categoryid','=','categories.id')
                        ->get();
       //dd($sub_category);
        return DataTables::of($sub_category)
            ->addIndexColumn()

            ->editColumn('action', function ($sub_category) {
                $return = "<div class=\"btn-group\">";
                if (!empty($sub_category->sname))
                {
                    $return .= "
                            <button data-subcatid='$sub_category->id' data-c_id='$sub_category->categoryid'  data-catid='$sub_category->name' data-sname='$sub_category->sname' data-sqfit='$sub_category->sqft'  style='margin-right: 5px' class=\"btn btn-xs btn-default\" data-toggle=\"modal\" data-target=\"#editModal\">
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

    public function update(Request $request)
    {
        if ($request->isMethod('post'))
        {

              $category = SubCategory::findOrFail($request->cat_id);
              $category->sname = $request->sname;
              $category->categoryid = $request->categoryid;
              $category->sqft = $request->sqft;
              $category->save();
              return redirect()->back()->with('flash_message_success','Sub Category Updated Sucessfully');
            }
          }

    public function destroy($id)
    {
        $category = SubCategory::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('flash_message_success','Sub Category Deleted Successfully!!');
    }
}
