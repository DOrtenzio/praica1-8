<?php
require_once("funzioni/operazioni.php");
if(session_status()!==PHP_SESSION_ACTIVE) session_start();
if(!isset($_SESSION["filtro"])) $_SESSION["filtro"]=-1;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banca</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f4f4f4; }
        tr:hover { background-color: #f9f9f9; }
        .actions { display: flex; gap: 5px; }
        button, input[type="submit"] { cursor: pointer; padding: 5px 10px; }
        .btn-add { background: #28a745; color: white; border: none; padding: 10px 15px; text-decoration: none; border-radius: 4px; }
        .btn { background: #f4f4f4; color: black; border: none; padding: 10px 15px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>Gestione ContiCorrenti</h1>
    <p>Benvenuto/a</p>

    <div style="margin-bottom: 20px;">
        <a href="funzioni/inserimento.php" class="btn-add">+ Nuovo CC</a>
        <a href="funzioni/inserimento.php" class="btn-add">+ Bonifico</a>
    </div>

    <div style="margin-bottom: 20px;">
        <p>Scegli un Correntista:</p>
        <form action="funzioni/filtra.php" method="POST">
            <select name="filtro" id="filtro" onchange="this.form.submit()">
                <?php
                    $val="";
                    if($_SESSION["filtro"]==-1) $val="selected";
                    echo '<option value="-1" '.$val.'>----</option>';

                    try {
                        $obj = new Operazioni();
                        foreach($obj->query("correntisti") as $cc) {
                            $val="";
                            if($_SESSION["filtro"]==$cc["id_correntista"]) $val="selected";
                            echo "<option value='".$cc["id_correntista"]."'".$val.">".$cc["codice_fiscale"]."</option>";
                        }
                    } catch(Exception $e) {
                        echo "<option value='-1'>Errore nel caricamento dati.</option>";
                    }
                ?>
            </select>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>NUMERO CONTO</th>
                <th>COD_FISC CORRENTISTA</th>
                <th>SALDO</th>
                <th>AZIONI</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $obj = new Operazioni();

                if($_SESSION["filtro"]==-1) echo "<tr><td colspan='5' style='color:red;'>Seleziona Un correntista</td></tr>";
                else{
                    $correntista = $obj->query("correntisti",["id_correntista"=>$_SESSION["filtro"]])[0];
                    $saldo=0;
                    foreach($obj->query("conticorrenti",["id_correntista"=>$_SESSION["filtro"]]) as $cc) {
                        echo "<tr>";
                        echo "<td><strong>" .$cc["id_conto"]. "</strong></td>";
                        echo "<td>" .$correntista["nome"]. "</td>";
                        echo "<td>" .$cc["saldo"]. "</td>";
                        $saldo+=$cc["saldo"];
                        echo "<td class='actions'>
                                <form action='funzioni/delete.php' method='post' onsubmit='return confirm(\"Sei sicuro di voler eliminare questo conto?\");'>
                                    <input type='hidden' name='id' value='".$cc["id_conto"]."'>
                                    <input type='submit' value='Elimina' name='Elimina' style='color: #d9534f;'>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                }
            } catch(Exception $e) {
                echo "<tr><td colspan='5' style='color:red;'>Errore nel caricamento dati.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
