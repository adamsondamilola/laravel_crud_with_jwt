<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     title="Post",
 *     properties={
 *         @OA\Property(property="title", type="string", description="Post title"),
 *         @OA\Property(property="content", type="string", description="Post content")
 *     }
 * )
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];
}
