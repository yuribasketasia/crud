<?php
require_once ("header.php");
require_once("database.php");
$link = mysqli_connect (DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$category = $date = $amount = "";
$category_err = $date_err = $amount_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $input_category = trim($_POST["category"]);
  if(empty($input_category)){
    $name_err = "Please select one";
  } elseif (!filter_var($input_category, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    $name_err = "Please enter valid name.";
  } else {
    $category = $input_category;
  }
  //validate address

  $input_address = trim($_POST["date"]);
  if (empty($input_date)){
    $address_err = "Please enter your address";
  } else {
    $address = $input_date;
  }
  //validate salary
  $input_salary = trim($_POST["amount"]);
  if (empty($input_amount)){
    $salary_err = "Please enter valid amount";
  } elseif(!ctype_digit($input_amount)) {
    $salary_err = "Please enter a positive integer value";
  } else {
    $amount = $amount_err;
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
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Increase your income</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="revenues.php">Home</a></li>
            <li class="breadcrumb-item active">add Income</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Add New Income</h3>
          </div>

          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="card-body">
              <div class="form-group">
                <label>Category</label>
                  <select class="custom-select">
                    <option>salary</option>
                    <option>overtime</option>
                    <option>freelancing</option>
                  </select>
                <label>Date</label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
                <label>Amount</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control <?php echo (!empty($amount_err)) ? 'is-valid' : ''; ?>" value="<?php echo $amount; ?>">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                    <span class="invalid-feedback"><?php echo $amount_err; ?></span>
                  </div>
                </div>

<!--  <div class="form-group">-->
<!--    <label>Name</label>-->
<!--    <input type="text" name="name" class="form-control--><?php //echo (!empty($category_err)) ? 'is-valid' : ''; ?><!--"-->
<!--           value="--><?php //echo $category; ?><!--">-->
<!--    <span class="invalid-feedback">--><?php //echo category_err; ?><!--</span>-->
<!--  </div>-->
<!--  <div class="form-group">-->
<!--    <label>Address</label>-->
<!--    <textarea name="address" class="form-control" --><?php //echo (!empty($date_err)) ? 'is-valid' : ''; ?><!--">-->
<!--    --><?php //echo $date; ?><!--</textarea>-->
<!--    <span class="invalid-feedback">--><?php //echo $date_err; ?><!--</span>-->
<!--  </div>-->
<!--  <div class="form-group">-->
<!--    <label>Salary</label>-->
<!--    <input name="salary" class="form-control"-->
<!--           value="--><?php //echo $amount; ?><!--">-->
<!--    <span class="invalid-feedback">--><?php //echo $amount_err; ?><!--</span>-->
<!--  </div>-->
<!--  <input type="submit" class="btn btn-primary" value="Submit">-->
<!--  <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>-->
<!--</form>-->


<?php
require_once ("footer.php");
?>
