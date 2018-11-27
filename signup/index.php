<?php
require "../includes/datacontrol.php" ;



$firstname;
$lastname;
$username;
$email;
$mobile = "234";
$password;
$photo_url = "../files/avater.png";
$emailErr;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $inputOk = TRUE;

  if(isset($_POST['first_name'])){
    $firstname = parse($_POST['first_name']);
  }else{
    $inputOk = FALSE;
    echo 'error node 1';
  }

  if(isset($_POST['last_name'])){
    $lastname = parse($_POST['last_name']);
  }else{
    $inputOk = FALSE;
    echo 'error node 2';
  }

  if(isset($_POST['username'])){
    $username = parse($_POST['username']);
  }else{
    $inputOk = FALSE;
    echo 'error node 3';
  }

  if(isset($_POST['email'])){
    $email = parse($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      $inputOk = FALSE;
      echo 'error node 4';
    }
  }else{
    $inputOk = FALSE;
    echo 'error node 5';
  }

  if(isset($_POST['password'])){
    $password = $_POST['password'];
    #create a salt for encryption as sha1 of the md5 of the password; this will make our encryption stronger
    $salt = sha1(md5($password));
    #encrypt the password with md5 and add the salt that was created above
    $password = md5($password.$salt);
  }else{
    #there is an error, set $inputOk to false so that data will not be written to database
    $inputOk = FALSE;
    echo 'error node 6';
  }

  if($inputOk){
    //echo "debug point";
    $baseData = new Database("thehub"); //create a new instance of the database class
    #write the user information to the database
    $baseData->insertUsers($username, $firstname, $lastname, $email, $mobile, $password, $photo_url);
  }

}



function parse($data){
  $data = trim($data); //trim the input data
  $data = stripslashes($data); //make sure that there is no slash in the input data
  $data = htmlspecialchars($data); //remove html special characters from the data
  return $data;// return the data
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <!-- Latest compiled and minified CSS -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="pingle_css.css">

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> -->


  <title></title>
</head>
  <body>
    <div class="container">
    <a href="login.html"><img  src="project_images/close-button (4).png" alt="" class="pull-right img-responsive"></a>
    </div>
    <br>
    <br>


    <div class="contentDiv">


        <!-- <div class="container jumbotron edge" style="background-color:rgba(255,255,255,0.5);border-radius:10px;">
          <h1>Login</h1>
          <p><h3>Enter your email and password below to login</h3></p>

        </div> -->

        <div class="container">
          <!-- <img src="project_images/smile(1).png" alt="image error"> -->
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="first_name">First name</label>
                  <input type="text" name="first_name" class="form-control" id="first_name" placeholder="input your first name" required>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="last_name">Last name</label>
                  <input type="text" name="last_name" class="form-control" id="last_name" placeholder="input your last name" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="first_name">username</label>
              <input type="text" name="username" class="form-control" id="username" placeholder="Choose a username" required>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required>
              <small id = "emailhelp" class = "form-text text-muted" style="color:black;">we'll never share your email with anyone else</small>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
              <small id = "passwordhelp" class = "form-text text-muted" style="color:black;">your password should be more than 8 characters length and must contain capital letters, small letters, numbers and special characters</small>
            </div>
            <!-- <div class="checkbox">
              <label>
                <input type="checkbox"> Login now
              </label>
            </div> -->

            <button type="submit" class="btn btn-primary">Sign me Up</button>
          </form>
        </div>

      </div>


    <script src="http://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>  <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="transparent_to_solid_navbar.js"></script>
    <script src="animated_arrow.js"></script>
    <script src="back_to_top.js"></script>



  </body>
</html>
