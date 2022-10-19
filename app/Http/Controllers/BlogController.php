<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     *  Show all data.
     *
     *  @return json
     */
    public function index(): JsonResponse {
        $blogs = Blog::all();

        return response()->json($blogs);
    }

    /**
     *  Store data to database.
     *
     *  @return json
     */
    public function store(Request $request) {
        if ($request->title == '') {
            return response()->json([
                'status' => 'BAD_REQUEST',
                'message' => 'Title is required'
            ], 400);
        }

        $blog = new Blog;

        $blog->title = $request->title;
        $blog->description = $request->description;

        $blog->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'New blog successfully created.',
            'data' => $blog
        ], 201);
    }

    /**
     *  Show data from database
     * 
     */
    public function show(Request $request) {
        $blog = Blog::find($request->id);

        if ($blog == null) {
            return response()->json([
                'status' => 'NOT_FOUND',
                'message' => 'Blog is not found'
            ], 404);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $blog
        ], 200);
    }

    /**
     *  Update data from database
     * 
     *  @return json
     */
    public function update(Request $request, Blog $blog) {
        $title = $request->title;
        $description = $request->description;
        
        $blog = $blog->find($request->id);

        if ($blog == null) {
            return response()->json([
                'status' => 'NOT_FOUND',
                'message' => 'Blog is not found.'
            ], 404);
        }
        
        if ($title == null) {
            $title = $blog->title;
        }

        if ($description == null) {
            $description = $blog->description;
        }

        $blog->title = $title;
        $blog->description = $description;

        $blog->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'Blog successfully updated',
            'data' => $blog
        ], 200);
    }

    /**
     *  Destroy data from database
     * 
     */
    public function destroy(Request $request, Blog $blog) {
        $blog = $blog->find($request->id);

        if ($blog == null) {
            return response()->json([
                'status' => 'NOT_FOUND',
                'message' => 'Blog is not found.'
            ], 404);
        }

        $blog->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'Blog successfully deleted.'
        ], 200);
    }
}
