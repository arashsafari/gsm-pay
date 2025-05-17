<?php

namespace App\Docs\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

interface LoginControllerDocsInteface
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="User Login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"mobile","password"},
     *             @OA\Property(property="mobile", type="string", example="09121234567"),
     *             @OA\Property(property="password", type="string", example="09121234567")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="results", type="object",
     *                     @OA\Property(property="access_token", type="string", example="eyJ0e..."),
     *                     @OA\Property(property="token_type", type="string", example="bearer"),
     *                     @OA\Property(property="expires_in", type="integer", example=3600)
     *                 ),
     *                 @OA\Property(property="error_message", type="string", example="")
     *             ),
     *             @OA\Property(property="server_time", type="string", format="date-time", example="2025-05-16T13:51:00+03:30")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="results", type="object", example={}),
     *                 @OA\Property(property="error_message", type="string", example="Invalid credentials.")
     *             ),
     *             @OA\Property(property="server_time", type="string", format="date-time", example="2025-05-16T13:51:00+03:30")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="mobile", type="array",
     *                     @OA\Items(type="string", example="The mobile field is required.")
     *                 ),
     *                 @OA\Property(property="password", type="array",
     *                     @OA\Items(type="string", example="The password field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(LoginRequest $request): JsonResponse;
}
