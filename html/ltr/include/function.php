<?php





// homw redirect function

    function redirectHome($errorMsg, $seconds = 3)
    {
        echo "<div class='alert alert-danger'>$errorMsg</div>";
        echo "<div class='alert alert-info'>You Will Be Redirected To HomePage After $seconds Secinds.</div>";
        header("refresh:$seconds;url=dash.php");
        exit();


    }
//
////conut number of itrm function
//    function countitem($item, $table)
//    {
//
//        global $con;
//        $stmt3 = $con->prepare("SELECT COUNT($item) FROM $table");
//        $stmt3->execute();
//        return $stmt3->fetchColumn();
//
//    }
//
//
////
//    function checkItem($select, $from, $value)
//    {
//        global $con;
//        $statment = $con->prepare("select $select from $from WHERE $select = ?");
//        $statment->execute(array($value));
//        $count = $statment->rowCount();
//        return $count;
//    }
//
