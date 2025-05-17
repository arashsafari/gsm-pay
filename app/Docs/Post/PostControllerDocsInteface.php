<?php

namespace App\Docs\Post;

use Illuminate\Http\JsonResponse;

interface PostControllerDocsInteface
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get paginated list of posts",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of posts per page",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="results", type="array",
     *                     @OA\Items(ref="#/components/schemas/Post")
     *                 ),
     *                 @OA\Property(property="links", type="object"),
     *                 @OA\Property(property="meta", type="object"),
     *                 @OA\Property(property="error_message", type="string", example="")
     *             ),
     *             @OA\Property(property="server_time", type="string", format="date-time")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse;

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a single post by ID",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="results", ref="#/components/schemas/Post"),
     *                 @OA\Property(property="error_message", type="string", example="")
     *             ),
     *             @OA\Property(property="server_time", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="results", type="object"),
     *                 @OA\Property(property="error_message", type="string", example="Not found")
     *             ),
     *             @OA\Property(property="server_time", type="string", format="date-time")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse;
}
