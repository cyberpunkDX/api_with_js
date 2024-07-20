<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Validation\ValidationException;

class RegisteredController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        try {
            $validator = $request->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'string', 'exists:users,email'],
                'phone' => ['nullable', 'string', 'exists:users,phone'],
                'password' => ['required'],
            ]);
            if ($validator) {
                DB::beginTransaction();
                $user = User::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $request->password,
                ]);

                if ($user) {
                    DB::commit();
                    return response()->json([
                        "status" => "success",
                        "message" => "Account Created successfully"
                    ]);
                }else {
                    return response()->json(['success' => 'Account registered successfully']);
                }
            } else {
               return response()->json([
                'errors' => $request->errors()
               ]);
            }
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => "error",
                'errors' => $errors,
            ]);
        }
    }
}
