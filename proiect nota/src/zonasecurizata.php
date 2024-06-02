<!DOCTYPE html>
<html>
<head>
	<title>Button Page</title>
	<style>
		body {
			display: flex;
            flex-direction: column;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
		}
		.container {
			max-width: 400px;
			margin: 0 auto;
			padding: 20px;
			background-color: #f9f9f9;
			border: 1px solid #ccc;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			height: 100vh;
		}
		.form-group {
            margin-bottom: 20px;
		}
		.form-group label {
			display: block;
			margin-bottom: 0.5rem;
		}
		.form-group input,.form-group button {
			width: 100%;
			padding: 0.5rem;
			box-sizing: border-box;
			font-size: 16px;
		}
		.form-group button {
			background-color: #007bff;
			color: white;
			border: none;
			cursor: pointer;
		}
		.form-group button:hover {
			background-color: #0056b3;
		}
	</style>
</head>
<body>
		<div class="form-group">
			<button type="button" onclick="location.href='zonasecurizatauseri.php'">Go to the users admin panel</button>
		</div>

		<div class="form-group">
			<button type="button" onclick="location.href='zonasecurizataimagini.php'">Go to the images admin panel</button>
		</div>
        <div class="form-group">
        <a href="index.php"><button type="button">Back to the site</button></a>
    </div>

</body>
</html>