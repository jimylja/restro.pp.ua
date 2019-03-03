<?php 
	$stocks = getStock($db);
	$now = time();
	$error = '';
	foreach ($stocks as $stock => $property){
		$your_date = strtotime($property['pull_date']); // какая-то дата в строке (1 января 2017 года)

		$datediff = $now - $your_date; // получим разность дат (в секундах)
		$days=floor($datediff / (60 * 60 * 24)); // вычислим количество дней из разности дат
		$left=$property['edibility'] - $days;
		$error= ($left<6)?'red':'';
		echo ";";?>
		<div class="order">
            <h1 class="order__id">ID: <?php echo($property['st_id']);?></h1>
			<h1 class="order__price"><?php echo($property['title']);?></h1>
            <h1 class="<?php echo $error;?>"><?php if ($left <= 0){echo('Просрочено!');}else{echo("Придатність: ".$left." днів");}?></h1>    
			<h1 class="">Залишок: <?php echo $property['quantity']/1000;?> кг.</h1>    
        </div>
	<?php } ?>