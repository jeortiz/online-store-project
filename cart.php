<?php
require_once "includes/lib_project1.php";
require_once "/home/jo5120/db_conn.php";

include("includes/page_init.inc.php");

startSession();

if(isset( $_POST["empty_cart"] )) {
    emptyCart($mysqli, session_id());
}

$activeTab = 'Cart';
$pageTitle = 'Your Cart';
$bodyId = "cart";

$template = "cart";
include("includes/page_templates/page.tpl.php");

?>

