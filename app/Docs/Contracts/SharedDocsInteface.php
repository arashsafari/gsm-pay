<?php

namespace App\Docs\Contracts;

use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     title="Post",
 *      @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Sample Post Title"),
 *     @OA\Property(property="body", type="string", example="This is the body of the post."),
 *     @OA\Property(property="view_count", type="integer", example=42),
 *     @OA\Property(property="user", ref="#/components/schemas/User")
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *      @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="mobile", type="string", example="09123456789"),
 *     @OA\Property(property="profile_image", oneOf={
 *         @OA\Schema(ref="#/components/schemas/Media"),
 *         @OA\Schema(type="null")
 *     })
 * )
 *
 * @OA\Schema(
 *     schema="Media",
 *     type="object",
 *     title="Media",
 *     @OA\Property(property="mime_type", type="string", example="image/jpeg"),
 *     @OA\Property(property="url", type="string", format="uri", example="https://example.com/media/profile.jpg")
 * )
 *
 * @OA\Schema(
 *      schema="UserMostViewedPosts",
 *      type="object",
 *      title="UserMostViewedPosts",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="mobile", type="string", example="09123456789"),
 *      @OA\Property(property="total_post_views", type="integer", example=123),
 *      @OA\Property(property="profile_image", oneOf={
 *          @OA\Schema(ref="#/components/schemas/Media"),
 *          @OA\Schema(type="null")
 *      })
 *  )
 * @OA\SecurityScheme(
 *      type="http",
 *      securityScheme="bearerAuth",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 *  )
 */
interface SharedDocsInteface
{
}
