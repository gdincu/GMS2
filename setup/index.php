<!DOCTYPE html>
<html>
<head>
    <script src="../js/alertify.js"></script>
    <link rel="stylesheet" href="../css/alertify.css" />
</head>
<body >

  <!-- Portfolio Section -->
  <section class="page-section portfolio" id="portfolio">
    <div class="container">
      <br>

      <!-- Portfolio Grid Items -->
      <div class="col">

		<div class="row">	
        <div class="col-md-2 col-lg-2">
        <!-- Portfolio Item 1 -->
		<button type="submit" name="S1" class="btn btn-primary" onclick="location.href='http://localhost/phpmyadmin/'">DB Admin Panel</button>
		</div>
		<div class="col-md-10 col-lg-10">
		Click here to access the Admin panel for the MariaDB dabatase.
		</div>
		</div>
		
		<br>
		
		<div class="row">	
        <div class="col-md-2 col-lg-2">
        <!-- Portfolio Item 2 -->
		<form action="" method="post">
		<input type="submit" name="createDB" value="Create database" class="btn btn-success">
		</form>	
		</div>
		<div class="col-md-10 col-lg-10">
		Click here to create a database and populate with template data.
		</div>
		</div>
		<?php 
		if(isset($_POST['createDB'])){ 
		 require "install.php";
		}
		?>
		
		<br>
		
		<div class="row">	
        <div class="col-md-2 col-lg-2">
        <!-- Portfolio Item 3 -->
		<form action="" method="post">
		<input type="submit" name="dropDB" value="Drop database" class="btn btn-danger">
		</form>
		</div>
		<div class="col-md-10 col-lg-10">
		Click here to delete the database. <b>Please be aware that all current data would also be removed</b>.
		</div>
		</div>
		<?php 
		if(isset($_POST['dropDB'])){ 
		 require "drop.php";
		}
		?>
		
	</div>
</div>
</section>

</body>
</html>