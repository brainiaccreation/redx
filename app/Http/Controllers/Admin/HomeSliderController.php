<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class HomeSliderController extends Controller
{
    public function list()
    {
        return view('admin.home_sliders.list');
    }
    public function get(Request $request)
    {
        if ($request->ajax()) {
            $data = HomeSlider::select('home_sliders.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('heading', function ($row) {
                    return ' <span style="white-space: normal;">' . $row->heading . '</span>';
                })
                ->addColumn('background_image', function ($row) {
                    $imgUrl = asset($row->background_image);
                    return '<a href="javascript:void(0);" class="viewImageBtn" data-image="' . $imgUrl . '">
                                <span style="white-space: normal;">View Image</span>
                            </a>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <div style="display: flex;justify-content: center; gap: 8px;">
                            
                            <a href="javascript:void(0);" 
                                class="action_btn edit-item editSlide" 
                                data-id="' . $row->id . ' "
                                data-heading="' . $row->heading . '"
                                data-content="' . $row->content . '"
                                data-image="' . asset($row->background_image) . '"
                                data-action="' . route('admin.home_slider.update', $row->id) . '">
                                <i class="ri-edit-line"></i>
                            </a>

                            <form method="POST" action="' . route('admin.home_slider.destroy', $row->id) . '" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="action_btn delete-item show_confirm" data-name="Product">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->filterColumn('heading', function ($query, $keyword) {
                    $query->whereRaw('LOWER(heading) LIKE ?', ["%" . strtolower($keyword) . "%"]);
                })
                ->orderColumn('heading', function ($query, $order) {
                    $query->select('home_sliders.*')->orderBy('home_sliders.heading', $order);
                })
                ->rawColumns(['heading', 'background_image', 'action'])
                ->make(true);
        }
    }
    public function create()
    {
        return view('admin.home_sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'heading' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:200',
            'background_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('background_image')) {
            $image = $request->file('background_image');
            $name = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = public_path('home/sliders');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true);
            }

            $image->move($path, $name);
            $data['background_image'] = 'home/sliders/' . $name;
        }

        HomeSlider::create($data);
        return response()->json(['success' => true, 200]);
    }


    public function edit(HomeSlider $homeSlider)
    {
        return view('admin.home_sliders.edit', compact('homeSlider'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'heading' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:200',
            'background_image' => 'nullable|image|max:2048',
        ]);
        $homeSlider = HomeSlider::find($id);
        if ($request->hasFile('background_image')) {
            // Delete old image
            if ($homeSlider->background_image && File::exists(public_path($homeSlider->background_image))) {
                File::delete(public_path($homeSlider->background_image));
            }

            $image = $request->file('background_image');
            $name = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = public_path('home/sliders');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true);
            }

            $image->move($path, $name);
            $data['background_image'] = 'home/sliders/' . $name;
        }

        $homeSlider->update($data);
        return response()->json(['success' => true, 200]);
    }


    public function destroy($id)
    {
        $homeSlider = HomeSlider::find($id);
        if ($homeSlider->background_image && File::exists(public_path($homeSlider->background_image))) {
            File::delete(public_path($homeSlider->background_image));
        }

        $homeSlider->delete();

        return redirect()->back()->with('success', 'Request has been completed.');
    }
}
