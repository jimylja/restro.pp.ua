<div class="col-lg-9">
  <div class="row">
	<?php if($this_id['role'] == 0){ echo 'Доступ обмежений!';}else{?>
		<h1 class="content__headline">Меню адміністратора</h1>
		
		<div class="row products">
			<div class="col-lg-4 col-md-6">
					<div class="product">
						<div class="text" style="text-align: center;">
							<h3><a href="/admin/orders">Замовлення</a></h3>
							<p><a href="/admin/orders" class="btn btn-primary">Замовлення</a></p>
						</div>
					</div>
				</div>

		<div class="col-lg-4 col-md-6">
					<div class="product">
						<div class="text" style="text-align: center;">
							<h3><a href="/stock">Склад</a></h3>
							<p><a href="/stock" class="btn btn-primary">Склад</a></p>
						</div>
				</div>
		</div>		


		<div class="col-lg-4 col-md-6">
					<div class="product">
						<div class="text" style="text-align: center;">
							<h3><a href="/admin/dishes/add">Додати страву</a></h3>
							<p><a href="/admin/dishes/add" class="btn btn-primary">Додати страву</a></p>
						</div>
					</div>
		</div>

		<div class="col-lg-4 col-md-6">
		<div class="product">
			<div class="text" style="text-align: center;">
				<h3><a href="/admin/statistic/dishes_stat">Статистика: Замовлення</a></h3>
				<p><a href="/admin/statistic/dishes_stat" class="btn btn-primary">Замовлення</a></p>
			</div>
		</div>
	</div>		

			<div class="col-lg-4 col-md-6">
		<div class="product">
			<div class="text" style="text-align: center;">
				<h3><a href="/admin/statistic/profit_stat">Статистика: Прибутки</a></h3>
				<p><a href="/admin/statistic/profit_stat" class="btn btn-primary">Статистика: Прибутки</a></p>
			</div>
		</div>
	</div>	
	</div>
	</div>	
		<!-- <a href='/admin/orders' class="admin_button">Замовлення</a>
		<a href='/stock' class="admin_button" class="">Склад</a>
		<a href='/admin/dishes/add' class="admin_button" class="">Додати страву</a>

		<a href='/admin/statistic/dishes_stat' class="admin_button" class="">Cтатистика: Замовлення</a>
		<a href='/admin/statistic/profit_stat' class="admin_button" class="">статистика: Прибутки</a>
		 -->
	<?php } ?>
</div>
