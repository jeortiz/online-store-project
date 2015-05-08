<?php
require_once "/home/jo5120/db_conn.php";
require_once "includes/lib_project1.php";

include("includes/page_init.inc.php");

if(isset($_COOKIE['jGuitarsSessionID']) && isAdmin($mysqli) ) {
    header("Location: admin.php");
}
elseif( isset( $_POST["submit-login"] ) ) {
    $userName = cleanInput($_POST["user-name"]);
    $password = cleanInput($_POST["user-password"]);
    $errors = array();
    $error = false;

    if(isset($_POST['g-recaptcha-response'])){
        $captcha = $_POST['g-recaptcha-response'];
        $captchaResponse = validateCaptcha($captcha);

        if( $captchaResponse == false ) {
            $error = true;
        }
    }

    if( !validateAdminPassword($mysqli, $password) ){
        $error = true;
    }

    if(!$error) {
        header("Location: admin.php");
    }
    else {
        $errors[] = "Check password or captcha";
    }

}
$activeTab = '';
$pageTitle = 'Login Page';
$bodyId = "login";

$template = "login";
include("includes/page_templates/page.tpl.php");

?>