<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\admin\Address;
use App\Models\admin\CartProduct;
use App\Models\admin\Category;
use App\Models\admin\Delivery;
use App\Models\admin\Order;
use App\Models\admin\Product;
use App\Models\admin\ProductDiscount;
use App\Models\admin\ThemeList;
use App\Models\admin\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $checkCart = DB::table('cart_product')->where('status', 1)->where('id_customer', $request->session()->get('id_customer'))->where('active', 1)->count();
        if ($checkCart == 0) {
            return redirect()->route('client.cart');
        }

        $addresses = DB::select('SELECT `address`.*, `customer`.`name` AS `name_customer` FROM `address`, `customer` WHERE `address`.`id_customer` = `customer`.`id` AND `customer`.`id` = ?', [$request->session()->get('id_customer')]);

        $products = DB::select('SELECT `cart_product`.*, `product`.`name` AS `name_product`, (`product`.`price` + `product_color`.`price`) AS `price`, `product_size`.`name` AS `name_size`, `product_color`.`name` AS `name_color`
        FROM `cart_product`, `customer`, `product`, `product_size`, `product_color`
        WHERE `cart_product`.`id_customer` = `customer`.`id` AND `customer`.`id` = ? AND `cart_product`.`id_product` = `product`.`id` AND `cart_product`.`status` = 1
        AND `cart_product`.`active` = 1 AND `cart_product`.`id_size` = `product_size`.`id` AND `cart_product`.`id_color` = `product_color`.`id`', [$request->session()->get('id_customer')]);

        $discounts = array();
        foreach ($products as $product) {
            foreach (ProductDiscount::orderBy('created_at')->where('active', 1)->get() as $discount) {
                if ($product->id_product == $discount->id_product) {
                    array_push($discounts, $discount);
                }
            }
        }

        $vouchers = Voucher::orderBy('created_at')->where('active', 1)->get();
        $deliverys = Delivery::orderBy('created_at')->where('active', 1)->get();

        return view('clients.checkout.index', [
            'addresses' => $addresses,
            'products' => $products,
            'discounts' => $discounts,
            'vouchers' => $vouchers,
            'deliverys' => $deliverys,
            'themes' => ThemeList::orderBy('created_at')->get(),
        ]);
    }

    public function changeAddress(Request $request, $id)
    {
        DB::select('UPDATE `address` SET `active`= ? WHERE `id_customer` = ?', [0, $request->session()->get('id_customer')]);

        $address = Address::find($id);
        $address->active = 1;
        $address->save();
    }

    public function insertOrder(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $order = new Order();
        $order->id_address = $request->input('id_address');
        $order->id_cart_product = implode(',', $request->input('id_cart_product'));

        if (isset($request->id_product_discount)) {
            $order->id_product_discount = implode(',', $request->input('id_product_discount'));
        }

        $order->id_voucher = $request->input('id_voucher');
        $order->id_delivery = $request->input('id_delivery');
        $order->date_unpaid = $dt->toDateString();
        $order->save();

        foreach ($request->id_cart_product as $value) {
            $cart = CartProduct::find($value);
            $cart->active = 0;
            $cart->save();

            $product = Product::find($cart->id_product);
            $product->quantity = $product->quantity - $cart->quantity_product;
            $product->save();
        }
    }

    public function handleCrudCheckout(Request $request)
    {
        if (explode(",", $request->button)[0] == "changeAddress") {
            self::changeAddress($request, explode(",", $request->button)[1]);
        }

        if ($request->button == "checkout") {
            self::insertOrder($request);
            return redirect()->route('client.purchase');
        }

        return redirect()->route('client.checkout');
    }

    public static function findCategoryByThemeId($themeId)
    {
        $category = Category::orderBy('created_at')->where('id_theme_list', $themeId)->get();
        return $category;
    }
}
