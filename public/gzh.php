<?php

 $testxml  = file_get_contents("php://input");

        $jsonxml = json_encode(simplexml_load_string($testxml, 'SimpleXMLElement', LIBXML_NOCDATA));

        $result = json_decode($jsonxml, true);//转成数组，

        file_put_contents("../pay.txt","订单处理返回结果"."3123123".PHP_EOL,FILE_APPEND);

        file_put_contents("../pay.txt","订单处理返回结果".json_encode($result,1).PHP_EOL,FILE_APPEND);

?>