<?php
require_once("operazioni.php");
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banca</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 20px; color: #333; background-color: #f9f9f9; }
        .container { max-width: 500px; background: white; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: auto; }
        h1 { font-size: 1.5rem; margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .btn-save { background: #28a745; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; width: 100%; font-size: 1rem; }
        .btn-save:hover { background: #218838; }
        .back-link { display: inline-block; margin-bottom: 15px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

    <div class="container">
        <a href="../index.php" class="back-link">&larr; Torna alla lista</a>
        <h1>Effettua un Bonifico</h1>

        <form action="salva_bonifico.php" method="post">
            <div class="form-group">
                <label for="id_correntista_m">Correntista Mittente</label>
                <select id="id_correntista_m" name="id_correntista_m" required>
                    <?php
                        $obj = new Operazioni();
                        foreach($obj->query("correntisti") as $cc) {
                            echo "<option value='".$cc["id_correntista"]."'>".$cc["codice_fiscale"]."</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_correntista_d">Correntista Destinatario</label>
                <select id="id_correntista_d" name="id_correntista_d" required>
                    <?php
                        $obj = new Operazioni();
                        foreach($obj->query("correntisti") as $cc) {
                            echo "<option value='".$cc["id_correntista"]."'>".$cc["codice_fiscale"]."</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="q">Quantità</label>
                <input type="number" name="q" placeholder="100.0" required min="0">
            </div>
            <button type="submit" name="Salva" class="btn-save">Effettua</button>
        </form>
    </div>
</body>
</html>
