<?php
require_once ("header.php");
$link1 = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$sql = "SELECT * FROM income";
$sum = 0;
$result = mysqli_query($link1, $sql);
if(mysqli_num_rows($result) > 0){
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
<!--  <section class="content-header">-->
<!--    <div class="container-fluid">-->
<!--      <div class="row mb-2">-->
<!--        <div class="col-sm-6">-->
<!--          <h1>Income</h1>-->
<!--        </div>-->
<!--        <div class="col-sm-6">-->
<!--          <ol class="breadcrumb float-sm-right">-->
<!--            <li class="breadcrumb-item"><a href="index.php">Home</a></li>-->
<!--            <li class="breadcrumb-item active">Income</li>-->
<!--          </ol>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div> /.container-fluid -->
<!--  </section>-->

<div class="card">
  <div class="card-header">
    <h3 class="card-title" >Add, Edit or Delete Your Income</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <a href="addIncome.php" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>  Add New income</a>
    <table id="example1" class="table table-bordered table-striped">

      <thead>
      <tr>
        <th>ID</th>
        <th>Category</th>
        <th>Date</th>
        <th>Amount</th>
        <th>Edit</th>
      </tr>
      </thead>
      <tbody>
      <?php while($row = mysqli_fetch_array($result)){ ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['incomeCategory']; ?></td>
        <td><?php echo $row['incomeDate']; ?></td>
        <td><?php echo $row['incomeAmount']; ?></td>
        <td>
          <a href="read.php?id=<?php echo $row['id']; ?>" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>
          <a href="update.php?id=<?php echo $row['id']; ?>" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
          <a href="incomeDelete.php?id=<?php echo  $row['id']; ?>" class="mr-3" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
        </td>
      </tr>
      <?php $sum += $row["incomeAmount"];  } ?>
      </tbody>
      <tfoot>
      <tr>
        <th>ID</th>
        <th>Category</th>
        <th>Date</th>
        <th>Total Income: RM<?php  echo $sum; ?></th>
        <th>Edit</th>
      </tr>
      </tfoot>
    </table>
    <?php mysqli_free_result($result);
    } else
    {
      echo "<div class='alert alert-danger'><em>No records were found.</em></div>";
    }

    mysqli_close($link1);
    ?>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
<!--footer-->
<?php require_once ("footer.php"); ?>
