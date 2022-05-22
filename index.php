<?php
     require 'config.php';
     // $mysqli = new mysqli("127.0.0.1", "root", "root", "shopify_challenge");
     $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
     if($mysqli->connect_errno){
          echo $mysqli->connect_error;
          exit();
     }
     $mysqli->set_charset("utf8");
     $sql = "SELECT items.item_name, categories.category_name, locations.location_name, location_has_item.qty FROM items
	JOIN category_has_item ON items.item_id = category_has_item.item_id
    JOIN categories ON categories.category_id = category_has_item.category_id
    JOIN location_has_item ON items.item_id = location_has_item.item_id
    JOIN locations ON locations.location_id = location_has_item.location_id;";
     $results = $mysqli->query($sql);
     $items_sql = "SELECT * FROM items";
     $items_results = $mysqli->query($items_sql);
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
     <title>Shopify Challenge</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
     <?php if( isset($_SESSION['delete-success']) && !empty($_SESSION['delete-success'])) : ?>
          <div class="text-success"> <?php echo $_SESSION['delete-success']; ?> </div>
     <?php endif; ?>
     <h2> Nia Rae's Craft Supplies </h2>
     <a href="create.php"> <em> Add a new item to Inventory </em> </a>
     <form action="" method="">
          <input type="text" placeholder="Search..." />
          <button class="btn btn-primary" type="submit"> Go </button>
          <div class="row">
               <div class="col-3">
                    <div id="filters">
                         <h4> Filter By: </h4>
                    </div>
               </div>
               <div class="col">
                    <div id="warehouse-filter">
                         <h5> Warehouse </h5>
                         <?php while($category = $categories_results->fetch_assoc()) : ?>
                              <input type="checkbox" /><label> <?php echo $category["category_name"]; ?> </label>
                         <?php endwhile; ?>
                    </div>
                    <div id="location-filter">
                         <h5> Location </h5>
                         <?php while($location = $locations_results->fetch_assoc()) : ?>
                              <input type="checkbox" /><label> <?php echo $location["location_name"]; ?> </label>
                         <?php endwhile; ?>
                    </div>
               </div>
          </div>
     </form>

     <div class="container" id="view-items">
          
          <ul id="items-display">
               <?php while($row = $items_results->fetch_assoc()) : ?>
                    <li class="item container">
                         <div class="row">
                              <div class="inline">
                                   <h4> <?php echo $row["item_name"]; ?> </h4> <a href="edit.php?item_id=<?php echo $row["item_id"]; ?>"><em> Edit </em></a>
                                   <a href="delete.php?item_id=<?php echo $row['item_id']; ?>"><em> Delete </em></a>
                              </div>
                              <div class="col">
                                   <div class="inline">
                                        <h5> Category: </h5> 
                                        <?php 
                                             $item_categories = "SELECT category_name FROM categories
                                             JOIN category_has_item ON categories.category_id = category_has_item.category_id
                                            JOIN items ON items.item_id = category_has_item.item_id
                                            WHERE item_name = '". $row["item_name"] ."';";
                                             $item_categories_results = $mysqli->query($item_categories);
                                        ?> 
                                        <?php while($categories = $item_categories_results->fetch_assoc()) : ?>
                                             <span class="item-category"> <?php echo $categories["category_name"]; ?>, </span>
                                        <?php endwhile; ?>
                                   </div>

                                   <div class="inline">
                                        <h5> Locations Available: </h5>
                                        <?php 
                                             $item_locations = "SELECT location_name, qty FROM locations
                                             JOIN location_has_item ON locations.location_id = location_has_item.location_id
                                             JOIN items ON items.item_id = location_has_item.item_id
                                             WHERE item_name = '". $row["item_name"] ."';";
                                             $item_location_results = $mysqli->query($item_locations);
                                        ?> 
                                        <?php while($locations = $item_location_results->fetch_assoc()) : ?>
                                             <span class="item-location"> <?php echo $locations["location_name"]; ?> (<?php echo $locations["qty"];?>), </span>
                                        <?php endwhile; ?>
                                   </div>
                              </div>
                         </div>
                    </li>
               <?php endwhile; ?>
          </ul>
     </div>
</body>
</html>