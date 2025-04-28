<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pages_list')->only(['index']);
        $this->middleware('permission:pages_create')->only(['create', 'store']);
        $this->middleware('permission:pages_detail')->only(['show']);
        $this->middleware('permission:pages_update')->only(['edit', 'update']);
        $this->middleware('permission:pages_delete')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $query = Page::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $size = $request->size ?? 20;
        $pages = $query->paginate($size);

        return view('admin.pages.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|unique:pages,type',
            'content' => 'required',
        ]);

        Page::create($request->all());

        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|unique:pages,type,' . $page->id,
            'content' => 'required',
        ]);

        $page->update($request->all());

        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    }
}
