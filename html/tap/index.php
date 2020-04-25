<!--start article-->
<?php
include ("navbar.php");
include('db_connect.php');
?>
<br><br><br><br><br>

<?php

$stmt=$con->prepare("SELECT `post_id`,`post_title`, `post_intro`, `post_img`,`cat_name`,publish_date FROM `post`,`categories` WHERE post.cat_id=categories.cat_id ");
$stmt->execute(array());
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $stmt->fetch()) {
    $count = $stmt->rowCount();
    if ($count > 0) {

        ?>


        <?php echo '
<div class="post">
<article>
        <header>
            <div class="img">
            
                <h3 style="text-align: right;font-family:Adobe Devanagari;padding: 20px">'. $row['cat_name'] .' <h4 >'. $row['post_title'] .'</h4></h3>
                <p>created by <span>Ali </span> on <span>'. $row['publish_date'] .'</span></p>

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
<aside class="cate" style="margin-top:-142%" >
    <section class="links">
        <h3 style="text-align: center">التصنيفات</h3>
        <?php

        $stmt=$con->prepare(" SELECT `cat_id`,`cat_name` FROM `categories` ");
        $stmt->execute(array());
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            $count = $stmt->rowCount();
            if ($count > 0) {

                echo '<ul style="text-align: right;padding-right: 10%"><li><a href="news.php?id='.$row['cat_id'].'" style="direction: rtl">' . $row['cat_name'] . '</a></li>
             </ul>';
            }
        }


        ?>
    </section>
</aside>

<aside class="cate" style="margin-top: -115%" >
    <section class="links">
        <h3 style="text-align: center">اخــر الاخبــــار</h3>
        <?php

        $stmt=$con->prepare(" SELECT post_title ,post_intro FROM `post` ");
        $stmt->execute(array());
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            $count = $stmt->rowCount();
            if ($count > 0) {

                echo '<ul ><li><a href="news.php?id='.$row['post_title'].'" style="direction: rtl">' . $row['post_intro'] . '</a></li>
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

























