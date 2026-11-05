<?php
namespace App\Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class UserService { public static function getUserIdFromSession(): string { if (! Session::has('user_id')) Session::put('user_id', (string) Str::uuid()); return (string) Session::get('user_id'); } }
