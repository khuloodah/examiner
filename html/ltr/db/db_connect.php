<?php

define("DSN","mysql:host=localhost;dbname=news;charset=utf8");
define("USER","root");
define("PASS","");

$opts=array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");

try{
    $con=new PDO(DSN,USER,PASS,$opts);

}
catch(PDOException $x){
    exit($x->getMessage());

}
?>