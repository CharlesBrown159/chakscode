<?php

require_once '../admin/includes/dbcon.php';

if (isset($_POST['add_quantity'])) {
    $cart_id = $_POST['add_cartId'];

    $sql = "SELECT * FROM `addtocart` WHERE cart_id = :cart_id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':cart_id', $cart_id);
    $query->execute();

    while ($row = $query->fetch()) {

        $quantity = $row['cart_Quantity'];
        $prodId = $row['cart_productId'];
    }

    $sqlprod = "SELECT * FROM `product` WHERE prod_id = :prodId";
    $queryProd = $pdo->prepare($sqlprod);
    $queryProd->bindParam(':prodId', $prodId);
    $queryProd->execute();

    while ($rowProd = $queryProd->fetch()) {

        $price = $rowProd['prod_price'];
    }

    $a = $quantity + 1;
    $b = $price;

    $tprice = $a * $b;

    $query_update = "UPDATE addtocart SET cart_Quantity='$a', cart_Price='$tprice' WHERE cart_id = $cart_id";
    if ($pdo->exec($query_update)) {

        $res = [
            'status' => 200,
            'message' => 'Student Updated Successfully'
        ];
        echo json_encode($res);
        return;
    } else {

        $res = [
            'status' => 500,
            'message' => 'Student Not Updated'
        ];
        echo json_encode($res);
        return;
    }

    $pdo = null;
    die();
}

/////////////// subtract ///////////////
if (isset($_POST['sub_quantity'])) {
    $cart_id = $_POST['sub_cartId'];

    
    $sql = "SELECT * FROM `addtocart` WHERE cart_id = :cart_id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':cart_id', $cart_id);
    $query->execute();

    while ($row = $query->fetch()) {

        $quantity = $row['cart_Quantity'];
        $prodId = $row['cart_productId'];
    }

    $sqlprod = "SELECT * FROM `product` WHERE prod_id = :prodId";
    $queryProd = $pdo->prepare($sqlprod);
    $queryProd->bindParam(':prodId', $prodId);
    $queryProd->execute();

    while ($rowProd = $queryProd->fetch()) {

        $price = $rowProd['prod_price'];
    }

    if ($quantity == 1) {
    } else {

        $a = $quantity - 1;
        $b = $price;

        $tprice = $a * $b;


        $query_update = "UPDATE addtocart SET cart_Quantity='$a', cart_Price='$tprice' WHERE cart_id = $cart_id";
        if ($pdo->exec($query_update)) {

            $res = [
                'status' => 200,
                'message' => 'Student Updated Successfully'
            ];
            echo json_encode($res);
            return;
        } else {

            $res = [
                'status' => 500,
                'message' => 'Student Not Updated'
            ];
            echo json_encode($res);
            return;
        }

        $pdo = null;
        die();
    }
}
///////////////////////////////


