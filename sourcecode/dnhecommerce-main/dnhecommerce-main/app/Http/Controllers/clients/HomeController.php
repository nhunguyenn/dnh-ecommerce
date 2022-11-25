<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\admin\Category;
use App\Models\admin\Product;
use App\Models\admin\ThemeList;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
                "1", "1", "1", "1", "Áo Sweater CUNA Áo Sweater Nam Nữ Form Rộng Chất Cotton Nỉ Ngoại Hàng Xuất Cao Cấp Trơn Cổ Tròn Dài Tay Local Brand", "1668044388.jpg,1668044389.jpg", "200", "500000", "700000", "102", "1", "1", ""
            ]);
        }

        $checkData = DB::table('product_size')->count();
        if ($checkData == 0) {
            DB::insert('insert into product_size (id_product, name, quantity, note, active) values (?, ?, ?, ?, ?)', [
                "1", "S", "20", "", "1"
            ]);
            DB::insert('insert into product_size (id_product, name, quantity, note, active) values (?, ?, ?, ?, ?)', [
                "1", "M", "20", "", "1"
            ]);
            DB::insert('insert into product_size (id_product, name, quantity, note, active) values (?, ?, ?, ?, ?)', [
                "2", "XL", "20", "", "1"
            ]);
            DB::insert('insert into product_size (id_product, name, quantity, note, active) values (?, ?, ?, ?, ?)', [
                "2", "L", "20", "", "1"
            ]);
        }

        $checkData = DB::table('product_color')->count();
        if ($checkData == 0) {
            DB::insert('insert into product_color (id_product, name, color_code, quantity, price, note, active) values (?, ?, ?, ?, ?, ?, ?)', [
                "1", "Đỏ", "#ff0000", "10", "300000", "", "1"
            ]);
            DB::insert('insert into product_color (id_product, name, color_code, quantity, price, note, active) values (?, ?, ?, ?, ?, ?, ?)', [
                "1", "Hồng", "#e75090", "10", "0", "", "1"
            ]);
            DB::insert('insert into product_color (id_product, name, color_code, quantity, price, note, active) values (?, ?, ?, ?, ?, ?, ?)', [
                "2", "Trắng", "#f8f8f8", "10", "100000", "", "1"
            ]);
            DB::insert('insert into product_color (id_product, name, color_code, quantity, price, note, active) values (?, ?, ?, ?, ?, ?, ?)', [
                "2", "Xanh", "#3d46e3", "10", "0", "", "1"
            ]);
        }

        $checkData = DB::table('product_discount')->count();
        if ($checkData == 0) {
            DB::insert('insert into product_discount (id_product, percent_discount, quantity, note, active, time_start, time_end) values (?, ?, ?, ?, ?, ?, ?)', [
                "1", "5", "2", "", "1", "2022-11-11", "2022-11-16"
            ]);
        }

        $checkData = DB::table('account')->count();
        if ($checkData == 0) {
            DB::insert('insert into account (email, password, role) values (?, ?, ?)', [
               "letriduc@gmail.com", md5("123456"), "customer"
            ]);
            DB::insert('insert into account (email, password, role) values (?, ?, ?)', [
                "nguyenthithaonhu@gmail.com", md5("123456"), "customer"
            ]);
            DB::insert('insert into account (email, password, role) values (?, ?, ?)', [
                "nguyenquochop@gmail.com", md5("123456"), "customer"
            ]);

            DB::insert('insert into account (email, password, role) values (?, ?, ?)', [
                "letriduc.dnh@gmail.com", md5("123456"), "admin"
            ]);
            DB::insert('insert into account (email, password, role) values (?, ?, ?)', [
                "nguyenthithaonhu.dnh@gmail.com", md5("123456"), "admin"
            ]);
            DB::insert('insert into account (email, password, role) values (?, ?, ?)', [
                "nguyenquochop.dnh@gmail.com", md5("123456"), "admin"
            ]);
        }

        $checkData = DB::table('customer')->count();
        if ($checkData == 0) {
            DB::insert('insert into customer (name, gender, phone, id_account) values (?, ?, ?, ?)', [
                "Lê Trí Đức", "0", "0377025449", "1"
            ]);
            DB::insert('insert into customer (name, gender, phone, id_account) values (?, ?, ?, ?)', [
                "Nguyễn Thị Thảo Như", "1", "0377025448", "2"
            ]);
            DB::insert('insert into customer (name, gender, phone, id_account) values (?, ?, ?, ?)', [
                "Nguyễn Quốc Hợp", "0", "0377025447", "3"
            ]);

            DB::insert('insert into address (id_customer, specific_address, phone, active) values (?, ?, ?, ?)', [
                "1", "19, Nguyễn Hữu Thọ, Tân Phong, Quận 7, HCM", "0377025449", "1"
            ]);
            DB::insert('insert into address (id_customer, specific_address, phone, active) values (?, ?, ?, ?)', [
                "1", "Ấp Hoà Bình, Xã Nguyễn Văn Thảnh, Huyện Bình Tân, Vĩnh Long", "0245675446", "0"
            ]);
            DB::insert('insert into address (id_customer, specific_address, phone, active) values (?, ?, ?, ?)', [
                "2", "19, Nguyễn Hữu Thọ, Tân Phong, Quận 7, HCM", "0377025448", "1"
            ]);
            DB::insert('insert into address (id_customer, specific_address, phone, active) values (?, ?, ?, ?)', [
                "3", "19, Nguyễn Hữu Thọ, Tân Phong, Quận 7, HCM", "0377025447", "1"
            ]);
        }

        $checkData = DB::table('employee')->count();
        if ($checkData == 0) {
            DB::insert('insert into employee (name, phone, address, id_card, id_account) values (?, ?, ?, ?, ?)', [
                "Lê Trí Đức", "0377025449", "19, Nguyễn Hữu Thọ, Tân Phong, Quận 7, HCM", "352541279", "4"
            ]);
            DB::insert('insert into employee (name, phone, address, id_card, id_account) values (?, ?, ?, ?, ?)', [
                "Nguyễn Thị Thảo Như", "0377025448", "19, Nguyễn Hữu Thọ, Tân Phong, Quận 7, HCM", "352541278", "5"
            ]);
            DB::insert('insert into employee (name, phone, address, id_card, id_account) values (?, ?, ?, ?, ?)', [
                "Nguyễn Quốc Hợp", "0377025447", "19, Nguyễn Hữu Thọ, Tân Phong, Quận 7, HCM", "352541277", "6"
            ]);
        }

        $checkData = DB::table('cart_product')->count();
        if ($checkData == 0) {
            DB::insert('insert into cart_product (id_customer, id_product, id_size, id_color) values (?, ?, ?, ?)', [
                "1", "1", "2", "1"
            ]);

            DB::insert('insert into cart_product (id_customer, id_product, id_size, id_color) values (?, ?, ?, ?)', [
                "1", "2", "4", "3"
            ]);

            DB::insert('insert into cart_product (id_customer, id_product, id_size, id_color) values (?, ?, ?, ?)', [
                "2", "1", "1", "2"
            ]);

            DB::insert('insert into cart_product (id_customer, id_product, id_size, id_color) values (?, ?, ?, ?)', [
                "2", "2", "3", "4"
            ]);
        }

        $themes = ThemeList::orderBy('created_at')->get();
        $categorys = Category::orderBy('created_at')->get();
        $products = Product::orderBy('created_at')->get();

        return view('clients.index', [
            'themes' => $themes,
            'categorys' => $categorys,
            'products' => $products,
        ]);
    }

    public static function findCategoryByThemeId($themeId)
    {
        $category = Category::orderBy('created_at')->where('id_theme_list', $themeId)->get();
        return $category;
    }
}
