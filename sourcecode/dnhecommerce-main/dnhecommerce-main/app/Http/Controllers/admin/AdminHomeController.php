<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    public function index()
    {
        $checkData = DB::table('supplier')->count();
        if ($checkData == 0) {
            DB::insert('insert into supplier (name, phone, email, address, bank_name, bank_number, note) values (?, ?, ?, ?, ?, ?, ?)', ["Local Brand", "0933758241", "localbrand@gmail.com", "19, Nguyễn Hữu Thọ, Tân Phong, Quận 7, HCM", "Local Brand", "788921763929", ""]);
        }

        $checkData = DB::table('tax')->count();
        if ($checkData == 0) {
            DB::insert('insert into tax (name, value, type, note) values (?, ?, ?, ?)', ["Thuế giá trị gia tăng (GTGT) - 5%", "5", "GTGT", ""]);
        }

        $checkData = DB::table('delivery')->count();
        if ($checkData == 0) {
            DB::insert('insert into delivery (name, phone, price, note) values (?, ?, ?, ?)', ["Việt Nam Spot (VNpost / EMS)", "0933758241", "30000", ""]);
        }

        $checkData = DB::table('voucher')->count();
        if ($checkData == 0) {
            DB::insert('insert into voucher (name, price, total_product, note) values (?, ?, ?, ?)', ["Gói Siêu Voucher chỉ từ 10K", "10000", "2", ""]);
        }

        $checkData = DB::table('theme_list')->count();
        if ($checkData == 0) {
            DB::insert('insert into theme_list (name, image, note) values (?, ?, ?)', ["Thời Trang Nam", "1668044293.jpg", ""]);
        }

        $checkData = DB::table('category')->count();
        if ($checkData == 0) {
            DB::insert('insert into category (id_theme_list, name, note) values (?, ?, ?)', ["1", "Áo Khoác", ""]);
        }

        $checkData = DB::table('related_product')->count();
        if ($checkData == 0) {
            DB::insert('insert into related_product (name, related_category, note) values (?, ?, ?)', ["Áo Khoác Chống Mưa Gió", "1", ""]);
        }

        $checkData = DB::table('product')->count();
        if ($checkData == 0) {
            DB::insert('insert into product (id_supplier, id_tax, id_category, id_related, name, image, quantity, cost, price, viewed, active_sale, active_purchase, note) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                "1", "1", "1", "1", "Áo Khoác Hoodie Nam Nữ Form Rộng Trơn Có Dây Kéo Zip Chất Nỉ Ngoại Cao Cấp Màu Trắng Đen Xám Xanh Lá Ulzzang Unisex CUNA", "1668040383.jpg,1668040384.jpg", "200", "500000", "700000", "102", "1", "1", ""
            ]);
            DB::insert('insert into product (id_supplier, id_tax, id_category, id_related, name, image, quantity, cost, price, viewed, active_sale, active_purchase, note) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                "1", "1", "1", "1", "Áo Sweater CUNA Áo Sweater Nam Nữ Form Rộng Chất Cotton Nỉ Ngoại Hàng Xuất Cao Cấp Trơn Cổ Tròn Dài Tay Local Brand", "1668040383.jpg,1668040384.jpg", "200", "500000", "700000", "102", "1", "1", ""
            ]);
        }

        $checkData = DB::table('product_size')->count();
        if ($checkData == 0) {
            DB::insert('insert into product_size (id_product, name, quantity, note, active) values (?, ?, ?, ?, ?)', [
                "1", "S", "20", "", "1"
            ]);
        }

        $checkData = DB::table('product_color')->count();
        if ($checkData == 0) {
            DB::insert('insert into product_color (id_product, name, color_code, quantity, note, active) values (?, ?, ?, ?, ?, ?)', [
                "1", "Đỏ", "#ff0000", "10", "", "1"
            ]);
        }

        $checkData = DB::table('product_discount')->count();
        if ($checkData == 0) {
            DB::insert('insert into product_discount (id_product, percent_discount, quantity, note, active, time_start, time_end) values (?, ?, ?, ?, ?, ?, ?)', [
                "1", "5", "2", "", "1", "2022-11-11", "2022-11-16"
            ]);
        }

        return view('admin.index');
    }
}
