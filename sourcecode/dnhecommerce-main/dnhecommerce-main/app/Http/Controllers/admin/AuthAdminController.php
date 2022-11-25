<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

session_start();

class AuthAdminController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function handleLogin(Request $request)
    {
        $account = DB::select('SELECT `account`.*, `employee`.`name`, `employee`.`id` AS `id_admin` FROM `account`, `employee` WHERE `email` = ? AND `password` = ? AND `employee`.`id_account` = `account`.`id` AND `account`.`role` = ? LIMIT 1', [$request->input('email'), md5($request->input('password')), 'admin']);

        if ($account) {
            $request->session()->put('id_admin', $account[0]->id_admin);
            $request->session()->put('name_admin', $account[0]->name);

            return redirect()->route('admin.home');
        }

        return redirect()->route('admin.auth.login');
    }

    public function logout(Request $request)
    {
        $request->session()->put('id_admin', null);
        $request->session()->put('name_admin', null);

        return redirect()->route('admin.auth.login');
    }
}
