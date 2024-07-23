<?php 
session_name('user');
// ADD TO CART xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
if (isset($_POST['addtocartbtn'])) {

    $bookpid= mysqli_real_escape_string($dbcon,$_POST['bookpid']);
    $useruname= mysqli_real_escape_string($dbcon,$_POST['useruname']);
    $bookprice= mysqli_real_escape_string($dbcon,$_POST['bookprice']);
    $dateCreated = date('Y-m-d H:i:s');
  
  
      $check_duplicate_book = "SELECT * FROM `addtocart` WHERE cart_bpid = '$bookpid' AND cart_username = '$useruname' AND  cart_purchaseid='0'";
      $check_result = mysqli_query($dbcon, $check_duplicate_book);
      $count = mysqli_num_rows($check_result);
      if ($count > 0) {
            echo "<script>alert('This Book Title is Already On Your Cart. Please Check!')</script>";
            ?>
            <meta http-equiv="refresh" content="0;URL='cart'" /> 
            <?php
            return false;
      }
      else
      {
         
          $sql="INSERT INTO `addtocart`(cart_bpid,cart_username,cart_totalquantity,cart_totalPrice,cart_dateAddedtocart) values ('$bookpid','$useruname','1','$bookprice','$dateCreated')";
          $result=mysqli_query($dbcon,$sql);
  
            if ($result) {
  
              ?>
              <meta http-equiv="refresh" content="0;URL='cart'" /> 
              <?php
  
            }else{
              echo "<script>alert('Something went wrong. Please try again!')</script>";
              ?>
              <meta http-equiv="refresh" content="0;URL='profile'" /> 
              <?php
            }   
        
         
      }
  }
  // END OF ADD TO CART xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
  

?>