<?php
if(session_status()!==PHP_SESSION_ACTIVE) session_start();

if(isset($_POST["filtro"]) && !empty($_POST["filtro"])){
    $_SESSION["filtro"]=$_POST["filtro"];
    header("location:../index.php");
}else{
    header("location:../errorpage.html");
}