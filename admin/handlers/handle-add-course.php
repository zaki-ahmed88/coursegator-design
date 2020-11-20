
<!-- <?php echo "<pre>"; print_r($_POST); echo "<pre>"; ?> -->


<?php 

session_start();

require_once("../includes/db-connect.php");



?>





<?php 


//mysqli_real_escape_string() is a function to solve sql query Error
//we will use  also htmlspecialchars() function to recover special chars like scripts
// we will use  also trim() function to recover spaces

    if(isset($_POST['submit'])){

         /* echo "<pre>"; print_r($_FILES['img']); echo "<pre>";
         die(); */

        $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])) );
        $desc = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['desc'])) );
        $cat_id = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['cat_id'])) );

        $img = $_FILES['img'];

        $imgName = $img['name'];
        $imgType = $img['type'];
        $imgError = $img['error'];
        $imgSize = $img['size'];
        $imgTempName = $img['tmp_name'];




        
    //validations
    $errors = [];

    //validate name:  (required / string / 255)
    if(empty($name)){
        $errors[] = "Name is required";
    }elseif(! is_string($name) || is_numeric(($name))){
        $errors[] = "Name must be string containing characters";
    }elseif(strlen(($name)) > 255){
        $errors[] = "Name length should not exceed 255 characters";
    }


    //validate description:  (required / string )
    if(empty($desc)){
        $errors[] = "description is required";
    }elseif(! is_string($desc) || is_numeric(($desc))){
        $errors[] = "description must be string containing characters";
    }



    //validate cat_id:  (required )
    if(empty($cat_id)){
        $errors[] = "category is required";
    }



    //img: no errors, available extension, max 2MB

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $randomStr = uniqid();
    $imgExtension = pathinfo($imgName, PATHINFO_EXTENSION);




    
    $imgSizeMb = $imgSize / (1024 ** 2);

    if($imgError != 0){
        $errors[] = "error while uploading image<br>";
    }elseif(! in_array($imgExtension, $allowedExtensions)){
        $errors[] = "exttension is not valid, extensions are jpg, jpeg, png and gif <br>";
    }elseif($imgSizeMb > 2){
        $errors[] = "max allowed size is 2 MB <br>";
    }

    


    



    if(empty($errors)){

        $randomStr = uniqid();
        $imgNewName = "$randomStr.$imgExtension";

        move_uploaded_file($imgTempName, "../../uploads/courses/$imgNewName");

        //insert data in reservations table

        $sql = "INSERT INTO courses (name, `desc`, cat_id, img)
        VALUES ('$name', '$desc', $cat_id, '$imgNewName')";

        if (mysqli_query($conn, $sql) == true) {
            //redirect back with success message
            $_SESSION['success'] = "you added course successflly";
            header("location:../all-courses.php");
        }
        mysqli_close($conn);
            
            
        } else {
            $_SESSION['errors'] = $errors;
            header("location:../add-course.php");
           
        }
    

 


        
    }





?>
