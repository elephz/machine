@extends('layouts.app')
@section('content')
   <div class="container">
       <h2><center>ข้อมูลเงินทอน</center></h2>
        <a href="/contact/create" class='btn btn-primary my-2'>เพิ่มข้อมูล</a>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">เงิน</th>
                <th scope="col">จำนวน</th>
                <th scope="col">เพิ่ม</th>
                </tr>
            </thead>
            <tbody>
                    @php
                        $fk ='';
                        $lk ='';
                    @endphp
                @foreach($data as $row)
                    @if($row->money_type < 20)
                        @php
                            $fk = 'เหรียญ';
                            $lk = 'เหรียญ';
                        @endphp
                    @else
                        @php
                            $fk = 'ธนบัตร'; 
                            $lk = 'ฉบับ';
                        @endphp
                    @endif
                    
                <tr>
                    <td>@php echo($fk); @endphp  {{$row->money_type}} บาท</td>
                    <td>
                    {{$row->stock}}  @php echo($lk); @endphp
                    </td>
                    <th scope="col">
                        <a href="{{route('money.edit',$row->id)}}" class='btn btn-success'>เพิ่ม</a>
                    </th>
                </tr>
                @endforeach
               
            </tbody>
        </table>
   </div>
@endsection