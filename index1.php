<?php 
	require_once "database.php";
	$link1 = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$sql = "SELECT * FROM employees";
	if ($result = mysqli_query($link1, $sql)) {
		if (mysqli_num_rows($result) > 0 ){;
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">  </head>
	<link rel="stylesheet" href="style.css">
	    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
  <body>
    <div class="wrapper">
		<div class="container_fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="md-5 mb-3 clearfix">
						<h2 class="pull-left">Employee Details</h2>
						<a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Employee</a>
                    </div>
					<table class="table">
					  <thead>
						<tr>
						  <th scope="col">#</th>
						  <th scope="col">Name</th>
						  <th scope="col">Address</th>
						  <th scope="col">Salary</th>
						  <th scope="col">Action</th>
						</tr>
					  </thead>
					  <tbody>
						<?php while($row = mysqli_fetch_array($result)){ ?>
						<tr>
						  <td><?php $row['id'] ?></td>
						  <td><?php $row['name'] ?></td>
						  <td><?php $row['address'] ?></td>
						  <td><?php $row['salary'] ?></td>
						  <td>
						  </td>
						</tr>
						<?php } ?>
					  </tbody>
					</table>
					<?php mysqli_free_result($result);
							} else 
							{ 
								echo "<div class='alert alert-danger'><em>No records were found.</em></div>"; 
							}
	}
						mysqli_close($link1);
						?>	
				</div>
            </div>        
        </div>
    </div>	

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    -->
  </body>
</html>