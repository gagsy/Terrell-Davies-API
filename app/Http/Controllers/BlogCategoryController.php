<?php

namespace App\Http\Controllers;

use App\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = BlogCategory::all();
        return response()->json(['categories' => $categories], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'url' => 'required',
        ]);

        $category = BlogCategory::create($data);
        return response()->json([
            'message' => 'Blog Category Created',
            'category' => $category,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (BlogCategory::where('id', $id)->exists()) {
            $categories = BlogCategory::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($categories, 200);
          } else {
            return response()->json([
              "message" => "Blog Category not found",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (BlogCategory::where('id', $id)->exists()) {
            $cat = BlogCategory::findOrFail($id);
            $cat->update($request->all());

            return response()->json([
                "message" => "Blog Category updated successfully",
            ], 200);
            } else {
            return response()->json([
                "message" => "Blog Category not found",
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(BlogCategory::where('id', $id)->exists()) {
            $cat = BlogCategory::findOrFail($id);
            $cat->delete();

            return response()->json([
              "message" => "Blog Category deleted",
            ], 202);
          } else {
            return response()->json([
              "message" => "Blog Category not found",
            ], 404);
        }
    }
}
