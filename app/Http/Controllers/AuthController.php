<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if (session()->get('user')) {
            return redirect('students/create');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => FALSE,
                'message' => $validator->errors()->first()
            ]);
        }

        $User = User::firstWhere('email', $request->email);
        // check if User exist or not
        if (empty($User)) {
            return response()->json([
                'status' => false,
                'message' => 'No user registered with this email'
            ]);
        }
        // check if password match or not
        if (!Hash::check($request->password, $User->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Password'
            ]);
        }

        //Check if role assigned or not
        if (empty($User->role_id)) {
            return response()->json([
                'status' => false,
                'message' => 'No role set for this user'
            ]);
        }

        $Role = Role::find($User->role_id);
        Session::put('user', $User);
        Session::put('role', $Role);


        return response()->json([
            'status' => true,
            'message' => 'You have successfully logged in!'
        ]);
    }

    public function logout()
    {
        Session::forget('user');
        Session::forget('role');
        Session::forget('school');

        return response()->json([
            'status' => true,
            'message' => 'Logout Successfully'
        ]);
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $User = User::where('email', $request->email)->first();

        if (!empty($User)) {
            $reset_password_token = date('hisymd') . $User->id;
            $User->reset_password_token = $reset_password_token;
            $User->save();

            /*******PREPARE EMAIL FOR USER PASSWORD RESET********/
            $User->notify(new ResetPassword($reset_password_token));


            /*******END- PREPARE EMAIL FOR USER PASSWORD RESET********/

            return response()->json([
                'status' => TRUE,
                'message' => "An Email Has been sent to your email address to reset your password",
            ]);
        } else {
            return response()->json([
                'status' => FALSE,
                'message' => "Email doesn't exists!"
            ]);
        }
    }

    public function reset($reset_password_token)
    {
        $User = User::where('reset_password_token', $reset_password_token)->get()->toArray();
        if (empty($User)) {
            return redirect(env('BASE_URL') . 'dashboard');
        }

        return view('auth.reset-password')->with(['reset_password_token' => $reset_password_token]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reset_password_token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => FALSE,
                'message' => $validator->errors()->first()
            ]);
        }

        $User = User::where('reset_password_token', $request->reset_password_token)->first();
        if (!empty($User)) {
            $User->password = Hash::make($request->password);
            $User->reset_password_token = '';
            $User->save();
            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully'
            ]);
        } else {
            return response()->json([
                'status' => FALSE,
                'message' => 'Invalid password reset request'
            ]);
        }
    }

    public function resetPasswordCodeCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reset_password_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => FALSE,
                'message' => $validator->errors()->first()
            ]);
        }

        $User = User::where('reset_password_token', $request->reset_password_token)->first();
        if (!empty($User)) {
            return response()->json([
                'status' => true,
                'message' => 'Enter New Password',
                'reset_password_token' => $request->reset_password_token
            ]);
        } else {
            return response()->json([
                'status' => FALSE,
                'message' => 'Invalid password reset request'
            ]);
        }
    }

    public function changePassword()
    {
        return view('auth.change-password')->with([
            'menu' => 'change_password'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => FALSE,
                'message' => $validator->errors()->first()
            ]);
        }

        $User = User::where('id', Session::get('user')->id)->first();
        if (!empty($User)) {
            // check if old password match or not
            if (Hash::check($request->old_password, $User->password)) {
                $User->password = Hash::make($request->password);
                $User->reset_password_token = '';
                $User->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Password changed successfully'
                ]);
            } else {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Incorrect old password'
                ]);
            }
        } else {
            return response()->json([
                'status' => FALSE,
                'message' => 'Invalid password reset request'
            ]);
        }
    }

    public function accountSettings()
    {
        return view('auth.account-settings')->with([
            'menu' => 'account_settings',
            'user' => Session::get('user')
        ]);
    }

    public function updateAccountSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => FALSE,
                'message' => $validator->errors()->first()
            ]);
        }

        $User = User::where('id', Session::get('user')->id)->first();
        if (!empty($User)) {
            $User->name = $request->name;
            $User->phone = $request->phone;
            $User->save();

            Session::forget('user');
            Session::put('user', $User);

            return response()->json([
                'status' => true,
                'message' => 'Account settings updated'
            ]);

        } else {
            return response()->json([
                'status' => FALSE,
                'message' => 'Invalid Request'
            ]);
        }
    }
}
