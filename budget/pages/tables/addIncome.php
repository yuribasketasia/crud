<?php
//connect to db and header
//require_once ("header.php");
require_once("database.php");

//define variables and initialize with empty values
$incomeAmount = $incomeCategory = $incomeDate = "";
$incomeAmount_err = $incomeCategory_err = $incomeDate_err = "";

//processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  //validate amount
  $input_incomeAmount = trim($_POST["incomeAmount"]);
    if (empty($input_incomeAmount)){
      $input_incomeAmount = "Please enter valid amount";
    } elseif(!ctype_digit($input_incomeAmount)) {
      $input_incomeAmount = "Please enter a positive integer value";
    } else {
      $incomeAmount = $input_incomeAmount;
    }

  //validate category
  $input_incomeCategory = trim($_POST["incomeCategory"]);
    if(empty($input_incomeCategory)){
      $incomeCategory_err = "Please select one";
    } elseif (!filter_var($input_incomeCategory, FILTER_VALIDATE_REGEXP,
      array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
      $incomeCategory_err = "Please enter choose name.";
    } else {
      $incomeCategory = $input_incomeCategory;
    }

  //validate date
  $input_incomeDate = trim($_POST["incomeDate"]);
    if (empty($input_incomeDate)){
      $incomeDate_err = "Please enter your date";
    } else {
      $incomeDate = $input_incomeDate;
    }

  //check input before inserting to database;
  if(empty($incomeAmount_err) && empty($incomeCategory_err) && empty($incomeDate_err)){
    //prepare an insert statement
    $sql = "INSERT INTO income (incomeAmount, incomeCategory, incomeDate) VALUES (?, ?, ?)";
      if ($stmt = mysqli_prepare($link, $sql)){
        ///bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_amount, $param_category, $param_date);
        $param_amount = $incomeAmount;
        $param_category = $incomeCategory;
        $param_date = $incomeDate;
          // attempt to execute the prepared statement
          if (mysqli_stmt_execute($stmt)){
            header("location: revenues.php");
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
require_once('header.php');
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
            <div class="form-group">
              <div class="form-group">
                <label>Amount</label>
                <input name="incomeAmount" class="form-control<?php echo (!empty($incomeAmount_err)) ? 'is-valid' : ''; ?>"
                       value="<?php echo $incomeAmount; ?>">
                <span class="invalid-feedback"><?php echo $incomeAmount_err; ?></span>
              </div>

              <label>Category</label>
              <input type="text" name="incomeCategory" class="form-control<?php echo (!empty($incomeCategory_err)) ? 'is-valid' : ''; ?>"
                     value="<?php echo $incomeCategory; ?>">
              <span class="invalid-feedback"><?php echo $incomeCategory_err; ?></span>
            </div>
            <div class="form-group">
              <label>date</label>
              <input type="date" name="incomeDate" class="form-control<?php echo (!empty($incomeDate_err)) ? 'is-valid' : ''; ?>"
                     value="<?php echo $incomeCategory; ?>">
              <span class="invalid-feedback"><?php echo $incomeDate_err; ?></span>
            </div>

            <input type="submit" class="btn btn-primary" value="Submit">
            <a href="revenues.php" class="btn btn-secondary ml-2">Cancel</a>
          </form>


        </div>
      </div>
    </div>
  </div>
</section>


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

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select2 -->
  <script src="../../plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="../../plugins/moment/moment.min.js"></script>
  <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- BS-Stepper -->
  <script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- dropzonejs -->
  <script src="../../plugins/dropzone/min/dropzone.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    //Date picker
    $('#reservationdate').datetimepicker({
      format: 'L'
    });
  </script>
