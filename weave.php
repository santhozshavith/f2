
<?php
  include "config.php";

  if (!isset($_SESSION['uname'])) {
    header('Location: weave.php');
  }

  if(isset($_POST['submit'])) {
    // echo "data submitted";
    $wevname = $_POST['selectedName'];
    $loomnam = $_POST['selectedunit'];
    $silk_nam = $_POST['selecteditem'];
    $col_nam = $_POST['selectedcolor'];
    $zari_nam = $_POST['selectedzari'];

    $wevid = $_POST['wevname'];
    $loomid = $_POST['loomnam'];
    $silk_id = $_POST['silk_nam'];
    $slk_colid = $_POST['col_nam'];
    
    $jari_id = $_POST['zari_nam'];

    $jari_qty = $_POST['jari_qty'];
    $jari_wght = $_POST['jari_wght'];
    
    $silk_qty= $_POST['silk_qty'];
    $silk_wght = $_POST['silk_wght'];


    $sql="INSERT INTO `wev_usage`(`txn_date`, `txn_typ`, `wev_id`, `wev_nam`, `work_id`, `work_nam`, `jari_qty`, 
    `jari_wght`, `jari_id`, `silk_id`, `silk_nam`, `silk_qty`, `silk_wght`, `slk_colid`, `slk_colnam`, 
    `work_start`, `work_progress`, `cmp_id`) VALUES (CURRENT_DATE(),'ISS','$loomid','$loomnam','$wevid',
    '$wevname', '$jari_qty','$jari_wght','$jari_id','$silk_id','$silk_nam','$silk_qty','$silk_wght','$slk_colid', 
    '$col_nam',current_time(),'1','1')";


    // $sql="INSERT INTO `wev_issue` (`wevid`, `wevname`, `loomid`, `loomnam`, `silk_id`, `silk_nam`, 
    // `col_id`, `col_nam`, `silk_wght`, `silk_qty`, `zari_id`, `zari_nam`, `zari_wght`, `zari_qty`, `issue`,
    // `dat`, `time`, `datetime`) VALUES ('$silk_id','$silk_nam','$col_id',
    // '$col_nam','$zari_id','$zari_nam','','','','',CURRENT_TIME(),NOW())";


    $result = $con->query($sql);
    if ($result === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $con->$error;
    }

    $con->close();
    header('Location: index.php');


        }

        if(isset($_POST['Log-out'])){   
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
  <link rel="stylesheet" href="style1.css">
  <title>AcPro Software</title>
</head>

<body>

  <div class="container">   
  <h2>Weave issuse</h2>  
    
  <form action="" method="post">

     <div class="form-group">
              
              <label for="name">Name:</label>
          <select name="wevname" id="wevname" class="selectpicker" value="" data-show-subtext="true" data-live-search="true">
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
              <label for="name">Loom:</label>

          <select name="loomnam" id="loomnam" class="selectpicker" value="" data-show-subtext="true" data-live-search="true">
          <option value="" selected disabled>Select loom</option>         
         <?php
          $sql = mysqli_query($con, "SELECT * FROM acct where ac_grp_nam='LOOMS' order by ac_nam");
          while ($row = $sql->fetch_assoc()) {
            $ac_nam = $row['ac_nam'];
            echo "<option value='" . $row['id'] . "'>" . $row['ac_nam'] . " </option>";
          }
          ?>
          </select>
        </div><br>

      <div class="form-row">
        
        <div class="form-group">
        <label for="input-name">Silk:</label>
        <select name="silk_nam" id="silk_nam" class="selectpicker" data-show-subtext="true" data-live-search="true">
        <option value="" selected disabled>Select Silk</option> 
          <?php
          $sql = mysqli_query($con, "SELECT * FROM itm where itm_grp_id='SILK'  order by itm_nam");
          while ($row = $sql->fetch_assoc()) {
            //            echo "<option value=\"owner1\">" . $row['acgrp_name'] ."</option>";
            echo "<option value='" . $row['id'] . "'>" . $row['itm_nam'] . " </option>";
          }
          ?>
          </select>
      </div>

      <div class="form-group">
      <label for="colour">Colour:</label>
        <select name="col_nam" id="col_nam" class="selectpicker" data-show-subtext="true" data-live-search="true">
        <option value="" selected disabled>Select Colour</option> 
          <?php
          $sql = mysqli_query($con, "SELECT * FROM col_name order by nam");
          while ($row = $sql->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nam'] . " </option>";
          }
          ?>
          </select>
        </div>

       
          
      </div>

      <div class="form-row">

        <div class="form-group">
        <label for="input-name">Weight:</label>
          <input type="Number" id="silk_wght" name="silk_wght" >
        </div>

        <div class="form-group">
          <label for="input-name">Qty:</label>
          <input type="Number" id="silk_qty" name="silk_qty">
        </div><br>

        

            
      </div><br>
      <div class="line-container"></div>
      <style>

        .line-container {
  width: 100%;
  text-align: center;
}

.line-container::before {
  content: "";
  display: inline-block;
  width: 100%;
  height: 1px;
  background-color: #e7c500;
}

        </style><br>
      <div class="form-row">

        <div class="form-group">
          <label for="input-name">Zari:</label>
          <select name="zari_nam" id="zari_nam" class="selectpicker" data-show-subtext="true" data-live-search="true">
        <option value="" selected disabled>Select Zari</option> 
          <?php
          $sql = mysqli_query($con, "SELECT * FROM itm where itm_grp_id='ZARI'  order by itm_nam");
          while ($row = $sql->fetch_assoc()) {
            //            echo "<option value=\"owner1\">" . $row['acgrp_name'] ."</option>";
            echo "<option value='" . $row['id'] . "'>" . $row['itm_nam'] . " </option>";
          }
          ?>
          </select>
        </div>

        <div class="form-group">
          <label for="input-name">Weight:</label>
          <input type="Number" id="jari_wght" name="jari_wght">
        </div>

        <div class="form-group">
          <label for="input-name">Qty:</label>
          <input type="Number" id="jari_qty" name="jari_qty" >
        </div>
            
      </div>

                            <br>

      <div class="form-group">
        <input type="submit" name="submit" id="submit" value="Submit" ><br><br>
        <input type="submit" name="Log-out" id="Log-out" value="Log-out" >
      </div>

    
      <input type="hidden" id="selectedName" name="selectedName">
      <input type="hidden" id="selectedunit" name="selectedunit">
      <input type="hidden" id="selecteditem" name="selecteditem">
      <input type="hidden" id="selectedcolor" name="selectedcolor">
      <input type="hidden" id="selectedzari" name="selectedzari">

      </div>
  </form>
    
  <script>
    // Get the necessary elements
    var selectElement = document.getElementById('wevname');
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
    var selectUnit = document.getElementById('loomnam');
    var hiddenUnit = document.getElementById('selectedUnit');
    // Add an event listener to the select element
    selectUnit.addEventListener('change', function() {
      var selectedunits = selectUnit.options[selectUnit.selectedIndex].text;
      //console.log(selectedunits);
      document.getElementById('selectedunit').value=selectedunits;
    });

    var selectItem = document.getElementById('silk_nam');
    var hiddenItem = document.getElementById('selecteditem');
    selectItem.addEventListener('change', function() {
      var selectedItems = selectItem.options[selectItem.selectedIndex].text;
      //console.log(selectedItems);
      document.getElementById('selecteditem').value=selectedItems;
    });

    var selectColor = document.getElementById('col_nam');
    var hiddenColor = document.getElementById('selectedcolor');
    selectColor.addEventListener('change', function() {
      var selectedColors = selectColor.options[selectColor.selectedIndex].text;
      console.log(selectedColors);
      document.getElementById('selectedcolor').value=selectedColors;
    });

    var selectzari = document.getElementById('zari_nam');
    var hiddenzari= document.getElementById('selectedzari');
    selectzari.addEventListener('change', function() {
      var selectedzari= selectzari.options[selectzari.selectedIndex].text;
      console.log(selectedzari);
      document.getElementById('selectedzari').value=selectedzari;
    });
  </script>

</body>

