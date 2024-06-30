<?php
session_start();
$errors = [];
if (empty($_REQUEST["name"])) $errors["name"]= "name is required";
if (empty($_REQUEST["email"])) $errors["email"]= "email is required";
if (empty($_REQUEST["password"])) $errors["password"]= "password is required";
if (empty($_REQUEST["re-pw"])) $errors["re-pw"]= "re password is required";
elseif ($_REQUEST["password"] != $_REQUEST["re-pw"]) {
    $errors["re-pw"] = "re-password must be equal password";
}
$name =htmlspecialchars(trim($_REQUEST["name"]));
$email = filter_var( $_REQUEST["email"],FILTER_SANITIZE_EMAIL);
$password = htmlspecialchars( $_REQUEST["password"]);
$re_password = htmlspecialchars( $_REQUEST["re-pw"]);
$phone = htmlspecialchars( $_REQUEST["phone"]);


if (!empty($_REQUEST["email"])&& !filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) $errors ["email"] = " email invalid format";

if (empty($errors)) {
   require_once('classes.php');
   try {
    $rslt =  Subscriber::register($name,$email,md5($password),$phone);
    header("location:index.php?msg=sucsses");
   } catch (\Throwable $th) {

    header("location:register.php?msg=error alrady register");
    
   }
 
}
else {
    $_SESSION ["errors"]= $errors;
    header("location: register.php");
} 