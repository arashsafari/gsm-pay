<?php

namespace App\Docs\User;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

interface UserMostViewedPostsControllerDocsInteface
{
    /**
     * @OA\Get(
     *     path="/api/users/most-viewed-posts",
     *     summary="Get users ranked by total post views",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="results", type="array",
     *                     @OA\Items(ref="#/components/schemas/UserMostViewedPosts")
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
    public function __invoke(LoginRequest $request): JsonResponse;
}
