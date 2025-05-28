<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $footers = Footer::orderBy('section')->orderBy('order')->get()->groupBy('section');
        return view('admin.footer.index', compact('footers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'link_text' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
        ]);

        Footer::create([
            'section' => $request->section,
            'link_text' => $request->link_text,
            'link_url' => $request->link_url,
            'order' => Footer::where('section', $request->section)->count(),
        ]);

        return response()->json(['message' => 'Footer item added successfully']);
    }

    public function update(Request $request, $id)
    {
        $footer = Footer::findOrFail($id);
        $footer->update($request->only(['section', 'link_text', 'link_url']));
        return response()->json(['message' => 'Footer item updated successfully']);
    }

    public function destroy($id)
    {
        Footer::findOrFail($id)->delete();
        return response()->json(['message' => 'Footer item deleted successfully']);
    }

    public function getFooterData()
    {
        $footers = Footer::orderBy('section')->orderBy('order')->get()->groupBy('section');
        return view('partials.footer', compact('footers'));
    }
}
