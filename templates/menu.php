			<article class="content">
                <h1 class="content__headline">Редактор меню</h1>
                <div class="orders">
                    <?php 
						$menus=getMenu($db);
						foreach ($menus as $menu => $property) {
					?>
                        <div class="order">
                            <h1 class="order__id">ID: <?php echo($property['menu_id']);?></h1>
                            <h1 class="order__date">Дата: <?php echo($property['menu_date']);?></h1>
                            <h1 class="order__price">Страви: <?php echo($property['menu_list']);?></h1>
                            <a href="#"><div class="order__accept">Редагувати</div></a>
                        </div>
					<?php
						}
					?>
                </div>
            </article>