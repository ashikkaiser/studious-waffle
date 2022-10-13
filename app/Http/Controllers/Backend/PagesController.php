<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::paginate(10);
        return view('backend.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('backend.pages.create');
    }

    public function store(Request $request)
    {
        $page = new Page();
        $page->name = $request->name;
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->description = $request->description;
        $page->save();
        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $page = Page::find($id);
        return view('backend.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);
        $page->title = $request->title;
        $page->name = $request->name;
        $page->slug = Str::slug($request->slug);
        $page->description = $request->description;
        $page->save();
        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully');
    }


    public function destroy($id)
    {
        $page = Page::find($id);
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully');
    }
}
