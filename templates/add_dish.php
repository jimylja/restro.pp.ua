<?php 

$all_kitchens=get_kitchens($db);
$all_categories=get_categories($db);
$all_products=$_SESSION['products_names_list'];
?>
<div>
  <form method="POST" action="" class="main_form">
    <h2 class="content__headline" style="color:#212121;">Добавити</h2>  
    <p>    
    <label  for="dish_name" class="form_label">Назва страви</label><br>
        <input name="dish_name" type="text" placeholder="Вкажіть назву" class="form_fields" required>
    </p>
    <p>
        <label for="dish_price" class="form_label">Вартість</label><br>
        <input name="dish_price" type="number" placeholder="Вкажіть ціну" class="form_fields" required><br>
  </p>
  <p> 
        <label for="cooking_time" class="form_label">Час приготування</label><br>
        <input name="cooking_time" type="number" placeholder="Час приготування" class="form_fields" required><br>
  </p>
  <p>
    <label for="dish_category">Категорія: </label>
    <select name="dish_category">
    <?php   foreach ($all_categories as $category => $property) { 
       echo '<option value="'.$property['id'].'">'.$property['name'].'</option>'; }
    ?>         
    </select>   
  </p>
  <p>  
  <label for="dish_kitchen">Кухня: </label>
    <select name="dish_kitchen">
    <?php   foreach ($all_kitchens as $kitchen => $property) { 
       echo '<option value="'.$property['id'].'">'.$property['name'].'</option>'; }
    ?>         
   </select>
  </p>
  <p>    
  <fieldset name="ingradients">
  <div id="add_product">Додати</div>
  <legend>Рецепт</legend>
   <label for="1_product">Продукт: </label>
   <select name="1_product">
    <?php   foreach ($all_products as $kitchen => $property) { 
       echo '<option value="'.$kitchen.'">'.$property.'</option>'; }?>         
   </select>
   <label for="1_product_quantity" class="form_label">Кількість</label><br>
   <input name="1_product_quantity" type="number" placeholder="Вкажіть кількість" class="form_fields" required><br>

  <select name="2_product">
    <?php   foreach ($all_products as $kitchen => $property) { 
       echo '<option value="'.$kitchen.'">'.$property.'</option>'; }?>         
   </select>
   <label for="2_product_quantity" class="form_label">Кількість</label><br>
   <input name="2_product_quantity" type="number" placeholder="Вкажіть кількість" class="form_fields" required><br>    
   
   </fieldset>
    </p>

   <input name="add_new_dish" type="submit" value="Добавити страву" class="login__button">
  </form>
</div>