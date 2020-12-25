@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">หยอดเงินเข้าตู้</div>

                <div class="card-body">

                    <div class="grid-3 ">
                    @foreach($money as $row2)
                            <button data='{{$row2->money_type}}' btn='btn' vid='{{$row2->id}}' class="btn btn-info coin">
                                {{$row2->money_type}} บาท
                            </button>
                    @endforeach 
                    </div>

                    <div class="list-coin py-3">
                        <ul class="list-group coin-list">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                จำนวนทั้งสิ้น
                                <span class="badge badge-primary badge-pill"><span id='total'></span> บาท</span>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-danger btn-block cancle">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">ทั้งหมด </div>

                <div class="card-body">

                    <div class="list-coin">
                        <ul class="list-group item-list">
                            
                        </ul>
                        <ul class="list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                สุทธิ
                                <span class="badge  badge-pill"><span id='total-product'></span> บาท</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                คงเหลือ
                                <span class="badge  badge-pill"><span id='recipt'></span> บาท</span>
                            </li>
                        </ul>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <button class="btn btn-success btn-block save">ซื้อสินค้า</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ระบบตู้ขายของอัตโนมัติ</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="grid-3">
                       @foreach($product as $row)
                            <div class="card_product">
                                @if($row->stock == '0')
                                <div class="outstock">
                                    <i class="fas fa-exclamation-circle"></i>สินค้าหมด
                                </div>
                                @endif
                                <img src="{{ asset('image/001.jpg') }}" style="width:100%">
                                <h3>{{$row->product_name}}</h3>
                                <p class="price">{{number_format($row->price,2)}} บาท</p>
                                @if($row->stock == '0')
                                <p><button type="button" class='btn outstockbtn'>สินค้าหมดชั่วคราว</button></p>
                                @else
                                <p><button type="button" data="{{$row}}" class='btn-buy btn-nomal' price="{{$row->price}}">ซื้อสินค้า</button></p>
                                @endif
                                
                            </div>
                        @endforeach 
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <span class="modal-title">ช่องรับสินค้า<span class='small'>กรุณาคลิกเพื่อรับสินค้า</span></span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                   
                <!-- Modal body -->
                <div class="modal-body mh300">
                    
                    <div class="row">
                        <div class="col-4">
                            <div class="recipt-card">
                                <div class="row">
                                    <div class="col">
                                        <span class='d-inline-block float-left'> เงินทอน</span>
                                        <span class='d-inline-block float-right res-recipt'> </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="list-coin">
                                            <ul class="list-group recipt-list">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="row mt-2">
                                            <div class="col">
                                                <button class="btn btn-success btn-block close_recipt_card">รับเงินทอน</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="grid-3 modal-product"></div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
