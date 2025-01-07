<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("Users.User", [
            "title" => "Daftar User"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            "name" => 'required',
            "email" => 'unique:users|email',
            "nisn" => 'unique:users',
            "password" => 'required'
        ]);

        // return $validate;
        $data = $request->input();
        if ($data["kelas_id"] === "isAdmin") {
            $data["kelas_id"] = "Administrator";
            $data["isAdmin"] = true;
        }
        $data["password"] = bcrypt($data["password"]);
        unset($data["_token"]);
        User::create($data);
        return back()->with("success", "User $request->name Berhasil di Buat");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user["title"] = $user->name;
        $user["Kelas"] = $user->Kelas();
        $user["Tagihan"] = $user->Tagihan();
        $user["Transaksi"] = $user->Transaksi();
        // dd($user);
        return view("Profile", $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->input();
        if ($data["kelas_id"] === "isAdmin") {
            $data["kelas_id"] = "Administrator";
            $data["isAdmin"] = true;
        }
        if ($data["password"] == null) {
            unset($data["password"]);
        } else {
            $data["password"] = bcrypt($data["password"]);
        }

        $user->update($data);
        return back()->with("success", "User $user->name Berhasil di update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->deleteOrFail();
        return redirect()->route("user.index")->with("success", "$user->name Berhasil Di Blokir");
    }
}
