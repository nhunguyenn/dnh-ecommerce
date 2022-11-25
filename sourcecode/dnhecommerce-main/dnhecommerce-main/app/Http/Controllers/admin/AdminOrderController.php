<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\OperationHistory;
use App\Models\admin\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = DB::select('SELECT `order`.*, `customer`.`name` AS `name_customer` FROM `order`, `cart_product`, `customer` WHERE `order`.`id_cart_product`=`cart_product`.`id` AND `cart_product`.`id_customer`=`customer`.`id`');
        $carts = DB::select('SELECT * FROM `cart_product`');
        $products = DB::select('SELECT * FROM `product`');
        $deliverys = DB::select('SELECT * FROM `delivery`');
        $countToship = DB::table('order')->where('active', 1)->count();
        $countShipping = DB::table('order')->where('active', 2)->count();
        $countCompleted = DB::table('order')->where('active', 3)->count();

        $returns = DB::select('SELECT `return_order`.`id`, `return_order`.`active`, `cart_product`.`quantity_product`, `product`.`name` AS `name_product`,
        `delivery`.`name` AS `name_delivery`, `customer`.`name` AS `name_customer`, `order`.`id` AS `id_order`
        FROM `return_order`, `purchase`, `cart_product`, `product`, `delivery`, `customer`, `order`
        WHERE `return_order`.`id_purchase`=`purchase`.`id` AND `purchase`.`id_cart_product`=`cart_product`.`id`
        AND `cart_product`.`id_product`=`product`.`id` AND `cart_product`.`id_customer`=`customer`.`id` AND `purchase`.`id_order`=`order`.`id` AND `order`.`id_delivery`=`delivery`.`id`');

        $order_dones = DB::select('SELECT `purchase`.id, `cart_product`.`quantity_product`, `product`.`name` AS `name_product`,
        `delivery`.`name` AS `name_delivery`, `customer`.`name` AS `name_customer`, `order`.`id` AS `id_order`, (`cart_product`.`quantity_product` * `product`.`price`) AS `total_price`
        FROM  `purchase`, `cart_product`, `product`, `delivery`, `customer`, `order`
        WHERE `purchase`.`id_cart_product`=`cart_product`.`id`
        AND `cart_product`.`id_product`=`product`.`id` AND `cart_product`.`id_customer`=`customer`.`id` AND `purchase`.`id_order`=`order`.`id` AND `order`.`id_delivery`=`delivery`.`id`');

        $return_orders = DB::select('SELECT * FROM return_order');
        // return [$order_dones, $return_order];

        return view('admin.order.index', [
            "countToship" => $countToship,
            "countShipping" => $countShipping,
            "countCompleted" => $countCompleted,
            "orders" => $orders,
            "returns" => $returns,
            "order_dones" => $order_dones,
            "return_orders" => $return_orders,
            "carts" => $carts,
            "products" => $products,
            "deliverys" => $deliverys,
        ]);
    }

    public function shipping(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $order = Order::find($request->id);
        $order->active = 2;
        $order->date_shipping = $dt->toDateString();
        $order->save();

        $operation_history = new OperationHistory();
        $operation_history->id_employee = $request->session()->get('id_admin');
        $operation_history->table = "order";
        $operation_history->operation = "Xác Nhận Giao Hàng";
        $operation_history->save();
    }

    public function completed(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $order = Order::find($request->id);
        $order->active = 3;
        $order->date_completed = $dt->toDateString();
        $order->save();

        foreach (explode(",", $order->id_cart_product) as $id_cart_product) {
            DB::insert('insert into purchase (id_order, id_cart_product) values (?, ?)', [$request->id, $id_cart_product]);
        }

        $operation_history = new OperationHistory();
        $operation_history->id_employee = $request->session()->get('id_admin');
        $operation_history->table = "order";
        $operation_history->operation = "Xác Nhận Đã Giao Hàng";
        $operation_history->save();
    }

    public function handleCrudOrder(Request $request)
    {
        if ($request->button == "shipping") {
            self::shipping($request);
        }

        if ($request->button == "completed") {
            self::completed($request);
        }

        return redirect()->route('admin.order');
    }
}
