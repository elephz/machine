<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Money;
class Ordercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $money = Money::orderBy('id', 'DESC')->get();
        $data = $request->get('val');
        $product_id = $request->get('product_id');

       $sum = [];
       $moneyname = [] ;
       $recipt = 0; 
    foreach($money as $k=>$v){
        if($v['stock'] > 0){
            array_push($moneyname,$v['money_type']);
            $stock[$v['money_type']] = $v['stock'];
        }
    }
    foreach($moneyname as $k=>$v){
         $toto = $data % $v;
         $val = ($data - $toto)/$v;
                if($val != 0){
                    if($val > $stock[$v]){
                        $diff = $val - $stock[$v];
                        $val = $stock[$v];
                        $toto = $toto + ($diff *  $v);
                    }
                }
            $sum[$v] = $val;
            $data = $toto;
     }
     foreach($sum as $k => $v){
         if($v == 0){
             unset($sum[$k]);
         }
         $recipt += ($k * $v);
     }
     
     if($data > 0){
        return response()->json(['message'=>"false"]);
     }else{
         
        foreach($product_id as $k => $v){
            $query2 = DB::table('products')->where('id',$v['id']);
            $query2->decrement('stock', $v['count']);
        }
         foreach($sum as $k => $v){
           $query = DB::table('money')->where('money_type',$k);
           $query->decrement('stock', $v);
         }
        return response()->json(['data'=>$sum,'message'=>'success','totalresponse' => $recipt]); 
     }
    //  echo "<pre>";
    //  print_r($product_id);
    //  echo "</pre>";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
}
