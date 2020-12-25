@extends('layouts.app')
@section('content')
    <div class="container">
        @if($errors->all())
            <ul class='alert alert-danger'>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
        {!! Form::open(['action' => ['ProductController@update',$data->id],'method'=>'PUT']) !!}
            <div class='col-md-6'>
                <div class="form-group">
                    {!! Form::label('ชื่อสินค้า')!!}
                    {!! Form::text('product_name',$data->product_name,["class"=>"form-control"])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('ราคา')!!}
                    {!! Form::text('price',$data->price,["class"=>"form-control"])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('จำนวนคงเหลือ')!!}
                    {!! Form::text('stock',$data->stock,["class"=>"form-control"])!!}
                </div>
                <input type="submit" value="อัพเดท" Class='btn btn-primary'>
                <a href="/product" class='btn btn-success'>กลับ</a>
            </div>
        {!! Form::close() !!}
    </div>
@endsection