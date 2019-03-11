<div id="basket" class="col-lg-9">
              <div class="box">
                <form method="post" action="checkout1.html">
                <input type="hidden" name="action" value="add"> 
                  <h1>Shopping cart</h1>
                  <p class="text-muted">You currently have <span id='cartCount'><?php echo get_cart_count();?></span> item(s) in your cart.</p>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th colspan="2">Product</th>
                          <th>Quantity</th>
                          <th>Unit price</th>
                          <th>Discount</th>
                          <th colspan="2">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                      
      <?php  if (isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])){
          // $cart_from_cookie=unserialize($_COOKIE['cart']);
          $cart_from_cookie= json_decode($_COOKIE['cart'],true);
          $cart_items=getCart($db); 
		      $sum=0; ?>
        <?php foreach ($cart_items as $item => $property) { 
          ?>
          <tr>
           <td><a href="dish/?id=<?php echo ($property['ID']);?>"><img src="../public/img/<?php echo($property['image'])?>" alt="dish_cover"></a></td>
           <td><a href="dish/?id=<?php echo ($property['ID']);?>"><?php echo ($property['title']);?></a></td>
           <td>
            <input type="number" value="<?php echo ($cart_from_cookie[$property['ID']]);?>" class="form-control">
            <input type="hidden" name="ID" value="<?php echo ($property['ID']);?>">
           </td>
           <td><?php echo $property['price']; ?></td>
           <td>$0.00</td>
           <td>
           <?php echo $property['price']*$cart_from_cookie[$property['ID']];
					$sum+=$property['price']*$cart_from_cookie[$property['ID']]; ?></td>
           <td><a href="cart/?delete=<?php echo($property['ID']);?>"><i class="fa fa-trash-o"></i></a></td>
        </tr>            


        <?php } } ?>


             </tbody>
                <tfoot>
                    <tr>
                          <th colspan="5">Total</th>
                          <th colspan="2" id="cartTotal"><?php echo $sum ?></th>
                    </tr>
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.table-responsive-->
                  <div class="box-footer d-flex justify-content-between flex-column flex-lg-row">
                    <div class="left"><a href="category.html" class="btn btn-outline-secondary"><i class="fa fa-chevron-left"></i> Continue shopping</a></div>
                    <div class="right">
                    <input type="hidden" name="order_price" value="<?php echo $sum;?>">
                     <a href="cart/?send=" style="margin:0 auto;">
				              <button class="cart__accept" type="submit">Підтвердити замовлення</button>	
			              </a>
                      <!-- <button class="btn btn-outline-secondary"><i class="fa fa-refresh"></i> Update cart</button> -->
                      <button type="submit" class="btn btn-primary">Proceed to checkout <i class="fa fa-chevron-right"></i></button>
                    </div>
                  </div>
                </form>
                </div>
              <!-- /.box-->
              <div class="row same-height-row">
                <div class="col-lg-3 col-md-6">
                  <div class="box same-height">
                    <h3>You may also like these products</h3>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="detail.html"><img src="img/product2.jpg" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="detail.html"><img src="img/product2_2.jpg" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="detail.html" class="invisible"><img src="img/product2.jpg" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3>Fur coat</h3>
                      <p class="price">$143</p>
                    </div>
                  </div>
                  <!-- /.product-->
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="detail.html"><img src="img/product1.jpg" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="detail.html"><img src="img/product1_2.jpg" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="detail.html" class="invisible"><img src="img/product1.jpg" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3>Fur coat</h3>
                      <p class="price">$143</p>
                    </div>
                  </div>
                  <!-- /.product-->
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="detail.html"><img src="img/product3.jpg" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="detail.html"><img src="img/product3_2.jpg" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="detail.html" class="invisible"><img src="img/product3.jpg" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3>Fur coat</h3>
                      <p class="price">$143</p>
                    </div>
                  </div>
                  <!-- /.product-->
                </div>
              </div>
            </div>
            <!-- /.col-lg-9-->
            <div class="col-lg-3 own_hidden">
              <div id="order-summary" class="box">
                <div class="box-header">
                  <h3 class="mb-0">Order summary</h3>
                </div>
                <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>
                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Order subtotal</td>
                        <th>$446.00</th>
                      </tr>
                      <tr>
                        <td>Shipping and handling</td>
                        <th>$10.00</th>
                      </tr>
                      <tr>
                        <td>Tax</td>
                        <th>$0.00</th>
                      </tr>
                      <tr class="total">
                        <td>Total</td>
                        <th>$456.00</th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="box">
                <div class="box-header">
                  <h4 class="mb-0">Coupon code</h4>
                </div>
                <p class="text-muted">If you have a coupon code, please enter it in the box below.</p>
                <form>
                  <div class="input-group">
                    <input type="text" class="form-control"><span class="input-group-append">
                      <button type="button" class="btn btn-primary"><i class="fa fa-gift"></i></button></span>
                  </div>
                  <!-- /input-group-->
                </form>
              </div>
            </div>