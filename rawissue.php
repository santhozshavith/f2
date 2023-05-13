<?php
include "config.php";
// Check user login or not
if (!isset($_SESSION['uname'])) {
  header('Location: rawissue.php');
}
if(isset($_POST['save'])){
    // echo "data submited";
      $workname = $_POST['selectedName'];
      $unitname = $_POST['selectedunit'];
      $itemname = $_POST['selecteditem'];
      if ($_POST['selectedcolor']==null){
        $colorname ="";
        $colorid = "";
      }else{
        $colorname = $_POST['selectedcolor'];
        $colorid = $_POST['colorname'];
      }
     
      $workid = $_POST['workname'];
      $unitid = $_POST['unitname'];
      $itemid = $_POST['itemname'];
      $itemnam = $_POST['selecteditem'];
      


      $weight = $_POST['weight'];

     // echo($weight);
     // echo($workid);
      if($weight>0 and $workname!="" and $unitname!="" and $itemid!=""){
      $sql="INSERT INTO `work_progress`(`work_sess`, `work_prog`, `it_id`,`it_nam`, `work_id`, `work_nam`, 
      `opb`,`dept_id`, `dept`, `col_id`,`col_nam`, `cmp_id`) 
      VALUES ('1','1','$itemid','$itemnam','$workid','$workname','$weight','$unitid','$unitname','$colorid','$colorname','1')";

        if ($con->query($sql) === TRUE) {
            //echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $con->$error;
          

          $con->close();
         // header('Location: index.php');
          }
        }
}
if(isset($_POST['log-out'])){   
  session_destroy(); 
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style2.css">
    <title>AcPro Software</title>
</head>
<body>
  <script>
    $(document).ready(function() {
      document.getElementById('selectedName').value="";
      document.getElementById('selectedunit').value="";
      document.getElementById('selectedName').selectedIndex=-1;
      
});
  </script>
  <div class="container">
    <h2>Raw Material Issue</h2>
    
    <form action="" method="post">
      <div class="form-group">
        <label for="name">Name:</label>
          <select name="workname" id="workname" class="selectpicker" value="" data-show-subtext="true" data-live-search="true">
          <option value="" selected disabled>Select Worker</option>         
         <?php
          $sql = mysqli_query($con, "SELECT * FROM acct where ac_grp_nam='WORKER' order by ac_nam");
          while ($row = $sql->fetch_assoc()) {
            $ac_nam = $row['ac_nam'];
            echo "<option value='" . $row['id'] . "'>" . $row['ac_nam'] . " </option>";
          }
          ?>
          </select>
      </div>

      <div class="form-group">
        <label for="unit">Unit:</label>
        <select name="unitname" id="unitname" class="selectpicker" data-show-subtext="true" data-live-search="true">
        <option value="" selected disabled>Select Unit</option> 
          <?php
          $sql = mysqli_query($con, "SELECT * FROM cnf where cls='DEPT' order by nam");
          while ($row = $sql->fetch_assoc()) {
            //            echo "<option value=\"owner1\">" . $row['acgrp_name'] ."</option>";
            echo "<option value='" . $row['auto_id'] . "'>" . $row['nam'] . " </option>";
          }
          ?>
          </select>
      </div>

      <div class="form-group">
        <label for="item">Item:</label>
        <select name="itemname" id="itemname" class="selectpicker" data-show-subtext="true" data-live-search="true">
        <option value="" selected disabled>Select Raw Material</option> 
          <?php
          $sql = mysqli_query($con, "SELECT * FROM itm where itm_grp_id='SILK' or itm_grp_id='ZARI' order by itm_nam");
          while ($row = $sql->fetch_assoc()) {
            //            echo "<option value=\"owner1\">" . $row['acgrp_name'] ."</option>";
            echo "<option value='" . $row['id'] . "'>" . $row['itm_nam'] . " </option>";
          }
          ?>
          </select>
      </div>

      <div class="form-group">
        <label for="colour">Colour:</label>
        <select name="colorname" id="colorname" class="selectpicker" data-show-subtext="true" data-live-search="true">
        <option value="" selected disabled>Select Colour</option> 
          <?php
          $sql = mysqli_query($con, "SELECT * FROM col_name order by nam");
          while ($row = $sql->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nam'] . " </option>";
          }
          ?>
          </select>
      </div>

      <div class="form-group">
        <label for="weight">Weight:</label>
        <input type="number" id="weight" name="weight" >
      </div>

      <div class="form-group"><br>
        <input type="submit" name="save" value="Save">
        <br><br>
        <input type="submit" name="log-out" value="LogOut">
      </div>
      

      <input type="hidden" id="selectedName" name="selectedName">
      <input type="hidden" id="selectedunit" name="selectedunit">
      <input type="hidden" id="selecteditem" name="selecteditem">
      <input type="hidden" id="selectedcolor" name="selectedcolor">
    </form>
  </div>
  <script>
    // Get the necessary elements
    var selectElement = document.getElementById('workname');
    var hiddenInput = document.getElementById('selectedName');
    // Add an event listener to the select element
    selectElement.addEventListener('change', function() {
      // Get the selected option
      var selectedOption = selectElement.options[selectElement.selectedIndex];
      
      // Get the ID and Name of the selected option
      var selectedId = selectedOption.value;
      var selectedName = selectedOption.text;
      
      // Update the hidden input field with the selected name
      hiddenInput.value = selectedName;
    });

    // Get the necessary elements
    var selectUnit = document.getElementById('unitname');
    var hiddenUnit = document.getElementById('selectedUnit');
    // Add an event listener to the select element
    selectUnit.addEventListener('change', function() {
      var selectedunits = selectUnit.options[selectUnit.selectedIndex].text;
      //console.log(selectedunits);
      document.getElementById('selectedunit').value=selectedunits;
    });

    var selectItem = document.getElementById('itemname');
    var hiddenItem = document.getElementById('selecteditem');
    selectItem.addEventListener('change', function() {
      var selectedItems = selectItem.options[selectItem.selectedIndex].text;
      //console.log(selectedItems);
      document.getElementById('selecteditem').value=selectedItems;
    });

    var selectColor = document.getElementById('colorname');
    var hiddenColor = document.getElementById('selectedcolor');
    selectColor.addEventListener('change', function() {
      var selectedColors = selectColor.options[selectColor.selectedIndex].text;
      console.log(selectedColors);
      document.getElementById('selectedcolor').value=selectedColors;
    });
  </script>
  <script src="//code.jquery.com/jquery.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/</script>/js/bootstrap.min.js"></script>
</body>
</html>