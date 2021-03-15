<?php
    
    namespace classes;

    class Database
    {
        private $host = "localhost";
        private $dbname = "testing";
        private $user = "root";
        private $pass = "";

        public function connect(){
            return new \PDO("mysql:host={$this -> host};dbname={$this -> dbname}", $this -> user, $this -> pass);
        }
    }

?>