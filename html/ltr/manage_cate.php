<?php
session_start();
include "include/navbar.php";
include "include/header.php";
include "db/db_connect.php";
$user = isset($_GET['user']) ? $_GET['user'] : 'Manage';


//create page
if ($user == 'Manage') {
    $stmt = $con->prepare("SELECT * FROM  categories");

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
                                <th>Name Categories</th>
                                <th>sub_categories</th>
                                <th>Date</th>
                                <th>Create By</th>
                                <th>Control</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            foreach ($row as $rows) {

                                ?>
                                <tr>

                                    <?php echo "<td>" . $rows['cat_id'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['cat_name'] . "</td>"; ?>

                                    <?php echo "<td>" . $rows['parent'] . "</td>";?>
                                    <?php echo "<td>" . $rows['create_date'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['create_by'] . "</td>"; ?>

                                    <td>

                                        <a href="manage_cate?user=edit&userid=<?php echo $rows['cat_id'] ?>"><i class="fas fa-edit" style="font-size: 22px"></i></a>
                                        <a href="manage_cate.php?user=delete&userid=<?php echo $rows['cat_id']  ?>"> <i class="fas fa-trash-alt" style="color: #f05050;font-size: 22px"></i></a>
                                        <a href="manage_cate.php?user=actvite&userid=<?php echo $rows['cat_id']  ?>"><i class="fas fas fa-cubes" style="color: #41f0b4;font-size: 22px"></i></a>
                                    </td>
                                </tr>
                                <?php
                            } ?>
                            </tbody>


                        </table>
                        <div class="card-body">
                            <a href='manage_cate.php?user=Add' class="btn btn-info"><i class="fa fa-plus"></i> Add Users </a>
                        </div>



                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
}
elseif ($user=='Add') {

    echo'
    <div class="container-fluid">

    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <form class="form-horizontal" action="?user=Insert" METHOD="post">
                    <div class="card-body">
                        <h4 class="card-title">Categories Info</h4>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="cate" id="cate" placeholder=" Category Name Here">
                            </div>
                        </div>
                              <div class="form-group row">
                            <label class="col-md-3 m-t-15">Single Select</label>
                            <div class="col-md-9">
                                <select class="select2 form-control custom-select" name="status" style="width: 100%; height:36px;">
                                    <option value="1">active</option>
                                       <option value="0">no active</option>

                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label class="col-md-3 m-t-15">Single Select</label>
                            <div class="col-md-9">
                                <select class="select2 form-control custom-select" name="parent" style="width: 100%; height:36px;">
                                    <option value="0">الرئيسية</option>';?>
    <?php

    $stmt = $con->prepare("SELECT * FROM categories ");
    $stmt->execute();
    $row = $stmt->fetchAll();
    foreach ($row as $rows) {



    echo "<option value=".$rows['cat_id']."> ".$rows['cat_name']." </option>";
}
?>

                                </select>
                            </div>
                        </div>
                    </div>

                 <?php echo '<div class="border-top">
                        <div class="card-body">
                                  <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                            Add New Cate
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
        $name_cate = $_POST['cate'];
        $active_cate = $_POST['status'];
        $sub_cate = $_POST['parent'];
        $create_by=   $_SESSION['ID'];

//            print_r($_POST);
//        echo  $name_cate. $active_cate .$sub_cate;
        $sql="INSERT INTO categories (cat_name,cat_status,parent,create_by) VALUES(:cate,:zstatus,:zsub,:zcreate)";
        $stmt=$con->prepare($sql);
        $stmt->execute(array('cate'=>$name_cate,'zstatus'=>$active_cate,'zsub'=>$sub_cate,'zcreate'=>$create_by));

        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record insert</div>';

    }
}

elseif ($user=='edit') {
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `categories` WHERE cat_id =? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($stmt->rowCount() > 0) {
        echo'
    <div class="container-fluid">

    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <form class="form-horizontal" action="?user=update" METHOD="post">
                    <div class="card-body">
                        <h4 class="card-title">Categories Info</h4>
                         <input type="hidden" name="userid" value='.$userid.'>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value=' .$row['cat_name'].' name="cate" id="cate" placeholder=" Category Name Here">
                            </div>
                        </div>
                              <div class="form-group row">
                            <label class="col-md-3 m-t-15">Active Select</label>
                            <div class="col-md-9">
                                <select class="select2 form-control custom-select" name="status" style="width: 100%; height:36px;">
                                    <option value="1">active</option>
                                       <option value="0">no active</option>

                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label class="col-md-3 m-t-15">Sub</label>
                            <div class="col-md-9">
                                <select class="select2 form-control custom-select" name="parent" style="width: 100%; height:36px;">
                                    <option>Select</option>';?>
        <?php

        $stmt = $con->prepare("SELECT * FROM categories ");
        $stmt->execute();
        $row = $stmt->fetchAll();
        foreach ($row as $rows) {



            echo "<option value=".$rows['cat_id']."> ".$rows['cat_name']." </option>";
        }
        ?>

        </select>
        </div>
        </div>
        </div>

        <?php echo '<div class="border-top">
                        <div class="card-body">
                                  <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                            Add New Cate
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
            $name_cate = $_POST['cate'];
            $active_cate = $_POST['status'];
            $sub_cate = $_POST['parent'];


        //        update to database
        $stmt = $con->prepare("UPDATE categories SET cat_name= ?, 	cat_status= ?,parent =? WHERE cat_id=?");
        $stmt->execute(array($name_cate, $active_cate,$sub_cate, $userid));

        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Update</div>';


    }
}



elseif ($user=='delete'){

//        database delete


    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `categories` WHERE cat_id =?  LIMIT 1");
    $stmt->execute(array($userid));

    $count = $stmt->rowCount();



    if ($stmt->rowCount() > 0) {

        $stmt=$con->prepare("DELETE FROM categories WHERE cat_id=:zcate");
        $stmt->bindParam(":zcate",$userid);
        $stmt->execute();

        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Delete</div>';

    }else{
        "this id is not exist";
    }
}

elseif ($user=='actvite'){
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `categories` WHERE cat_id =?  LIMIT 1");
    $stmt->execute(array($userid));

    $count = $stmt->rowCount();



    if ($stmt->rowCount() > 0) {

        $stmt=$con->prepare("UPDATE categories SET cat_status=0 WHERE cat_id =? ");

        $stmt->execute(array($userid));

        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record active</div>';

    }




}












include "include/footer.php";

