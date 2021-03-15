<?php

    namespace classes;

    class Product
    {
        private $request;
        private $requestToArray;
        private $table_name = "products";
        private $database;
        private $action;
        private $method;
        private $data;
        private $errors;

        public function __construct($request){
            $this -> data = [];
            $this -> errors = [];
            $this -> request = $request;
            $this -> requestToArray = json_decode($request -> getPost()["request"], true);

            if($this -> requestToArray === null){
                $this -> errors[] = "Некорректный JSON-запрос.";
                return;
            }

            $this -> database = new Database();
        }

         public function setData(){

            $this -> checkRequest();

            if(!empty($this -> errors)){
                return;
            }

            $this -> action = $this -> requestToArray["action"];
            $this -> method = $this -> request -> getRoute()[$this -> action]["method"];

            if(!$this -> checkParams()){
                return;
            }

            $this -> {$this -> method}();
        }

        public function getData(){
            return $this -> data;
        }

        public function getAll(){

            if (!$this -> validateParams()){
                return;
            }

            $limit = "";
            $filter = "";

            if(isset($this -> requestToArray["data"]["pageNumber"]) && isset($this -> requestToArray["data"]["countOnPage"])){

                $firstPos =  ((($this -> requestToArray["data"]["pageNumber"] - 1) * $this -> requestToArray["data"]["countOnPage"]));
                $count = $this -> requestToArray["data"]["countOnPage"];
                $limit = "LIMIT $firstPos, $count";

            }

            if(isset($this -> requestToArray["data"]["filter"])){
                $filter = "WHERE category = '{$this -> requestToArray["data"]["filter"]}'";
            }

            $connect = $this -> database -> connect();
            $query = "SELECT * FROM {$this -> table_name} $filter $limit";

            $preQuery = $connect -> prepare($query);
            $preQuery -> execute();
            $result = $preQuery -> fetchAll(\PDO::FETCH_ASSOC);

            $this -> data["products"] = $result;
        }

        public function getCountByCategoriies(){

            $connect = $this -> database -> connect();
            $query = "SELECT DISTINCT category FROM {$this -> table_name} ORDER BY category";

            $preQuery = $connect -> prepare($query);
            $preQuery -> execute();
            $result = $preQuery -> fetchAll(\PDO::FETCH_ASSOC);

            $this -> data["categories"] = [];

            foreach ($result as $value) {
                $query = "SELECT COUNT(*) as count FROM {$this -> table_name} WHERE category = '{$value["category"]}'";
                $preQuery = $connect -> prepare($query);
                $preQuery -> execute();
                $count = $preQuery -> fetch(\PDO::FETCH_ASSOC)["count"];

                $this -> data["categories"][] = [$value["category"], $count];
            }
        }

        public function getOne(){

            $connect = $this -> database -> connect();
            $query = "SELECT * FROM {$this -> table_name} WHERE id={$this -> requestToArray['data']['id']}";

            $preQuery = $connect -> prepare($query);
            $preQuery -> execute();
            $result = $preQuery -> fetch(\PDO::FETCH_ASSOC);

            if($result === false){
                $this -> errors[] = "Продукт по данному id не найден.";
                return;
            }

            $this -> data["product"] = $result;
        }

        public function addOne(){

            if (!$this -> validateParams()){
                return;
            }

            if($this -> articleIsExists($this -> requestToArray["data"]["article"])){
                return;
            }

            $connect = $this -> database -> connect();
            $query = "INSERT INTO {$this -> table_name}(`article`, `name`, `price`, `category`) VALUES (
                           '{$this -> requestToArray["data"]["article"]}',
                           '{$this -> requestToArray["data"]["name"]}',
                           '{$this -> requestToArray["data"]["price"]}',
                           '{$this -> requestToArray["data"]["category"]}'
                       )";
            $preQuery = $connect -> prepare($query);
            if($preQuery -> execute()){
                $this -> data["message"] = "Добавлено.";
            }

        }

        private function edit(){

            if (!$this -> productIsExists($this -> requestToArray["data"]["id"])){
                $this -> errors = "Данной позиции не существует.";
            }
            if($this -> articleIsExists($this -> requestToArray["data"]["article"])){
                return;
            }

            $connect = $this -> database -> connect();
            $query = "UPDATE {$this -> table_name} SET 
                article = '{$this -> requestToArray["data"]["article"]}',
                name = '{$this -> requestToArray["data"]["name"]}',
                category = '{$this -> requestToArray["data"]["category"]}',
                price = '{$this -> requestToArray["data"]["price"]}'
            WHERE id= {$this -> requestToArray["data"]["id"]}";
            $preQuery = $connect -> prepare($query);

            if($preQuery -> execute()){
                $this -> data["message"] = "Обновлено.";
            }
        }

        private function productIsExists($id){
            $connect = $this -> database -> connect();
            $query = "SELECT * FROM {$this -> table_name} WHERE id='{$id}'";
            $preQuery = $connect -> prepare($query);
            $preQuery -> execute();
            $result = $preQuery -> fetch(\PDO::FETCH_ASSOC);
            if($result === false){
                return false;
            }
            return true;
        }

        private function articleIsExists($article){

            $connect = $this -> database -> connect();
            $query = "SELECT * FROM {$this -> table_name} WHERE article='{$article}'";

            $preQuery = $connect -> prepare($query);
            $preQuery -> execute();
            $result = $preQuery -> fetch(\PDO::FETCH_ASSOC);

            if($result !== false){
                $this -> errors[] = "Позиция с таким артикулом существует.";
                return true;
            }
            return false;
        }

        public function getErrors(){
            return $this -> errors;
        }

        private function checkRequest(){
            if(!empty($this -> errors)){
                return;
            }

            if(!isset($this -> requestToArray["action"])){
                $this -> errors[] = "Нет параметра action в запросе.";
            }
            elseif(gettype($this -> requestToArray["action"]) !== "string"){
                $this -> errors[] = "Параметр action должен быть строкой.";
            }
            elseif(!array_key_exists($this -> requestToArray["action"], $this -> request -> getRoute())){
                $this -> errors[] = "Заданного в параметре action действия не предусмотренно.";
            }

            if(!isset($this -> requestToArray["data"])){
                $this -> errors[] = "Нет параметра data в запросе.";
            }
            elseif(!is_array($this -> requestToArray["data"])){
                $this -> errors[] = "Параметр data должен быть массивом.";
            }
        }

        private function checkParams(){
            $params = $this -> request -> getRoute()[$this -> action]["params"];
            foreach ($params as $param) {
                if(!array_key_exists($param, $this -> requestToArray["data"])){
                    $this -> errors[] = "Отсутствует обязательный параметр {$param} в запросе";
                }
            }
            if(!empty($this -> errors)){
                return false;
            }
            else{
                return true;
            }
        }

        private function validateParams(){
            $flag = true;
            $validateOptions = [];
            foreach ($this -> requestToArray["data"] as $key => $value) {
                if(array_key_exists($key, $this -> request -> getValidatorParams())){

                    $validateOptions = $this -> request -> getValidatorParams()[$key];
                    if(in_array("notEmpty", $validateOptions)){

                        if(trim($value) == "" || trim($value) == null){
                            $this -> errors[] = "Параметр $key не должен быть пустым.";
                            $flag = false; 
                        }
                    }
                    if(in_array("isNumber", $validateOptions)){
                        if(!is_numeric(trim($value))){
                            $this -> errors[] = "Параметр $key должен быть числом.";
                            $flag = false;
                        }
                        if(in_array("notLessZero", $validateOptions)){
                            if(trim($value) < 0){
                                $this -> errors[] = "Параметр $key неможет быть меньше нуля.";
                                $flag = false; 
                            }
                        }
                        if(in_array("positive", $validateOptions)){
                            if(trim($value) <= 0){
                                $this -> errors[] = "Параметр $key должен быть положительным числом.";
                                $flag = false; 
                            }
                        }
                    }
                }
            }

            return $flag;
        }

    }

?>