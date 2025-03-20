<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users_list')->only(['index']);
        $this->middleware('permission:users_create')->only(['create', 'store']);
        $this->middleware('permission:users_detail')->only(['show']);
        $this->middleware('permission:users_update')->only(['edit', 'update']);
        $this->middleware('permission:users_delete')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $role = $request->query('role') ?? 'user';

        if ($role == 'admin') {
            $users = User::with('roles')->where('role', 'admin')->paginate(10);
        } else {
            $users = User::with('roles')->where('role', 'user')->paginate(10);
        }

        return view('admin.pages.user.index', compact("users", 'role'));
    }
    public function create()
    {
        $roles = Role::all();
        return view('admin.pages.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'admin',
            'password' => Hash::make($request->password),
        ]);

        Profile::create([
            'user_id' => $user->id,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.user.index', 'role=admin')->with('success', 'Tạo nhân viên thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('admin.user.index')->with('error', 'Không thể xóa Admin!');
        }

        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'Người dùng đã được xóa thành công.');
    }
}
