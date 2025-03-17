<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin/pages/banners.index', compact('banners'));
    }

    public function create()
    {
        $positions = range(1, 3);
        $usedPositions = Banner::pluck('position')->toArray();
        $availablePositions = array_diff($positions, $usedPositions);

        return view('admin.pages.banners.create', compact('availablePositions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'position' => 'required|integer|between:1,3|unique:banners,position',
            'link' => 'nullable|url',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'image' => $imagePath,
            'position' => $request->position,
            'status' => $request->status,
            'link' => $request->link,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        $positions = range(1, 3);
        $usedPositions = Banner::where('id', '!=', $banner->id)->pluck('position')->toArray();
        $availablePositions = array_diff($positions, $usedPositions);
        return view('admin.pages.banners.edit', compact('banner', 'availablePositions'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'position' => 'required|integer|between:1,3|unique:banners,position,' . $banner->id,
            'link' => 'nullable|url',
        ]);

        $data = $request->only(['position', 'status', 'link']);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();

        return response()->json(['success' => true]);
    }
}
