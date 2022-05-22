<?php
     require 'config.php';

     $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
     if($mysqli->connect_errno){
          echo $mysqli->connect_error;
          exit();
     }
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
     <title>Create</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
     <a href="index.php"> Back to Home Page </a>
     <form action="" method="POST">
          <label for="item-name"> Item Name: </label> <input name="item-name" id="item-name">
          <br />
          <div class="inline" name="categories">
               <label for="categories"> Categories: </label>
               <?php while($category = $categories_results->fetch_assoc()) : ?>
                    <input type="checkbox" id="category<?php echo $category['category_id']; ?>"/><label> <?php echo $category["category_name"]; ?> </label>
               <?php endwhile; ?>
          </div>
          <div class="inline"> <!-- Locations div -->
               <label for="locations"> Locations: </label>
               <div name="locations">
                    <?php while($location = $locations_results->fetch_assoc()) : ?>
                              <div class="inline">
                                   <label> <?php echo $location["location_name"]; ?> </label>
                                   <label for="qty"> Qty: </label> <input type="text" id="qty<?php echo $location['location_id'];?>" value=0 />
                              </div>
                    <?php endwhile; ?>
               </div>
          </div>
          <div class="inline">
               <button type="submit" class="btn btn-primary"> Add to Inventory </button>
               <span class="text-danger" id="err-msg"></span>
          </div>
     </form>
     <script src="create.js"></script>
</body>
</html>