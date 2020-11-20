<?php include("includes/header.php") ?>

<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = 1;
}
$sql = "select name, `desc`, img from courses where id = $id";
$result = mysqli_query($conn, $sql);
$found = false;

if(mysqli_num_rows($result) > 0){
    $course = mysqli_fetch_assoc($result);
    $found = true;

}else{
    $course['name'] = "No Course Found";
}


?>


     <!-- bradcam_area_start -->
     <div class="courses_details_banner">
         <div class="container">
             <div class="row">
                 <div class="col-xl-6">
                     <div class="course_text">
                            <h3><?= $course['name']; ?></h3>
                            <div class="rating">
                                <i class="flaticon-mark-as-favorite-star"></i>
                                <i class="flaticon-mark-as-favorite-star"></i>
                                <i class="flaticon-mark-as-favorite-star"></i>
                                <i class="flaticon-mark-as-favorite-star"></i>
                                <i class="flaticon-mark-as-favorite-star"></i>
                                <span>(5)</span>
                            </div>
                     </div>
                 </div>
             </div>
         </div>
    </div>
    <!-- bradcam_area_end -->

  <?php if($found){ ?>      <!-- if(mysqli_num_rows($result) != 0) -->
    <div class="courses_details_info">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-7">
                    <div class="single_courses">
                        <h3>Desription</h3>
                        <p><?= $course['desc']; ?></p>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5">
                    <div class="courses_sidebar">
                        <div class="video_thumb">
                            <img src="uploads/courses/<?= $course['img']; ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php } ?>



    <?php include("includes/footer.php") ?>