<?php 
$all_dishes=get_all_dishes($db);
?>
<h2>Statistic</h2>

<form name="filter" method="POST">
  <p>
    <label for="start_date">Від: </label>
    <input type="date" id="start_date" name="start_date"/>
   </p>
   <p>
    <label for="end_date">До: </label>
    <input type="date" id="end_date" name="end_date"/>
   </p>
   <p>
    <label for="dishes_filter">Страва: </label>
    <select name="dish_id">
    <option value="default">Усі страви</option>
    <?php  
    foreach ($all_dishes as $dish => $property) { 
       echo '<option value="'.$property['id'].'">'.$property['title'].'</option>'; }
    ?>         
   </select>
   	</p>
     <p>Групувати за:</p>  
    <p><input name="group_by" type="radio" value="date" checked> Датою</p>
    <p><input name="group_by" type="radio" value="day"> Днем тижня</p>
    <p><input name="group_by" type="radio" value="mounth"> Місяцем</p>
    <p> 
   	<label for="product_filter_form"></label>
   	<input type="submit" name="product_filter_form">	
	</p>
</form>


<?php
if ($products_stats['stat_data']!='none' && isset($products_stats)) { ?>
<div id="linechart_material" style="width: 900px; height: 500px"></div>
<script>
   var group_by='<?php echo $products_stats['group_by']; ?>';
   var mydata = JSON.parse('<?php echo $products_stats['stat_data']; ?>');
   console.log('mydata:'+mydata);
</script>
<?php }
else {echo '<span>Немає даних1</span>';}
