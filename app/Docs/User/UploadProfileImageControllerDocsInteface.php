<?php

namespace App\Docs\User;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

interface UploadProfileImageControllerDocsInteface
{
    /**
     * @OA\Post(
     *     path="/api/users/upload-profile-image",
     *     summary="Upload user profile image",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Image file to upload",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"image"},
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                     description="Image file"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile image uploaded successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/User"),
     *             @OA\Property(property="server_time", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found or upload error",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="results", type="object"),
     *                 @OA\Property(property="error_message", type="string", example="User not found")
     *             ),
     *             @OA\Property(property="server_time", type="string", format="date-time")
     *         )
     *     )
     * )
     */
    public function __invoke(LoginRequest $request): JsonResponse;
}
