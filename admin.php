<?php
    require_once "/home/jo5120/db_conn.php";
    require_once "includes/lib_project1.php";

    include("includes/page_init.inc.php");

    $productToEdit = null;

    if( !isset($_COOKIE['jGuitarsSessionID']) || !isAdmin($mysqli) ) {
        header("Location: login.php");
    }


    if( isset( $_POST["submit-add-product"] ) || isset( $_POST["submit-edit-product"] ) ) {
        $errors = array();
        $name = cleanInput($_POST["product-name"]);
        $description = cleanInput($_POST["product-description"]);
        $price = cleanInput($_POST["product-price"]);
        $quantity = cleanInput($_POST["product-quantity"]);
        $image = cleanInput($_POST["product-image"]);
        $onSale = cleanInput($_POST["product-sale-price"]);

        if(empty($name)) {
            $errors[] = "Name cannot be empty.";
        }

        if(empty($description)) {
            $errors[] = "Description cannot be empty.";
        }

        if(empty($price) && $price != 0) {
            $errors[] = "Price cannot be empty.";
        }

        if(!is_numeric($price)) {
            $errors[] = "Price must be a number.";
        }

        if(empty($quantity)  && $quantity != 0) {
            $errors[] = "Quantity cannot be empty.";
        }

        if(!ctype_digit($quantity)) {
            $errors[] = "Quantity must be a integer number.";
        }

        if(empty($image)) {
            $errors[] = "Image cannot be empty.";
        }

        if(empty($onSale) && $onSale != 0) {
            $errors[] = "Sale price cannot be empty.";
        }

        if(!is_numeric($onSale)) {
            $errors[] = "Sale price must be a number.";
        }

        $productsOnSaleIds = getOnSaleProductsIds($mysqli);

        if(isset( $_POST["submit-add-product"] ) && count($errors) == 0) {

            if( ($onSale > 0 && count($productsOnSaleIds) < 5) || $onSale == 0)
                insertProduct($mysqli, $name, $description, $price, $quantity, $image, $onSale);
            else
                $errors[] = "Cannot have more than 5 products on sale.";
        }
        elseif(isset( $_POST["submit-edit-product"] ) && count($errors) == 0 ) {

            $id = $_POST["product-id"];
            $editedProduct = new Product($id, $name, $description, $price, $quantity, $image, $onSale);

            if($editedProduct->getOnSalePrice() == 0 && in_array($editedProduct->getId(), $productsOnSaleIds)
                    && ( (count($productsOnSaleIds) - 1) < 3) ) {
                $errors[] = "Cannot have less than 3 products on sale.";
            }
            elseif($editedProduct->getOnSalePrice() > 0 && !in_array($editedProduct->getId(), $productsOnSaleIds)
                && ( (count($productsOnSaleIds) + 1) > 5) ) {
                $errors[] = "Cannot have more than 5 products on sale.";
            }
            else {
                saveProduct($mysqli, $editedProduct);
            }
        }
    }
    elseif( isset( $_POST["edit-product"] ) ) {
        $productToEdit = getProduct($mysqli, $_POST["product-to-edit"] );
    }

    $catalog = getAllProducts($mysqli);

$activeTab = 'Admin';
$pageTitle = 'Admin Page';
$bodyId = "admin";
$extraHeader = "<link rel=stylesheet' href='content/product_form.css' />";

$template = "admin";
include("includes/page_templates/page.tpl.php");
?>
