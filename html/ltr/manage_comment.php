<?php
session_start();
include "include/navbar.php";
include "include/header.php";
include "db/db_connect.php";
$user = isset($_GET['user']) ? $_GET['user'] : 'Manage';


//create page
if ($user == 'Manage') {
    $stmt = $con->prepare("SELECT  
comment.*,posts.post_title AS item,userss.FullName AS Name FROM `comment`
 INNER JOIN posts ON posts.post_id=comment.post_id 
 INNER JOIN userss ON userss.UserID=comment.user_id ");

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
                                <th>Comment</th>
                                <th>Item Comment</th>
                                <th>Date Comment</th>
                                <th>User comment</th>
                                <th>Control</th>

                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            foreach ($row as $rows) {

                                ?>
                                <tr>

                                    <?php echo "<td>" . $rows['comm_id'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['comm_text'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['item'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['comm_date'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['Name'] . "</td>"; ?>


                                    <td>

                                        <a href="manage_comment?user=edit&userid=<?php echo $rows['comm_id'] ?>"><i class="fas fa-edit" style="font-size: 22px"></i></a>
                                        <a href="manage_new.php?user=delete&userid=<?php echo $rows['post_id']  ?>"> <i class="fas fa-trash-alt" style="color: #f05050;font-size: 22px"></i></a>
                                        <a href="manage_comment.php?user=actvite&userid=<?php echo $rows['post_id']  ?>"><i class="fas fas fa-cubes" style="color: #41f0b4;font-size: 22px"></i></a>
                                    </td>
                                </tr>
                                <?php
                            } ?>
                            </tbody>


                        </table>
                        <div class="card-body">
                            <a href='manage_commentphp?user=edit' class="btn btn-primary"><i class="fa fa-plus"></i> Add News </a>
                        </div>



                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
}




elseif ($user=='ss') {
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `user` WHERE UserID =? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($stmt->rowCount() > 0) {
      ?>
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <form class="form-horizontal" action="?user=update"  method="post">
                        <div class="card-body">
                            <h4 class="card-title">Personal Info</h4>
                              <input type="hidden" name="userid" value='.$userid.'>
                            <div class="form-group row">
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Full Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="fname" id="fname" placeholder="Full Name Here">
                                </div>
                            </div>

                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                  <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                            Add New Category
                        </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
        <?php

    }


}



elseif ($user=='update') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userid=$_POST['userid'];
        $comment = $_POST['comment'];


        //        update to database
        $stmt = $con->prepare("UPDATE comment SET comm_text= ?,post_intro= ? WHERE UserID=?");
        $stmt->execute(array($comment, $userid));

        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Update</div>';


    }
}



elseif ($user=='delete'){

//        database delete


    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `post` WHERE post_id =?  LIMIT 1");
    $stmt->execute(array($userid));

    $count = $stmt->rowCount();



    if ($stmt->rowCount() > 0) {

        $stmt=$con->prepare("DELETE FROM post WHERE post_id=:zpost");
        $stmt->bindParam(":zpost",$userid);
        $stmt->execute();

        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Delete</div>';

    }else{
        "this id is not exist";
    }
}

elseif ($user=='actvite'){
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `post` WHERE post_id =?  LIMIT 1");
    $stmt->execute(array($userid));

    $count = $stmt->rowCount();

    if ($stmt->rowCount() > 0) {

        $stmt=$con->prepare("UPDATE post SET post_status=1 && post_status=0 WHERE post_id =? ");

        $stmt->execute(array($userid));

        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record active</div>';


    }
}












include "include/footer.php";

