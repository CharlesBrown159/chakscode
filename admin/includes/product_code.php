<?php

if ($_SERVER["REQUEST_METHOD"] = "POST") {

    $pname = $_POST["pname"];
    $fileUpload = $_FILES["fileUpload"]["name"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $price = $_POST["price"];


    try {

        require_once 'dbcon.php';
        /////////////////// Model ////////////////

        function get_username(object $pdo, string $pname)
        {
            $query = "SELECT prod_name FROM product WHERE prod_name = :pname;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":pname", $pname);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        function set_product(object $pdo, string $pname, string $description, string $category, string $price)
        {

            $randomfilename = bin2hex(openssl_random_pseudo_bytes(16));
            $extension = explode("/", $_FILES['fileUpload']['type']);
            $name = $randomfilename . "." . $extension[1];

            // Set image placement folder
            $target_dir = "../assets/image/prodPhoto/";
            // Get file path
            $target_file = $target_dir . basename($name);
            // Get file extension
            

            if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO product (prod_name, prod_image, prod_desc, prod_category, prod_price) VALUES (:pname, :targetfile, :description, :category, :price)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":pname", $pname);
                $stmt->bindParam(":targetfile", $name);
                $stmt->bindParam(":description", $description);
                $stmt->bindParam(":category", $category);
                $stmt->bindParam(":price", $price);
                $stmt->execute();
            }
        }

        /////////////////// End Model ////////////////



        /////////////////// Control ////////////////

        function is_input_empty(string $pname, string $description, string $category, string $price, string $fileUpload)
        {
            if (empty($pname) || empty($description) || empty($category) || empty($price) || empty($fileUpload)) {
                return true;
            } else {
                return false;
            }
        }

        function is_productname_taken(object $pdo, string $pname)
        {
            if (get_username($pdo, $pname)) {
                return true;
            } else {
                return false;
            }
        }

        function is_imagefile_format()
        {

            // Set image placement folder
            $target_dir = "../assets/image/prodPhoto/";
            // Get file path
            $target_file = $target_dir . basename($_FILES["fileUpload"]['name']);
            // Get file extension
            $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Allowed file types
            $allowd_file_ext = array("jpg", "jpeg", "png");

            if (!in_array($imageExt, $allowd_file_ext)) {
                return true;
            } else {
                return false;
            }
        }

        function is_imagefile_size()
        {

            if ($_FILES["fileUpload"]["size"] > 2097152) {
                return true;
            } else {
                return false;
            }
        }

        function create_product(object $pdo, string $pname, string $description, string $category, string $price)
        {
            set_product($pdo, $pname, $description, $category, $price);
        }

        ///////////////////// END CONTROL ///////////



        //ERROR HANDLERS

        $errors = [];

        if (is_input_empty($pname, $description, $category, $price, $fileUpload)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        if (is_productname_taken($pdo, $pname)) {
            $errors["product_taken"] = "Productname is Already Exist!";
        }

        if (is_imagefile_format()) {
            $errors["file_format"] = "Allowed file formats .jpg, .jpeg and .png.";
        }

        if (is_imagefile_size()) {
            $errors["file_size"] = "File is too large. File size should be less than 2 megabytes.";
        }




        // require_once 'config_session.php';
        session_start();


        if ($errors) {
            $_SESSION["errors_product"] = $errors;

            $productData = [

                "pname" => $pname,
                "description" => $description,
                "category" => $category,
                "price" => $price

            ];
            $_SESSION["product_data"] = $productData;

            
            header("location: ../addproduct");
            die();
        }

        

        create_product($pdo, $pname, $description, $category, $price);

        header("location: ../addproduct?addproduct=success");
        unset($_SESSION['product_data']);
        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        die("Query failed:" . $e->getMessage());
    }
} else {
    header("location: ../addproduct");
    die();
}
