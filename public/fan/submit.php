<?php
$pdata = $_REQUEST;
$fieldString = http_build_query($pdata);
$purl = "http://api.youpay.chongxiaole.net/submit.php". "?" . $fieldString ;
$data = file_get_contents($purl);
echo $data;