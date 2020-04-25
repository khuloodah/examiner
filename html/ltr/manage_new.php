<?php
session_start();
include "include/navbar.php";
include "include/header.php";
include "db/db_connect.php";
$user = isset($_GET['user']) ? $_GET['user'] : 'Manage';


//create page
if ($user == 'Manage') {
    $stmt = $con->prepare("SELECT * FROM  `post` ");

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
                                <th>Title</th>
                                <th>Intro</th>
                                <th>Contect</th>
                                <th>Image</th>
                                <th>Categories</th>
                                <th>Control</th>

                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            foreach ($row as $rows) {

                                ?>
                                <tr>

                                    <?php echo "<td>" . $rows['post_id'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['post_title'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['post_intro'] . "</td>"; ?>
                                    <?php echo "<td>" . $rows['post_content'] . "</td>"; ?>
                                    <?php echo "<td><img src=". $rows['post_img'] ." style='width: 100px;height: 50px'></td>"; ?>
                                    <?php echo "<td>" . $rows['cat_id'] . "</td>"; ?>

                                    <td>

                                        <a href="manage_new?user=edit&userid=<?php echo $rows['post_id'] ?>"><i class="fas fa-edit" style="font-size: 22px"></i></a>
                                        <a href="manage_new.php?user=delete&userid=<?php echo $rows['post_id']  ?>"> <i class="fas fa-trash-alt" style="color: #f05050;font-size: 22px"></i></a>
                                        <a href="manage_new.php?user=actvite&userid=<?php echo $rows['post_id']  ?>"><i class="fas fas fa-cubes" style="color: #41f0b4;font-size: 22px"></i></a>
                                    </td>
                                </tr>
                                <?php
                            } ?>
                            </tbody>


                        </table>
                        <div class="card-body">
                            <a href='manage_new.php?user=Add' class="btn btn-primary"><i class="fa fa-plus"></i> Add News </a>
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
                <form class="form-horizontal" action="?user=Insert" METHOD="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <h4 class="card-title">Post Info</h4>
                          <div class="form-group row">
                                <label class="col-md-3 m-t-15">Title Post</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title_post" id="title_post" placeholder="Title Post Here">
                                </div>
                            </div>
                        
                        
                       
                        <div class="form-group row">
                            <label class="col-md-3 m-t-15">Post Intro </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="post_intro" id="post_intro" placeholder=" Post Intro Here">
                            </div>
                        </div>
                        
                              <div class="form-group row">
                            <label class="col-md-3 m-t-15">Post Status </label>
                            <div class="col-md-9">
                                <select class="select2 form-control custom-select" name="post_status" style="width: 100%; height:36px;">
                                    <option value="1">active</option>
                                       <option value="0">no active</option>

                                </select>
                            </div>
                        </div>
                        
                        
                           <div class="form-group row">
                            <label class="col-md-3 m-t-15">ChocesImage </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="img" id="post_img" >
                            </div>
                        </div>
                        
                    
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <div class="form-group row">
                            <label class="col-md-3 m-t-15">Categories</label>
                            <div class="col-md-9">
                                <select class="select2 form-control custom-select" name="cate_name" style="width: 100%; height:36px;">
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
    <div class="form-group row">
        <label class="col-md-3 m-t-15">Contant</label>
        <div class="col-md-9">
                               <textarea rows="4" cols="50" class="form-control" name="contect" id="contect" placeholder=" Contact Here">
                              </textarea>
        </div>
    </div>
    </div>

    <?php echo '<div class="border-top">
                        <div class="card-body">
                                  <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                            Add New Post
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
        $post_title = $_POST['title_post'];
        $post_intro = $_POST['post_intro'];
        $post_status = $_POST['post_status'];
        $post_contact = $_POST['contect'];
        $cate_name = $_POST['cate_name'];
        $target_path = "uploads/";
        $tmpFilePath=$_FILES['img']['tmp_name'];
        $target_path ="$target_path".$_FILES['img']['name'];
        move_uploaded_file($tmpFilePath,$target_path);
        $create_by=   $_SESSION['ID'];


        $sql="INSERT INTO `post`( `post_title`, `post_intro`, `post_content`, `post_img`, `post_status`,`cat_id`,`create_by`)
                       VALUES
                                    (:ptitle,:pintro,:pcontact,:pimg,:pstatus,:zcate,:zcreate)";
        $stmt=$con->prepare($sql);
        $stmt->execute([
            'ptitle'=>$post_title,
            'pintro'=>$post_intro,
            'pcontact'=>$post_contact,
            'pimg'=>$target_path,
            'pstatus'=>$post_status,
            'zcate'=>$cate_name,
            'zcreate'=>$create_by
           ]);




        echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record insert</div>';
    }
}



elseif ($user=='edit') {
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    $stmt = $con->prepare("SELECT  * FROM `post` WHERE post_id =? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($stmt->rowCount() > 0) {
        echo'
    <div class="container-fluid">

    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <form class="form-horizontal" action="?user=Insert" METHOD="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <h4 class="card-title">Post Info</h4>
                         <input type="hidden" name="userid" value='.$userid.'>
                          <div class="form-group row">
                                <label class="col-md-3 m-t-15">Title Post</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title_post" id="title_post" value='.$row['post_title'].' placeholder="Title Post Here">
                                </div>
                            </div>
                        
                        
                       
                        <div class="form-group row">
                            <label class="col-md-3 m-t-15">Post Intro </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="post_intro" id="post_intro" value='.$row['post_intro'].'  placeholder=" Post Intro Here">
                            </div>
                        </div>
                        
                              <div class="form-group row">
                            <label class="col-md-3 m-t-15">Post Status </label>
                            <div class="col-md-9">
                                <select class="select2 form-control custom-select" value='.$row['post_status'].' name="post_status" style="width: 100%; height:36px;">
                                    <option value="1">active</option>
                                       <option value="0">no active</option>

                                </select>
                            </div>
                        </div>
                        
                        
                           <div class="form-group row">
                            <label class="col-md-3 m-t-15">ChocesImage </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" value='.$row['post_img'].' name="img" id="post_img" >
                            </div>
                        </div>
                        
                    
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <div class="form-group row">
                            <label class="col-md-3 m-t-15">Categories</label>
                            <div class="col-md-9">
                                <select class="select2 form-control custom-select" value='.$row['cat_id'].' name="cate_name" style="width: 100%; height:36px;">
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
        <div class="form-group row">
            <label class="col-md-3 m-t-15">Contant</label>
            <div class="col-md-9">
                               <textarea rows="4" cols="50" class="form-control"  name="contect" id="contect"    placeholder=" Contact Here" >
<!--                                   --><?php //echo  value=".$row['cat_id']."?>

                              </textarea>
            </div>
        </div>
        </div>

        <?php echo '<div class="border-top">
                        <div class="card-body">
                                  <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                            Add New Post
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
        $post_title = $_POST['title_post'];
        $post_intro = $_POST['post_intro'];
        $post_status = $_POST['post_status'];
        $post_contact = $_POST['contect'];
//        $cate_name = $_POST['cate_name'];
        $target_path = "uploads/";
        $tmpFilePath=$_FILES['img']['tmp_name'];
        $target_path ="$target_path".$_FILES['img']['name'];
        move_uploaded_file($tmpFilePath,$target_path);

        //        update to database
        $stmt = $con->prepare("UPDATE post SET post_title= ?,post_intro= ?,post_content=?,post_img=?,post_status=? WHERE UserID=?");
        $stmt->execute(array($post_title, $post_intro, $post_status,$post_contact,$target_path, $userid));

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

