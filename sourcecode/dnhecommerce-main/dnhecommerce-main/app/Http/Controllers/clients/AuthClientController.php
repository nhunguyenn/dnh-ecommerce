<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\admin\Account;
use App\Models\admin\Address;
use App\Models\admin\Category;
use App\Models\admin\Customer;
use App\Models\admin\ThemeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

session_start();

class AuthClientController extends Controller
{
    public function login()
    {
        return view('clients.auth.login', [
            'themes' => ThemeList::orderBy('created_at')->get(),
        ]);
    }

    public function handleLogin(Request $request)
    {
        $account = DB::select('SELECT `account`.*, `customer`.`name`, `customer`.`id` AS `id_customer` FROM `account`, `customer` WHERE `email` = ? AND `password` = ? AND `customer`.`id_account` = `account`.`id` AND `account`.`role` = ? LIMIT 1', [$request->input('email'), md5($request->input('password')), 'customer']);
        if ($account) {
            $request->session()->put('id_customer', $account[0]->id_customer);
            $request->session()->put('name_customer', $account[0]->name);

            return redirect()->route('client.cart');
        }

        return redirect()->route('client.auth.login');
    }

    public function register()
    {
        return view('clients.auth.register', [
            'themes' => ThemeList::orderBy('created_at')->get(),
        ]);
    }

    public function handleRegister(Request $request)
    {
        $email_customer = DB::select('SELECT * FROM `account` WHERE `email` = ?', [$request->input('email')]);

        if ($email_customer) {
            return redirect()->route('client.auth.register');
        }

        $account = new Account();
        $account->email = $request->input('email');
        $account->password = md5($request->input('password'));
        $account->role = "customer";
        $account->save();

        $id_account = DB::select('SELECT id FROM `account` WHERE `email` = ?', [$request->input('email')]);
        if ($id_account) {
            $customer = new Customer();
            $customer->name = $request->input('name');
            $customer->gender = $request->input('gender');
            $customer->phone = $request->input('phone');
            $customer->id_account = $id_account[0]->id;
            $customer->save();

            $address = new Address();
            $address->id_customer = $id_account[0]->id;
            $address->specific_address = $request->input('specific_address');
            $address->phone = $request->input('phone');
            $address->active = 1;
            $address->save();
        }

        return redirect()->route('client.auth.login');
    }

    public function logout(Request $request)
    {
        $request->session()->put('id_customer', null);
        $request->session()->put('name_customer', null);

        return redirect()->route('client.auth.login');
    }

    public static function findCategoryByThemeId($themeId)
    {
        $category = Category::orderBy('created_at')->where('id_theme_list', $themeId)->get();
        return $category;
    }
}
