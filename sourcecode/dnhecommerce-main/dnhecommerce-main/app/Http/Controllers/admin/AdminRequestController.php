<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\CartProduct;
use App\Models\admin\OperationHistory;
use App\Models\admin\Order;
use App\Models\admin\Product;
use App\Models\admin\Purchase;
use App\Models\admin\ReturnOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRequestController extends Controller
{
    public function unpaid()
    {
        $orders = DB::select('SELECT `order`.*, `customer`.`name` AS `name_customer` FROM `order`, `cart_product`, `customer` WHERE `order`.`id_cart_product`=`cart_product`.`id` AND `cart_product`.`id_customer`=`customer`.`id`');
        $carts = DB::select('SELECT * FROM `cart_product`');
        $products = DB::select('SELECT * FROM `product`');
        $deliverys = DB::select('SELECT * FROM `delivery`');

        $countUnpaid = DB::table('order')->where('active', 0)->count();
        $countConfirm = DB::table('order')->where('active', 3)->count();
        $countCancelled = DB::table('order')->where('active', 4)->count();

        return view('admin.request.unpaid', [
            "countUnpaid" => $countUnpaid,
            "countConfirm" => $countConfirm,
            "countCancelled" => $countCancelled,
            "orders" => $orders,
            "carts" => $carts,
            "products" => $products,
            "deliverys" => $deliverys,
        ]);
    }

    public function return()
    {
        $returns = DB::select('SELECT `return_order`.`id`, `return_order`.`active`, `cart_product`.`quantity_product`, `product`.`name` AS `name_product`,
        `delivery`.`name` AS `name_delivery`, `customer`.`name` AS `name_customer`, `order`.`id` AS `id_order`
        FROM `return_order`, `purchase`, `cart_product`, `product`, `delivery`, `customer`, `order`
        WHERE `return_order`.`id_purchase`=`purchase`.`id` AND `purchase`.`id_cart_product`=`cart_product`.`id`
        AND `cart_product`.`id_product`=`product`.`id` AND `cart_product`.`id_customer`=`customer`.`id` AND `purchase`.`id_order`=`order`.`id` AND `order`.`id_delivery`=`delivery`.`id`');

        $countUnpaid = DB::table('order')->where('active', 0)->count();
        $countConfirm = DB::table('order')->where('active', 1)->count();
        $countCancelled = DB::table('order')->where('active', 2)->count();

        return view('admin.request.return', [
            "countUnpaid" => $countUnpaid,
            "countConfirm" => $countConfirm,
            "countCancelled" => $countCancelled,
            "returns" => $returns,
        ]);
    }

    public function confirmOrder(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $order = Order::find($request->id);
        $order->active = 1;
        $order->date_toship = $dt->toDateString();
        $order->save();

        $operation_history = new OperationHistory();
        $operation_history->id_employee = $request->session()->get('id_admin');
        $operation_history->table = "order";
        $operation_history->operation = "Xác Nhận Đơn Hàng";
        $operation_history->save();
    }

    public function cancelledOrder(Request $request)
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $order = Order::find($request->id);
        $order->active = 4;
        $order->date_cancelled = $dt->toDateString();
        $order->save();

        $operation_history = new OperationHistory();
        $operation_history->id_employee = $request->session()->get('id_admin');
        $operation_history->table = "order";
        $operation_history->operation = "Hủy Đơn Hàng";
        $operation_history->save();

        foreach (explode(',', $order->id_cart_product) as $value) {
            $cart = CartProduct::find($value);

            $product = Product::find($cart->id_product);
            $product->quantity = $product->quantity + $cart->quantity_product;
            $product->save();
        }
    }

    public function confirmReturn(Request $request)
    {
        $return = ReturnOrder::find($request->id);
        $return->active = 1;
        $return->save();

        $operation_history = new OperationHistory();
        $operation_history->id_employee = $request->session()->get('id_admin');
        $operation_history->table = "return_order";
        $operation_history->operation = "Xác Nhận Trả Hàng/Hoàn Tiền";
        $operation_history->save();
    }

    public function cancelledReturn(Request $request)
    {
        $return = ReturnOrder::find($request->id);
        $return->active = 2;
        $return->save();

        $purchase = Purchase::find($return->id_purchase);
        $purchase->active_confirm = 1;
        $purchase->active_return = 0;
        $purchase->save();

        $operation_history = new OperationHistory();
        $operation_history->id_employee = $request->session()->get('id_admin');
        $operation_history->table = "purchase, return_order";
        $operation_history->operation = "Từ Chối Trả Hàng/Hoàn Tiền";
        $operation_history->save();
    }

    public function confirmReturnOrder(Request $request)
    {
        $return = ReturnOrder::find($request->id);
        $return->active = 3;
        $return->save();

        $operation_history = new OperationHistory();
        $operation_history->id_employee = $request->session()->get('id_admin');
        $operation_history->table = "return_order";
        $operation_history->operation = "Xác Nhận Đã Trả Hàng";
        $operation_history->save();

        $purchase = Purchase::find($return->id_purchase);
        $cart = CartProduct::find($purchase->id_cart_product);

        $product = Product::find($cart->id_product);
        $product->quantity = $product->quantity + $cart->quantity_product;
        $product->save();
    }

    public function confirmRefunded(Request $request)
    {
        $return = ReturnOrder::find($request->id);
        $return->active = 4;
        $return->save();

        $operation_history = new OperationHistory();
        $operation_history->id_employee = $request->session()->get('id_admin');
        $operation_history->table = "return_order";
        $operation_history->operation = "Xác Nhận Đã Hoàn Tiền";
        $operation_history->save();
    }

    public function handleCrudRequest(Request $request)
    {
        if ($request->button == "confirmOrder") {
            self::confirmOrder($request);
        }

        if ($request->button == "cancelledOrder") {
            self::cancelledOrder($request);
        }

        if ($request->button == "confirmReturn") {
            self::confirmReturn($request);
            return redirect()->route('admin.request.return');
        }

        if ($request->button == "cancelledReturn") {
            self::cancelledReturn($request);
            return redirect()->route('admin.request.return');
        }

        if ($request->button == "confirmReturnOrder") {
            self::confirmReturnOrder($request);
            return redirect()->route('admin.order');
        }

        if ($request->button == "confirmRefunded") {
            self::confirmRefunded($request);
            return redirect()->route('admin.order');
        }

        return redirect()->route('admin.request.unpaid');
    }
}
