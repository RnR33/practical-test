<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Validator;

class UserAuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Create Account
     * @OA\Post (
     *     path="/api/register",
     *     tags={"user"},
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                       @OA\Property(
     *                         property="name",
     *                         type="text"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="text"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="text"
     *                      ),
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8'
            ]);

            if ($validator->fails()) {

                return response($validator->messages(), 200);

            }else{

                $data = $request->only(['name', 'email', 'password']);

                $user = $this->userService->storeUser($data);

                $token = $user->createToken('API Token')->accessToken;

                return response([ 'user' => $user]);
            }
        }catch (\Exception $e)
        {
            \Log::error('UserAuthController(register) '.  $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 404);
        }

    }

    /**
     * @OA\Post(
     ** path="/api/login",
     *   tags={"user"},
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
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details.
            Please try again']);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);

    }

    public function logoutApi()
    {
        if (\Auth::check()) {
            \Auth::user()->AauthAcessToken()->delete();
            return response()->json('Successfully Logout', 401);
        }
    }
}
