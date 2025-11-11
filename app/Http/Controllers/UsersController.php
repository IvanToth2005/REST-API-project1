<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Users API",
 *     version="1.0",
 *     description="API dokumentáció a felhasználók kezeléséhez és beléptetéshez"
 * )
 */
class UsersController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Felhasználó beléptetése",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sikeres belépés",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Hibás email vagy jelszó",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Invalid email or password")
     *         )
     *     )
     * )
     */
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $password ? $user->password : '')) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401); 
        }

        $user->tokens()->delete();
        $user->token = $user->createToken('access')->plainTextToken;

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Összes felhasználó listázása",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Sikeres lekérés",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
        ]);
    }
}

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="Felhasználó adatai",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="user@example.com"),
 *     @OA\Property(property="token", type="string", example="plain-text-access-token")
 * )
 */
