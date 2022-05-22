<?php
var_dump($_POST);
     include 'config.php';
     $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
     if($mysqli->connect_errno) {
          echo $mysqli->connect_error;
          exit();
     }     
     //error checking -- check that all required fields are there
     if( !isset($_POST['item_name']) || empty($_POST['item_name']) ||
          !isset($_POST['la_qty']) || empty($_POST['la_qty']) ||
          !isset($_POST['sf_qty']) || empty($_POST['sf_qty']) ||
          !isset($_POST['ny_qty']) || empty($_POST['ny_qty']) ||
          !isset($_POST['c1']) || empty($_POST['c1']) ||
          !isset($_POST['c2']) || empty($_POST['c2']) ||
          !isset($_POST['c3']) || empty($_POST['c3'])){ 
               echo "Error updating form.";
     } else {
          //update the items table
          $item_sql = $mysqli->prepare("INSERT INTO items (item_name) VALUES (?);");
          $item_sql->bind_param("s", $_POST['item_name']);
          $item_exec = $item_sql->execute();
          if(!$item_exec){
               echo "Error updating items table.";
          }
          //get the item id of the new item we just added
          $get_item_sql = "SELECT * FROM items WHERE item_name LIKE '". $_POST['item_name'] ."';";
          $get_item_results = $mysqli->query($get_item_sql);
          echo $get_item_results;
          $get_results = $get_item_results->fetch_assoc();
          $item_id = $get_results['item_id'];

          //update location_has_item table
          $la_sql = $mysqli->prepare("UPDATE location_has_item SET qty=? WHERE location_id = 1 AND item_id = ?");
          $la_sql->bind_param("ii", $_POST['la_qty'], $item_id);
          $la_exec = $la_sql->execute();
          if(!$la_exec){
               echo "Error updating LA.";
          }
          $sf_sql = $mysqli->prepare("UPDATE location_has_item SET qty=? WHERE location_id = 2 AND item_id = ?");
          $sf_sql->bind_param("ii", $_POST['sf_qty'], $item_id);
          $sf_exec = $sf_sql->execute();
          if(!$sf_exec){
               echo "Error updating SF.";
          }
          $ny_sql = $mysqli->prepare("UPDATE location_has_item SET qty=? WHERE location_id = 3 AND item_id = ?");
          $ny_sql->bind_param("ii", $_POST['ny_qty'], $item_id);
          $ny_exec = $ny_sql->execute();
          if(!$ny_exec){
               echo "Error updating NY.";
          }
          //update category_has_item table
          if($_POST['c1'] == true){ //if this category has this item, add it to the table if the record is not there already
               $card_sql = $mysqli->prepare("INSERT INTO category_has_item (category_id, item_id) VALUES (1, ?);");
               $card_sql->bind_param("i", $item_id);
               $card_exec = $card_sql->execute();
               if(!$card_exec){
                    echo "Error updating card category.";
               }
          }//end of category1: card making
          if($_POST['c2'] == true){ //if this category has this item, add it to the table if the record is not there already
               $sew_sql = $mysqli->prepare("INSERT INTO category_has_item (category_id, item_id) VALUES (2, ?);");
               $sew_sql->bind_param("i", $item_id);
               $sew_exec = $sew_sql->execute();
               if(!$sew_exec){
                    echo "Error updating sewing category.";
               }
          }//end of category2: sewing
          if($_POST['c3'] == true){ //if this category has this item, add it to the table if the record is not there already
               $paint_sql = $mysqli->prepare("INSERT IGNORE INTO category_has_item (category_id, item_id) VALUES (3, ?);");
               $paint_sql->bind_param("i", $item_id);
               $paint_exec = $paint_sql->execute();
               if(!$paint_exec){
                    echo "Error updating painting category.";
               }
          }//end of category3: painting
          if(!$err){
               $_SESSION['delete-success'] = "Successfully deleted.";
               header("Location: index.php"); //redirect back to home page
          }
     }
     
?>