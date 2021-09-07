<?php
//start the session
session_start();
  //check if the user is already loged in
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ){
    header("location:index.php");
    exit();
  }
  //connect db
  require_once ('database.php');
  //Define variables and initialize with empty values
  $email = $password = "";
  $email_err = $password_err = $login_Err = "";

// Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      //CHECK IF email is empty
      if (empty(trim($_POST["email"]))){
        $email_err = "Please enter your email address";
      }else{
        $email = trim($_POST["email"]);
      }
    }

    //check if password is empty
    if (empty(trim($_POST["password"]))){
      $password_err = "Please enter your password";
    }else{
      $password = trim($_POST["password"]);
    }

    //validate credentials
    if (empty($email_err) && empty($password_err)){
      $sql = "SELECT id, email, password FROM admin WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)){
          mysqli_stmt_bind_param($stmt, "s", $param_email);
          $param_email = $email;

          //attemp to execute the prpared statement
          if (mysqli_stmt_execute($stmt)){
            //store result
            mysqli_stmt_store_result($stmt);
            //check if username exists
            if(mysqli_stmt_num_rows($stmt) == 1){
              // Bind result variables
              mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
              if(mysqli_stmt_fetch($stmt)){
                if(password_verify($password, $hashed_password)){
                  // Password is correct, so start a new session
                  session_start();
                  //store dat in session variables
                  $_SESSION["loggedin"] = true;
                  $_SESSION["id"] == $id;
                  $_SESSION["email"] == $email;
                  // redirect user to welcome page
                  header("location: index.php");
                } else{
                //password is not valid display a generic error
                  $login_Err = "Invalid username password";
                  }
              }
            } else{
              // Username doesn't exist, display a generic error message
              $login_err = "Invalid username or password.";
              }
          } else{
            echo "Oops! Something went wrong. Please try again later.";
          }
          // Close statement
          mysqli_stmt_close($stmt);
        }
    }
  // Close connection
  mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <style>
    .divider:after,
    .divider:before {
      content: "";
      flex: 1;
      height: 1px;
      background: #eee;
    }
    .h-custom {
      height: calc(100% - 73px);
    }
    @media (max-width: 450px) {
      .h-custom {
        height: 100%;
      }
    }
  </style>
</head>
<body>
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-login-form/draw2.png" class="img-fluid"
             alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <?php
        if(!empty($login_err)){
          echo '<div class="alert alert-danger">' . $login_err .'</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" METHOD="post">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3">Welcome Back</p>
          </div>
          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0"></p>
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input name="email" type="email" id="form3Example3" class="form-control form-control-lg"
                   placeholder="Enter a valid email address" />
            <label class="form-label" for="form3Example3">Email address</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <input name="password" type="password" id="form3Example4" class="form-control form-control-lg"
                   placeholder="Enter password" />
            <label class="form-label" for="form3Example4">Password</label>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
              <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
              <label class="form-check-label" for="form2Example3">
                Remember me
              </label>
            </div>
            <a href="#!" class="text-body">Forgot password?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="button" class="btn btn-primary btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
    <!-- Copyright -->
    <div class="text-white mb-3 mb-md-0">
      Copyright © 2021. All rights reserved.
    </div>

  </div>
</section>
</div>
</body>
</html>
