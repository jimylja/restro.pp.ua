<div class="content">
	<?php if($this_id['role'] == 0){ echo 'Доступ обмежений!';}else{?>
		<h1 class="content__headline">Меню адміністратора</h1>
		<a href='/admin/orders' class="admin_button">Замовлення</a>
		<a href='/stock' class="admin_button" class="">Склад</a>
		<a href='/admin/dishes/add' class="admin_button" class="">Додати страву</a>

		<a href='/admin/statistic/dishes_stat' class="admin_button" class="">Cтатистика: Замовлення</a>
		<a href='/admin/statistic/profit_stat' class="admin_button" class="">статистика: Прибутки</a>
		
	<?php } ?>
</div>
