<?php
require_once("operazioni.php");

if(isset($_POST["id_correntista_d"]) && !empty($_POST["id_correntista_d"]) && isset($_POST["id_correntista_m"]) && !empty($_POST["id_correntista_m"]) && isset($_POST["q"]) && !empty($_POST["q"])){
    header("location:../index.php");
}else{
    header("location:../errorpage.html");
}