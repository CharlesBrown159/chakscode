<?php

require_once '../uaincludes/auconfig_session.php';
?>

<div class="col-sm justify-content-center my-3">



    <div class="card text-center shadow p-2 mb-1 rounded" style="min-height: 400px; width: 280px; margin-left: auto; margin-right: auto;">
        <form action="food" method="GET" enctype="multipart/form-data">
            <?php
            $id = $rowimg['prod_id'];

            // Store the cipher method
            $ciphering = "AES-128-CTR";

            // Use OpenSSl Encryption method
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;

            // Non-NULL Initialization Vector for encryption
            $encryption_iv = '1234567891011121';

            // Store the encryption key
            $encryption_key = "chaks";

            // Use openssl_encrypt() function to encrypt the data
            $encryption = openssl_encrypt(
                $id,
                $ciphering,
                $encryption_key,
                $options,
                $encryption_iv
            );
            ?>
            <input type="hidden" name="id" value="<?php echo $encryption; ?>">
            <button class="btn" style="background-color: transparent;">
                <img src="../admin/assets/image/prodPhoto/<?php echo $rowimg['prod_image']; ?>" alt="image" height="230px;">
            </button>
        </form>
        <h1 class="prodname"><?php echo $rowimg['prod_name']; ?></h1>
        <h1 class="prodprice">₱<?php echo $rowimg['prod_price']; ?></h1>



        <form method="POST" action="../uaincludes/user_addcode" enctype="multipart/form-data">

            <input type="hidden" name="prodId" value="<?php echo ($rowimg['prod_id']) ?>">
            <input type="hidden" name="prodPrice" value="<?php echo ($rowimg['prod_price']) ?>">
            <input type="hidden" name="useruname" value="<?php echo ($_SESSION['use_username']) ?>">
            
            <button name="addtocartbtn" type="submit" class="btn btn-warning align-items-baseline" style="width: 100%;">ADD TO CART</button>
            

        </form>



    </div>


</div>