Gestione di un database di una banca
Scenario
Immagina di dover gestire un semplice database di una banca (struttura DB allegata), che prevede più conti corrente per ogni correntista.
L'operazione più comune è il bonifico tra conti correnti.
Questa operazione è composta da tre passaggi fondamentali:
Verifica della disponibilità sul conto del mittente.
Sottrazione della cifra dal conto del mittente.
Aggiunta della stessa cifra al conto del destinatario.
Se il sistema dovesse crashare prima di avere completato le tre operazioni, il bonifico potrebbe non essere effettuato correttamente con conseguente perdita di denaro.
Crea un’applicazione che implementi le seguenti funzionalità:
Elenco di tutti i conti corrente di un correntista con relativo saldo e totale complessivo dei saldi dei conti correnti appartenenti al correntista selezionato.
Apertura di un nuovo conto corrente associato ad un nuovo correntista o a un correntista esistente;
Effettuazione di un bonifico tra due correntisti;
Chiusura di un conto corrente;
