<?php
require_once("operazioni.php");

try{
    if(isset($_POST["id_correntista"]) && !empty($_POST["id_correntista"]) && isset($_POST["saldo"]) && !empty($_POST["saldo"])){
        $id=$_POST["id_correntista"];
        if($id===-1){
            //aggiunta utente
            if(isset($_POST["nome"]) && !empty($_POST["nome"]) && isset($_POST["cod_fisc"]) && !empty($_POST["cod_fisc"]) & isset($_POST["email"]) && !empty($_POST["email"])) $id=$obj->insert("correntisti",["nome"=>$_POST["nome"],"codice_fiscale"=>$_POST["cod_fisc"],"email"=>$_POST["email"]]);
            else header("location:../errorpage.html");
        }
        $obj=new Operazioni();
        $obj->insert("conticorrenti",["id_correntista"=>$id,"saldo"=>$_POST["saldo"]]);
        header("location:../index.php");
    }else{
        header("location:../errorpage.html");
    }
}catch(Exception $e){
    header("location:../errorpage.html");
}