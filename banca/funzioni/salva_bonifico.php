<?php
require_once("operazioni.php");

try{
    if(isset($_POST["id_cm"]) && !empty($_POST["id_cm"]) && isset($_POST["id_cd"]) && !empty($_POST["id_cd"]) && isset($_POST["q"]) && !empty($_POST["q"])){
        $obj=new Operazioni();
        $obj->transaction([
            [
                "table"=>"",
                "type"=>"UPDATE",
                "data"=>[
                    'saldo' => 'saldo - '.$_POST["q"]
                ],
                'where' => [
                    'id_conto' => $_POST["id_cm"]
                ]
                ],
                [
                    "table"=>"",
                    "type"=>"UPDATE",
                    "data"=>[
                        'saldo' => 'saldo + '.$_POST["q"]
                    ],
                    'where' => [
                        'id_conto' => $_POST["id_cd"]
                    ]
                ]
        ]);
        header("location:../index.php");
    }else{
        header("location:../errorpage.html");
    }
}catch(Exception $e){
    header("location:../errorpage.html");
}