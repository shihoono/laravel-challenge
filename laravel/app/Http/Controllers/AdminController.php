<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);

        return view('admin.index', [
            'users' => $users,
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validator($request->all())->validate();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        if($user->save()){
            return redirect('admin')->with('flash_success', '更新しました');
        }

        return redirect('admin')->with('flash_error', 'もう一度やり直してください');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',],
            'role' => ['required', 'integer', 'gte:0', 'lte:1'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->delete()){
            return redirect('admin')->with('flash_success', '削除しました');
        }

        return redirect('admin')->with('flash_error', 'このユーザーは削除できません');
    }
}
