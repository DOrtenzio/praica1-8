# Sistema di Gestione Database Bancario

Applicazione per la gestione di conti correnti e l'esecuzione di transazioni sicure tramite transazioni SQL.

---

## Struttura del Database (Schema ER)

Il database è composto da due tabelle principali collegate da una relazione uno-a-molti.

### 1. Tabella `Correntisti`
Memorizza i dati anagrafici dei clienti della banca.


| Campo | Tipo di Dati | Vincoli | Descrizione |
| :--- | :--- | :--- | :--- |
| **id_correntista** | INT | PK, Auto Increment | Identificativo univoco del cliente |
| **nome** | VARCHAR(50) | NOT NULL | Nome del correntista |
| **cognome** | VARCHAR(50) | NOT NULL | Cognome del correntista |
| **codice_fiscale** | CHAR(16) | NOT NULL, UNIQUE | Codice fiscale del cliente |

### 2. Tabella `ContiCorrente`
Memorizza i singoli conti correnti associati ai clienti.


| Campo | Tipo di Dati | Vincoli | Descrizione |
| :--- | :--- | :--- | :--- |
| **id_conto** | INT | PK, Auto Increment | Identificativo univoco del conto |
| **id_correntista** | INT | FK -> `Correntisti`, NOT NULL | Legame con il proprietario |
| **iban** | CHAR(27) | NOT NULL, UNIQUE | Codice IBAN del conto corrente |
| **saldo** | DECIMAL(15,2) | NOT NULL, DEFAULT 0.00 | Quantità di denaro disponibile |

---

## Funzionalità e Query SQL

### 1. Elenco Conti e Saldo Totale
Mostra tutti i conti di un cliente e calcola la somma complessiva dei suoi saldi.

```sql
-- Sostituire :id_correntista con l'ID del cliente cercato
SELECT 
    c.id_conto, 
    c.iban, 
    c.saldo,
    SUM(c.saldo) OVER() AS saldo_totale_complessivo
FROM ContiCorrente c
WHERE c.id_correntista = :id_correntista;
```

### 2. Apertura Nuovo Conto Corrente
L'apertura può avvenire per un cliente esistente o per un nuovo cliente.

#### Opzione A: Per un cliente già registrato
```sql
INSERT INTO ContiCorrente (id_correntista, iban, saldo) 
VALUES (:id_correntista, :nuovo_iban, :saldo_iniziale);
```

#### Opzione B: Per un nuovo cliente (Logica Transazionale)
```sql
START TRANSACTION;

INSERT INTO Correntisti (nome, cognome, codice_fiscale) 
VALUES (:nome, :cognome, :codice_fiscale);

-- Recupera l'ID appena generato e crea il conto
INSERT INTO ContiCorrente (id_correntista, iban, saldo) 
VALUES (LAST_INSERT_ID(), :nuovo_iban, :saldo_iniziale);

COMMIT;
```

### 3. Effettuazione Bonifico (Gestione ACID)
Per evitare perdite di dati in caso di crash, l'operazione usa una transazione SQL con controllo preventivo del saldo.

```sql
START TRANSACTION;

-- 1. Verifica disponibilità (da gestire anche a livello applicativo)
SELECT saldo FROM ContiCorrente 
WHERE id_conto = :id_mittente FOR UPDATE;

-- 2. Sottrazione cifra dal mittente (Se saldo >= cifra)
UPDATE ContiCorrente 
SET saldo = saldo - :cifra 
WHERE id_conto = :id_mittente AND saldo >= :cifra;

-- 3. Aggiunta cifra al destinatario
UPDATE ContiCorrente 
SET saldo = saldo + :cifra 
WHERE id_conto = :id_destinatario;

-- Conferma solo se tutte le operazioni riescono
COMMIT;
-- In caso di errore applicativo, eseguire: ROLLBACK;
```

### 4. Chiusura di un Conto Corrente
Il conto può essere chiuso solo se il saldo è pari a zero.

```sql
DELETE FROM ContiCorrente 
WHERE id_conto = :id_conto AND saldo = 0.00;
```
