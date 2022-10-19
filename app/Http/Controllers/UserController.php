<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     *  Show all data.
     *
     *  @return json
     */
    public function index(): JsonResponse {
        $users = User::all();

        return response()->json($users);
    }

    /**
     *  Store data to database.
     *
     *  @return json
     */
    public function store(Request $request) {
        if ($request->username == '') {
            return response()->json([
                'status' => 'BAD_REQUEST',
                'message' => 'Username is required'
            ], 400);
        }

        if ($request->password == '') {
            return response()->json([
                'status' => 'BAD_REQUEST',
                'message' => 'Password is required'
            ], 400);
        }

        if ($request->email == '') {
            return response()->json([
                'status' => 'BAD_REQUEST',
                'message' => 'Email is required'
            ], 400);
        }

        $user = new User;

        $encrypted_password = Hash::make($request->password);

        $user->username = $request->username;
        $user->password = $encrypted_password;
        $user->email = $request->email;
        $user->name = $request->name;

        $user->save();

        return response()->json([
            'status' => 'OK',
            'message' => 'New user successfully created.',
            'data' => $user
        ], 201);
    }

    /**
     *  Show data from database
     * 
     */
    /* public function show(Request $request) {
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
    } */

    /**
     *  Update data from database
     * 
     *  @return json
     */
    /* public function update(Request $request, Blog $blog) {
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
    } */

    /**
     *  Destroy data from database
     * 
     */
    /* public function destroy(Request $request, Blog $blog) {
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
    } */
}
