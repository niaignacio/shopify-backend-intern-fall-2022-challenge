<?php
     include 'config.php';
     $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
     if($mysqli->connect_errno) {
          echo $mysqli->connect_error;
          exit();
     }
     var_dump($_POST);
     //error checking -- check that all required fields are there
     if( !isset($_POST['item_id']) || empty($_POST['item_id']) ||
          !isset($_POST['item_name']) || empty($_POST['item_name']) ||
          !isset($_POST['la_qty']) || empty($_POST['la_qty']) ||
          !isset($_POST['sf_qty']) || empty($_POST['sf_qty']) ||
          !isset($_POST['ny_qty']) || empty($_POST['ny_qty']) ||
          !isset($_POST['c1']) || empty($_POST['c1']) ||
          !isset($_POST['c2']) || empty($_POST['c2']) ||
          !isset($_POST['c3']) || empty($_POST['c3'])){ 
               echo "Error updating form.";
     } else {
          //update the items table
          $item_sql = $mysqli->prepare("UPDATE items SET item_name = ? WHERE item_id = ?;");
          $item_sql->bind_param("si", $_POST['item_name'], $_POST['item_id']);
          $item_exec = $item_sql->execute();
          if(!$item_exec){
               echo "Error updating items table.";
          }
          //update location_has_item table
          $la_sql = $mysqli->prepare("UPDATE location_has_item SET qty=? WHERE location_id = 1 AND item_id = ?");
          $la_sql->bind_param("ii", $_POST['la_qty'], $_POST['item_id']);
          $la_exec = $la_sql->execute();
          if(!$la_exec){
               echo "Error updating LA.";
          }
          $sf_sql = $mysqli->prepare("UPDATE location_has_item SET qty=? WHERE location_id = 2 AND item_id = ?");
          $sf_sql->bind_param("ii", $_POST['sf_qty'], $_POST['item_id']);
          $sf_exec = $sf_sql->execute();
          if(!$sf_exec){
               echo "Error updating SF.";
          }
          $ny_sql = $mysqli->prepare("UPDATE location_has_item SET qty=? WHERE location_id = 3 AND item_id = ?");
          $ny_sql->bind_param("ii", $_POST['ny_qty'], $_POST['item_id']);
          $ny_exec = $ny_sql->execute();
          if(!$ny_exec){
               echo "Error updating NY.";
          }
          //update category_has_item table
          if($_POST['c1'] == true){ //if this category has this item, add it to the table if the record is not there already
               $card_sql = $mysqli->prepare("INSERT IGNORE INTO category_has_item (category_id, item_id) VALUES (1, ?);");
          } else { //otherwise, drop the record if it is there
               $card_buff = "SELECT * FROM category_has_item WHERE category_id = 1 AND item_id = ". $_POST['item_id'] .";"; //check if it is there first
               $card_buff_results = $mysqli->query($card_buff);
               if($card_buff_results->num_rows > 0) { 
                    $card_sql = $mysqli->prepare("DELETE FROM category_has_item WHERE category_id = 1 AND item_id = ?;");
               }
          }
          if( isset($card_sql) && !empty($card_sql)) {
               $card_sql->bind_param("i", $_POST['item_id']);
               $card_exec = $card_sql->execute();
               if(!$card_exec){
                    echo "Error updating card category.";
               }
          } //end of category1: card making
          if($_POST['c2'] == true){ //if this category has this item, add it to the table if the record is not there already
               $sew_sql = $mysqli->prepare("INSERT IGNORE INTO category_has_item (category_id, item_id) VALUES (2, ?);");
          } else { //otherwise, drop the record if it is there
               $sew_buff = "SELECT * FROM category_has_item WHERE category_id = 2 AND item_id = ". $_POST['item_id'] .";"; //check if it is there first
               $sew_buff_results = $mysqli->query($sew_buff);
               if($sew_buff_results->num_rows > 0) { 
                    $sew_sql = $mysqli->prepare("DELETE FROM category_has_item WHERE category_id = 2 AND item_id = ?;");
               }
          }
          if( isset($sew_sql) && !empty($sew_sql)) {
               $sew_sql->bind_param("i", $_POST['item_id']);
               $sew_exec = $sew_sql->execute();
               if(!$sew_exec){
                    echo "Error updating sewing category.";
               }
          } //end of category2: sewing
          if($_POST['c3'] == true){ //if this category has this item, add it to the table if the record is not there already
               $paint_sql = $mysqli->prepare("INSERT IGNORE INTO category_has_item (category_id, item_id) VALUES (3, ?);");
          } else { //otherwise, drop the record if it is there
               $paint_buff = "SELECT * FROM category_has_item WHERE category_id = 3 AND item_id = ". $_POST['item_id'] .";"; //check if it is there first
               $paint_buff_results = $mysqli->query($paint_buff);
               if($paint_buff_results->num_rows > 0) { 
                    $paint_sql = $mysqli->prepare("DELETE FROM category_has_item WHERE category_id = 3 AND item_id = ?;");
               }
          }
          if( isset($paint_sql) && !empty($paint_sql)) {
               $paint_sql->bind_param("i", $_POST['item_id']);
               $paint_exec = $paint_sql->execute();
               if(!$paint_exec){
                    echo "Error updating painting category.";
               }
          } //end of category3: painting
          echo "success";
     }
     
?>