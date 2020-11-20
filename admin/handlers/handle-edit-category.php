
<!-- like handle-add-category.php -->

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

        $id = $_GET['id'];

        $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])) );


        $errors = [];

        //validate name:  (required / string / 255)
        if(empty($name)){
            $errors[] = "Name is required";
        }elseif(! is_string($name) || is_numeric(($name))){
            $errors[] = "Name must be string containing characters";
        }elseif(strlen(($name)) > 255){
            $errors[] = "Name length should not exceed 255 characters";
        }
    
    
        
    
    
        
        //validations

        if(empty($errors)){
    
            //insert data in reservations table
    
            $sql = "update cats set name = '$name' where id = $id";
    
            if (mysqli_query($conn, $sql) == true) {
                //redirect back with success message
                $_SESSION['success'] = "you Updated category successflly";
                header("location:../all-categories.php");
            }
            mysqli_close($conn);
                
                
            } else {
                $_SESSION['errors'] = $errors;
                header("location:../edit-category.php?id=$id");
               
            }
        
        
    }
   

 


?>
