

  
<?php




$con= new PDO("mysql:host=localhost;dbname=news","root","");
$con->exec("set character_set_server='utf8'");
    $con->exec("set names 'utf8'");
    return $con;



?>