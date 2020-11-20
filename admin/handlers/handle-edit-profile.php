

<?php 

session_start();

require_once("../includes/db-connect.php");



?>

<?php 


//mysqli_real_escape_string() is a function to solve sql query Error
//we will use  also htmlspecialchars() function to recover special chars like scripts
// we will use  also trim() function to recover spaces

    if(isset($_POST['submit'])){

        $id = $_SESSION['adminId'];

        $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])) );
        $email = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['email'])) );
        $password = $_POST['password'];        //we will take it as written to avoid special chars conversion
        $confirm_password = $_POST['confirm_password']; 


        

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




        //validate email (required / string / 255)
        if(empty($email)){
            $errors[] = "Email is required";
        }elseif(! filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Mail is not valid";
        }elseif(strlen(($email)) > 255){
            $errors[] = "Email length should not exceed 255 characters";
        }






        //validate password
        if(!empty($password)){
            if(! is_string($password)){
                $errors[] = "password must be string containing characters";
            }elseif(strlen($password) < 5 || strlen($password) > 25){
                $errors[] = "password length must be between 5 and 25 chars";
            }elseif($password != $confirm_password){
                $errors[] = "Password and Confirm Password not matched";
            }


            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }


        



        if(empty($errors)){

            if(!empty($password)){
                 
            $sql = "update admins 
                    set name = '$name',
                    email = '$email',
                    `password` = '$hashedPassword'
                    where id = $id";
                    
            
            }else{
                $sql = "update admins 
                        set name = '$name',
                        email = '$email'
                        where id = $id";
                        
            }


          
            if (mysqli_query($conn, $sql)) {
                
                $_SESSION['success'] = "you Updated profile successflly";  
                $_SESSION['adminName'] = $name;                        //to change the admin name beside the logo
                 
            }
            mysqli_close($conn);

        } else {
            $_SESSION['errors'] = $errors;
        }
        header("location:../edit-profile.php");
       
    

        
    }

   

 


?>
