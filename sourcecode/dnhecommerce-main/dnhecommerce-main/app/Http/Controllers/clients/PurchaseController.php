<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\admin\ThemeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $order = DB::select('SELECT `order`.*, IF(`order`.`id_voucher` = `voucher`.`id`,`voucher`.`price` , 0) AS `price_voucher`, IF(`order`.`id_delivery` = `delivery`.`id`,`delivery`.`price` , 0) AS `price_delivery`
        FROM `order`, `address`, `voucher`, `delivery`
        WHERE `order`.`id_address` = `address`.`id` AND `address`.`id_customer` = ?', [$request->session()->get('id_customer')]);

        return view('clients.purchase.index', [
            'order' => $order,
            'themes' => ThemeList::orderBy('created_at')->get(),
        ]);
    }

    public function cancelOrder($id_order)
    {
        DB::select('UPDATE `order` SET `active`= ? WHERE `id` = ?', [4, $id_order]);
    }

    public function confirmOrder($id_order, $id_cart_product){
        DB::select('UPDATE `purchase` SET `active_confirm`= ? WHERE `id_order` = ? AND `id_cart_product` = ?', [1, $id_order, $id_cart_product]);

        // {"id_purchase": 3, "id_product": 2, "price_product": 700000}
        $purchase = DB::select('SELECT `purchase`.`id` AS `id_purchase`, `product`.`id` AS `id_product`, `product`.`price` AS `price_product`
        FROM `purchase`, `product`, `cart_product`
        WHERE `id_order` = ? AND `id_cart_product` = ? AND `purchase`.`id_cart_product` = `cart_product`.`id` AND `cart_product`.`id_product` = `product`.`id`', [$id_order, $id_cart_product]);

        $check_voucher = DB::select('SELECT id_voucher FROM `order` WHERE id = ?', [$id_order]);
        if($check_voucher[0]->id_voucher != null) {
            // {"price_delivery": 30000, "price_voucher": 10000, "price_discount": 35000}
            $order = DB::select('SELECT `delivery`.`price` AS `price_delivery`, `voucher`.`price` AS `price_voucher`, (?*(`product_discount`.`percent_discount`/"100")) AS `price_discount`
            FROM `order`, `delivery`, `voucher`, `product_discount`
            WHERE `order`.`id` = ? AND `order`.`id_delivery` = `delivery`.`id` AND `order`.`id_product_discount` = `product_discount`.`id`', [$purchase[0]->price_product, $id_order]);

            DB::insert('INSERT INTO `purchase_history` (id_purchase, id_product, price_product, price_discount, price_voucher, price_delivery) VALUES (?, ?, ?, ?, ?, ?)', [$purchase[0]->id_purchase, $purchase[0]->id_product, $purchase[0]->price_product, $order[0]->price_discount, $order[0]->price_voucher, $order[0]->price_delivery]);
        } else {
            // {"price_delivery": 30000, "price_voucher": 0, "price_discount": 35000}
            $order = DB::select('SELECT `delivery`.`price` AS `price_delivery`, (?*(`product_discount`.`percent_discount`/"100")) AS `price_discount`
            FROM `order`, `delivery`, `voucher`, `product_discount`
            WHERE `order`.`id` = ? AND `order`.`id_delivery` = `delivery`.`id` AND `order`.`id_product_discount` = `product_discount`.`id`', [$purchase[0]->price_product, $id_order]);

            DB::insert('INSERT INTO `purchase_history` (id_purchase, id_product, price_product, price_discount, price_delivery) VALUES (?, ?, ?, ?, ?)', [$purchase[0]->id_purchase, $purchase[0]->id_product, $purchase[0]->price_product, $order[0]->price_discount, $order[0]->price_delivery]);
        }
    }

    public function returnOrder($id_order, $id_cart_product){
        DB::select('UPDATE `purchase` SET `active_return`= ? WHERE `id_order` = ? AND `id_cart_product` = ?', [1, $id_order, $id_cart_product]);

        $purchase = DB::select('SELECT * FROM `purchase` WHERE `id_order` = ? AND `id_cart_product` = ?', [$id_order, $id_cart_product]);
        DB::insert('insert into return_order (id_purchase) values (?)', [$purchase[0]->id]);
    }

    public function handlePurchase(Request $request)
    {
        if ($request->button == "cancel") {
            self::cancelOrder($request->id_order);
            return redirect()->route('client.purchase');
        }

        if($request->button == "confirm"){
            self::confirmOrder($request->id_order, $request->id_cart_product);
            return redirect()->route('client.purchase');
        }

        if($request->button == "return"){
            self::returnOrder($request->id_order, $request->id_cart_product);
            return redirect()->route('client.purchase');
        }

        return redirect()->route('client.purchase');
    }


    public static function findPriceByCartProductId($id_cart_product){
        $price = DB::select('SELECT `cart_product`.`id`, (`product`.`price` + `product_color`.`price`) AS `price_product`,
        IF(`product`.`id`=`product_discount`.`id`,(`product`.`price` + `product_color`.`price`) * (`product_discount`.`percent_discount` / "100"), 0) AS `price_discount`
        FROM `cart_product`, `product`, `product_discount`, `product_color`
        WHERE `cart_product`.`id` = ? AND `product`.`id` = `cart_product`.`id_product` AND `cart_product`.`id_color` = `product_color`.`id` LIMIT 1', [$id_cart_product]);

        return $price;
    }

    public static function findActiveConfirmByOrderId($id_order){
        $active_confirm = DB::select('SELECT `purchase`.`active_confirm` FROM `purchase` WHERE `id_order` = ? LIMIT 1', [$id_order])[0]->active_confirm;
        return $active_confirm;
    }

    public static function findActiveReturnByOrderId($id_order){
        $active_return = DB::select('SELECT `purchase`.`active_return` FROM `purchase` WHERE `id_order` = ? LIMIT 1', [$id_order])[0]->active_return;
        return $active_return;
    }

    public static function findActiveConfirmByOrderIdAndCartProductId($id_order, $id_cart_product){
        $active_confirm = DB::select('SELECT `purchase`.`active_confirm` FROM `purchase` WHERE `id_order` = ? AND `id_cart_product` = ? LIMIT 1', [$id_order, $id_cart_product])[0]->active_confirm;
        return $active_confirm;
    }

    public static function findActiveReturnByOrderIdAndCartProductId($id_order, $id_cart_product){
        $active_return = DB::select('SELECT `purchase`.`active_return` FROM `purchase` WHERE `id_order` = ? AND `id_cart_product` = ? LIMIT 1', [$id_order, $id_cart_product])[0]->active_return;
        return $active_return;
    }

    public static function findActiveReturnByOrderIdAndCartProductIdInTableReturnOrder($id_order, $id_cart_product){
        $active_return_order = DB::select('SELECT `return_order`.`active` AS `active_return_order` FROM `purchase`, `return_order` WHERE `id_order` = ? AND `id_cart_product` = ? AND `return_order`.`id_purchase` = `purchase`.`id` LIMIT 1', [$id_order, $id_cart_product]);
        if(isset($active_return_order[0]->active_return_order)) {
            return $active_return_order[0]->active_return_order;
        }
        return 2020;
    }
}
