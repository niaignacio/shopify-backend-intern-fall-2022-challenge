<?php
     require 'config.php';

     $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
     if($mysqli->connect_errno){
          echo $mysqli->connect_error;
          exit();
     }

     $item_sql = "SELECT * FROM items WHERE item_id = ". $_GET['item_id'] .";";
     $item_result = $mysqli->query($item_sql);
     $item_row = $item_result->fetch_assoc();
     $categories_sql = "SELECT * FROM categories";
     $categories_results = $mysqli->query($categories_sql);
     $locations_sql = "SELECT * FROM locations";
     $locations_results = $mysqli->query($locations_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Update Item</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
     <a href="index.php"> Back to Home Page </a>
     <h1> Editing Item #<?php echo $_GET["item_id"]; ?> </h1>
          <form action="update.php" method="POST">
          <div class="inline">
               <label for="item-name"> Item Name: </label> <input type="text" name="item-name" id="item-name" value="<?php echo $item_row['item_name']; ?>" />
               <input class="hidden" type="text" id="item-id" value="<?php echo $_GET["item_id"]; ?>"/>
          </div>
          <br />
          <div class="inline"> <!-- Categories div -->
               <label for="categories"> Categories: </label>
               <div name="categories">
                    <?php while($category = $categories_results->fetch_assoc()) : ?>
                         <?php 
                              $item_categories = "SELECT * FROM items
                              JOIN category_has_item ON category_has_item.item_id = items.item_id
                              WHERE category_has_item.category_id = ". $category['category_id']." AND items.item_id = ". $_GET['item_id'].";";
                              $item_categories_results = $mysqli -> query($item_categories);
                              if($item_categories_results->num_rows > 0) :    
                         ?>
                              <input type="checkbox" id="category<?php echo $category['category_id']; ?>" checked/><label> <?php echo $category["category_name"]; ?> </label>
                         <?php else : ?>
                              <input type="checkbox" id="category<?php echo $category['category_id']; ?>"/><label> <?php echo $category["category_name"]; ?> </label>
                         <?php endif; ?>
                    <?php endwhile; ?>
               </div>
          </div>
          <br />
          <div class="inline"> <!-- Locations div -->
               <label for="locations"> Locations: </label>
               <div name="locations">
                    <?php while($location = $locations_results->fetch_assoc()) : ?>
                         <?php 
                              $item_locations = "SELECT items.item_id, items.item_name, location_has_item.location_id, location_has_item.qty FROM items
                              JOIN location_has_item ON location_has_item.item_id = items.item_id
                              WHERE location_has_item.location_id = ". $location['location_id']." AND items.item_id = ". $_GET['item_id'].";";
                              $item_locations_results = $mysqli -> query($item_locations);
                              $item_locations_row = $item_locations_results->fetch_assoc();
                         ?>
                              <div class="inline">
                                   <label> <?php echo $location["location_name"]; ?> </label>
                                   <label for="qty"> Qty: </label> <input type="text" id="qty<?php echo $location['location_id'];?>" value="<?php echo $item_locations_row['qty']; ?>" />
                              </div>
                    <?php endwhile; ?>
               </div>
          </div>
          <div class="inline">
               <button type="submit" class="btn btn-primary"> Update Item </button>
               <span class="text-danger" id="err-msg"></span>
          </div>
     </form>
     <script src="edit.js"></script>
</body>
</html>