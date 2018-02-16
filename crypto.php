<?php
	//require_once('include/db.php');
	
	//phpinfo();

	session_start();
	
	if(!isset($_SESSION['access']) || !$_SESSION['access']){
		header('Location: index.php');
		die();
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
		
		.amount{
			text-align:right;
		}
		
		td{
			background-color:#343a40;
			color:white;
			white-space: nowrap;
		}
		
		th{
			background-color:black;
			color:white;
			white-space: nowrap;
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
	
	<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
	$cryptoNameArray = array("ETH"=>"Ethereum", "LTC"=>"Litecoin", "XRP"=>"Ripple");
	
	$arrayCrypto = json_decode(file_get_contents("https://min-api.cryptocompare.com/data/pricemulti?fsyms=ETH,LTC,XRP&tsyms=EUR"), true);

	$timestamp = new DateTime('-1 day');
	$timestamp = $timestamp->getTimestamp();
	
	$xrpHistory = json_decode(file_get_contents("https://min-api.cryptocompare.com/data/histominute?fsym=XRP&tsym=EUR&limit=0&aggregate=3&e=CCCAGG&toTs=".$timestamp), true);
	$ltcHistory = json_decode(file_get_contents("https://min-api.cryptocompare.com/data/histominute?fsym=LTC&tsym=EUR&limit=0&aggregate=3&e=CCCAGG&toTs=".$timestamp), true);
	$ethHistory = json_decode(file_get_contents("https://min-api.cryptocompare.com/data/histominute?fsym=ETH&tsym=EUR&limit=0&aggregate=3&e=CCCAGG&toTs=".$timestamp), true);
	
	$cryptoHistory = array("XRP"=>$xrpHistory['Data'][1]['open'], "ETH"=>$ethHistory['Data'][1]['open'], "LTC"=>$ltcHistory['Data'][1]['open']);
	
	$arrayStart = array('El Dooss'=>array("ETH"=>array("buyEuro"=>200, "buyCrypto"=>0.51), "LTC"=>array("buyEuro"=>300, "buyCrypto"=>3.89), "XRP"=>array("buyEuro"=>300, "buyCrypto"=>1447.71)), 'NeXiuS'=>array("ETH"=>array("buyEuro"=>200, "buyCrypto"=>1), "XRP"=>array("buyEuro"=>300, "buyCrypto"=>1596.13)));
	?>
	
	<div class="container-fluid">
		<div class="row mt-5">
			<div class="col-lg-8 offset-lg-2 col-sm-10 offset-sm-1 text-center">
			<?php
			foreach($arrayStart as $key=>$val){
			?>
				<h2><?php echo $key;?> dashboard</h2>
				<hr>
				<table class="table table-responsive table-bordered">
					<thead>
						<tr>
							<th>Crypto</th>
							<th>Valeur</th>
							<th>24H</th>
							<th>En possession</th>
							<th>Au départ</th>
							<th>Maintenant</th>
							<th>+/-</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$montantDepartTotal = 0;
					$montantActuelTotal = 0;
					$beneficeTotal = 0;
					
					foreach($val as $crypto=>$value){
						$montantActuel = $value['buyCrypto'] * $arrayCrypto[$crypto]['EUR'];
						$benefice = $montantActuel-$value['buyEuro'];
						$pourcentageHistory = $arrayCrypto[$crypto]['EUR']/$cryptoHistory[$crypto]*100-100;
						
						$montantDepartTotal += $value['buyEuro'];
						$montantActuelTotal += $montantActuel;
						$beneficeTotal += $benefice;
						
						if($benefice >= 0){
							$colorBenef = "green";
						}else{
							$colorBenef = "red";
						}
						
						if($pourcentageHistory >= 0){
							$colorPourcentageHistory = "green";
						}else{
							$colorPourcentageHistory = "red";
						}
					?>
						<tr>
							<td><?php echo $cryptoNameArray[$crypto];?></td>
							<td class="amount"><?php echo number_format($arrayCrypto[$crypto]['EUR'], 2, ",", " ");?> €</td>
							<td class="amount" style="color:<?php echo $colorPourcentageHistory;?>;"><?php echo number_format($pourcentageHistory, 2, ",", " ");?>%</td>
							<td class="amount"><?php echo number_format($value['buyCrypto'], 2, ",", " ");?></td>
							<td class="amount"><?php echo number_format($value['buyEuro'], 2, ",", " ");?> €</td>
							<td class="amount" style="font-weight:bold;"><?php echo number_format($montantActuel, 2, ",", " ");?> €</td>
							<td class="amount" style="font-weight:bold; color:<?php echo $colorBenef;?>;"><?php echo number_format($benefice, 2, ",", " ");?> €</td>
						</tr>
					<?php
					}
					
					if($beneficeTotal >= 0){
						$colorBenefTotal = "green";
					}else{
						$colorBenefTotal = "red";
					}
					?>
						<tr>
							<td colspan="4" style="font-weight:bold; text-align:right;">Total :</td>
							<td class="amount"><?php echo number_format($montantDepartTotal, 2, ",", " ");?> €</td>
							<td class="amount" style="font-weight:bold;"><?php echo number_format($montantActuelTotal, 2, ",", " ");?> €</td>
							<td class="amount" style="font-weight:bold; color:<?php echo $colorBenefTotal;?>;"><?php echo number_format($beneficeTotal, 2, ",", " ");?> €</td>
						</tr>
					</tbody>
				</table>
			<?php
			}
			?>
			</div>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>