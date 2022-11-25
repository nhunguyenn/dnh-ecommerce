<?php

namespace App\Http\Controllers\clients;

class Helper
{
    public static function loadImage($product)
    {
        $imageList = explode(",", $product->image);
        return $imageList;
    }
}
