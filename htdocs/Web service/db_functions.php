<?php

class DB_Functions {

    private $db;
    private $con;

    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->con=$this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    public static function esc($string)  {
        return mysqli_real_escape_string($string);
    }

    public function startTransaction(){
        $this->con->begin_transaction();
    }

    public function endTransaction(){
        $this->con->commit();
    }

    public function rollback(){
        $this->con->rollback();
    }

    /**
     * Funzione che esegue una Query nel DB
     * @param $procedure
     * @return array
     */
    public function executeQuery($query)  {
        // Execute Query
        include_once './db_connect.php';
        //$query = "INSERT INTO persona VALUES (null,'a','b','1900-12-30','dsdasdasd')";
        $result = mysqli_query($this->con, $query);
        //$result = mysqli_query($this->con, "INSERT INTO persona VALUES (null,null,null,null,null)");
        $outResult = array();
        if ($result) {
            $this->con->next_result();            // flush the null RS from the call
            //$i=0;
            //$j=0;

            if ($rs = mysqli_store_result($this->con)) {
                //printf( "<b>Result #%u</b>:<br/>", ++$results );
                while( $row = $rs->fetch_row() ) {
                    /*foreach( $row as $cell ) {
                        if (is_null($cell))
                            $row[$j] = "";
                        //$outResult[][] = $cell;
                        $j++;
                    */
                }
                $outResult["response"][] = $row;
                //$i++;
                //$j=0;
            }
            $rs->free();
            $outResult ["state"] = true;
            $outResult ["text"] = "";
            //if( mysqli_more_results($this->con) )
            //    $outResult[$i][$j]="Fine";
        }
        else {
            if (mysqli_errno($this->con) == 1062) {
                // Duplicate key - Primary Key Violation
                //echo "Primary violation";
                $outResult ["state"] = false;
                $outResult ["text"] = "Primary violation";
            } else {
                // For other errors
                //echo "Other errors in query";
                $outResult  ["state"] = false;
                $outResult  ["text"] = "Characters not valids !!";
            }
        }
        return $outResult;
    }

    /**
     * Funzione che esegue una Stored Procedure nel DB
     * @param $procedure
     * @return array
     */
    public function executeProcedure($procedure)  {
        // Execute Query
        include_once './db_connect.php';
        //$query = "INSERT INTO persona VALUES (null,'a','b','1900-12-30','dsdasdasd')";
        $result = mysqli_multi_query($this->con, $procedure);
        //$result = mysqli_query($this->con, "INSERT INTO persona VALUES (null,null,null,null,null)");
        $outResult = array();
        if ($result) {
            $this->con->next_result();            // flush the null RS from the call
            //$i=0;
            $j=0;

            if ($rs = mysqli_store_result($this->con)) {
                //printf( "<b>Result #%u</b>:<br/>", ++$results );
                while( $row = $rs->fetch_row() ) {
                    foreach( $row as $cell ) {
                        if (is_null($cell))
                            $row[$j] = "";
                        //$outResult[][] = $cell;
                        $j++;
                    }
                    $outResult["response"][] = $row;
                    //$i++;
                    $j=0;
                }
                $rs->free();
                //if( mysqli_more_results($this->con) )
                //    $outResult[$i][$j]="Fine";
            }
            mysqli_next_result($this->con);
            $rs = mysqli_store_result($this->con);       // get the RS containing the id
            //Se c'è un result vuol dire che non è stata restituita una tabella
            if ($rs) {
                $outResult ["state"] = $outResult["response"][0][0];
                //$outResult["response"] = null;
                $outResult["response"][0][0]="";
                $outResult ["text"] = ($rs->fetch_object()->mess);
            }
            else {
                mysqli_next_result($this->con);
                $rs = mysqli_store_result($this->con);
                //$outResult [$i][$j]= $rs->fetch_row();
                $outResult ["state"] = $rs->fetch_object()->res;
                $rs->free();
                mysqli_next_result($this->con);
                $rs = mysqli_store_result($this->con);
                $outResult ["text"] = ($rs->fetch_object()->mess);
            }

        } else {
            $i=1;
            if (mysqli_errno($this->con) == 1062) {
                // Duplicate key - Primary Key Violation
                //echo "Primary violation";
                $outResult ["state"] = "0";
                $outResult ["text"] = "Primary violation";
            } else {
                // For other errors
                //echo "Other errors in query";
                $outResult  ["state"] = "0";
                $outResult  ["text"] = "Characters not valids !!";
            }
        }
        return $outResult;
    }
}
?>

