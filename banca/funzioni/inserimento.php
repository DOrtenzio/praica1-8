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
        <h1>Aggiungi Nuovo</h1>

        <form action="salva_inserimento.php" method="post">
            <div class="form-group">
                <label for="id_correntista">Assegna a Correntista</label>
                <select id="id_correntista" name="id_correntista" required onchange="toggleNuovoCorrentista()">
                    <option value="-1" selected>Nuovo</option>
                    <?php
                        $obj = new Operazioni();
                        foreach($obj->query("correntisti") as $cc) {
                            echo "<option value='".$cc["id_correntista"]."'>".$cc["codice_fiscale"]."</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-group" id="sezione_nuovo">
                <p>Inserire Nuovo Correntista</p>
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Maria Rossi">
                <label for="cod_fisc">Codice Fiscale</label>
                <input type="text" id="cod_fisc" name="cod_fisc" placeholder="RSSLCX80A01H501U">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="alice@email.com">
            </div>

            <div class="form-group">
                <label for="saldo">Saldo Iniziale</label>
                <input type="number" name="saldo" placeholder="0" required>
            </div>
            <button type="submit" name="Salva" class="btn-save">Aggiungi</button>
        </form>
    </div>

    <script>
        function toggleNuovoCorrentista() {
            const select = document.getElementById('id_correntista');
            const sezioneNuovo = document.getElementById('sezione_nuovo');
            const inputs = sezioneNuovo.querySelectorAll('input');

            if (select.value === "-1") {
                sezioneNuovo.style.display = "block";
                inputs.forEach(input => input.required = true);
            } else {
                sezioneNuovo.style.display = "none";
                inputs.forEach(input => {
                    input.required = false;
                    input.value = ""; 
                });
            }
        }
        document.addEventListener("DOMContentLoaded", toggleNuovoCorrentista);
    </script>
</body>
</html>
