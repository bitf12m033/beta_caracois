<?php
/**
 * Created by PhpStorm.
 * User: umair
 * Date: 8/18/2020
 * Time: 7:35 PM
 */


if (! function_exists('get_product')) {
    function get_product($pro)
    {
         $produc = unserialize($pro);
        $string =null;
        foreach ($produc as $p)
        {
            $prok = \App\Product::where('id',$p)->first();

            $string  .= ' ' . $prok->product_name.',';

        }
        return rtrim($string, ',');
    }
}
if (! function_exists('get_product_name')) {
    function get_product_name($id)
    {
        $prok = \App\Product::where('id',$id)->first();
        return $prok->product_name;

    }
}