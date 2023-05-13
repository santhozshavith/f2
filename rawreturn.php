<?php
include "config.php";

if (!isset($_SESSION['uname'])) {
  header('Location: rawreturn.php');
}

if (isset($_POST['save'])) {
  // echo "data submited";
  $id = $_POST['workname'];
  $clb = $_POST['totalweight'];
  // $finish_date = $_POST['finish_date'];
  $finish_qty = $_POST['bobin_qty'];
  $finish_wght = $_POST['returnweight'];

  
  date_default_timezone_set("Asia/Kolkata"); // set the timezone
  $finish_date= date("Y-m-d H:i:s");
  

  $sql = "UPDATE `work_progress` SET  `work_prog`=0, `work_end`=1, `clb`='$clb', `finish_date`='$finish_date',`finish_qty`=' $finish_qty', 
  `finish_wght`='$finish_wght' WHERE id='$id'";

  if ($con->query($sql) === TRUE) {
    // echo "Update record successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $con->$error;


    $con->close();
    header('Location: index.php');
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
  <link rel="stylesheet" href="style.css">
  <title>AcPro Software</title>
</head>

<body>

  <div class="container">
    <h2>Worker Return Details</h2>

    <form action="" method="post">
      <div class="form-group">
        <label for="name">Name:</label>
        <select name="workname" id="workname" onchange="funfetch()"  class="selectpicker" value=""
          data-show-subtext="true" data-live-search="true">
          <option value="" selected disabled>Select Worker</option>
          <?php
          $sql = mysqli_query($con, "SELECT * FROM work_progress where work_prog=1 and work_end=0  order by work_nam");
          while ($row = $sql->fetch_assoc()) {
            // $id = $row['id'];
            echo "<option value='" . $row['id'] . "'>" . $row['work_nam'] . " </option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="unit">Unit:</label>
        <input type="text" id="unit" name="unit" >
      </div>

      <div class="form-group">
        <label for="item">Item Name :</label>
        <input type="text" id="itemname" name="itemname" >
      </div>
      <div class="form-group">
        <label for="item">Item opening :</label>
        <input type="text" id="itemopb" name="itemopb" >
      </div>

      <div class="form-group">
        <label for="bobin">Return Bobin qty:</label>
        <input type="number" id="bobin_qty" name="bobin_qty" >
      </div>

      <div class="form-group">
        <label for="bobin">Return weight:</label>
        <input type="number" id="returnweight" name="returnweight" >
      </div>

      <div class="form-group">
        <label for="bobin">Total bobin usage weight:</label>
        <input type="text" id="totalweight" name="totalweight" >
      </div>

      <!-- <div class="form-group">
        <input type="submit" name="save" id="submit" value="Submit" onclick="setSubmitTime()">
        <input type="submit" name="log-out" id="log-out" value="log-out" >
      </div> -->

      <div class="form-group"><br>
        <input type="submit" name="save" value="Save">
        <br><br>
        <input type="submit" name="log-out" value="Log Out">
      </div>



  
</form>


      
      <input type="hidden" id="selectedid" name="selecteid">
      <!-- <input type="hidden" id="selectedunit" name="selectedunit">
      <input type="hidden" id="selecteditem" name="selecteditem">
      <input type="hidden" id="selectedcolor" name="selectedcolor"> -->
    </form>
  </div>


  


  <script>
    // Get references to the input and output fields
    const itemopbField = document.getElementById('itemopb');
    const returnWeightField = document.getElementById('returnweight');
    const resultField = document.getElementById('totalweight');
  
    // Add event listeners to the input fields to listen for changes
    itemopbField.addEventListener('input', updateResult);
    returnWeightField.addEventListener('input', updateResult);
  
    // Function to update the result field
    function updateResult() {
      const itemopb = parseFloat(itemopbField.value);
      const returnWeight = parseFloat(returnWeightField.value);
      const totalweight = itemopb - returnWeight;
      resultField.value = totalweight;
    }
  </script>


<script>
function funfetch() {
  var id = document.getElementById("workname").value;
  console.log("con7");

  $.ajax({
    url: 'fetch.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      var myData = work.work_nam;
      console.log(myData);
      document.getElementById("unit").value = work.dept;
      document.getElementById("itemname").value = work.it_nam;
      document.getElementById("itemopb").value = work.opb;
    }
  });
}
</script>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>  -->

</body>

</html>