<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $blogs = Blog::all();
        // return response()->json(['blogs' => $blogs], 200);

        $blogs = Blog::paginate(5);
        return $blogs;
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
            'category_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'url' => 'required',
            'image' => 'required|image',
        ]);

        try{

            $featuredImage = $request->file('image');
            $image_filename = time().'.'.$featuredImage->getClientOriginalExtension();
            $image_path = public_path('/Blog_images');
            $featuredImage->move($image_path,$image_filename);

            $data['image'] = $image_filename;
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'An error occured',
            ], 400);
        }

        $blog = Blog::create($data);
        return response()->json([
            'message' => 'Blog Created',
            'blog' => $blog,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Blog::where('id', $id)->exists()) {
            $blogs = Blog::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($blogs, 200);
          } else {
            return response()->json([
              "message" => "Blog not found",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Blog::where('id', $id)->exists()) {
            $blog = Blog::findOrFail($id);
            $blog->update($request->all());

            return response()->json([
                "message" => "Blog updated successfully",
            ], 200);
            } else {
            return response()->json([
                "message" => "Blog not found",
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(BlogCategory::where('id', $id)->exists()) {
            $blog = BlogCategory::findOrFail($id);
            $blog->delete();

            return response()->json([
              "message" => "Blog deleted",
            ], 202);
          } else {
            return response()->json([
              "message" => "Blog not found",
            ], 404);
        }
    }
}
