<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command("admin:new {name} {email} {password}", function ($name, $email, $password) {

    $add = User::create([
        "name" => $name,
        "email" => $email,
        "password" => bcrypt($password),
        "isAdmin" => 1,
    ]);
    $this->comment($add);
})->purpose("Add New Admin Account");
Artisan::command("admin:deactive {email}", function ($email) {

    $dell = User::where("email", $email)->delete();
    if ($dell) {
        # code...
        $this->comment("Data Admin $email Berhasil di Non Aktifkan");
    } else {
        $this->comment("Data Admin $email Tidak Di Temukan");
    }
})->purpose("Add deactive Admin Account");
Artisan::command("admin:active {email}", function ($email) {

    $dell = User::withTrashed()->where("email", $email)->restore();
    if ($dell) {
        # code...
        $this->comment("Data Admin $email Berhasil di Aktifkan");
    } else {
        $this->comment("Data Admin $email Tidak Di Temukan");
    }
})->purpose("Add active Admin Account");
