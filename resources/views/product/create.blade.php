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
        {!! Form::open(['action' => 'ProductController@store','method'=>'POST']) !!}
            <div class='col-md-6'>
                <div class="form-group">
                    {!! Form::label('ชื่อสินค้า')!!}
                    {!! Form::text('product_name',null,["class"=>"form-control"])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('ราคา')!!}
                    {!! Form::text('price',null,["class"=>"form-control"])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('จำนวน')!!}
                    {!! Form::text('stock',null,["class"=>"form-control"])!!}
                </div>
                <input type="submit" value="บันทึก" Class='btn btn-primary'>
                <a href="/product" class='btn btn-success'>กลับ</a>
            </div>
        {!! Form::close() !!}
    </div>
@endsection