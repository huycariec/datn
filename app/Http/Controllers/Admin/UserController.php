<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        $users = User::where('role', '!=', 'admin')->get(); 
    
        return view('admin.pages.user.index', compact('admins', 'users'));
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
