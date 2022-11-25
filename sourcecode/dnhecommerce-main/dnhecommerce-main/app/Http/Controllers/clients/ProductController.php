<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\admin\CartProduct;
use App\Models\admin\Product;
use App\Models\admin\ThemeList;
use App\Models\admin\Category;
use App\Models\admin\ProductColor;
use App\Models\admin\ProductSize;
use Illuminate\Http\Request;

class ProductController extends Controller{

    public function index($id = '', $slug = ''){
        $product = self::findProductById($id);
        $themes = ThemeList::orderBy('created_at')->get();
        $categorys = Category::orderBy('created_at')->get();
        $sizes = ProductSize::orderBy('created_at')->where('active', 1)->get();
        $colors = ProductColor::orderBy('created_at')->where('active', 1)->get();

        return view('clients.detail.index',[
            'product' => $product,
            'themes' => $themes,
            'categorys' => $categorys,
            'sizes' => $sizes,
            'colors' => $colors,
        ]);
    }

    public static function findProductById($id){
        return Product::where('id', $id)
        ->get()
        ->first();
    }

    public static function findThemeById($idCategory){
        $themeId = Category::where('id', $idCategory)
        ->first()
        ->id_theme_list;
        return $themeId;
    }
    public function handleAddToCart(Request $request)
    {
        $cart = new CartProduct;
        $cart->id_customer = $request->session()->get('id_customer');
        $cart->id_product = $request->id_product;
        $cart->id_size = $request->id_size;
        $cart->id_color = $request->id_color;
        $cart->quantity_product = $request->quantity_product;
        $cart->save();

        return redirect('product/'.$request->id_product.'-'.$request->slug_product);
    }
}
