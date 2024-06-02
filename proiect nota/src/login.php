<?php
session_start();

$con=mysqli_connect("mysql_db","root","toor","login");

if (!$con) {
    die("Connection failed: ". mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$correctSum=$_POST['correctsum'];
	$userEnteredSum=$_POST['captcha'];

	if($correctSum==$userEnteredSum){

		$mailtrim = trim($_POST['mail']);
		$mailtrip=stripcslashes($mailtrim);
		$finalmail=htmlspecialchars($mailtrip);

		$remember_me = isset($_POST['remember_me']) && $_POST['remember_me'] == 'on';

		$parolatrim = trim($_POST['parola']);
		$parolatrip=stripcslashes($parolatrim);
		$finalparola=htmlspecialchars($parolatrip);

		if ($remember_me) {

    		$token = bin2hex(random_bytes(16)); 
    		$_SESSION['remember_token'] = $token; 
    		setcookie('remember_token', $token, time() + (30 * 24 * 3600), '/', '', true, true); 
		}

		$sql = "SELECT * FROM login where mail='$finalmail' AND parola='$finalparola'";
		$result = mysqli_query($con,$sql);
    
		if (mysqli_num_rows($result) >= 1) {
    		$_SESSION["myuser"]=$finalmail;
			$_SESSION["mypassword"]=$finalparola;

    		if ($finalmail == "admin" && $finalparola == "admin") {
    			$_SESSION["is_admin"] = true;
    		}

    		header("location: index.php");
    		exit;
		}
		else
	{
    		$_SESSION["error"]="No valid user";
    		header("Location:login.php");
    		exit;
		}
	}
	else{
		$_SESSION["error"]="Incorrect sum";
		header("Location:login.php");
		exit;
	}
}
if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
} else {
    $error = "";
}

$number1=rand(1,9);
$number2=rand(1,9);
$sum=$number1+$number2;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f0f0f0;
		}
		
		.login-form {
			width: 320px;
			margin: 40px auto;
			padding: 20px;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}
		
		.login-form label {
			display: block;
			margin-bottom: 10px;
		}
		
		.login-form input[type="text"],.login-form input[type="password"] {
			width: 90%;
			padding: 10px;
			margin-bottom: 20px;
			border: 1px solid #ccc;
		}
		
		.login-form input[type="submit"] {
			background-color: #4CAF50;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}
		
		.login-form input[type="submit"]:hover {
			background-color: #3e8e41;
		}
		.modal {
  		display: none; 
  		position: fixed; 
  		z-index: 1; 
  		left: 0;
  		top: 0;
  		width: 100%; 
  		height: 100%; 
 		overflow: auto; 
  		background-color: rgb(0,0,0); 
  		background-color: rgba(0,0,0,0.4); 
		}
		.modal-content {
  		background-color: #fefefe;
  		margin: 15% auto; 
  		padding: 20px;
  		border: 1px solid #888;
  		width: 80%; 
		}

	.close {
  		color: #aaa;
  		float: right;
  		font-size: 28px;
  		font-weight: bold;
	}

	.close:hover,
	.close:focus {
	  color: black;
	  text-decoration: none;
	  cursor: pointer;
	}

	</style>
</head>
<body>
	<div class="login-form">
		<h2>Login</h2>
		<form action="login.php" method="post">
			<label for="mail">Email:</label>
			<input type="text" id="mail" name="mail" required>
			
			<label for="parola">Password:</label>
			<input type="password" id="parola" name="parola" required>
			
			<input type="checkbox" id="remember_me" name="remember_me" value="1">Remember me
            <?php if ($error) { echo "<br><span style='color:red'>$error</span>"; } ?>
            </br>

			<input type="hidden" name="correctsum" value="<?php echo $sum;?>"/>
			<?php echo $number1.'+'.$number2.' = ';?>
			<input type="text" name="captcha" /><br/>

			<input type="submit" value="Login">
		</form>
	</div>
</body>
</html>