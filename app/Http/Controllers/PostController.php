<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="API Endpoints for Managing Posts"
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *      path="/posts",
     *      operationId="getPostsList",
     *      tags={"Posts"},
     *      summary="Get list of posts",
     *      description="Returns list of posts",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Post")
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function index()
    {
        try{
            return Post::all();
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([], 200);
        }
    }

    /**
     * @OA\Post(
     *     path="/posts",
     *     tags={"Posts"},
     *     summary="Create a new post",
     *     description="Creates a new post and returns the created post",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     )
     * )
     */
    public function store(Request $request)
{
    try{
        $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required',
    ]);

    $post = Post::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => auth('api')->id(), 
    ]);

    return response()->json($post, 201);
} catch (\Throwable $th) {
    //throw $th;
    return response()->json([
        'message' => 'Something went wrong, try again.'
    ], 400);
}
}


    /**
     * @OA\Get(
     *     path="/posts/{id}",
     *     tags={"Posts"},
     *     summary="Get a specific post",
     *     description="Returns the details of a specific post",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post details",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     )
     * )
     */
    public function show(Post $post)
{
    try {
        // Check if post exists, if not return a 404 response
        if (!$post) {
            return response()->json([
                'message' => 'Post not found.'
            ], 404);
        }

        // Return the post if it exists
        return response()->json($post, 200);

    } catch (\Throwable $th) {
        // Handle any unexpected errors
        return response()->json([
            'message' => 'Something went wrong, try again.'
        ], 400);
    }
}


    /**
     * @OA\Put(
     *     path="/posts/{id}",
     *     tags={"Posts"},
     *     summary="Update a post",
     *     description="Updates an existing post and returns the updated post",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     )
     * )
     */
    public function update(Request $request, Post $post)
    {
        try{
            if ($post->user_id !== auth('api')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $post->update($request->all());
        return $post;
    } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
            'message' => 'Something went wrong, try again.'
        ], 400);
    }
    }

    /**
     * @OA\Delete(
     *     path="/posts/{id}",
     *     tags={"Posts"},
     *     summary="Delete a post",
     *     description="Deletes a post",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post deleted successfully"
     *     )
     * )
     */
    public function destroy(Post $post)
    {
        try{    // Check if the authenticated user is the owner of the post
    if ($post->user_id !== auth('api')->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $post->delete();

    return response()->json(['message' => 'Post deleted successfully']);
} catch (\Throwable $th) {
    //throw $th;
    return response()->json([
        'message' => 'Something went wrong, try again.'
    ], 400);
}
}

}
