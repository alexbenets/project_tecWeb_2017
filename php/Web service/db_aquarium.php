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
     * @return id_utente_registrato
     */
    public function getIdUtenteRegistrato() {
        return $this->id_utente_registrato;
    }

    /**
     * @return nome
     */
    public function getNome()   {
        return $this->nome;
    }

    /**
     * @return cognome
     */
    public function getCognome() {
        return $this->cognome;
    }

    /**
     * @return codice_fiscale
     */
    public function getCodiceFiscale() {
        return $this->codice_fiscale;
    }

    /**
     * @return data_nascita
     */
    public function getDataNascita() {
        return $this->data_nascita;
    }

    /**
     * @return numero_telefono
     */
    public function getNumeroTelefono() {
        return $this->numero_telefono;
    }

    /**
     * @return email
     */
    public function getEmail()  {
        return $this->email;
    }

    /**
     * @return password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Funzione che esegue la registrazione di un utente nel DB
     * @param   $nome $cognome $codice_fiscale $data_nascita $numero_telefono $email $password
     * @return  array resQuery
     */
    public function __construct($nome, $cognome, $codice_fiscale, $data_nascita, $numero_telefono, $email, $password){
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
    public function setter($id_utente_registrato, $nome, $cognome, $codice_fiscale, $data_nascita, $numero_telefono, $email, $password){
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
    public static function getter($id_utente_registrato){
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
     * @return mixed
     */
    public function getIdPrenotazione()
    {
        return $this->id_prenotazione;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getNumeroPosti()
    {
        return $this->numero_posti;
    }

    /**
     * @return mixed
     */
    public function getIdSede()
    {
        return $this->id_sede;
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
    public function getIdUtenteRegistrato()
    {
        return $this->id_utente_registrato;
    }



    /**
     * Funzione che effettua una prenotazione nel DB
     * @param   $data $numero_posti $id_sede $id_tipologia_prenotazione $id_utente_registrato
     * @return  array resQuery
     */
    public function __construct($data, $numero_posti, $id_sede, $id_tipologia_prenotazione, $id_utente_registrato){
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
    public function setter($id_prenotazione, $data, $numero_posti, $id_sede, $id_tipologia_prenotazione, $id_utente_registrato){
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
    public static function getter($id_prenotazione){
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
     * @return mixed
     */
    public function getIdUtilizzoBiglietto()
    {
        return $this->id_utilizzo_biglietto;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getNumeroPosti()
    {
        return $this->numero_posti;
    }

    /**
     * @return mixed
     */
    public function getIdPrenotazione()
    {
        return $this->id_prenotazione;
    }

    /**
     * Funzione che utilizza un certo numero di posti disponibili nel biglietto convalidato
     * @param   $data $numero_posti $id_prenotazione
     * @return  state
     */
    public function __construct($data, $numero_posti, $id_prenotazione){
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
    public function setter($id_utilizzo_biglietto, $data, $numero_posti, $id_prenotazione){
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
    public static function getter($id_utilizzo_biglietto){
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
            $utilizzo_biglietto = new Utilizzo_biglietto($resQuery["response"][0][0],$resQuery["response"][0][1],$resQuery["response"][0][2]);
            return $utilizzo_biglietto;
        }
        else
            return null;
    }

}