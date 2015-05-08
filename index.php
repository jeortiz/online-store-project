<?php

require_once "includes/lib_project1.php";
require_once "/home/jo5120/db_conn.php";

include("includes/page_init.inc.php");

$totalItems = getCatalogSize($mysqli);
$pageSize = 5;
$totalPages = ceil($totalItems / $pageSize);

$queryPage = $_GET["catalogpage"];

if( isset( $_GET["catalogpage"] ) && ctype_digit($queryPage) && $queryPage <= $totalPages) {
    $currentPage = $_GET["catalogpage"];
}
else {
    $currentPage = 1;
}

if(isset( $_POST["add-product-to-cart"] )) {
    startSession();

    $productId = $_POST["product-id"];
    $userSessionId = session_id();

    addProductToCart($mysqli, $productId, $userSessionId);

}

$addToCartAction = strlen($_SERVER['QUERY_STRING']) ?
    basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'] : basename($_SERVER['PHP_SELF']);

$activeTab = 'Home';
$pageTitle = 'jGuitars - Home';
$bodyId = "home";

$template = "index";
include("includes/page_templates/page.tpl.php");
?>
