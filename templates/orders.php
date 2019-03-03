<article class="content">
                <h1 class="content__headline">Замовлення</h1>
                <?php if(empty($_COOKIE['id'])){?>
                <h2 class="alert__text">Для замовлення страв необхідно <a href="/login">увійти</a> або <a href="/register">зареєструватися!</a></h2>
                <?php } ?>        
                <div class="dishes">
                    <?php 
                        $orders=getOrders($db);
//                        print_r($orders);
                        $stock_summary=get_stock_summary($db);
						foreach ($orders as $order => $property) {
                            $dishes_array=get_dishes_array($property['order_list']);
                            $dishes_names='';
                            $dishes_names_list=$_SESSION['dishes_names_list'];
                            foreach ($dishes_array as $key => $value) {
                               $dishes_names.=$dishes_names_list[$key].'('.$value.'); '; 
                            }
                            $ingradients=get_order_ingradients($db, $dishes_array);
                            
                            $shortage=[];
                            foreach ($ingradients as $product => $order_quantity){
                                if ($order_quantity>$stock_summary[$product]['quantity']) {array_push($shortage, $stock_summary[$product]['title']);}
                            }
                            $status='';
                            if ($property['status'] == 1) {$status='accepted'; $order_status='<div class="order_message"><span>Підтверджено</span></div>';}
                            elseif(count($shortage)>0) { 
                                $status='error';
                                $order_status='<div class="order_message"><span>Нестача:</span>'.implode(",", $shortage).'</div>';                            }
                            else {
                                $order_status= '                 
                                 <form class="add_order" action="/admin/orders/add" method="POST">
                                   <input type="hidden" name="action" value="add">
                                   <input type="hidden" name="order_id" value='.$property['id'].'>
                                   <input type="hidden" name="ingradients" value='.htmlentities(serialize($ingradients)).'>
                                   <button order__accept type="submit">Підтвердити</button>
                                 </form>
                                 <a href="?delete='.$property['id'].'"><div class="order__decline">Відхилити</div></a>
                                 ';}
                           
                        ?>
                            <div class="order <?php echo $status ?>">
                            <h1 class="order__id">Замовлення: <?php echo($dishes_names);?></h1>
                            <h1 class="order__date">Дата: <?php echo($property['order_date']);?></h1>
                            <h1 class="order__price">Ціна: <?php echo($property['order_price']);?></h1>
                            <?php echo $order_status; ?> 
                            </div>
					<?php }
					?>
                </div>
            </article>