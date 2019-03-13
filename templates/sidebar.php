<!--
    *** MENUS AND FILTERS ***
  ________________________________________________________
 -->
        <div class="card sidebar-menu mb-4">
                <div class="card-header">
                  <h3 class="h4 card-title">Categories</h3>
                </div>
                <div class="card-body">
                  <ul class="nav nav-pills flex-column category-menu">
                    <?php
                    $categories_data=get_categories($db);
                    $curent_category_name='Усі страви';
                    foreach ($categories_data as $key => $value) {
                      $categories[$key]=$value;
                      if ($value['count']>0){
                        
                        if ($dish_info['category_id']==$value['id'] || $value['id']==$_GET['category'] ){
                         echo '<li><a href="../dishes/?category='.$value['id'].'" class="nav-link active">'.$value["name"].'<span class="badge badge-secondary">'.$value['count'].'</span></a></li>';
                         $curent_category_name=$value["name"];
                        } else {
                          echo '<li><a href="../dishes/?category='.$value['id'].'" class="nav-link">'.$value["name"].'<span class="badge badge-secondary">'.$value['count'].'</span></a></li>';
                        }
                       }
                      }?>
                  </ul>
                </div>
              </div>
              <div class="card sidebar-menu mb-4">
                <div class="card-header">
                  <h3 class="h4 card-title">Brands <a href="#" id="clearFilter" class="btn btn-sm btn-danger pull-right"><i class="fa fa-times-circle"></i> Clear</a></h3>
                </div>
                <div class="card-body">
                  <form>
                    <div class="form-group" id="kitchenFilter">
                    <?php
                    $kitchens_data=get_kitchens($db);
                    // $curent_category_name='Усі страви';
                    foreach ($kitchens_data as $key => $value) {
                      $kitchens[$key]=$value;
                      if ($value['count']>0){
                        echo '
                        <div class="checkbox">
                        <label>
                          <input type="checkbox" name="'.$value['id'].'">'.$value['name'].' ('.$value['count'].')
                        </label>
                        </div>  
                        ';
                      }}?>
                    </div>
                    <!-- <button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Apply</button> -->
                  </form>
                </div>
              </div>
              <!-- *** MENUS AND FILTERS END ***-->
              