<?php

    namespace classes;

    class Answer
    {
        private $statusMessages = [
            "success" => "ok",
            "fail" => "fail",
        ];
        private $data;
        private $answer;

        public function __construct(){
            $this -> data = [];
            $this -> answer = [];
        }

        public function createSuccessAnswer($data){
            $this -> answer["status"] = $this -> statusMessages["success"];
            $this -> answer["data"] = $data;
        }

        public function createFailAnswer($errors){
            $this -> answer["status"] = $this -> statusMessages["fail"];
            $this -> answer["data"]["errors"] = $errors;
        }

        public function send(){
            echo json_encode($this -> answer, JSON_UNESCAPED_UNICODE) . "<br>";
        }

        
    }

?>