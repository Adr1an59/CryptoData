<?php
	//require_once('include/db.php');

	session_start();
	$showAlert = false;
	
	//var_dump(hash('sha256', '#Omnislash#16!'));
	if(isset($_POST['password'])){
		if(hash('sha256', htmlspecialchars($_POST['password'])) == '191fdb9a20dfd1443f77400e7439f982de6211792b00f9d262cd142563b0c90b'){
			$_SESSION['access'] = true;
			header('Location: crypto.php');
		}else{
			$_SESSION['access'] = false;
			$showAlert = true;
		}
	}
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CryptoDatas</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	
	<link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
	
	<style>
		body{
			background-color: #d6e0f5;
		}
	</style>
	
</head>
<body>
			
	<header class="navbar navbar-expand navbar-dark bg-dark flex-column flex-md-row bd-navbar">
		<a class="navbar-brand" href="#">Cryptocurrencies <i class="fab fa-bitcoin white-color"></i></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav">
		  
			</ul>
		</div>
	</header>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-lg-4 col-md-6 offset-lg-4 offset-md-3 text-center mt-5">
			
			<?php
				if($showAlert){
			?>
					<div class="alert alert-danger" role="alert">
						Wrong Password Mate !
					</div>
			<?php
				}
			?>
			
				<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<div class="form-group">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					</div>
					<div class="form-group">
						<input type="submit" value="Go Crypto !" class="btn btn-primary btn-rounded">
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>