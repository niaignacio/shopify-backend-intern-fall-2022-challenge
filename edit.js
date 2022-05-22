function ajaxPost(endpointUrl, postData, returnFunction){
     var xhr = new XMLHttpRequest();
     xhr.open('POST', endpointUrl, true);
     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     xhr.onreadystatechange = function(){
          if (xhr.readyState == XMLHttpRequest.DONE) {
               if (xhr.status == 200) {
                    returnFunction( xhr.responseText );
               } else {
                    alert('AJAX Error.');
                    console.log(xhr.status);
               }
          }
     }
     xhr.send(postData);
};
document.querySelector("form").onsubmit = function(event) {
     console.log("submitted?!?!?!");
     let err = false;
     let errorMessage = "";
     // prevent the form from actually submitting
     event.preventDefault();
     // Get the user's input
     let itemId = document.querySelector("#item-id").value.trim();
     let itemName = document.querySelector("#item-name").value.trim();
     let laQty = document.querySelector("#qty1").value.trim();
     let sfQty = document.querySelector("#qty2").value.trim();
     let nyQty = document.querySelector("#qty3").value.trim();
     let c1 = document.querySelector("#category1");
     let c2 = document.querySelector("#category2");
     let c3 = document.querySelector("#category3");
     //error checking
     if(itemName.length < 1 || laQty.length < 1 || sfQty.length < 1 || nyQty.length < 1){ //check if any fields are blank
          errorMessage += "Please complete all fields. "
          err = true;
     }
     if(!Number.isInteger(Number.parseInt(laQty)) || !Number.isInteger(Number.parseInt(sfQty)) || !Number.isInteger(Number.parseInt(nyQty)) ){
          errorMessage += "All quantities must be integers. ";
          err = true;
     }
     if(!Number.isInteger(Number.parseInt(laQty)) < 0 || !Number.isInteger(Number.parseInt(sfQty)) < 0 || !Number.isInteger(Number.parseInt(nyQty)) < 0 ){
          errorMessage += "Quantities cannot be negative. ";
          err = true;
     }
     if(!err) {
          // Call the ajax function, pass in the search term, and log out the results.
          
          errorMessage = "";
          let postData = `item_id=${itemId}&item_name=${itemName}&la_qty=${laQty}&sf_qty=${sfQty}&ny_qty=${nyQty}&c1=${c1.checked}&c2=${c2.checked}&c3=${c3.checked}`;
          console.log(postData);
          ajaxPost("update.php", postData, function(results) {
               console.log(results); // this function gets called when backend gives a response
          });
     }
     document.querySelector("#err-msg").innerHTML = errorMessage;
     
}