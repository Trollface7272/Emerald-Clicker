<?php
    class Database 
    {

        private $mysqli;

        private $server = "remotemysql.com";
        private $user = "cldhl9QKa9";
        private $password = "xF2D0SXPJL";
        private $database = "cldhl9QKa9";


        public function __construct()
        {
            $this->mysqli = new mysqli(
                            $this->server,
                            $this->user, 
                            $this->password, 
                            $this->database);
        }

        public function isConnected()
        {
            return $this->mysqli->connect_error == "";
        }

        public function insertData($table, $collumns, $values)
        {
            $sql = "INSERT INTO $table ($collumns) VALUES ('$values')";
            if($this->mysqli->query($sql) === TRUE)
                return TRUE;
            return FALSE;
        }
    }
?>