CREATE TABLE Correntisti (
    id_correntista INT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    codice_fiscale CHAR(16) UNIQUE NOT NULL,
    email VARCHAR(100)
);

CREATE TABLE ContiCorrenti (
    id_conto INT PRIMARY KEY,
    id_correntista INT REFERENCES Correntisti(id_correntista),
    saldo DECIMAL(10, 2) NOT NULL
);

INSERT INTO Correntisti (id_correntista, nome, codice_fiscale, email) VALUES 
(1, 'Alice Rossi', 'RSSLCX80A01H501U', 'alice@email.com'),
(2, 'Bob Bianchi', 'BNCBBO90M15F205Z', 'bob@email.com');

INSERT INTO ContiCorrenti (id_conto, id_correntista, saldo) VALUES 
(101, 1, 1000.00), -- Conto di Alice
(102, 2, 500.00);  -- Conto di Bob