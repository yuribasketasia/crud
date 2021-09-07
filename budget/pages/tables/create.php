<?php
//connect to db
require_once ("database.php");
//define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter your name";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter valid name.";
    } else {
        $name = $input_name;
    }
    //validate address

    $input_address = trim($_POST["address"]);
    if (empty($input_address)){
        $address_err = "Please enter your address";
    } else {
        $address = $input_address;
    }
    //validate salary
    $input_salary = trim($_POST["salary"]);
    if (empty($input_salary)){
        $salary_err = "Please enter valid salary amount";
    } elseif(!ctype_digit($input_salary)) {
        $salary_err = "Please enter a positive integer value";
    } else {
        $salary = $salary_err;
    }

    //check input before inserting to database;
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        //prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)){
            ///bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;

            // attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)){
                header("location: index2.php");
                exit();
            } else{
                echo "Oops! something went wrong. Please try again later.";
            }
        }
        //close statement
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
      <link rel="stylesheet" href="style.css">
      <script>
          $(document).ready(function(){
              $('[data-toggle="tooltip"]').tooltip();
          });
      </script>
  </head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add new employee</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control<?php echo (!empty($name_err)) ? 'is-valid' : ''; ?>"
                        value="<?php echo $name; ?>">
                        <span class="invalid-feedback"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" <?php echo (!empty($address_err)) ? 'is-valid' : ''; ?>">
                        <?php echo $address; ?></textarea>
                        <span class="invalid-feedback"><?php echo $address_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <input name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-valid' : ''; ?>"
                         value="<?php echo $salary; ?>">
                        <span class="invalid-feedback"><?php echo $salary_err; ?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
                </div>
            </div>
        </div>
    </div>
</body>
