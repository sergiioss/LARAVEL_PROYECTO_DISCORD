<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    const ROLE_SUPER_ADMIN = 3;
    const ROLE_ADMIN = 2;

    public function rolSuperAdmin($id)
    {
        try {
            $user = User::find($id);

            $user->roles()->attach(self::ROLE_SUPER_ADMIN);

            return response()->json(
                [
                    'succes' => true,
                    'message' => "Super admin role added to user",
                ]
                ,200);

        } catch (\Exception $exception) {
            Log::error('Error delete super admin:' . $exception->getMessage());

            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Error adding superadmin role to user'
                ],
                500
            );
        }
    }

    public function deleteRolSuperAdmin($id)
    {
        try {

            $user = User::find($id);

            $user->roles()->detach(self::ROLE_SUPER_ADMIN);

            return response()->json(
                [
                    'succes' => true,
                    'message' => "Remove super admin role",
                ]
                ,200);

        } catch (\Exception $exception) {
            Log::error('Error delete superadmin:' . $exception->getMessage());

            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Error remove superadmin role to user'
                ],
                500
            );
        }
    }

    public function rolAdmin($id)
    {
        try {
            $user = User::find($id);

            $user->roles()->attach(self::ROLE_ADMIN);

            return response()->json(
                [
                    'succes' => true,
                    'message' => "Admin role added to user",
                ]
                ,200);

        } catch (\Exception $exception) {
            Log::error('Error delete task:' . $exception->getMessage());

            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Error adding dmin role to user'
                ],
                500
            );
        }
    }

    public function deleteRolAdmin($id)
    {
        try {

            $user = User::find($id);

            $user->roles()->detach(self::ROLE_ADMIN);

            return response()->json(
                [
                    'succes' => true,
                    'message' => "Remove admin role",
                ]
                ,200);

        } catch (\Exception $exception) {
            Log::error('Error delete admin:' . $exception->getMessage());

            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Error remove admin role to user'
                ],
                500
            );
        }
    }
}
