<!-- <?php echo "<pre>"; print_r($_POST); echo "<pre>"; ?> -->


<?php 

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coursegator";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coursegator";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




?>





<?php 


//mysqli_real_escape_string() is a function to solve sql query Error
//we will use  also htmlspecialchars() function to recover special chars like scripts
// we will use  also trim() function to recover spaces

    if(isset($_POST['submit'])){

        $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])) );
        $email = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['email'])));
        $phone = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['phone'])));
        $spec = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['spec'])) );
        $course_id = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['course_id'])));
    }

    //validations
    $errors = [];

    //validate name (required / string / 255)
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


    //validate phone (required / string / 255)
    if(empty($phone)){
        $errors[] = "Phone is required";
    }elseif(! is_string($phone)){
        $errors = "Phone must be string";
    }elseif(strlen(($phone)) > 255){
        $errors[] = "Phone length should not exceed 255 characters";
    }


    //validate spec (string / [in:courses.id])
    if(! empty($spec)){
        if(! is_string($spec)){
            $errors[] = "spec is required";
        }elseif(strlen(($spec)) > 255){
            $errors[] = "spec length should not exceed 255 characters";
        }
    }


    //validate course_id
    if(empty($course_id)){
        $errors[] = "course_id is required";
    }



    if(empty($errors)){

        //insert data in reservations table

        $sql = "INSERT INTO reservations (name, email, phone, spec, course_id)
        VALUES ('$name', '$email', '$phone', '$spec', '$course_id')";

        if (mysqli_query($conn, $sql)) {

            //redirect back with success message

            $_SESSION['success'] = "you enrolled to course successflly";
            
            
        } else {
            $_SESSION['queryError'] = "Error happen while storing, please try again later";
           
        }

        

        mysqli_close($conn);

        

    }else{
        //store errors in session
        $_SESSION['errors'] = $errors;

        //redirect back with error messages
    }

    header("location:../enroll.php");


?>
