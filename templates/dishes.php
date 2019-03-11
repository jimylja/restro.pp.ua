            <div class="col-lg-3">
          <?php 
            require_once('sidebar.php');
          ?>
                   
          <div class="banner"><a href="#"><img src="../public/img/banner.jpg" alt="sales 2014" class="img-fluid"></a></div>
            </div>
            <div class="col-lg-9">
              <div class="box">
                <h1><?php echo ($curent_category_name); ?></h1>
                <p>In our Ladies department we offer wide selection of the best products we have found and carefully selected worldwide.</p>
              </div>
              <div class="box info-bar">
                <div class="row">
                  <div class="col-md-12 col-lg-4 products-showing">Showing <strong>12</strong> of <strong>25</strong> products</div>
                  <div class="col-md-12 col-lg-7 products-number-sort">
                    <form class="form-inline d-block d-lg-flex justify-content-between flex-column flex-md-row">
                      <div class="products-number"><strong>Show</strong><a href="#" class="btn btn-sm btn-primary">12</a><a href="#" class="btn btn-outline-secondary btn-sm">24</a><a href="#" class="btn btn-outline-secondary btn-sm">All</a><span>products</span></div>
                      <div class="products-sort-by mt-2 mt-lg-0"><strong>Sort by</strong>
                        <select name="sort-by" class="form-control">
                          <option>Price</option>
                          <option>Name</option>
                          <option>Sales first</option>
                        </select>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="row products">
                <?php 
                  foreach ($dishes as $key => $value) {
                  // print_r($value['ID']);
                
                echo '
                <div class="col-lg-4 col-md-6">
                  <div class="product">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="../dish/?id='.$value['ID'].'"><img src="../public/img/'.$value['image'].'" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="../dish/?id='.$value['ID'].'"><img src="../public/img/'.$value['image'].'" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="../dish/?id='.$value['ID'].'"" class="invisible"><img src="../public/img/'.$value['image'].'" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3><a href="../dish/?id='.$value['ID'].'"">'.$value['title'].'</a></h3>
                      <p class="price"> 
                        $'.$value['price'].'
                      </p>
                      <p class="buttons"><a href="../dish/?id='.$value['ID'].'" class="btn btn-outline-secondary">View detail</a>';
                      if (count($this_id)!=0 && $this_id != 0){ $cart_url='../cart/?add='.$value['ID']; } 
                      echo'
                      <a href="'.$cart_url.'" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a></p>
                    </div>
                    <!-- /.text-->
                  </div>
                  <!-- /.product            -->
                </div>';
                } ?>
                <!-- /.products-->
              </div>
              <div class="pages">
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
              </div>
            </div>
            <!-- /.col-lg-9-->
          </div>
        </div>
      </div>
          </div>