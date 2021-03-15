<?php   
    
    $request1 = '{"action":"getAll","data":{}}';
    $request2 = '{"action":"getOne","data":{"id":1}}';
    $request3 = '{"action":"addOne","data":{"name":"Продукт №3", "article":"1020","category":"Категория №4", "price": "480"}}';
    $request4 = '{"action":"edit","data":{"id":"1" ,"name":"Продукт №3", "article":"1021","category":"Категория №4", "price": "480"}}';
    $request5 = '{"action":"getAll","data":{"pageNumber":"1", "countOnPage":"2", "filter":"Категория №4"}}';
    $request6 = '{"action":"getAll","data":{"filter":"Категория №1"}}';
    $request7 = '{"action":"getCountByCategoriies","data":{}}';

    $request8 = '{}';
    $request9 = '{"action":"getdsfgsdfgegoriies","data":[]}';
    $request10 = '{"action":[],"data":[]}';
    $request11 = '{"action":"addOne","data":{"name":"Продукт №3", "article":"1020","category":"Категория №4", "price": "480"}}';

    $_POST["request"] = $request11;

    function __autoload($class){
        include_once $class . ".php";
    }

    $app = new classes\App();
    $app -> go();

    for($i = 1; $i < 12; $i++){
        $str = "request" . $i;

        $_POST["request"] = $$str;

        $app = new classes\App();
        $app -> go();
    }
?>