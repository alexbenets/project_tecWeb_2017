SET FOREIGN_KEY_CHECKS=0;

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

DROP TABLE IF EXISTS Sezione;
CREATE TABLE Sezione (
	ID_Sezione INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nome VARCHAR(50),
	titolo VARCHAR(50),
	testo_presentazione VARCHAR(500),
	prezzo INT,
	ID_Sede INT NOT NULL,
	FOREIGN KEY (ID_Sede) REFERENCES Sede (ID_Sede)
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

DROP TABLE IF EXISTS Entita;
CREATE TABLE Entita (
	ID_Entita INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nome VARCHAR(50),
	nome_icona VARCHAR(10),
	nome_immagine VARCHAR(10),
	quantita INT,
	ID_Sede INT NOT NULL,
	FOREIGN KEY (ID_Sede) REFERENCES Sede (ID_Sede)
);

DROP TABLE IF EXISTS FAQ;
CREATE TABLE FAQ (
	ID_FAQ INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	data DATE,
	domanda VARCHAR(500),
	risposta VARCHAR(500),
	ID_Utente_Registrato INT NOT NULL,
	FOREIGN KEY (ID_Utente_Registrato) REFERENCES Amministratore (ID_Utente_Registrato)
);

DROP TABLE IF EXISTS News;
CREATE TABLE News (
	ID_News INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	data DATE,
	titolo VARCHAR(50),
	testo VARCHAR(500),
	ID_Utente_Registrato INT NOT NULL,
	FOREIGN KEY (ID_Utente_Registrato) REFERENCES Amministratore (ID_Utente_Registrato)
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

DROP TABLE IF EXISTS Protagonista;
CREATE TABLE Protagonista (
	ID_Sezione INT NOT NULL,
	ID_Entita INT NOT NULL,
 	PRIMARY KEY (ID_Sezione,ID_Entita),
 	FOREIGN KEY (ID_Sezione) REFERENCES Sezione (ID_Sezione),
 	FOREIGN KEY (ID_Entita) REFERENCES Entita (ID_Entita)
);

DROP TABLE IF EXISTS Utilizzo_Biglietto;
CREATE TABLE Utilizzo_Biglietto (
	ID_Utilizzo_Biglietto INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	data DATE,
	numero_posti INT,
	ID_Prenotazione INT NOT NULL,
	FOREIGN KEY (ID_Prenotazione) REFERENCES Prenotazione (ID_Prenotazione)
);


