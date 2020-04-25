<?php
include "include/navbar.php";
include "include/header.php";
include "db/db_connect.php";


$user = isset($_GET['user']) ? $_GET['user'] : 'Manage';


//create page
if ($user == 'Manage') {
    $stmt = $con->prepare("SELECT * FROM user ");

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
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>email</th>
                                    <th>Date</th>
                                    <th>Control</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                foreach ($row as $rows) {

                                    ?>
                                    <tr>

                                        <?php echo "<td>" . $rows['UserID'] . "</td>"; ?>
                                        <?php echo "<td>" . $rows['FullName'] . "</td>"; ?>
                                        <?php echo "<td>" . $rows['Email'] . "</td>"; ?>
                                        <?php echo "<td>" . $rows['Phone'] . "</td>"; ?>
                                        <?php echo "<td>" . $rows['create_Date'] . "</td>"; ?>
                                        <td>

                                            <a href="manage_user?user=edit&userid=<?php echo $rows['UserID'] ?>"><i class="fas fa-edit" style="font-size: 22px"></i></a>
                                            <a href="manage_user.php?user=delete&userid=<?php echo $rows['UserID']  ?>"> <i class="fas fa-trash-alt" style="color: #f05050;font-size: 22px"></i></a>
                                            <a href="manage_user.php?user=actvite&userid=<?php echo $rows['UserID']  ?>"><i class="fas fas fa-cubes" style="color: #41f0b4;font-size: 22px"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                } ?>
                                </tbody>


                            </table>
                            <div class="card-body">
                                <a href='manage_user.php?user=Add' class="btn btn-info"><i class="fa fa-plus"></i> Add Users </a>
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
                            <h4 class="card-title">Personal Info</h4>
                            <div class="form-group row">
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Full Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="fname" id="fname" placeholder="Full Name Here">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lname" class="col-sm-3 text-right control-label col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Here">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Last Name Here">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lname" class="col-sm-3 text-right control-label col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sos" id="pass" placeholder="Password Here">
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                  <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                            Add New User
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
        $full_name = $_POST['fname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $Password = $_POST['sos'];
//        echo  $full_name. $email .$phone.$Password;
        $sql="INSERT INTO `user`(`FullName`, `Email`, `Password`, `Phone`) 
                 VALUES (:name,:email,:pass,:phone)";
        $stmt=$con->prepare($sql);
        $stmt->execute(['name'=>$full_name,'email'=>$email,'pass'=>$Password,'phone'=>$phone]);





        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record insert</div>';


    }

}
elseif ($user=='edit') {
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `user` WHERE UserID =? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($stmt->rowCount() > 0) {
        echo '
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
                                    <input type="text" class="form-control" name="fname" value=' .$row['FullName'].' id="fname" placeholder="Full Name Here">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lname" class="col-sm-3 text-right control-label col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="phone"value='.$row['Phone'] .' id="phone" placeholder="Phone Here">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" value='.$row['Email'].' id="email" placeholder="Last Name Here">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lname" class="col-sm-3 text-right control-label col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sos" value='.$row['Password'].' id="pass" placeholder="Password Here">
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

    </div>';

    }


}


elseif ($user=='update') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userid = $_POST['userid'];
        $full_name = $_POST['fname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $Password = $_POST['sos'];

        //        update to database
        $stmt = $con->prepare("UPDATE user SET FullName= ?,Email= ?,Password=?,Phone=? WHERE UserID=?");
        $stmt->execute(array($full_name, $email,$Password, $phone, $userid));

       echo  "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Update</div>';



    }
}



elseif ($user=='delete'){

//        database delete


    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `user` WHERE UserID =?  LIMIT 1");
    $stmt->execute(array($userid));

    $count = $stmt->rowCount();



    if ($stmt->rowCount() > 0) {

        $stmt=$con->prepare("DELETE FROM user WHERE UserID=:zuser");
        $stmt->bindParam(":zuser",$userid);
        $stmt->execute();

        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Delete</div>';


    }else{
        "this id is not exist";
    }

    redirectHome(6);
}

elseif ($user=='actvite'){
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `user` WHERE UserID =?  LIMIT 1");
    $stmt->execute(array($userid));

    $count = $stmt->rowCount();



    if ($stmt->rowCount() > 0) {

        $stmt=$con->prepare("UPDATE user SET GroupID=1 WHERE UserID =? ");

        $stmt->execute(array($userid));

       echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record active</div>';

    }




}












include "include/footer.php";

