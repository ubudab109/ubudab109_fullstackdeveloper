<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
  }



  /**
   * @OA\Post(
   ** path="/api/login",
   *   tags={"Login"},
   *   summary="Login",
   *   operationId="login",
   *
   *   @OA\Parameter(
   *      name="email",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *           type="string"
   *      )
   *   ),
   *   @OA\Parameter(
   *      name="password",
   *      in="query",
   *      required=true,
   *      @OA\Schema(
   *          type="string"
   *      )
   *   ),
   *   @OA\Response(
   *      response=200,
   *       description="Success",
   *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *   ),
   *   @OA\Response(
   *      response=401,
   *       description="Unauthenticated"
   *   ),
   *   @OA\Response(
   *      response=400,
   *      description="Bad Request"
   *   ),
   *)
   **/
  /**
   * Get a JWT via given credentials.
   *
   * @param  Request  $request
   * @return JsonResponse
   */
  public function login(Request $request): JsonResponse
  {
    $validate = Validator::make($request->all(), [
      'email'     => 'required|email',
      'password'  => 'required',
    ]);

    if ($validate->fails()) {
      return $this->sendBadRequest('Validation Failed', $validate->errors());
    }

    $credentials = $request->all();

    if (!$token = Auth::attempt($credentials)) return $this->sendUnauthorized('Unauthorized', 'Credential Not Found');

    return $this->sendResponse($this->respondWithToken($token), 'Logged In Successfully');
  }



  /**
   * @OA\Post(
   ** path="/api/logout",
   *   tags={"Logout"},
   * security={
   *  {"bearer": {}},
   *   },
   *   summary="Logout",
   *   operationId="logout",
   *
   *   @OA\Response(
   *      response=200,
   *       description="Success",
   *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *   ),
   *   @OA\Response(
   *      response=401,
   *       description="Unauthenticated"
   *   ),
   *)
   **/
  /**
   * Log the user out (Invalidate the token).
   *
   * @return JsonResponse
   */
  public function logout(): JsonResponse
  {
    auth()->logout();

    return $this->sendResponse(true, 'Successfully logged out');
  }


  /**
   * Get the token array structure.
   *
   * @param  string $token
   * @return array
   */
  protected function respondWithToken($token): array
  {
    return [
      'access_token' => $token,
      'user' => auth()->user(),
      'expires_in' => auth()->factory()->getTTL() * 60 * 24
    ];
  }
}
