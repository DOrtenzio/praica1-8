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

INSERT INTO Correntisti (id_correntista, nome, codice_fiscale, email) VALUES 
(3, 'Marco Verdi', 'VRDMRC85A01F205H', 'marco.verdi@email.com'),
(4, 'Giulia Neri', 'NRUGLI92F42H501O', 'giulia.neri@email.com'),
(5, 'Luca Russo', 'RSSLCI78M10L219Y', 'luca.russo@email.com'),
(6, 'Anna Gialli', 'GLLNNA88S45F205W', 'anna.gialli@email.com'),
(7, 'Francesco Bruno', 'BRNFNC82R18G224Q', 'francesco.bruno@email.com'),
(8, 'Sara Gallo', 'GLLSRA95B51H501C', 'sara.gallo@email.com'),
(9, 'Alessandro Conti', 'CNTLSN90T20L219Z', 'alessandro.conti@email.com'),
(10, 'Elena Ferrari', 'FRRLNE84E48F205V', 'elena.ferrari@email.com'),
(11, 'Matteo Costa', 'CSTMTT93M12H501D', 'matteo.costa@email.com'),
(12, 'Chiara Fontana', 'FNTCHR87P55F205F', 'chiara.fontana@email.com'),
(13, 'Tommaso Rizzo', 'RZZTMS81T05L219V', 'tommaso.rizzo@email.com'),
(14, 'Sofia Moretti', 'MRTSFO96A41H501N', 'sofia.moretti@email.com'),
(15, 'Davide Marini', 'MRNDVD89C14F205U', 'davide.marini@email.com'),
(16, 'Valentina Barbieri', 'BRBVNT83L52G224K', 'valentina.barbieri@email.com'),
(17, 'Federico Lombardi', 'LMBFRC91E22H501M', 'federico.lombardi@email.com'),
(18, 'Beatrice Giordano', 'GRDBRC94H61F205Y', 'beatrice.giordano@email.com'),
(19, 'Riccardo Colombo', 'CLMRCR80P19L219P', 'riccardo.colombo@email.com'),
(20, 'Martina Martini', 'MRTMNT86S49H501O', 'martina.martini@email.com'),
(21, 'Andrea Leone', 'LNNDND97B08F205I', 'andrea.leone@email.com'),
(22, 'Francesca Longo', 'LNGFNC88T60G224S', 'francesca.longo@email.com'),
(23, 'Giorgio Galli', 'GLLGRG75E15L219B', 'giorgio.galli@email.com'),
(24, 'Elisa Marchetti', 'MRCHLS93A53H501T', 'elisa.marchetti@email.com'),
(25, 'Simone Mariani', 'MRNSMN90M28F205W', 'simone.mariani@email.com'),
(26, 'Alice Villa', 'VLLLCX85P44L219E', 'alice.villa@email.com'),
(27, 'Antonio Serra', 'SRRNTN82R02H501J', 'antonio.serra@email.com');

INSERT INTO ContiCorrenti (id_conto, id_correntista, saldo) VALUES 
(103, 3, 2500.50),
(104, 4, 150.00),
(105, 5, 5400.00),
(106, 6, 12500.85),
(107, 7, 0.00),
(108, 8, 850.20),
(109, 9, 3100.00),
(110, 10, 15450.00),
(111, 11, 420.15),
(112, 12, 2100.00),
(113, 13, 95.50),
(114, 14, 11200.00),
(115, 15, 340.00),
(116, 16, 6700.40),
(117, 17, 1850.00),
(118, 18, 4500.00),
(119, 19, 120.00),
(120, 20, 2890.30),
(121, 21, 730.00),
(122, 22, 19000.00),
(123, 23, 50.00),
(124, 24, 3200.10),
(125, 25, 1450.00),
(126, 26, 980.00),
(127, 27, 410.60);
