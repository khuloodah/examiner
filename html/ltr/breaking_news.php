<?php
session_start();
include "include/navbar.php";
include "include/header.php";
include "db/db_connect.php";


$user = isset($_GET['user']) ? $_GET['user'] : 'Manage';


//create page
if ($user == 'Manage') {
    $stmt = $con->prepare("SELECT * FROM `breaking_news` ");

    $stmt->execute();

    $row = $stmt->fetchAll();

    ?>


    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->

    <!-- ============================================================== -->
    <div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Basic Datatable</h5>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>

                            <tr>
                                <th>#</th>
                                <th>preak_content</th>
                                <th>start_date</th>
                                <th>end_date</th>
                                <th>Create By</th>
                                <th>Control</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            foreach ($row as $rows) {

                                ?>
                                <tr>

                                    <?php echo "<td>" . $rows['break_id'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['preak_content'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['start_date'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['end_date'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['create_by'] . "</td>"; ?>
                                    <td>

                                        <a href="breaking_news.php?user=edit&userid=<?php echo $rows['break_id'] ?>"><i class="fas fa-edit" style="font-size: 22px"></i></a>
                                        <a href="breaking_news.php?user=delete&userid=<?php echo $rows['break_id']  ?>"> <i class="fas fa-trash-alt" style="color: #f05050;font-size: 22px"></i></a>
                                        <a href="breaking_news.php?user=actvite&userid=<?php echo $rows['break_id']  ?>"><i class="fas fas fa-cubes" style="color: #41f0b4;font-size: 22px"></i></a>
                                    </td>
                                </tr>
                                <?php
                            } ?>
                            </tbody>


                        </table>
                        <div class="card-body">
                            <a href='breaking_news.php?user=Add' class="btn btn-primary"><i class="fa fa-plus"></i> Add breaking_news </a>
                        </div>



                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
}
elseif ($user=='Add') {

    echo '
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <form class="form-horizontal" action="?user=Insert" method="post">
                        <div class="card-body">
                            <h4 class="card-title">preak_content Info</h4>
                            <div class="form-group row">
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label">preak_content</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="preak_content" id="preak_content" placeholder="preak_content Here">
                                </div>
                            </div>
                       
                           

                        <div class="border-top">
                            <div class="card-body">
                                  <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                            Add New break
                        </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>';
}
elseif ($user=='Insert') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $preak_content = $_POST['preak_content'];
        $create_by=   $_SESSION['ID'];

//        echo  $full_name. $email .$phone.$Password;
        $sql="INSERT INTO `breaking_news`( `preak_content`,`create_by` )
                 VALUES (:preak_content,:zcreate)";
        $stmt=$con->prepare($sql);
        $stmt->execute(['preak_content'=>$preak_content,'zcreate'=>$create_by]);





        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record insert</div>';


    }

}
elseif ($user=='edit') {
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `breaking_news` WHERE break_id =? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($stmt->rowCount() > 0) {
        echo '
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <form class="form-horizontal" action="?user=update" method="post">
                        <div class="card-body">
                            <h4 class="card-title">preak_content Info</h4>
                            <input type="hidden" name="userid" value='.$userid.'>
                            <div class="form-group row">
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label">preak_content</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="preak_content" value='.$row['preak_content'].' id="preak_content" placeholder="preak_content Here">
                                </div>
                            </div>
                       
                           

                        <div class="border-top">
                            <div class="card-body">
                                  <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                            Add New break
                        </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>';
    }


}


elseif ($user=='update') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userid = $_POST['userid'];

        $preak_content = $_POST['preak_content'];

        //        update to database
        $stmt = $con->prepare("UPDATE breaking_news SET preak_content=? WHERE break_id=?");
        $stmt->execute(array($preak_content, $userid));

        echo  "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Update</div>';



    }
}



elseif ($user=='delete'){

//        database delete


    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `breaking_news` WHERE break_id =?  LIMIT 1");
    $stmt->execute(array($userid));

    $count = $stmt->rowCount();



    if ($stmt->rowCount() > 0) {

        $stmt=$con->prepare("DELETE FROM breaking_news WHERE break_id=:zbreak");
        $stmt->bindParam(":zbreak",$userid);
        $stmt->execute();



    }
    echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Delete</div>';

}

elseif ($user=='actvite'){
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `breaking_news` WHERE break_id =?  LIMIT 1");
    $stmt->execute(array($userid));

    $count = $stmt->rowCount();



    if ($stmt->rowCount() > 0) {

        $stmt=$con->prepare("UPDATE breaking_news SET GroupID=1 WHERE break_id =? ");

        $stmt->execute(array($userid));

        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record active</div>';

    }




}

include "include/footer.php";

