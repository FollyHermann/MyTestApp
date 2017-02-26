<?php
require("Log.class.php");

class DB_Crud 
{

    # @object, The PDO object
    private $db;

    # @object, PDO statement object
    private $sQuery;

    # @array,  The database settings
    private $settings;

    # @bool ,  Connected to the database
    private $bConnected = false;

    # @bool ,  query execution success
    private $bSuccess = false;

    # @object, Object for logging exceptions
    private $log;

    # @array, The parameters of the SQL query
    private $parameters;

    public $currentSql;

    public $serverName;
    public $serverSelf;

    public function __construct()
    {
        $this->log = new Log();
        $this->Connect();
        $this->parameters = array();
        //$this->currentUrl = $_SERVER['SERVER_NAME'] .':8080'. $_SERVER['PHP_SELF'];
        $this->serverName = $_SERVER['SERVER_NAME'];
        $this->serverSelf = $_SERVER['PHP_SELF'];

    }

    private function Connect()
    {
        $this->settings = parse_ini_file("settings.ini.php");
        //$cnx = new PDO("sqlsrv:server= $hostname; Database=$db_name", $username, $password);

        $dsn = 'mysql:dbname='.$this->settings["dbname"].';host='.$this->settings["host"].'';
        //$dsn = 'sqlsrv:server='.$this->settings["host"].'; Database='.$this->settings["dbname"].'';
        try
        {
            $mysql_options =
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];

            $this->db = new PDO($dsn,
                $this->settings["user"],
                $this->settings["password"],
                $mysql_options);

            # Connection succeeded, set the boolean to true.
            $this->bConnected = true;
        }
        catch (PDOException $e)
        {
            # Write into log
            echo $this->ExceptionLog($e->getMessage());
            die();
        }
    }

    public function CloseConnection()
    {
        $this->db = null;
    }

    private function ExceptionLog($message , $sql = "")
    {
        $exception  = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";

        if(!empty($sql)) {
            # Add the Raw SQL to the Log
            $message .= "\r\nRaw SQL : "  . $sql;
        }
        # Write into log
        $this->log->write($message);

        return $exception;
    }

    public function insert($table, $bindings)
    {
        $fields = array_keys($bindings);
        $fields_array = implode(",", $fields);
        $values = " VALUES ('".implode("', '", $bindings)."') ";

        $sql = "INSERT INTO $table (".$fields_array.") $values";

        if($this->executeQuery($sql))
        { return true; }
        else {return false; }

    }

    public function get($table)
    {
        $sql = "SELECT * FROM " . $table;
        $query = $this->db->prepare( $sql );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRowOf($table)
    {
        $sql = "SELECT * FROM " . $table . $this->currentSql;
        $data = $this->db->query($sql);
        return $data->fetch();

    }

    public function orderBy($orderColumn, $orderMethod)
    {
        $this->currentSql = " ORDER BY " . $orderColumn . " " .$orderMethod;
    }

    public function where($pk, $value)
    {
        $this->currentSql = " WHERE " . $pk . " = '{$value}'";
        //return " WHERE " . $pk . " = {$value}";
    }

    public function whereMultiple($pk_1, $value_1, $pk_2, $value_2)
    {
        $this->currentSql = " WHERE " . $pk_1 . " = '{$value_1}' AND " . $pk_2 . " = '{$value_2}'";
    }

    public function getWhere($table, $pk, $pkValue)
    {
        $sql = "SELECT * FROM " .$table. " WHERE " .$pk. " = '{$pkValue}'";

        $data = $this->db->query($sql);
        return $data;
    }

    public function getColumn($column,$table, $pk, $pkValue)
    {
        $sql = "SELECT ".$column." FROM " .$table. " WHERE " .$pk. " = '{$pkValue}'";
        $data = $this->db->query($sql);
        return $data->fetch();
    }
    public function getNameOf($id)
    {
        $sql = "SELECT name FROM staff WHERE staff_id = '{$id}'";
        $data = $this->db->query($sql);
        return $data->fetch();
    }

    public function leftJoin($table_1, $table_2, $on)
    {
       $this->currentSql =  " FROM " . $table_1 . " INNER JOIN " . $table_2 . " ON " . $on ;
    }

    public function selectRows($table_1_rows, $table_2_rows)
    {
        $sql = "SELECT " . $table_1_rows. ", ". $table_2_rows. $this->currentSql;
        $data = $this->db->query($sql);
        $this->currentSql = null;
        return $data;

    }

    public function getSelectAll($sql)
    {
        //return $this->db->query($sql);
        $query = $this->db->prepare( $sql );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function executeQuery($query)
    {
        # Connect to database
        if(!$this->bConnected) { $this->Connect(); }
        try
        {
            $success = $this->db->exec($query);
            return $success;
        }
        catch(PDOException $e)
        {
            # Write into log and display Exception
            echo $this->ExceptionLog($e->getMessage(), $query );
            die();
        }

    }

    public function formatCode($table, $id, $number)
    {
        $sql = "SELECT max(".$id.") AS maxID FROM ".$table." ";
        $max_ix = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        $id = $max_ix['maxID'] + 1;
        $value =  str_pad($id, $number, '0', STR_PAD_LEFT);
        return $value;
    }

    public function update($table, $bindings)
    {

        foreach ($bindings as $column => $value)
        {
            $valstr[] = $column.' = ' .'"' .$value .'"' ;
        }

        $valstr = str_replace("'",'"',$valstr);

        $sql = 'UPDATE ' .$table. ' SET '.implode(', ', $valstr) .$this->currentSql ;
        $this->currentSql=null;
        if($this->executeQuery($sql))
            return true;
            return false;

    }

    public function delete($table)
    {
        $sql = "DELETE FROM " . $table ." " .$this->currentSql;
        $this->currentSql=null;
        if($this->executeQuery($sql))
        { return true; }
        else {return false; }
    }

    private function Init($query,$parameters = "")
    {
        # Connect to database
        if(!$this->bConnected) { $this->Connect(); }
        try {
            # Prepare query
            $this->sQuery = $this->pdo->prepare($query);

            # Add parameters to the parameter array	
            $this->bindMore($parameters);

            # Bind parameters
            if(!empty($this->parameters)) {
                foreach($this->parameters as $param)
                {
                    $parameters = explode("\x7F",$param);
                    $this->sQuery->bindParam($parameters[0],$parameters[1]);
                }
            }

            # Execute SQL 
            $this->succes 	= $this->sQuery->execute();
        }
        catch(PDOException $e)
        {
            # Write into log and display Exception
            echo $this->ExceptionLog($e->getMessage(), $query );
            die();
        }

        # Reset the parameters
        $this->parameters = array();
    }
    
    public function bind($para, $value)
    {
        $this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . $value;
    }

    public function bindMore($parray)
    {
        if(empty($this->parameters) && is_array($parray)) {
            $columns = array_keys($parray);
            foreach($columns as $i => &$column)	{
                $this->bind($column, $parray[$column]);
            }
        }
    }

    public function query($query,$params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        $query = trim($query);

        $this->Init($query,$params);

        $rawStatement = explode(" ", $query);

        # Which SQL statement is used 
        $statement = strtolower($rawStatement[0]);

        if ($statement === 'select' || $statement === 'show') {
            return $this->sQuery->fetchAll($fetchmode);
        }
        elseif ( $statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ) {
            return $this->sQuery->rowCount();
        }
        else {
            return NULL;
        }
    }

    public function column($query,$params = null)
    {
        $this->Init($query,$params);
        $Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);

        $column = null;

        foreach($Columns as $cells) {
            $column[] = $cells[0];
        }

        return $column;

    }

    public function row($query,$params = null,$fetchmode = PDO::FETCH_ASSOC)
    {
        $this->Init($query,$params);
        return $this->sQuery->fetch($fetchmode);
    }

    public function single($query,$params = null)
    {
        $this->Init($query,$params);
        return $this->sQuery->fetchColumn();
    }


}