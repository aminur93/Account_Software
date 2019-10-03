<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('admin.category.category',compact('category'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $category = new Category();

            $category->name = $request->category_name;
            $category->type = $request->type;

            $category->save();

            return redirect()->back()->with('flash_message_success','Category Added Successfully!!');
        }
    }

    public function getData()
    {
        $category = Category::latest()->get();

        return DataTables::of($category)
            ->addIndexColumn()

            ->editColumn('action', function ($category) {
                $return = "<div class=\"btn-group\">";
                if (!empty($category->name))
                {
                    $return .= "
                            <button data-catid='$category->id' data-catname='$category->name' data-type='$category->type' style='margin-right: 5px' class=\"btn btn-xs btn-default\" data-toggle=\"modal\" data-target=\"#editModal\">Edit</button>
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
            $category = Category::findOrFail($request->category_id);

            $category->name = $request->category_name;
            $category->type = $request->type;

            $category->update();

            return redirect()->back()->with('flash_message_success','Category Updated Sucessfully');
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('flash_message_success','Category Deleted Successfully!!');
    }
}
