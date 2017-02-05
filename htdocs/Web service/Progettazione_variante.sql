SET FOREIGN_KEY_CHECKS=0;

-- elimino vecchie tabelle --

DROP TABLE IF EXISTS Utilizzo_Biglietto;
DROP TABLE IF EXISTS Protagonista;
DROP TABLE IF EXISTS News;
DROP TABLE IF EXISTS FAQ;
DROP TABLE IF EXISTS Entita;
DROP TABLE IF EXISTS Sezione;

DROP TABLE IF EXISTS Luogo;
CREATE TABLE Luogo (
	ID_Luogo INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	citta VARCHAR(50),
	paese VARCHAR(50)
);

DROP TABLE IF EXISTS Sede;
CREATE TABLE Sede (
	ID_Sede INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nome VARCHAR(50),
	ID_Luogo INT NOT NULL,
	FOREIGN KEY (ID_Luogo) REFERENCES Luogo (ID_Luogo)
);

DROP TABLE IF EXISTS Tipologia_Prenotazione;
CREATE TABLE Tipologia_Prenotazione (
	ID_Tipologia_Prenotazione INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nome VARCHAR(50),
	descrizione VARCHAR(500),
	note_varie VARCHAR(500),
	prezzo INT
);

DROP TABLE IF EXISTS Utente_Registrato;
CREATE TABLE Utente_Registrato (
	ID_Utente_Registrato INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nome VARCHAR(50),
	cognome VARCHAR(50),
	codice_fiscale VARCHAR(50),
	numero_telefono VARCHAR(50),
	data_nascita DATE,
	email VARCHAR(50),
	password VARCHAR(50)
);

DROP TABLE IF EXISTS Amministratore;
CREATE TABLE Amministratore (
	ID_Utente_Registrato INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	FOREIGN KEY (ID_Utente_Registrato) REFERENCES Utente_Registrato (ID_Utente_Registrato)
);

DROP TABLE IF EXISTS Prenotazione;
CREATE TABLE Prenotazione (
	ID_Prenotazione INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	data DATE,
	numero_posti INT,
	ID_Sede INT NOT NULL,
	ID_Tipologia_Prenotazione INT NOT NULL,
	ID_Utente_Registrato INT NOT NULL,
	FOREIGN KEY (ID_Sede) REFERENCES Sede (ID_Sede),
	FOREIGN KEY (ID_Tipologia_Prenotazione) REFERENCES Tipologia_Prenotazione (ID_Tipologia_Prenotazione),
	FOREIGN KEY (ID_Utente_Registrato) REFERENCES Utente_Registrato (ID_Utente_Registrato)
);

-- Popolamento località --
INSERT INTO Luogo(ID_luogo, Citta, Paese) VALUES(1, 'Padova', 'Italia');
Insert INTO Sede(ID_Sede, nome, ID_Luogo) VALUES(1, 'Palageox', 1);

-- popolamento tipi biglietti --

INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('INTERO', null, 'TARIFFE INDIVIDUALI', 20);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('RIDOTTO', '(da 100cm a 140 di altezza)', 'TARIFFE INDIVIDUALI', 16);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('SENIOR OVER 65', null, 'TARIFFE INDIVIDUALI', 16);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('INVALIDO', null, 'TARIFFE INDIVIDUALI', 16);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('ACCOMPAGNATORE DISABILE', null, 'TARIFFE INDIVIDUALI', 16);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('BIMBI', 'fino ad 1 metro', 'TARIFFE INDIVIDUALI', 0);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('DISABILE', 'non autosufficiente', 'TARIFFE INDIVIDUALI', 0);

INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('GRUPPI MISTI', null, 'TARIFFE GRUPPI', 15);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('GRUPPI OVER 65', null, 'TARIFFE GRUPPI', 12);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('GRUPPI SPORTIVI RAGAZZI', '(fino a 16 anni)', 'TARIFFE GRUPPI', 10);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('CENTRI ESTIVI', null, 'TARIFFE GRUPPI', 10);


INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('STUDENTI', null, 'SCOLARESCHE', 10);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('ACCOMPAGNATORI NON DOCENTI', null, 'SCOLARESCHE', 15);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('DOCENTI', null, 'SCOLARESCHE', 0);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('BAMBINI SOTTO IL METRO', null, 'SCOLARESCHE', 0);
INSERT INTO Tipologia_Prenotazione(nome, descrizione, note_varie, prezzo) VALUES('DIVERSAMENTE ABILI', null, 'SCOLARESCHE', 0);

-- UTENTI --
INSERT INTO Utente_Registrato (ID_Utente_Registrato, nome, cognome, codice_fiscale, numero_telefono, data_nascita, email, password) VALUES (1, 'Amministratore', 'Di Sistema', 'AMM', '000000', '1987-01-12', 'admin', '99ccf152e63f5c2aca927995fe46d2d318db51c68d07f8df92');
INSERT INTO Utente_Registrato (ID_Utente_Registrato, nome, cognome, codice_fiscale, numero_telefono, data_nascita, email, password) VALUES (2, 'Utente', 'Di Sistema', 'UTE', '000000', '1987-01-12', 'user', '2d9add75671947d61c30ea63c4433848d49829ef7354963d02');

-- SELEZIONO AMMINISTRATORI --
INSERT INTO Amministratore(ID_Utente_Registrato) VALUES(1);

SET FOREIGN_KEY_CHECKS=1;
