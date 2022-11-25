<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\admin\CartProduct;
use App\Models\admin\Category;
use App\Models\admin\ProductColor;
use App\Models\admin\ProductSize;
use App\Models\admin\ThemeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = DB::select('SELECT `cart_product`.*, `product`.`name` AS `name_product`, `product`.`price`, `product`.id AS `id_product`
        FROM `cart_product`, `customer`, `product`
        WHERE `cart_product`.`id_customer` = `customer`.`id` AND `customer`.`id` = ? AND `cart_product`.`id_product` = `product`.`id` AND `cart_product`.`active` = 1', [$request->session()->get('id_customer')]);

        $countActive = DB::table('cart_product')->where('id_customer', $request->session()->get('id_customer'))->where('active', 1)->count();
        $sizes = ProductSize::orderBy('created_at')->where('active', 1)->get();
        $colors = ProductColor::orderBy('created_at')->where('active', 1)->get();

        $request->session()->put('cart', $cart);
        $request->session()->put('countActive', $countActive);

        return view('clients.cart.index', [
            'themes' => ThemeList::orderBy('created_at')->get(),
            'cart' => $cart,
            'countActive' => $countActive,
            'sizes' => $sizes,
            'colors' => $colors,
        ]);
    }

    public function update(Request $request)
    {
        for ($i = 0; $i < sizeof($request->id); $i++) {
            $cart = CartProduct::find($request->id[$i]);
            $cart->id_product = $request->input('id_product')[$i];
            $cart->id_size = $request->input('id_size')[$i];
            $cart->id_color = $request->input('id_color')[$i];
            $cart->quantity_product = $request->input('quantity_product')[$i];

            if (isset($request->input('status')[$i])) {
                $cart->status = $request->input('status')[$i];
            } else {
                $cart->status = 0;
            }

            $cart->save();
        }
    }

    public function delete($id)
    {
        $cart = CartProduct::find($id);
        $cart->delete();
    }

    public function handleCrudCart(Request $request)
    {
        if ($request->button == "updateCart") {
            self::update($request);
        }

        if (explode(",", $request->buttonDelete)[0] == "deleteCart") {
            self::delete(explode(",", $request->buttonDelete)[1]);
        }

        return redirect()->route('client.cart');
    }

    public static function findCategoryByThemeId($themeId)
    {
        $category = Category::orderBy('created_at')->where('id_theme_list', $themeId)->get();
        return $category;
    }

    public static function getCartProductInforById($id)
    {
        $cart = DB::select('SELECT `cart_product`.*, `product`.`name` AS `name_product`, `product`.`price`, `product_color`.`name` AS `color`, `product_size`.`name` AS `size`
        FROM `cart_product`, `product`, `product_color`, `product_size`
        WHERE `cart_product`.`id_product` = `product`.`id` AND `cart_product`.`id` = ? AND `product_color`.`id` = `cart_product`.`id_color` AND `product_size`.`id` = `cart_product`.`id_size`', [$id]);
        return $cart;
    }
}
