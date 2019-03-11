            <div class="col-lg-12">
              <div class="box">
                <h1>Menu on: <?php echo date('d\.m\.Y'); ?></h1>
                <p> Every day we are cooking other dishes to fascinate You!
                    <?php if(empty($_COOKIE['id'])){?>
                    <h2 class="alert__text authorization_message">Для замовлення страв необхідно <a href="/login">увійти</a> або <a href="/register">зареєструватися!</a></h2>
                <?php } ?>
                </p>
              </div>
              <div class="row products">    
              <?php $dishes=getDishes($db);
                foreach ($dishes as $dish => $property) {
              ?>             
                <div class="col-lg-3 col-md-4">
                  <div class="product">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="dish/?id=<?php echo ($property['id']);?>"><img src="../public/img/<?php echo($property['image']); ?>" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="dish/?id=<?php echo ($property['id']);?>"><img src="../public/img/<?php echo($property['image']); ?>" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="dish/?id=<?php echo ($property['id']);?>" class="invisible"><img src="../public/img/<?php echo($property['image']); ?>" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3><a href="dish/?id=<?php echo ($property['id']);?>"><?php echo($property['title']);?></a></h3>
                      <p class="price"> 
                        <del></del><?php echo(fixPrice($property['price']));?> грн.
                      </p>
                      <p class="buttons">
                        <a href="dish/?id=<?php echo ($property['id']);?>" class="btn btn-outline-secondary">View detail</a>
                        <a href="<?php if (count($this_id)!=0 && $this_id != 0){ echo ('cart/?add='.$property['id']); } ?>" class="btn btn-primary">
                            <i class="fa fa-shopping-cart"></i>Add to cart</a>
                      </p>
                    </div>
                    <!-- /.text-->
                  </div>
                  <!-- /.product            -->
                </div>
            <?php } ?>    
                <!-- /.products-->
              </div>
              <!-- <div class="pages">
                <p class="loadMore"><a href="#" class="btn btn-primary btn-lg"><i class="fa fa-chevron-down"></i> Load more</a></p>
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                  <ul class="pagination">
                    <li class="page-item"><a href="#" aria-label="Previous" class="page-link"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>
                    <li class="page-item active"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                    <li class="page-item"><a href="#" aria-label="Next" class="page-link"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>
                  </ul>
                </nav>
              </div> -->
            </div>
            <!-- /.col-lg-9-->
          </div>
      