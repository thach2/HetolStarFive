@extends('layout')
@section('content')
<div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Kết quả tìm kiếm</h2>
    @foreach($search_room as $key => $room)
    <div class="col-sm-4">
        <div class="product-image-wrapper">

            <div class="single-products">
                <div class="productinfo text-center">
                    <form>
                        @csrf
                        <input type="hidden" value="{{ $room->room_id }}" class="cart_room_id_{{ $room->room_id }}">
                        <input type="hidden" value="{{ $room->room_name }}" class="cart_room_name_{{ $room->room_id }}">



                        <input type="hidden" value="{{ $room->room_image }}"
                            class="cart_room_image_{{ $room->room_id }}">
                        <input type="hidden" value="{{ $room->room_price }}"
                            class="cart_room_price_{{ $room->room_id }}">
                        <input type="hidden" value="1" class="cart_room_qty_{{ $room->room_id }}">
                        <a href="{{ URL::to('/chi-tiet/' . $room->room_id) }}">

                            <img src="../public/uploads/room/{{ $room->room_image }} " alt="" height="200"
                                width="200" />
                            <h1 style="color: rgb(4, 49, 252)">{{ $room->room_name }}</h1>
                            <h2>{{ number_format($room->room_price, 0, ',', '.') . ' ' . 'VNĐ' }} / Ngày</h2>


                            <p>92-94 Hang Trong Street Hoan Kiem District, Hà Nội Việt Nam</p>
                        </a>

                        <a href="{{ URL::to('/chi-tiet/' . $room->room_id) }}" class="btn btn-default add-to-cart"></i>Đặt Phòng</a>
                    </form>


                </div>

            </div>

            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!--/recommended_items-->
@endsection