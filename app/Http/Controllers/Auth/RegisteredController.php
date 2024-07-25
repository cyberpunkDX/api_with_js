<?php

namespace App\Http\Controllers\Auth;

use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class RegisteredController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function verify()
    {
        return view('auth.verify');
    }

    public function verification(Request $request)
    {
        try {
            $validator = $request->validate([
                'code' => ['required', 'integer', 'min:4'],
            ]);

            if ($validator) {

                $user = User::where('token', $request->token)
                            ->where('code', $request->code)
                            ->first();

                if($user){

                    $user->email_verified_at = Carbon::now();
                    $user->save();

                    return response()->json([
                        "message" => "Email verified successfully",
                        "status" => "success",
                    ]);

                }else{
                    return response()->json([
                        "message" => "Invalid verification code given",
                        "status" => "error",
                    ]);
                }

            }
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => "error",
                'errors' => $errors,
            ]);
        }
    }


    public function store(Request $request)
    {
        try {
            $validator = $request->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'string', 'unique:users,email'],
                'phone' => ['nullable', 'string', 'unique:users,phone'],
                'password' => ['required', 'confirmed'],
            ]);
            if ($validator) {
                DB::beginTransaction();
                $user = User::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $request->password,
                    'code' => random_int(1000, 9000),
                    'token' => Str::uuid(),
                ]);

                if ($user) {
                    DB::commit();
                    Mail::to($request->email)->send(new EmailVerification($user->code));
                    return response()->json([
                        "status" => "success",
                        "token" => $user->token,
                        "message" => "Account created successfully. you would be automatically redirected to verify your email address"
                    ]);
                }else {
                    return response()->json(['error' => 'Something went wrong']);
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
