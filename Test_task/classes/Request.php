<?php

    namespace classes;

    class Request
    {
        private $get;
        private $post;
        private $route = [
            "getAll" => [
                "method" => "getAll",
                "params" => [
                ],
            ],
            "getCountByCategoriies" => [
                "method" => "getCountByCategoriies",
                "params" => [
                ],
            ],
            "getOne" => [
                "method" => "getOne",
                "params" => [
                    "id",
                ],
            ],
            "addOne" => [
                "method" => "addOne",
                "params" => [
                    "article",
                    "name",
                    "category",
                    "price",
                ],
            ],
            "edit" => [
                "method" => "edit",
                "params" => [
                    "id",
                    "article",
                    "name",
                    "category",
                    "price",
                ],
            ],
        ];
        private $validatorParams = [
            "name" => [
                "notEmpty",
            ],
            "article" => [
                "notEmpty",
                "isNumber",
            ],
            "price" => [
                "notEmpty",
                "isNumber",
                "notLessZero"
            ],
            "category" => [
                "notEmpty",
            ],
            "pageNumber" => [
                "isNumber",
                "positive",
            ],
            "countOnPage" => [
                "isNumber",
                "positive",
            ]
        ];

        public function __construct(){
            $this -> get = $_GET;
            $this -> post = $_POST;
        }

        public function getPost(){
            return $this -> post;
        }

        public function getRoute(){
        return $this -> route; 
        }

        public function getValidatorParams(){
            return $this -> validatorParams;
        }
    }

?>