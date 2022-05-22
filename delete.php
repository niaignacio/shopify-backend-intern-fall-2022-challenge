<?php
     require 'config.php';
     $err = false;
     $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
     if($mysqli->connect_errno){
          echo $mysqli->connect_error;
          exit();
     }
     var_dump($_GET);
     //delete item from items table
     $item_sql = $mysqli->prepare("DELETE FROM items WHERE item_id=?");
     $item_sql->bind_param("i", $_GET['item_id']);
     $item_exec = $item_sql->execute();
     if(!$item_exec){
          echo "Error deleting from items table.";
          $err = true;
     }
     //delete item from location_has_item table
     $location_sql = $mysqli->prepare("DELETE FROM location_has_item WHERE item_id=?");
     $location_sql->bind_param("i", $_GET['item_id']);
     $location_exec = $location_sql->execute();
     if(!$location_exec){
          echo "Error deleting from location_has_item table.";
          $err = true;
     }
     //delete item from category_has_item table
     $category_sql = $mysqli->prepare("DELETE FROM category_has_item WHERE item_id=?");
     $category_sql->bind_param("i", $_GET['item_id']);
     $category_exec = $category_sql->execute();
     if(!$category_exec){
          echo "Error deleting from category_has_item table.";
          $err = true;
     }
     //relocate back to home page
     if(!$err){
          $_SESSION['delete-success'] = "Successfully deleted.";
          header("Location: index.php"); //redirect back to home page
     }
?>