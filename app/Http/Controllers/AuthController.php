<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        /* Role::create(['name' => 'admin']);
        Permission::create(['name' => 'create_patient']);*/

        /* $role = Role::findById(1);
        $permission = Permission::findById(1);
        $role->givePermissionTo($permission); */

        /* Make user an admin to create patients */
        /* $user->assignRole('admin'); */

        $token = $user->createToken($user->name)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $response;
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return ['message' => 'Logged out'];
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Invalid credentials!'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'Logged in successfully!'
        ];

        return $response;
    }

}