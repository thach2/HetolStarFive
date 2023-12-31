<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Social; // Assuming your model namespace is App\Models
use Socialite;
use App\Models\Login; // Assuming your model namespace is App\Models
use App\Http\Requests; // Make sure you have the appropriate namespace for Requests
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Http\Controllers\Captcha; // Assuming your Captcha rule is in the App\Rules namespace
use Cart;


class CartController extends Controller
{


    public function save_cart(Request $request){
        $roomId = $request->roomid_hidden;
        $quantity_checkin = $request->qty_checkin;
        $quantity_checkout = $request->qty_checkout;

        $room_info = DB::table('tbl_room')->where('room_id',$roomId)->first();
        $first_date = strtotime($quantity_checkin);
        $second_date = strtotime($quantity_checkout);
        $qty = abs($first_date - $second_date);
        $quantity= floor($qty / (60*60*24));
        if (empty($quantity_checkin)||empty($quantity_checkout)) {
            Session::put('message', 'Không được để trống checkin và checkout');
            return Redirect::to('/chi-tiet/'.$roomId);
          
        } else if( strtotime($quantity_checkin)>strtotime($quantity_checkout) ){ Session::put('message', 'Ngày checkout phải lớn hơn ngày checkin');
            return Redirect::to('/chi-tiet/'.$roomId);
           
        }
        else{ $data['id'] = $room_info->room_id;
            $data['qty']=$quantity;
            $data['name'] = $room_info->room_name;
            $data['price'] = $room_info->room_price;
            $data['weight'] = $room_info->room_price;
            $data['options']['qty_checkin'] = $quantity_checkin;
            $data['options']['qty_checkout'] = $quantity_checkout;
            $data['options']['image'] = $room_info->room_image;
            Cart::add($data);
           return Redirect::to('/show-cart');}
       
    }
    public function delete_to_cart($rowId){
        Cart::remove($rowId);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity_checkin(Request $request){
        $rowId = $request->rowId_cart;
        $quantity_checkin = $request->cart_qty_checkin;
        $roomId = $request->roomid_hidden;
        $quantity_checkout = $request->cart_qty_checkout;


        $room_info = DB::table('tbl_room')->where('room_id',$roomId)->first();
        $first_date = strtotime($quantity_checkin);
        $second_date = strtotime($quantity_checkout);
        $qty = abs($first_date - $second_date);
        $quantity= floor($qty / (60*60*24));

        $data['id'] = $room_info->room_id;
        $data['qty']=$quantity;
        $data['name'] = $room_info->room_name;
        $data['price'] = $room_info->room_price;
        $data['weight'] = $room_info->room_price;
        $data['options']['qty_checkin'] = $quantity_checkin;
        $data['options']['qty_checkout'] = $quantity_checkout;
        $data['options']['image'] = $room_info->room_image;
       
        
        Cart::update($rowId,$data);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity_checkout(Request $request){
        $rowId = $request->rowId_cart;
        $quantity_checkout = $request->cart_qty_checkout;
        $roomId = $request->roomid_hidden;
        $quantity_checkin = $request->cart_qty_checkin;


        $room_info = DB::table('tbl_room')->where('room_id',$roomId)->first();
        $first_date = strtotime($quantity_checkin);
        $second_date = strtotime($quantity_checkout);
        $qty = abs($first_date - $second_date);
        $quantity= floor($qty / (60*60*24));

        $data['id'] = $room_info->room_id;
        $data['qty']=$quantity;
        $data['name'] = $room_info->room_name;
        $data['price'] = $room_info->room_price;
        $data['weight'] = $room_info->room_price;
        $data['options']['qty_checkin'] = $quantity_checkin;
        $data['options']['qty_checkout'] = $quantity_checkout;
        $data['options']['image'] = $room_info->room_image;
       
        
        Cart::update($rowId,$data);
        return Redirect::to('/show-cart');
    }
    public function show_cart(Request $request){
        //seo 
        $meta_desc = "Đơn đặt phòng của bạn"; 
        $meta_keywords = "Đơn đặt";
        $meta_title = "Đơn đặt";
        $url_canonical = $request->url();
        //--seo
        $cate_room = DB::table('tbl_category_room')->where('category_status','0')->orderby('category_id','desc')->get(); 
       
        return view('page.cart.show_cart')->with('category',$cate_room)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }

}