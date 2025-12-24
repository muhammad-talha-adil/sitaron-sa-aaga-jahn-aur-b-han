<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $menu_url = "dashboard";
    public function index()
    {

        $this->data['users'] = User::with('dog')->get();
        $this->data['menu'] = $this->menu_url;
        return view('users.list', $this->data);
    }

    public function create()
    {
        $this->data['roles'] = Role::all();
        $this->data['menu'] = $this->menu_url;
        return view('users.create', $this->data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $Role = Role::firstWhere('code', 'admin');
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $Role->id,
            'address' => $request->address,
            'notes' => $request->notes
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Saved successfully'
        ]);
    }

    public function edit(Request $request)
    {
        $this->data['user'] = User::find($request->id);
        $this->data['menu'] = $this->menu_url;
        return view('users.edit', $this->data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $request->id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $User = User::find($request->id);
        $User->email = $request->email;
        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->address = $request->address;
        $User->notes = $request->notes;

        if (!empty($request->password) && strlen($request->password) < 6) {
            return response()->json([
                'status' => false,
                'message' => 'Minimum 6 characters of password required'
            ]);
        } else if (!empty($request->password) && strlen($request->password) >= 6) {
            $User->password = Hash::make($request->password);
        }

        $User->save(); // Can use update here as well

        return response()->json([
            'status' => true,
            'message' => 'User saved successfully'
        ]);
    }


    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $User = User::find($request->id);
        if (!$User) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $Dog = Dog::where('user_id', $User->id)->first();

        if ($Dog) {
            return response()->json([
                'status' => false,
                'message' => 'Delete this user dog first if you want to delete this user'
            ]);
        }

        $User->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);

    }
}
