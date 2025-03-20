<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
