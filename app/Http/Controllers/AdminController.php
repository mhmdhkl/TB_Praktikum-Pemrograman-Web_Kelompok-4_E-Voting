<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->get();

        return view('admin.index', [
            'title' => 'E-Voting | Admin List',
            'admin' => $admins
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
        ], [
            'email.unique' => 'Email sudah dipakai.',
        ]);

        $validatedData['password'] = Hash::make($request->password);
        $validatedData['role'] = 'admin';

        User::create($validatedData);

        return redirect()->route('admin.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admins = User::findOrFail($id);
        return response()->json($admins);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
        ]);

        $admins = User::findOrFail($id);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }

        $admins->update($validatedData);

        return redirect()->route('admin.index')->with('message', 'Data Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->route('admin.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
