<?php
    
    namespace classes;

    class App
    {
        private $request;
        private $answer;
        private $errors;

        public function __construct(){
            $this -> errors = [];
            $this -> answer = new Answer();
            $this -> request = new Request();            
        }        

        public function go(){
            $this -> checkRequest();
            if(!$this -> checkErrors()){
                $product = new Product($this -> request);
                $product -> setData();
                $this -> errors = $product -> getErrors();
                if(!$this -> checkErrors()){
                    $this -> answer -> createSuccessAnswer($product -> getData());
                } 
            }
            $this -> answer -> send();

        }

        public function getRequest(){
            return $this -> request;
        }

        private function checkRequest(){
            if(!isset($this -> request -> getPost()["request"])){
                $this -> errors[] = 'Нет переменной request в POST-запросе';
            }
        }

        private function checkErrors(){
            if(!empty($this -> errors)){
                $this -> answer -> createFailAnswer($this -> errors);
                return true;
            }
            else{
                return false;
            }
        }
    }

?>