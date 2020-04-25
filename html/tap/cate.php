<!--start article-->
<?php
include ("navbar.php");
include('db_connect.php');
?>
<br><br><br><br><br>

    <?php

    $stmt=$con->prepare("SELECT `post_title`, `post_intro`, `post_img`, `cat_id`,`create_date` FROM `post` ");
    $stmt->execute(array());
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $stmt->fetch()) {
    $count = $stmt->rowCount();
    if ($count > 0) {

        ?>


   <?php echo '
<div class="post"><article>
        <header>
            <div class="img">
                <h4>'. $row['post_title'] .' </h4>
                <p>created by <span>kholod</span>on <span>'. $row['create_date'] .'</span></p>

            </div>
            <img src="../ltr/'. $row['post_img'] .'" alt="jj" style="width: 100%;height: 500px">


        </header>

        <section>
            <p>'. $row['post_intro'] .'</p>
        </section></article>


</div>';
?>
<?php }
    }?>
<!--end article-->
<aside class="cate" style="margin-top:-140%;">
    <section class="links">
        <h3>التصنيفات</h3>
        <?php

            $stmt=$con->prepare(" SELECT `cat_id`,`cat_name` FROM `categories` ");
            $stmt->execute(array());
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                $count = $stmt->rowCount();
                if ($count > 0) {

                    echo '<ul><li><a href="news.php?id='.$row['cat_id'].'" style="direction: rtl">' . $row['cat_name'] . '</a></li>
             </ul>';
                }
            }


            ?>
    </section>
</aside>






<!--start aside-->
<div class="clearfix">
</div>


<!--end aside-->
<footer>

</footer>

























