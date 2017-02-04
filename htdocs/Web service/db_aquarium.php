<?php





class Utente_registrato {
    //attributi classe
    private $id_utente_registrato;
    private $nome;
    private $cognome;
    private $codice_fiscale;
    private $data_nascita;
    private $numero_telefono;
    private $email;
    private $password;

    /**
     * Utente_registrato constructor.
     * @param $id_utente_registrato
     * @param $nome
     * @param $cognome
     * @param $codice_fiscale
     * @param $data_nascita
     * @param $numero_telefono
     * @param $email
     * @param $password
     */
    public function __construct($id_utente_registrato, $nome, $cognome, $codice_fiscale, $data_nascita, $numero_telefono, $email, $password)
    {
        $this->id_utente_registrato = $id_utente_registrato;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->codice_fiscale = $codice_fiscale;
        $this->data_nascita = $data_nascita;
        $this->numero_telefono = $numero_telefono;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getIdUtenteRegistrato()
    {
        return $this->id_utente_registrato;
    }

    /**
     * @param mixed $id_utente_registrato
     */
    public function setIdUtenteRegistrato($id_utente_registrato)
    {
        $this->id_utente_registrato = $id_utente_registrato;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @param mixed $cognome
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
    }

    /**
     * @return mixed
     */
    public function getCodiceFiscale()
    {
        return $this->codice_fiscale;
    }

    /**
     * @param mixed $codice_fiscale
     */
    public function setCodiceFiscale($codice_fiscale)
    {
        $this->codice_fiscale = $codice_fiscale;
    }

    /**
     * @return mixed
     */
    public function getDataNascita()
    {
        return $this->data_nascita;
    }

    /**
     * @param mixed $data_nascita
     */
    public function setDataNascita($data_nascita)
    {
        $this->data_nascita = $data_nascita;
    }

    /**
     * @return mixed
     */
    public function getNumeroTelefono()
    {
        return $this->numero_telefono;
    }

    /**
     * @param mixed $numero_telefono
     */
    public function setNumeroTelefono($numero_telefono)
    {
        $this->numero_telefono = $numero_telefono;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }



    /**
     * Funzione che esegue la registrazione di un utente nel DB
     * @param   $nome $cognome $codice_fiscale $data_nascita $numero_telefono $email $password
     * @return  array resQuery
     */
    public function addRecordInDB($nome, $cognome, $codice_fiscale, $data_nascita, $numero_telefono, $email, $password){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $nome = DB_Functions::esc($nome);
        $cognome = DB_Functions::esc($cognome);
        $codice_fiscale = DB_Functions::esc($codice_fiscale);
        $numero_telefono = DB_Functions::esc($numero_telefono);
        $data_nascita = DB_Functions::esc($data_nascita);
        $email = DB_Functions::esc($email);
        $password = DB_Functions::esc($password);

        $query = "INSERT INTO UTENTE_REGISTRATO (ID_UTENTE_REGISTRATO, NOME, COGNOME, CODICE_FISCALE, NUMERO_TELEFONO, DATA_NASCITA, EMAIL, PASSWORD) 
	              VALUES ($nome , $cognome, $codice_fiscale, $numero_telefono, $data_nascita, $email, SHA1($password)";
        $resQuery1 = $db->executeQuery($query);
        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_UTENTE_REGISTRATO) FROM UTENTE_REGISTRATO;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_utente_registrato = $resQuery2["response"][0][0];
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->codice_fiscale = $codice_fiscale;
            $this->data_nascita = $data_nascita;
            $this->numero_telefono = $numero_telefono;
            $this->email = $email;
            $this->password = $password;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di un utente registrato
     * @param   $nome $cognome $codice_fiscale $data_nascita $numero_telefono $email $password
     * @return  array resQuery
     */
    public function setRecordInDB($id_utente_registrato, $nome, $cognome, $codice_fiscale, $data_nascita, $numero_telefono, $email, $password){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $nome = DB_Functions::esc($nome);
        $cognome = DB_Functions::esc($cognome);
        $codice_fiscale = DB_Functions::esc($codice_fiscale);
        $numero_telefono = DB_Functions::esc($numero_telefono);
        $data_nascita = DB_Functions::esc($data_nascita);
        $email = DB_Functions::esc($email);
        $password = DB_Functions::esc($password);

        $query = "UPDATE UTENTE_REGISTRATO 
                  SET 	NOME                  =   $nome,
                        COGNOME               =   $cognome,
                        CODICE_FISCALE        =   $codice_fiscale,
                        NUMERO_TELEFONO       =   $numero_telefono,
                        DATA_NASCITA          =   $data_nascita,
                        EMAIL                 =   $email,
                        PASSWORD              =   SHA1($password)
                  WHERE 	
                        ID_UTENTE_REGISTRATO  =   $id_utente_registrato;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->codice_fiscale = $codice_fiscale;
            $this->data_nascita = $data_nascita;
            $this->numero_telefono = $numero_telefono;
            $this->email = $email;
            $this->password = $password;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di un utente registrato
     * @param   $id_utente_registrato
     * @return  object UTENTE_REGISTRATO
     */
    public static function getRecordInDB($id_utente_registrato){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_utente_registrato = DB_Functions::esc($id_utente_registrato);
        $query = "SELECT  *
                  FROM 	  UTENTE_REGISTRATO
	              WHERE	  ID_UTENTE_REGISTRATO=$id_utente_registrato;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $utente_registrato = new Utente_registrato($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2],$resQuery["response"][0][3],$resQuery["response"][0][4],
                $resQuery["response"][0][5],$resQuery["response"][0][6]);
            return $utente_registrato;
        }
        else
            return null;
    }

    /**
     * Funzione di classe per autenticare un utente registrato
     * @param   $id_utente_registrato
     * @return  array resQuery
     */
    public static function autentication($email, $password){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $email = DB_Functions::esc($email);
        $password = DB_Functions::esc($password);
        $query = "SELECT  COUNT (*)			
	              FROM 	  UTENTE_REGISTRATO
                  WHERE	  EMAIL     = $email AND
			              PASSWORD  = SHA1($password);";
        $resQuery = $db->executeQuery($query);
        if (count($resQuery["response"][]) == 0) {
            $resQuery["esito"] = false;
            $resQuery["text"] = "user don't exist";
        }
        else {
            $resQuery["esito"] = true;
            $resQuery["text"] = "";
        }
        return $resQuery;
    }

}



class Prenotazione {
    //attributi classe
    private $id_prenotazione;
    private $data;
    private $numero_posti;

    //ID object dependence
    private $id_sede;
    private $id_tipologia_prenotazione;
    private $id_utente_registrato;

    /**
     * Prenotazione constructor.
     * @param $id_prenotazione
     * @param $data
     * @param $numero_posti
     * @param $id_sede
     * @param $id_tipologia_prenotazione
     * @param $id_utente_registrato
     */
    public function __construct($id_prenotazione, $data, $numero_posti, $id_sede, $id_tipologia_prenotazione, $id_utente_registrato)
    {
        $this->id_prenotazione = $id_prenotazione;
        $this->data = $data;
        $this->numero_posti = $numero_posti;
        $this->id_sede = $id_sede;
        $this->id_tipologia_prenotazione = $id_tipologia_prenotazione;
        $this->id_utente_registrato = $id_utente_registrato;
    }


    /**
     * @return mixed
     */
    public function getIdPrenotazione()
    {
        return $this->id_prenotazione;
    }

    /**
     * @param mixed $id_prenotazione
     */
    public function setIdPrenotazione($id_prenotazione)
    {
        $this->id_prenotazione = $id_prenotazione;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getNumeroPosti()
    {
        return $this->numero_posti;
    }

    /**
     * @param mixed $numero_posti
     */
    public function setNumeroPosti($numero_posti)
    {
        $this->numero_posti = $numero_posti;
    }

    /**
     * @return mixed
     */
    public function getIdSede()
    {
        return $this->id_sede;
    }

    /**
     * @param mixed $id_sede
     */
    public function setIdSede($id_sede)
    {
        $this->id_sede = $id_sede;
    }

    /**
     * @return mixed
     */
    public function getIdTipologiaPrenotazione()
    {
        return $this->id_tipologia_prenotazione;
    }

    /**
     * @param mixed $id_tipologia_prenotazione
     */
    public function setIdTipologiaPrenotazione($id_tipologia_prenotazione)
    {
        $this->id_tipologia_prenotazione = $id_tipologia_prenotazione;
    }

    /**
     * @return mixed
     */
    public function getIdUtenteRegistrato()
    {
        return $this->id_utente_registrato;
    }

    /**
     * @param mixed $id_utente_registrato
     */
    public function setIdUtenteRegistrato($id_utente_registrato)
    {
        $this->id_utente_registrato = $id_utente_registrato;
    }



    /**
     * Funzione che effettua una prenotazione nel DB
     * @param   $data $numero_posti $id_sede $id_tipologia_prenotazione $id_utente_registrato
     * @return  array resQuery
     */
    public function addRecordInDB($data, $numero_posti, $id_sede, $id_tipologia_prenotazione, $id_utente_registrato){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $data = DB_Functions::esc($data);
        $numero_posti = DB_Functions::esc($numero_posti);
        $id_sede = DB_Functions::esc($id_sede);
        $id_tipologia_prenotazione = DB_Functions::esc($id_tipologia_prenotazione);
        $id_utente_registrato = DB_Functions::esc($id_utente_registrato);
        $query = "INSERT INTO PRENOTAZIONE (DATA, NUMERO_POSTI, ID_SEDE, ID_TIPOLOGIA_PRENOTAZIONE, ID_UTENTE_REGISTRATO)
	              VALUES ($data, $numero_posti, $id_sede, $id_tipologia_prenotazione, $id_utente_registrato)";
        $resQuery1 = $db->executeQuery($query);
        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_PRENOTAZIONE) FROM PRENOTAZIONE;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_prenotazione = $resQuery2["response"][0][0];
            $this->data = $data;
            $this->numero_posti = $numero_posti;
            $this->id_sede = $id_sede;
            $this->id_tipologia_prenotazione = $id_tipologia_prenotazione;
            $this->id_utente_registrato = $id_utente_registrato;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di una prenotazione
     * @param   $id_prenotazione $data $numero_posti $id_sede $id_tipologia_prenotazione $id_utente_registrato
     * @return  array resQuery
     */
    public function setRecordInDB($id_prenotazione, $data, $numero_posti, $id_sede, $id_tipologia_prenotazione, $id_utente_registrato){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $data = DB_Functions::esc($data);
        $numero_posti = DB_Functions::esc($numero_posti);
        $id_sede = DB_Functions::esc($id_sede);
        $id_tipologia_prenotazione = DB_Functions::esc($id_tipologia_prenotazione);
        $id_utente_registrato = DB_Functions::esc($id_utente_registrato);
        $id_prenotazione = DB_Functions::esc($id_prenotazione);

        $query = "UPDATE PRENOTAZIONE 
                  SET 	DATA                      = $data,
                        NUMERO_POSTI              = $numero_posti,
                        ID_SEDE                   = $id_sede,
                        ID_TIPOLOGIA_PRENOTAZIONE = $id_tipologia_prenotazione,
                        ID_UTENTE_REGISTRATO      = $id_utente_registrato
                  WHERE 	
                        ID_PRENOTAZIONE           = $id_prenotazione;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->data = $data;
            $this->numero_posti = $numero_posti;
            $this->id_sede = $id_sede;
            $this->id_tipologia_prenotazione = $id_tipologia_prenotazione;
            $this->id_utente_registrato = $id_utente_registrato;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di una PRENOTAZIONE
     * @param   $id_prenotazione
     * @return  object PRENOTAZIONE
     */
    public static function getRecordInDB($id_prenotazione){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_prenotazione = DB_Functions::esc($id_prenotazione);
        $query = "SELECT  *
                  FROM 	  PRENOTAZIONE
	              WHERE	  ID_PRENOTAZIONE = $id_prenotazione;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $prenotazione = new Prenotazione($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2],$resQuery["response"][0][3],$resQuery["response"][0][4]);
            return $prenotazione;
        }
        else
            return null;
    }

    /**
     * Funzione che restituisce tutti i posti disponibili di una prenotazione
     * @param   $id_prenotazione
     * @return  $numero_posti_disponibili
     */
    public static function posti_disponibili($id_prenotazione)
    {
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_prenotazione = DB_Functions::esc($id_prenotazione);
        $query =    "SELECT * 
                     FROM UTILIZZO_BIGLIETTO
                     WHERE ID_PRENOTAZIONE = $id_prenotazione;";
        $resQuery = $db->executeQuery($query);
        $numero_posti_utilizzati = 0;
        foreach( $resQuery["response"] as $row ) {
            $numero_posti_utilizzati  += $row[2];
        }
        $query = "SELECT  numero_posti
                  FROM 	  PRENOTAZIONE
	              WHERE	  ID_PRENOTAZIONE = $id_prenotazione;";
        $resQuery = $db->executeQuery($query);
        $numero_posti_totali = 0;


        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $numero_posti_totali = $resQuery["response"][0][2];

        }
        return $numero_posti_totali-$numero_posti_utilizzati;
    }

    /**
     * Funzione che restituisce tutti i posti disponibili della prenotazione
     * @param
     * @return  $numero_posti_disponibili
     */
    public function get_posti_disponibili(){
        $id_prenotazione = $this->getIdPrenotazione();
        Prenotazione::posti_disponibili($id_prenotazione);
    }
}



class Utilizzo_biglietto {
    //attributi classe
    private $id_utilizzo_biglietto;
    private $data;
    private $numero_posti;

    //ID object dependence
    private $id_prenotazione;

    /**
     * Utilizzo_biglietto constructor.
     * @param $id_utilizzo_biglietto
     * @param $data
     * @param $numero_posti
     * @param $id_prenotazione
     */
    public function __construct($id_utilizzo_biglietto, $data, $numero_posti, $id_prenotazione)
    {
        $this->id_utilizzo_biglietto = $id_utilizzo_biglietto;
        $this->data = $data;
        $this->numero_posti = $numero_posti;
        $this->id_prenotazione = $id_prenotazione;
    }

    /**
     * @return mixed
     */
    public function getIdUtilizzoBiglietto()
    {
        return $this->id_utilizzo_biglietto;
    }

    /**
     * @param mixed $id_utilizzo_biglietto
     */
    public function setIdUtilizzoBiglietto($id_utilizzo_biglietto)
    {
        $this->id_utilizzo_biglietto = $id_utilizzo_biglietto;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getNumeroPosti()
    {
        return $this->numero_posti;
    }

    /**
     * @param mixed $numero_posti
     */
    public function setNumeroPosti($numero_posti)
    {
        $this->numero_posti = $numero_posti;
    }

    /**
     * @return mixed
     */
    public function getIdPrenotazione()
    {
        return $this->id_prenotazione;
    }

    /**
     * @param mixed $id_prenotazione
     */
    public function setIdPrenotazione($id_prenotazione)
    {
        $this->id_prenotazione = $id_prenotazione;
    }



    /**
     * Funzione che utilizza un certo numero di posti disponibili nel biglietto convalidato
     * @param   $data $numero_posti $id_prenotazione
     * @return  state
     */
    public function addRecordInDB($data, $numero_posti, $id_prenotazione){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $data = DB_Functions::esc($data);
        $numero_posti = DB_Functions::esc($numero_posti);
        $id_prenotazione = DB_Functions::esc($id_prenotazione);

        //Verifica posti disponibili
        $posti_disponibili = Prenotazione::posti_disponibili($id_prenotazione);

        //Se posso non posso utilizzare il biglietto
        if ($numero_posti > $posti_disponibili) {
            return false;
        }

        //Utilizza biglietto con numero posti desiderato
        $query = "INSERT INTO UTILIZZO_BIGLIETTO (DATA, NUMERO_POSTI, ID_PRENOTAZIONE)
	              VALUES ($data, $numero_posti, $id_prenotazione)";

        $resQuery1 = $db->executeQuery($query);
        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_UTILIZZO_BIGLIETTO) FROM UTILIZZO_BIGLIETTO;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_utilizzo_biglietto = $resQuery2["response"][0][0];
            $this->data = $data;
            $this->numero_posti = $numero_posti;
            $this->id_prenotazione = $id_prenotazione;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di UTILIZZO BIGLIETTO
     * @param   $id_utilizzo_biglietto $data $numero_posti $id_prenotazione
     * @return  array resQuery
     */
    public function setRecordInDB($id_utilizzo_biglietto, $data, $numero_posti, $id_prenotazione){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_utilizzo_biglietto = DB_Functions::esc($id_utilizzo_biglietto);
        $data = DB_Functions::esc($data);
        $numero_posti = DB_Functions::esc($numero_posti);
        $id_prenotazione = DB_Functions::esc($id_prenotazione);

        $query = "UPDATE UTILIZZO_BIGLIETTO 
                  SET 	DATA                      = $data,
                        NUMERO_POSTI              = $numero_posti,
                        ID_PRENOTAZIONE           = $id_prenotazione
                  WHERE 	
                        ID_UTILIZZO_BIGLIETTO     = $id_utilizzo_biglietto;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->data = $data;
            $this->numero_posti = $numero_posti;
            $this->id_prenotazione = $id_prenotazione;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di UTILIZZO BIGLIETTO
     * @param   $id_utilizzo_biglietto
     * @return  object UTILIZZO_BIGLIETTO
     */
    public static function getRecordInDB($id_utilizzo_biglietto){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_utilizzo_biglietto = DB_Functions::esc($id_utilizzo_biglietto);
        $query = "SELECT  *
                  FROM 	  UTILIZZO_BIGLIETTO
	              WHERE	  ID_UTILIZZO_BIGLIETTO = $id_utilizzo_biglietto;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $utilizzo_biglietto = new Utilizzo_biglietto($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2],$resQuery["response"][0][3]);
            return $utilizzo_biglietto;
        }
        else
            return null;
    }

}



class Tipologia_prenotazione {
    //attributi classe
    private $id_tipologia_prenotazione;
    private $nome;
    private $descrizione;
    private $note_varie;
    private $prezzo;

    /**
     * Tipologia_prenotazione constructor.
     * @param $id_tipologia_prenotazione
     * @param $nome
     * @param $descrizione
     * @param $note_varie
     * @param $prezzo
     */
    public function __construct($id_tipologia_prenotazione, $nome, $descrizione, $note_varie, $prezzo)
    {
        $this->id_tipologia_prenotazione = $id_tipologia_prenotazione;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->note_varie = $note_varie;
        $this->prezzo = $prezzo;
    }

    /**
     * @return mixed
     */
    public function getIdTipologiaPrenotazione()
    {
        return $this->id_tipologia_prenotazione;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * @return mixed
     */
    public function getNoteVarie()
    {
        return $this->note_varie;
    }

    /**
     * @return mixed
     */
    public function getPrezzo()
    {
        return $this->prezzo;
    }



    /**
     * Funzione per aggiungere una nuova TIPOLOGIA_PRENOTAZIONE
     * @param   $nome $descrizione $note_varie $prezzo
     * @return  array resQuery
     */
    public function addRecordInDB($nome, $descrizione, $note_varie, $prezzo){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $nome = DB_Functions::esc($nome);
        $descrizione = DB_Functions::esc($descrizione);
        $note_varie = DB_Functions::esc($note_varie);
        $prezzo = DB_Functions::esc($prezzo);

        //inserimento nuova tipologia prenotazione
        $query = "INSERT INTO TIPOLOGIA_PRENOTAZIONE (NOME, DESCRIZIONE, NOTE_VARIE, PREZZO)
	              VALUES ($nome, $descrizione, $note_varie, $prezzo)";
        $resQuery1 = $db->executeQuery($query);

        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_TIPOLOGIA_PRENOTAZIONE) FROM TIPOLOGIA_PRENOTAZIONE;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_tipologia_prenotazione = $resQuery2["response"][0][0];
            $this->nome = $nome;
            $this->descrizione = $descrizione;
            $this->note_varie = $note_varie;
            $this->prezzo = $prezzo;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di TIPOLOGIA_PRENOTAZIONE
     * @param   $id_tipologia_prenotazione $nome $descrizione $note_varie $prezzo
     * @return  array resQuery
     */
    public function setRecordInDB($id_tipologia_prenotazione, $nome, $descrizione, $note_varie, $prezzo){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_tipologia_prenotazione = DB_Functions::esc($id_tipologia_prenotazione);
        $nome = DB_Functions::esc($nome);
        $descrizione = DB_Functions::esc($descrizione);
        $note_varie = DB_Functions::esc($note_varie);
        $prezzo = DB_Functions::esc($prezzo);

        $query = "UPDATE TIPOLOGIA_PRENOTAZIONE 
                  SET 	NOME                        = $nome,
                        DESCRIZIONE                 = $descrizione,
                        NOTE_VARIE                  = $note_varie
                        PREZZO                      = $prezzo
                  WHERE 	
                        ID_TIPOLOGIA_PRENOTAZIONE   = $id_tipologia_prenotazione;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->nome = $nome;
            $this->descrizione = $descrizione;
            $this->note_varie = $note_varie;
            $this->prezzo = $prezzo;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di TIPOLOGIA_PRENOTAZIONE
     * @param   $id_tipologia_prenotazione
     * @return  object TIPOLOGIA_PRENOTAZIONE
     */
    public static function getRecordInDB($id_tipologia_prenotazione){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_tipologia_prenotazione = DB_Functions::esc($id_tipologia_prenotazione);
        $query = "SELECT  *
                  FROM 	  TIPOLOGIA_PRENOTAZIONE
	              WHERE	  ID_TIPOLOGIA_PRENOTAZIONE = $id_tipologia_prenotazione;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $tipologia_prenotazione = new Tipologia_prenotazione($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2],$resQuery["response"][0][3],$resQuery["response"][0][4]);
            return $tipologia_prenotazione;
        }
        else
            return null;
    }

}



class Entita {
    //attributi classe
    private $id_entita;
    private $nome;
    private $nome_icona;
    private $nome_immagine;
    private $quantita;

    //ID object dependence
    private $id_sede;

    /**
     * Entita constructor.
     * @param $id_entita
     * @param $nome
     * @param $nome_icona
     * @param $nome_immagine
     * @param $quantita
     * @param $id_sede
     */
    public function __construct($id_entita, $nome, $nome_icona, $nome_immagine, $quantita, $id_sede)
    {
        $this->id_entita = $id_entita;
        $this->nome = $nome;
        $this->nome_icona = $nome_icona;
        $this->nome_immagine = $nome_immagine;
        $this->quantita = $quantita;
        $this->id_sede = $id_sede;
    }

    /**
     * @return mixed
     */
    public function getIdEntita()
    {
        return $this->id_entita;
    }

    /**
     * @param mixed $id_entita
     */
    public function setIdEntita($id_entita)
    {
        $this->id_entita = $id_entita;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getNomeIcona()
    {
        return $this->nome_icona;
    }

    /**
     * @param mixed $nome_icona
     */
    public function setNomeIcona($nome_icona)
    {
        $this->nome_icona = $nome_icona;
    }

    /**
     * @return mixed
     */
    public function getNomeImmagine()
    {
        return $this->nome_immagine;
    }

    /**
     * @param mixed $nome_immagine
     */
    public function setNomeImmagine($nome_immagine)
    {
        $this->nome_immagine = $nome_immagine;
    }

    /**
     * @return mixed
     */
    public function getQuantita()
    {
        return $this->quantita;
    }

    /**
     * @param mixed $quantita
     */
    public function setQuantita($quantita)
    {
        $this->quantita = $quantita;
    }

    /**
     * @return mixed
     */
    public function getIdSede()
    {
        return $this->id_sede;
    }

    /**
     * @param mixed $id_sede
     */
    public function setIdSede($id_sede)
    {
        $this->id_sede = $id_sede;
    }




    /**
     * Funzione per aggiungere una nuova ENTITA
     * @param   $nome $nome_icona $nome_immagine $quantita $id_sede
     * @return  array resQuery
     */
    public function addRecordInDB($nome, $nome_icona, $nome_immagine, $quantita, $id_sede){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $nome = DB_Functions::esc($nome);
        $nome_icona = DB_Functions::esc($nome_icona);
        $nome_immagine = DB_Functions::esc($nome_immagine);
        $quantita = DB_Functions::esc($quantita);
        $id_sede = DB_Functions::esc($id_sede);

        //inserimento nuova ENTITA
        $query = "INSERT INTO ENTITA (NOME, NOME_ICONA, NOME_IMMAGINE, QUANTITA, ID_SEDE)
	              VALUES ($nome, $nome_icona, $nome_immagine, $id_sede)";
        $resQuery1 = $db->executeQuery($query);

        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_ENTITA) FROM ENTITA;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_entita = $resQuery2["response"][0][0];
            $this->nome = $nome;
            $this->nome_icona = $nome_icona;
            $this->nome_immagine = $nome_immagine;
            $this->quantita = $quantita;
            $this->id_sede = $id_sede;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di ENTITA
     * @param   $id_entita $nome $nome_icona $nome_immagine $quantita $id_sede
     * @return  array resQuery
     */
    public function setRecordInDB($id_entita, $nome, $nome_icona, $nome_immagine, $quantita, $id_sede){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_entita = DB_Functions::esc($id_entita);
        $nome = DB_Functions::esc($nome);
        $nome_icona = DB_Functions::esc($nome_icona);
        $nome_immagine = DB_Functions::esc($nome_immagine);
        $quantita = DB_Functions::esc($quantita);
        $id_sede = DB_Functions::esc($id_sede);

        $query = "UPDATE ENTITA 
                  SET 	NOME                          = $nome,
                        NOME_ICONA                    = $nome_icona,
                        NOME_IMMAGINE                 = $nome_immagine
                        QUANTITA                      = $quantita
                        ID_SEDE                       = $id_sede
                  WHERE 	
                        ID_ENTITA                     = $id_entita;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->nome = $nome;
            $this->nome_icona = $nome_icona;
            $this->nome_immagine = $nome_immagine;
            $this->quantita = $quantita;
            $this->id_sede = $id_sede;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di ENTITA
     * @param   $id_entita
     * @return  object ENTITA
     */
    public static function getRecordInDB($id_entita){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_entita = DB_Functions::esc($id_entita);
        $query = "SELECT  *
                  FROM 	  ENTITA
	              WHERE	  ID_ENTITA = $id_entita;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $entita = new Entita($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2],$resQuery["response"][0][3],$resQuery["response"][0][4],$resQuery["response"][0][5]);
            return $entita;
        }
        else
            return null;
    }

}



class Luogo {
    //attributi classe
    private $id_luogo;
    private $citta;
    private $paese;

    /**
     * Luogo constructor.
     * @param $id_luogo
     * @param $citta
     * @param $paese
     */
    public function __construct($id_luogo, $citta, $paese)
    {
        $this->id_luogo = $id_luogo;
        $this->citta = $citta;
        $this->paese = $paese;
    }

    /**
     * @return mixed
     */
    public function getIdLuogo()
    {
        return $this->id_luogo;
    }

    /**
     * @param mixed $id_luogo
     */
    public function setIdLuogo($id_luogo)
    {
        $this->id_luogo = $id_luogo;
    }

    /**
     * @return mixed
     */
    public function getCitta()
    {
        return $this->citta;
    }

    /**
     * @param mixed $citta
     */
    public function setCitta($citta)
    {
        $this->citta = $citta;
    }

    /**
     * @return mixed
     */
    public function getPaese()
    {
        return $this->paese;
    }

    /**
     * @param mixed $paese
     */
    public function setPaese($paese)
    {
        $this->paese = $paese;
    }




    /**
     * Funzione per aggiungere una nuovo LUOGO
     * @param   $citta $paese
     * @return  array resQuery
     */
    public function addRecordInDB($citta, $paese){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $citta = DB_Functions::esc($citta);
        $paese = DB_Functions::esc($paese);

        //inserimento nuovo LUOGO
        $query = "INSERT INTO LUOGO (CITTA, PAESE)
	              VALUES ($citta, $paese)";
        $resQuery1 = $db->executeQuery($query);

        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_LUOGO) FROM LUOGO;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_entita = $resQuery2["response"][0][0];
            $this->citta = $citta;
            $this->paese = $paese;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di LUOGO
     * @param   $id_entita $nome $nome_icona $nome_immagine $quantita $id_sede
     * @return  array resQuery
     */
    public function setRecordInDB($id_luogo, $citta, $paese){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_luogo = DB_Functions::esc($id_luogo);
        $citta = DB_Functions::esc($citta);
        $paese = DB_Functions::esc($paese);

        $query = "UPDATE LUOGO 
                  SET 	CITTA                         = $citta,
                        PAESE                         = $paese,
                  WHERE 	
                        ID_LUOGO                     = $id_luogo;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->citta = $citta;
            $this->paese = $paese;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di LUOGO
     * @param   $id_luogo
     * @return  object LUOGO
     */
    public static function getRecordInDB($id_luogo){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_luogo = DB_Functions::esc($id_luogo);
        $query = "SELECT  *
                  FROM 	  LUOGO
	              WHERE	  ID_LUOGO = $id_luogo;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $luogo = new Luogo($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2]);
            return $luogo;
        }
        else
            return null;
    }

}



class Sede {
    //attributi classe
    private $id_sede;
    private $nome;

    //ID object dependence
    private $id_luogo;

    /**
     * Sede constructor.
     * @param $id_sede
     * @param $nome
     * @param $id_luogo
     */
    public function __construct($id_sede, $nome, $id_luogo)
    {
        $this->id_sede = $id_sede;
        $this->nome = $nome;
        $this->id_luogo = $id_luogo;
    }

    /**
     * @return mixed
     */
    public function getIdSede()
    {
        return $this->id_sede;
    }

    /**
     * @param mixed $id_sede
     */
    public function setIdSede($id_sede)
    {
        $this->id_sede = $id_sede;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getIdLuogo()
    {
        return $this->id_luogo;
    }

    /**
     * @param mixed $id_luogo
     */
    public function setIdLuogo($id_luogo)
    {
        $this->id_luogo = $id_luogo;
    }


    /**
     * Funzione per aggiungere una nuova SEDE
     * @param   $nome $id_luogo
     * @return  array resQuery
     */
    public function addRecordInDB($nome, $id_luogo){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $nome = DB_Functions::esc($nome);
        $id_luogo = DB_Functions::esc($id_luogo);

        //inserimento nuova SEDE
        $query = "INSERT INTO SEDE (NOME, ID_LUOGO)
	              VALUES ($nome, $id_luogo)";
        $resQuery1 = $db->executeQuery($query);

        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_SEDE) FROM SEDE;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_sede = $resQuery2["response"][0][0];
            $this->nome = $nome;
            $this->id_luogo = $id_luogo;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di SEDE
     * @param   $id_sede $nome $id_luogo
     * @return  array resQuery
     */
    public function setRecordInDB($id_sede, $nome, $id_luogo){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_sede = DB_Functions::esc($id_sede);
        $nome = DB_Functions::esc($nome);
        $id_luogo = DB_Functions::esc($id_luogo);

        $query = "UPDATE SEDE 
                  SET 	NOME                        = $nome,
                        ID_LUOGO                    = $id_luogo,
                  WHERE 	
                        ID_SEDE                     = $id_sede;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->nome = $nome;
            $this->id_luogo = $id_luogo;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di SEDE
     * @param   $id_sede
     * @return  object SEDE
     */
    public static function getRecordInDB($id_sede){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_sede = DB_Functions::esc($id_sede);
        $query = "SELECT  *
                  FROM 	  SEDE
	              WHERE	  ID_SEDE = $id_sede;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $sede = new Luogo($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2]);
            return $sede;
        }
        else
            return null;
    }

}



class Sezione {
    //attributi classe
    private $id_sezione;
    private $nome;
    private $titolo;
    private $testo_presentazione;
    private $prezzo;

    //ID object dependence
    private $id_sede;

    /**
     * Sezione constructor.
     * @param $id_sezione
     * @param $nome
     * @param $titolo
     * @param $testo_presentazione
     * @param $prezzo
     * @param $id_sede
     */
    public function __construct($id_sezione, $nome, $titolo, $testo_presentazione, $prezzo, $id_sede)
    {
        $this->id_sezione = $id_sezione;
        $this->nome = $nome;
        $this->titolo = $titolo;
        $this->testo_presentazione = $testo_presentazione;
        $this->prezzo = $prezzo;
        $this->id_sede = $id_sede;
    }

    /**
     * @return mixed
     */
    public function getIdSezione()
    {
        return $this->id_sezione;
    }

    /**
     * @param mixed $id_sezione
     */
    public function setIdSezione($id_sezione)
    {
        $this->id_sezione = $id_sezione;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getTitolo()
    {
        return $this->titolo;
    }

    /**
     * @param mixed $titolo
     */
    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }

    /**
     * @return mixed
     */
    public function getTestoPresentazione()
    {
        return $this->testo_presentazione;
    }

    /**
     * @param mixed $testo_presentazione
     */
    public function setTestoPresentazione($testo_presentazione)
    {
        $this->testo_presentazione = $testo_presentazione;
    }

    /**
     * @return mixed
     */
    public function getPrezzo()
    {
        return $this->prezzo;
    }

    /**
     * @param mixed $prezzo
     */
    public function setPrezzo($prezzo)
    {
        $this->prezzo = $prezzo;
    }

    /**
     * @return mixed
     */
    public function getIdSede()
    {
        return $this->id_sede;
    }

    /**
     * @param mixed $id_sede
     */
    public function setIdSede($id_sede)
    {
        $this->id_sede = $id_sede;
    }



    /**
     * Funzione per aggiungere una nuova SEZIONE
     * @param   $nome $titolo $testo_presentazione $prezzo $id_sede
     * @return  array resQuery
     */
    public function addRecordInDB($nome, $titolo, $testo_presentazione, $prezzo, $id_sede){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $nome = DB_Functions::esc($nome);
        $titolo = DB_Functions::esc($titolo);
        $testo_presentazione = DB_Functions::esc($testo_presentazione);
        $prezzo = DB_Functions::esc($prezzo);
        $id_sede = DB_Functions::esc($id_sede);

        //inserimento nuova SEZIONE
        $query = "INSERT INTO SEZIONE (NOME, TITOLO, TESTO_PRESENTAZIONE, PREZZO, ID_SEDE)
	              VALUES ($nome, $titolo, $testo_presentazione, $prezzo, $id_sede)";
        $resQuery1 = $db->executeQuery($query);

        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_SEZIONE) FROM SEZIONE;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_sezione = $resQuery2["response"][0][0];
            $this->nome = $nome;
            $this->titolo = $titolo;
            $this->testo_presentazione = $testo_presentazione;
            $this->prezzo = $prezzo;
            $this->id_sede = $id_sede;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di SEZIONE
     * @param   $id_sezione $nome $titolo $testo_presentazione $prezzo $id_sede
     * @return  array resQuery
     */
    public function setRecordInDB($id_sezione, $nome, $titolo, $testo_presentazione, $prezzo, $id_sede){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_sezione = DB_Functions::esc($id_sezione);
        $nome = DB_Functions::esc($nome);
        $titolo = DB_Functions::esc($titolo);
        $testo_presentazione = DB_Functions::esc($testo_presentazione);
        $prezzo = DB_Functions::esc($prezzo);
        $id_sede = DB_Functions::esc($id_sede);

        $query = "UPDATE SEZIONE 
                  SET 	NOME                        = $nome,
                        TITOLO                      = $titolo,
                        TESTO_PRESENTAZIONE         = $testo_presentazione
                        PREZZO                      = $prezzo
                  WHERE 	
                        ID_SEDE                     = $id_sede;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->nome = $nome;
            $this->titolo = $titolo;
            $this->testo_presentazione = $testo_presentazione;
            $this->prezzo = $prezzo;
            $this->id_sede = $id_sede;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di SEZIONE
     * @param   $id_sezione
     * @return  object SEZIONE
     */
    public static function getRecordInDB($id_sezione){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_sezione = DB_Functions::esc($id_sezione);
        $query = "SELECT  *
                  FROM 	  SEZIONE
	              WHERE	  ID_SEZIONE = $id_sezione;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $sezione = new Luogo($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2],$resQuery["response"][0][3],$resQuery["response"][0][4],$resQuery["response"][0][5]);
            return $sezione;
        }
        else
            return null;
    }

}



class Protagonista {
    //attributi classe

    //ID object dependence
    private $id_entita;
    private $id_sezione;

    /**
     * Protagonista constructor.
     * @param $id_entita
     * @param $id_sezione
     */
    public function __construct($id_entita, $id_sezione)
    {
        $this->id_entita = $id_entita;
        $this->id_sezione = $id_sezione;
    }

    /**
     * @return mixed
     */
    public function getIdEntita()
    {
        return $this->id_entita;
    }

    /**
     * @param mixed $id_entita
     */
    public function setIdEntita($id_entita)
    {
        $this->id_entita = $id_entita;
    }

    /**
     * @return mixed
     */
    public function getIdSezione()
    {
        return $this->id_sezione;
    }

    /**
     * @param mixed $id_sezione
     */
    public function setIdSezione($id_sezione)
    {
        $this->id_sezione = $id_sezione;
    }



    /**
     * Funzione per aggiungere un nuovo PROTAGONISTA
     * @param   $id_entita $id_sezione
     * @return  array resQuery
     */
    public function addRecordInDB($id_entita, $id_sezione){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_entita = DB_Functions::esc($id_entita);
        $id_sezione = DB_Functions::esc($id_sezione);

        //inserimento nuovo PROTAGONISTA
        $query = "INSERT INTO PROTAGONISTA (ID_ENTITA, ID_SEZIONE)
	              VALUES ($id_entita, $id_sezione)";
        $resQuery = $db->executeQuery($query);

        // Se la query ha esito positivo
        if ($resQuery["state"]) {
            $this->id_entita = $id_entita;
            $this->id_sezione = $id_sezione;
        }
        return $resQuery;
    }

    /**
     * Funzione che elimina un determinato recordset di PROTAGONISTA
     * @param   $id_entita $id_sezione
     * @return  array resQuery
     */
    public static function deleteRecordInDB($id_entita, $id_sezione){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_entita = DB_Functions::esc($id_entita);
        $id_sezione = DB_Functions::esc($id_sezione);

        $query = "DELETE  FROM          PROTAGONISTA       
                  WHERE   ID_ENTITA   = $id_entita AND
                          ID_SEZIONE  = $id_sezione; ";
        $resQuery = $db->executeQuery($query);
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di PROTAGONISTA
     * @param   $id_entita $id_sezione
     * @return  object PROTAGONISTA
     */
    public static function getRecordInDB($id_entita, $id_sezione){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_entita = DB_Functions::esc($id_entita);
        $id_sezione = DB_Functions::esc($id_sezione);
        $query = "SELECT  *
                  FROM 	  PROTAGONISTA
	              WHERE   ID_ENTITA   = $id_entita AND
                          ID_SEZIONE  = $id_sezione; ";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $protagonista = new Protagonista($resQuery["response"][0][0],$resQuery["response"][0][1]);
            return $protagonista;
        }
        else
            return null;
    }

    /**
     * Funzione di classe che visualizza tutti i PROTAGONISTI di una SEZIONE
     * @param   $id_sezione
     * @return  array PROTAGONISTA
     */
    public static function getProtagonistiDaSezione($id_sezione){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_sezione = DB_Functions::esc($id_sezione);
        $query = "SELECT  *
                  FROM 	  PROTAGONISTA
	              WHERE   ID_SEZIONE  = $id_sezione; ";
        $resQuery = $db->executeQuery($query);

        $i=0;
        $protagonisti= array();
        foreach($resQuery["response"] as $row ){
            $protagonista = new Protagonista($row[0],$row[1]);
            $protagonisti[$i] = $protagonista;
            $i++;
        }
        return $protagonisti;
    }

    /**
     * Funzione di classe che visualizza tutti i PROTAGONISTI di una ENTITA
     * @param   $id_entita
     * @return  array PROTAGONISTA
     */
    public static function getProtagonistiDaEntita($id_entita){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_entita = DB_Functions::esc($id_entita);
        $query = "SELECT  *
                  FROM 	  PROTAGONISTA
	              WHERE   ID_ENTITA  = $id_entita; ";
        $resQuery = $db->executeQuery($query);

        $i=0;
        $protagonisti= array();
        foreach($resQuery["response"] as $row ){
            $protagonista = new Protagonista($row[0],$row[1]);
            $protagonisti[$i] = $protagonista;
            $i++;
        }
        return $protagonisti;
    }
}



class Amministratore extends Utente_registrato {

    /**
     * Funzione per aggiungere un nuovo AMMINISTRATORE
     * @param   $id_utente_registrato
     * @return  array resQuery
     */
    public function addRecordInDB($id_utente_registrato){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_utente_registrato = DB_Functions::esc($id_utente_registrato);

        //inserimento nuovo AMMINISTRATORE
        $query = "INSERT INTO AMMINISTRATORE (ID_UTENTE_REGISTRATO)
	              VALUES ($id_utente_registrato)";
        $resQuery = $db->executeQuery($query);

        return $resQuery;
    }

    /**
     * Funzione che revoca il privilegio di AMMINISTRATORE ad un UTENTE_REGISTRATO
     * @param   $id_utente_registrato
     * @return  array resQuery
     */
    public function deleteRecordInDB($id_utente_registrato){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_utente_registrato = DB_Functions::esc($id_utente_registrato);

        $query = "DELETE  FROM                      AMMINISTRATORE       
                  WHERE   ID_UTENTE_REGISTRATO   =  $id_utente_registrato; ";
        $resQuery = $db->executeQuery($query);

        return $resQuery;
    }

    /**
     * Funzione di classe che restituisce TUTTI gli AMMINISTRATORI con un ARRAY di AMMINISTRATORE
     * @param
     * @return  array AMMINISTRATORE
     */
    public static function getAdministratorsFromDB(){
        include_once './db_functions.php';
        $db = new DB_Functions();
        $query = "SELECT  *
                  FROM 	  AMMINISTRATORE;";
        $resQuery = $db->executeQuery($query);

        $i=0;
        $amministratori= array();
        foreach($resQuery["response"] as $row ){
            $utente_registrato = Utente_registrato::getRecordInDB($row[0]);
            $amministratori[$i] = $utente_registrato;
            $i++;
        }
        return $amministratori;
    }

}



class News {
    //attributi classe
    private $id_news;
    private $data;
    private $titolo;
    private $testo;

    //ID object dependence
    private $id_utente_registrato;

    /**
     * News constructor.
     * @param $id_news
     * @param $data
     * @param $titolo
     * @param $testo
     * @param $id_utente_registrato
     */
    public function __construct($id_news, $data, $titolo, $testo, $id_utente_registrato)
    {
        $this->id_news = $id_news;
        $this->data = $data;
        $this->titolo = $titolo;
        $this->testo = $testo;
        $this->id_utente_registrato = $id_utente_registrato;
    }

    /**
     * @return mixed
     */
    public function getIdNews()
    {
        return $this->id_news;
    }

    /**
     * @param mixed $id_news
     */
    public function setIdNews($id_news)
    {
        $this->id_news = $id_news;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getTitolo()
    {
        return $this->titolo;
    }

    /**
     * @param mixed $titolo
     */
    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }

    /**
     * @return mixed
     */
    public function getTesto()
    {
        return $this->testo;
    }

    /**
     * @param mixed $testo
     */
    public function setTesto($testo)
    {
        $this->testo = $testo;
    }

    /**
     * @return mixed
     */
    public function getIdUtenteRegistrato()
    {
        return $this->id_utente_registrato;
    }

    /**
     * @param mixed $id_utente_registrato
     */
    public function setIdUtenteRegistrato($id_utente_registrato)
    {
        $this->id_utente_registrato = $id_utente_registrato;
    }



    /**
     * Funzione per aggiungere una nuova NEWS
     * @param   $data $titolo $testo $id_utente_registrato
     * @return  array resQuery
     */
    public function addRecordInDB($data, $titolo, $testo, $id_utente_registrato){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $data = DB_Functions::esc($data);
        $titolo = DB_Functions::esc($titolo);
        $testo = DB_Functions::esc($testo);
        $id_utente_registrato = DB_Functions::esc($id_utente_registrato);

        //inserimento nuova NEWS
        $query = "INSERT INTO NEWS (DATA, TITOLO, TESTO, ID_UTENTE_REGISTRATO)
	              VALUES ($data, $titolo, $testo, $id_utente_registrato)";
        $resQuery1 = $db->executeQuery($query);

        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_NEWS) FROM NEWS;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_news = $resQuery2["response"][0][0];
            $this->data = $data;
            $this->titolo = $titolo;
            $this->testo = $testo;
            $this->id_utente_registrato = $id_utente_registrato;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di NEWS
     * @param   $id_news $data $titolo $testo $id_utente_registrato
     * @return  array resQuery
     */
    public function setRecordInDB($id_news, $data, $titolo, $testo, $id_utente_registrato){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_news = DB_Functions::esc($id_news);
        $data = DB_Functions::esc($data);
        $titolo = DB_Functions::esc($titolo);
        $testo = DB_Functions::esc($testo);
        $id_utente_registrato = DB_Functions::esc($id_utente_registrato);

        $query = "UPDATE NEWS 
                  SET 	DATA                        = $data,
                        TITOLO                      = $titolo,
                        TESTO                       = $testo
                        ID_UTENTE_REGISTRATO        = $id_utente_registrato
                  WHERE 	
                        ID_NEWS                     = $id_news;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->data = $data;
            $this->titolo = $titolo;
            $this->testo = $testo;
            $this->id_utente_registrato = $id_utente_registrato;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di NEWS
     * @param   $id_news
     * @return  object NEWS
     */
    public static function getRecordInDB($id_news){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_news = DB_Functions::esc($id_news);
        $query = "SELECT  *
                  FROM 	  NEWS
	              WHERE	  ID_NEWS = $id_news;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $news = new News($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2],$resQuery["response"][0][3],$resQuery["response"][0][4]);
            return $news;
        }
        else
            return null;
    }

    /**
     * Funzione di classe che restituisce TUTTE le NEWS con un ARRAY di NEWS
     * @param
     * @return  array NEWS
     */
    public static function getAllNewsFromDB(){
        include_once './db_functions.php';
        $db = new DB_Functions();
        $query = "SELECT  *
                  FROM 	  NEWS;";
        $resQuery = $db->executeQuery($query);

        $i=0;
        $allNews= array();
        foreach($resQuery["response"] as $row ){
            $news = News($row[0],$row[1],$row[2],$row[3],$row[4]);
            $allNews[$i] = $news;
            $i++;
        }
        return $allNews;
    }

}



class FAQ {
    //attributi classe
    private $id_news;
    private $data;
    private $domanda;
    private $risposta;

    //ID object dependence
    private $id_utente_registrato;

    /**
     * FAQ constructor.
     * @param $id_news
     * @param $data
     * @param $domanda
     * @param $risposta
     * @param $id_utente_registrato
     */
    public function __construct($id_news, $data, $domanda, $risposta, $id_utente_registrato)
    {
        $this->id_news = $id_news;
        $this->data = $data;
        $this->domanda = $domanda;
        $this->risposta = $risposta;
        $this->id_utente_registrato = $id_utente_registrato;
    }

    /**
     * @return mixed
     */
    public function getIdNews()
    {
        return $this->id_news;
    }

    /**
     * @param mixed $id_news
     */
    public function setIdNews($id_news)
    {
        $this->id_news = $id_news;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getDomanda()
    {
        return $this->domanda;
    }

    /**
     * @param mixed $domanda
     */
    public function setDomanda($domanda)
    {
        $this->domanda = $domanda;
    }

    /**
     * @return mixed
     */
    public function getRisposta()
    {
        return $this->risposta;
    }

    /**
     * @param mixed $risposta
     */
    public function setRisposta($risposta)
    {
        $this->risposta = $risposta;
    }

    /**
     * @return mixed
     */
    public function getIdUtenteRegistrato()
    {
        return $this->id_utente_registrato;
    }

    /**
     * @param mixed $id_utente_registrato
     */
    public function setIdUtenteRegistrato($id_utente_registrato)
    {
        $this->id_utente_registrato = $id_utente_registrato;
    }


    /**
     * Funzione per aggiungere una nuova FAQ
     * @param   $data $domanda $risposta $id_utente_registrato
     * @return  array resQuery
     */
    public function addRecordInDB($data, $domanda, $risposta, $id_utente_registrato){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $data = DB_Functions::esc($data);
        $domanda = DB_Functions::esc($domanda);
        $risposta = DB_Functions::esc($risposta);
        $id_utente_registrato = DB_Functions::esc($id_utente_registrato);

        //inserimento nuova FAQ
        $query = "INSERT INTO FAQ (DATA, DOMANDA, RISPOSTA, ID_UTENTE_REGISTRATO)
	              VALUES ($data, $domanda, $risposta, $id_utente_registrato)";
        $resQuery1 = $db->executeQuery($query);

        // Se la query ha esito positivo
        if ($resQuery1["state"]) {
            //Salva valore ID del record creato
            $query = "SELECT max(ID_FAQ) FROM FAQ;";
            $resQuery2 = $db->executeQuery($query);
            $this->id_FAQ = $resQuery2["response"][0][0];
            $this->data = $data;
            $this->domanda = $domanda;
            $this->risposta = $risposta;
            $this->id_utente_registrato = $id_utente_registrato;
        }
        return $resQuery1;
    }

    /**
     * Funzione che aggiorna campo dati di FAQ
     * @param   $id_FAQ $data $domanda $risposta $id_utente_registrato
     * @return  array resQuery
     */
    public function setRecordInDB($id_FAQ, $data, $domanda, $risposta, $id_utente_registrato){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_news = DB_Functions::esc($id_FAQ);
        $data = DB_Functions::esc($data);
        $titolo = DB_Functions::esc($domanda);
        $testo = DB_Functions::esc($risposta);
        $id_utente_registrato = DB_Functions::esc($id_utente_registrato);

        $query = "UPDATE FAQ 
                  SET 	DATA                        = $data,
                        DOMANDA                     = $domanda,
                        RISPOSTA                    = $risposta
                        ID_UTENTE_REGISTRATO        = $id_utente_registrato
                  WHERE 	
                        ID_NEWS                     = $id_news;";
        $resQuery = $db->executeQuery($query);
        if ($resQuery["state"]) {
            $this->data = $data;
            $this->domanda = $domanda;
            $this->risposta = $risposta;
            $this->id_utente_registrato = $id_utente_registrato;
        }
        return $resQuery;
    }

    /**
     * Funzione di classe che visualizza campo dati di FAQ
     * @param   $id_FAQ
     * @return  object FAQ
     */
    public static function getRecordInDB($id_FAQ){
        include_once './db_functions.php';
        $db = new DB_Functions();
        //Escaping
        $id_FAQ = DB_Functions::esc($id_FAQ);
        $query = "SELECT  *
                  FROM 	  FAQ
	              WHERE	  ID_FAQ = $id_FAQ;";
        $resQuery = $db->executeQuery($query);
        //Se ho un recordset
        if (count($resQuery["response"][]) == 1) {
            $FAQ = new FAQ($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2],$resQuery["response"][0][3],$resQuery["response"][0][4]);
            return $FAQ;
        }
        else
            return null;
    }

    /**
     * Funzione di classe che restituisce TUTTE le FAQ con un ARRAY di FAQ
     * @param
     * @return  array FAQ
     */
    public static function getAllFAQFromDB(){
        include_once './db_functions.php';
        $db = new DB_Functions();
        $query = "SELECT  *
                  FROM 	  FAQ;";
        $resQuery = $db->executeQuery($query);

        $i=0;
        $allFAQ= array();
        foreach($resQuery["response"] as $row ){
            $FAQ = FAQ($row[0],$row[1],$row[2],$row[3],$row[4]);
            $allFAQ[$i] = $FAQ;
            $i++;
        }
        return $allFAQ;
    }

}