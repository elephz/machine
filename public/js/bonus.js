$(document).ready(function(){
    coin();
    
    $('.deleteForm').click(function(evt){
        var name = $(this).data("name");
        var form = $(this).closest("form");
        evt.preventDefault();
        swal({
            title:`คุณต้องการลบข้อมูล ${name} ?`,
            text:"ถ้าลบแล้วไม่สามารถกู้คืนได้",
            icon:"warning",
            buttons:true,
            dangerMode:true
        }).then((willDelete)=>{
            if(willDelete){
                form.submit();
            }
        });
    });

     
    function coin(){
        let total = 0;
        var arrproduct = [];
        let total_product = 0;
        let recipts = 0;
       
        check();
        $('.save').click(function(evt){ 
            if(shoppingCart.totalCart() == 0 || itemCart.totalCart() == 0){
                swal("ไม่สำเร็จ","กรุณาป้อนข้อมูลให้ครบถ้วน","error");
                return;
            }
          let val = shoppingCart.totalCart()-itemCart.totalCart();
          let product_id = [];
          $.each(itemCart.loadcart(),function(k,v){
              let obj = {'id':v.id,'count':v.count}
            product_id.push(obj);
          })
          data = {val,product_id}
          $(".in-recipt-list").remove();
          $.ajax({
            type: "POST",
            url: "/api/order",
            data: data,
            dataType: 'json',
            cache: false,
            success: function (result) {
                if(result.message == "false"){
                    swal("ขออภัยค่ะ!","ระบบไม่สามารถทอนเงินคุณได้","error");
                    $('.cancle').click();
                }
                if(result.message == "success"){
                    let resdata = result.data;
                    let rows = "";
                   
                    $(".res-recipt").html(result.totalresponse+" บาท");
                    $.each(resdata,function(k,v){
                        let fkeyword;
                        let lkeyword;
                        if(Number(k) < 20){
                            fkeyword = 'เหรียญ';
                            lkeyword = 'เหรียญ';
                        }else{
                            fkeyword = 'ธนบัตร ';
                            lkeyword = 'ฉบับ';
                        }
                        rows += `<li class="list-group-item d-flex in-recipt-list justify-content-between align-items-center">
                                    ${fkeyword} ${k} บาท
                                <span class="badge badge-primary badge-pill">${v} ${lkeyword}</span>
                                </li>`;
                      })
                      $(".recipt-list").append(rows);
                      swal({
                        title: "ดำเนินการเสร็จสิ้น",
                        text: "กรุณารับสินค้าและเงินทอนค่ะ!",
                        icon: "success",
                        button: "รับสินค้า",
                      }).then(()=>{
                        runmodel();
                    });;
                     
                }
            } 

            }).then(()=>{
                $('.close_recipt_card').click(function(evt){ 
                    $(".recipt-card").fadeOut(1000);
                  
                }); 
                $('#myModal').on('hidden.bs.modal', function () {
                      location.reload();
              })
                
            });
    
        });
        function runmodel(){
        $('#myModal').modal('show');
          let rowRecipt= "";
          $.each(itemCart.loadcart(),function(k,v){ 
            console.log(v);
            rowRecipt+=
            `<div class="card_product in-product">
                <img src="../image/001.jpg" style="width:100%">
                <h3>${v.name}</h3>
            </div>`;
          });
          $(".modal-product").append(rowRecipt);
        }
        $('.modal-product').on("click", ".in-product", function(event) {
          console.log(this);
            $(this).fadeOut('slow');
        })
        $('.coin').click(function(evt){ 
           $(".ls").remove();
            let val = $(this).attr('data');
            total+= Number(val);
            shoppingCart.addItemToCart(val, 1);
            console.log("total money"+shoppingCart.totalCart());
            totalmoney(shoppingCart.totalCart())
            check(shoppingCart.totalCart()-itemCart.totalCart())
            coinlist(shoppingCart.loadcart());
        });
       function coinlist(listcoin){
        console.log(listcoin);
        let rows1 = "";
        $.each(listcoin, function (k,v) { 
            let fk ;
            let lk ;
            if(Number(v.name) < 20){
                fk = 'เหรียญ';
                lk = 'เหรียญ';
            }else{
                fk = 'ธนบัตร';
                lk = 'ฉบับ';
            }
            rows1 += `<li class="list-group-item ls d-flex justify-content-between align-items-center">
                       ${fk} ${v.name} บาท
                        <span class="badge badge-pill">
                        ${v.count} ${lk}
                        </span>
                    </li>`;
        });
        $(".coin-list").append(rows1)
       }
        $('.cancle').click(function(evt){
            shoppingCart.clearCart();
            itemCart.clearCart();
            totalmoney(shoppingCart.totalCart())
            producttotal(itemCart.totalCart())
            check(shoppingCart.totalCart())
            $('.in-item-list').remove().fadeOut('fast')
            $('.ls').remove().fadeOut('fast')
         });

        
         $('.btn-buy').click(function(evt){
             let val = $(this).attr('data'); 
             let ps =$.parseJSON(val);
            
             arrproduct.push(ps);
            itemCart.addItemToCart(ps.id,ps.price,ps.stock,ps.product_name, 1);
            wiretpoduct(itemCart.loadcart())
         })
         function wiretpoduct(list){
            var rows = "";
            $(".in-item-list").remove();
            $.each(list, function (k, v) { 
                    let limit ;
                    recipts = (shoppingCart.totalCart()-itemCart.totalCart());
                    if(Number(v.price) > Number(recipts)){
                        limit = 'disabled';
                    }else{
                        limit = 'item';
                    }
                rows += `<li class="list-group-item in-item-list d-flex justify-content-between align-items-center">
                          <button item-id='${v.id}' class='btn btn-danger del-item'> X </button>  ${v.name}
                        <span class="badge badge-pill">
                            <a href="#" item-id='${v.id}' class='minus-item'><i class="fas fa-arrow-down"></i></a>
                            <input type='number' class='input-amount text-center' value='${v.count}' readonly/> 
                            <a href="#" item-id='${v.id}'  class='plush-item ${limit}'  ><i class="fas fa-arrow-up"></i></a>
                        </span>
                        </li>`;
            });
            $(".item-list").append(rows)
            total_product = itemCart.totalCart();
            producttotal(itemCart.totalCart())
            totalmoney(shoppingCart.totalCart())
            
         }
         $('.item-list').on("click", ".del-item", function(event) {
            event.preventDefault();
            var id = $(this).attr('item-id')
            itemCart.removeItemFromCartAll(id);
            wiretpoduct(itemCart.loadcart())
          })
          $('.item-list').on("click", ".minus-item", function(event) {
            event.preventDefault();
            var id = $(this).attr('item-id')
            itemCart.removeItemFromCart(id);
            wiretpoduct(itemCart.loadcart())
          })
          $('.item-list').on("click", ".plush-item", function(event) {
            event.preventDefault();
            console.log("total count" +itemCart.totalCount());
            
            
            var id = $(this).attr('item-id')
            itemCart.addItemToCart(id);
            wiretpoduct(itemCart.loadcart())
          })
          

         function producttotal(val){
                console.log(total_product);
                $("#total-product").html(val)
         }

         function recipt(val){
            $("#recipt").html(val)
         }

         function totalmoney(val){
            $("#total").html(val);
            recipt(shoppingCart.totalCart()-itemCart.totalCart())
            check(shoppingCart.totalCart()-itemCart.totalCart())
         }
       

         function check(total = 0){
            $('.btn-buy').each(function(i, obj) {
            let val = $(this).attr('price');
            if(Number(val) > total){
                 $(this).removeClass('btn-nomal');
                 $(this).addClass('btn-disabel');
                 $(this).attr('disabled', true)
            }else{
                 $(this).addClass('btn-nomal');
                 $(this).removeClass('btn-disabel');
                 $(this).attr('disabled', false)
            }
         });
         }
    };

var shoppingCart = (function() {  
    cart_coin = [];

    function Item(name,count) {
        this.name = name;
        this.count = count;
      }

      var obj = {};

      obj.totalCart = function() {
        var totalCart = 0;
        for(var item in cart_coin) {
          totalCart += Number(cart_coin[item].name) * Number(cart_coin[item].count);
        }
        return Number(totalCart);
      }

      obj.addItemToCart = function(name, count) {
        for(var item in cart_coin) {
          if(cart_coin[item].name === name) {
            cart_coin[item].count ++;
            return;
          }
        }
        var item = new Item(name, count);
        cart_coin.push(item);
      }
      obj.loadcart = function(){
        return cart_coin;
      }
      obj.clearCart = function() {
        cart_coin = [];
      }
      return obj;
})();

var itemCart = (function() {  
    cart = [];

    function Item(id,price,stock,name,count) {
        this.name = name;
        this.count = count;
        this.id = id;
        this.price = price;
        this.stock = stock;
      }

      var obj = {};

      obj.totalCart = function() {
        var totalCart = 0;
        for(var item in cart) {
          totalCart += cart[item].price * cart[item].count;
        }
        return Number(totalCart);
      }

      obj.totalCount = function() {
        var totalCount = 0;
        for(var item in cart) {
          totalCount += cart[item].count;
        }
        return totalCount;
      }
      obj.addItemToCart = function(id,price,stock,name,count) {
        id = Number(id);
        for(var item in cart) {
          if(Number(cart[item].id) === id) {
                if(Number(cart[item].count) >= Number(cart[item].stock)){
                    swal("ขออภัยค่ะ","สินค้ามีจำนวนไม่เพียงพอ","error");
                    return
                }
                cart[item].count ++;
                return;
          }
        }
        var item = new Item(id,price,stock,name,count);
        cart.push(item);
      }
      obj.loadcart = function(){
        return cart;
      }
      obj.clearCart = function() {
        cart = [];
      }
      obj.removeItemFromCartAll = function(id) {
          id = Number(id);
        for(var item in cart) {
          if(Number(cart[item].id) === id) {
            cart.splice(item, 1);
            break;
          }
        }
      }
      obj.removeItemFromCart = function(id) {
        id = Number(id);
        for(var item in cart) {
          if(Number(cart[item].id) === id) {
            cart[item].count --;
            if(cart[item].count === 0) {
              cart.splice(item, 1);
            }
            break;
          }
      }
    }
      return obj;
})();


});





