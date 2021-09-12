<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('login.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:3|max:255',
            'username' => 'required|min:3|max:50|unique:users',
            'password' => 'required|min:6|max:255',
        ]);
        // dd($request->all());

        $validatedData['password'] = bcrypt($validatedData['password']);
        // ada dua metode untuk hash password, tapi keduanya sama fungsinya
        // $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        // $request->session()->flash('success', "Registrasi berhasil! Silahkan login!");
        // dump('User berhasil dibuat!');
        // dump($validatedData);

        return view('login.succeed')->with('success', 'Registrasi berhasil! Silahkan login!');
    }

}
