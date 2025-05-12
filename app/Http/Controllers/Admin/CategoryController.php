<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function list() {
        return view('admin.categories.list');
    }

    public function get(Request $request) {
        if ($request->ajax()) {
        $data = Category::select('categories.*');
            return DataTables::of($data)
                ->addIndexColumn()
                 ->addColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="text-center">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                <input type="checkbox" class="form-check-input status" id="customSwitchsizemd" data-id="' . $row->id .'" ' . $checked . '>
                            </div>
                        </div>
                    ';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="'.route('admin.category.edit',$row->id).'" class="btn btn-sm btn-info">Edit</a>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
    }

    public function add(){
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:categories,slug',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = $validated['slug'];
        $category->description = $request->description;
        $category->status = $request->has('status') ? 1 : 0;
        $category->save();

        return redirect()->route('admin.categories.list')->with('success', 'Category created successfully.');
    }

    public function edit($id){
        $category = Category::find($id);
        return view('admin.categories.edit',compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:categories,slug,' . $id,
        ]);

        $category = Category::find($id);
        $category->name = $validated['name'];
        $category->slug = $validated['slug'];
        $category->description = $request->description;
        $category->status = $request->has('status') ? 1 : 0;
        $category->update();

        return redirect()->route('admin.categories.list')->with('success', 'Category updated successfully.');
    }

    public function status($id, Request $request) {
        Category::where('id', $id)->update(['status' => $request->status]);
        return response()->json(['message' => 'Caregory Status Updated', 'status' => 200]);
    }

}
