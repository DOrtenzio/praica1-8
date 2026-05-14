<?php
require_once("operazioni.php");

if(isset($_POST["id"]) && !empty($_POST["id"])){
    $obj=new Operazioni();
    $obj->delete("conticorrenti",["id_conto"=>trim($_POST["id"])]);
    header("../location:index.php");
}else{
    header("location:../errorpage.html");
}