<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Upload</title>
    <style>
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
        .alert-success h2,
        .alert-danger h2 {
            margin-top: 0;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        .btn-primary:hover {
            color: #fff;
            background-color: #23527c;
            border-color: #1d4e7a;
        }
    </style>
</head>
<body>

<?php
$db_host = 'mysql_db';
$db_username = 'root';
$db_password = 'toor';
$db_name = 'images';

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["image"]) && $_FILES["image"]["name"] != "") {
        $image = $_FILES["image"];
        $image_name = $image["name"];
        $image_tmp_name = $image["tmp_name"];
        $image_size = $image["size"];
        $image_type = $image["type"];

        if (isset($_POST["descriere"]) && $_POST["descriere"] != "") {
            $descriere = $_POST['descriere'];
            $check = getimagesize($image_tmp_name);
            if ($check !== false) {
                $image_data = file_get_contents($image_tmp_name);
                if ($image_data === false) {
                    echo "Error reading image file.";
                } else {
                    $image_data = base64_encode($image_data);
                    $stmt = $conn->prepare("INSERT INTO images (image_data, descriere) VALUES (?, ?)");
                    $stmt->bind_param("ss", $image_data, $descriere);
                    $stmt->execute();
                    $id = $stmt->insert_id;
                    if ($id > 0) {
                        ?>
                        <div class="container">
                            <div class="alert alert-success">
                                <h2><i class="fas fa-check-circle"></i> Image uploaded successfully!</h2>
                                <p>Image ID: <?php echo $id; ?></p>
                                <p><a href="contact.php" class="btn btn-primary">Back to the site</a></p>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "Error uploading image: " . $conn->error;
                    }
                }
            } else {
                echo "File is not an image.";
            }
        } else {
            echo "<div class='container'>
                    <div class='alert alert-danger'>
                        <h2><i class='fas fa-exclamation-circle'></i> Please enter a description!</h2>
                        <p><a href='contact.php' class='btn btn-primary'>Back to the site</a></p>
                    </div>
                </div>";
        }
    } else {
        if (isset($_POST["descriere"]) && $_POST["descriere"] != "") {
            echo "<div class='container'>
                    <div class='alert alert-danger'>
                        <h2><i class='fas fa-exclamation-circle'></i> Please select a file to upload!</h2>
                        <p><a href='contact.php' class='btn btn-primary'>Back to the site</a></p>
                    </div>
                </div>";
        } else {
            echo "<div class='container'>
                    <div class='alert alert-danger'>
                        <h2><i class='fas fa-exclamation-circle'></i> Please enter a description and select a file to upload!</h2>
                        <p><a href='contact.php' class='btn btn-primary'>Back to the site</a></p>
                    </div>
                </div>";
        }
    }
}
?>

</body>
</html>
