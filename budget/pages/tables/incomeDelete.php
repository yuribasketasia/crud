<?php

if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once("database.php");

    // Prepare a delete statement
    $sql = "DELETE FROM income WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: revenues.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
require_once ('header.php');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-md-12">
            <h2 class="mt-5 mb-4">Delete Record</h2>
            <form action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" METHOD="post">
                <div class="alert alert-danger">
                    <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                    <p>Are you Sure you want to delete this income record?</p>
                    <input type="submit" value="Yes" class="btn btn-danger">
                    <a href="revenues.php" class="btn btn-secondary">No</a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require_once ('footer.php');?>
