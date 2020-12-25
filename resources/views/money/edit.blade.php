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
        {!! Form::open(['action' => ['MoneyController@update',$data->id],'method'=>'PUT']) !!}
            <div class='col-md-6'>
                <div class="form-group">
                    {!! Form::label('ชนิด')!!}
                    {!! Form::text('money_type',$data->money_type,["class"=>"form-control",'readonly' => 'true'])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('จำนวน')!!}
                    {!! Form::text('stock',$data->stock,["class"=>"form-control"])!!}
                </div>
                <input type="submit" value="อัพเดท" Class='btn btn-primary'>
                <a href="/product" class='btn btn-success'>กลับ</a>
            </div>
        {!! Form::close() !!}
    </div>
@endsection