@extends('layouts.app')
@section('content')
   <div class="container">
       <h2><center>ข้อมูลสินค้า</center></h2>
        <a href="/product/create" class='btn btn-primary my-2'>เพิ่มข้อมูล</a>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">รหัส</th>
                <th scope="col">ชื่อ</th>
                <th scope="col">ราคา</th>
                <th scope="col">คงเหลือ</th>
                <th scope="col">แก้ไข</th>
                <th scope="col">ลบ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                <tr>
                    <th scope="row">{{$row->id}}</th>
                    <td>{{$row->product_name}}</td>
                    <td>{{number_format($row->price,2)}}</td>
                    <td>{{$row->stock}}</td>
                    <td>
                        <a href="{{route('product.edit',$row->id)}}" class='btn btn-success'>แก้ไข</a>
                    </td>
                    <td>
                        <form action="{{route('product.destroy',$row->id)}}" method='POST'>
                            @csrf @method('DELETE')
                            <input type="submit" value='ลบ' data-name="{{$row->product_name}}" class='btn btn-danger deleteForm' >
                        </form>
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col text-right">
                {{$data->links()}}
            </div>
        </div>
   </div>
@endsection