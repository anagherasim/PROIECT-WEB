<?php
session_start();

$db_host = 'mysql_db';
$db_username = 'root';
$db_password = 'toor';
$db_name = 'images';

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM images");
$stmt->execute();
$result = $stmt->get_result();
$images = [];
while ($image = $result->fetch_assoc()) {
    $images[] = $image;
}

$searchResults = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['create'])) {
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
                            <script>
                                window.location.href = "zonasecurizataimagini.php";
                            </script>
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
                            <p><a href='zonasecurizataimagini.php' class='btn btn-primary'>Back to the site</a></p>
                        </div>
                    </div>";
            }
        } else {
            if (isset($_POST["descriere"]) && $_POST["descriere"] != "") {
                echo "<div class='container'>
                        <div class='alert alert-danger'>
                            <h2><i class='fas fa-exclamation-circle'></i> Please select a file to upload!</h2>
                            <p><a href='zonasecurizataimagini.php' class='btn btn-primary'>Back to the site</a></p>
                        </div>
                    </div>";
            } else {
                echo "<div class='container'>
                        <div class='alert alert-danger'>
                            <h2><i class='fas fa-exclamation-circle'></i> Please enter a description and select a file to upload!</h2>
                            <p><a href='zonasecurizataimagini.php' class='btn btn-primary'>Back to the site</a></p>
                        </div>
                    </div>";
            }
        }
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $descriere = $_POST['descriere'];

        if (!empty($_FILES['image']['tmp_name'])) {
            $image = $_FILES["image"];
            $image_name = $image["name"];
            $image_tmp_name = $image["tmp_name"];
            $image_size = $image["size"];
            $image_type = $image["type"];

            $check = getimagesize($image_tmp_name);
            if ($check !== false) {
                $image_data = file_get_contents($image_tmp_name);
                if ($image_data === false) {
                    echo "Error reading image file.";
                } else {
                    $image_data = base64_encode($image_data);
                    $stmt = $conn->prepare("UPDATE images SET image_data = ?, descriere = ? WHERE id = ?");
                    $stmt->bind_param("ssi", $image_data, $descriere, $id);
                    $stmt->execute();
                }
            } else {
                echo "File is not an image.";
            }
        } else {
            $stmt = $conn->prepare("UPDATE images SET descriere = ? WHERE id = ?");
            $stmt->bind_param("si", $descriere, $id);
            $stmt->execute();
        }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}


if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $stmt = $conn->prepare("SELECT * FROM images WHERE descriere LIKE ?");
    $likeQuery = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($image = $result->fetch_assoc()) {
        $searchResults[] = $image;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body {
            display: flex;
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
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-group input, .form-group button {
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

<div class="container">
    <a href="index.php"><button type="button">Back to the site</button></a>
    <h2>Create New Image</h2>
    <form method="POST" action="zonasecurizataimagini.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" required>
        </div>
        <div class="form-group">
            <label for="descriere">Description</label>
            <input type="text" name="descriere" placeholder="Description" required>
        </div>
        <div class="form-group">
            <button type="submit" name="create">Create</button>
        </div>
    </form>
</div>
<div class="container">
    <h2>Update Image</h2>
    <?php foreach ($images as $image) { ?>
        <form method="POST" action="zonasecurizataimagini.php" enctype="multipart/form-data">
            <input type="number" name="id" value="<?php echo $image['id']; ?>" hidden>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label for="descriere">Description</label>
                <input type="text" name="descriere" value="<?php echo $image['descriere']; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" name="update">Update</button>
            </div>
        </form>
    <?php } ?>
</div>
<div class="container">
    <h2>Delete Image</h2>
    <form method="POST" action="zonasecurizataimagini.php">
        <div class="form-group">
            <label for="id">Image ID</label>
            <input type="number" name="id" placeholder="Image ID" required>
        </div>
        <div class="form-group">
            <button type="submit" name="delete">Delete</button>
        </div>
    </form>
</div>
<div class="container">
    <h2>Search Images</h2>
    <form method="GET" action="zonasecurizataimagini.php">
        <div class="form-group">
            <label for="search">Search</label>
            <input type="text" name="search" placeholder="Search by description" required>
        </div>
        <div class="form-group">
            <button type="submit">Search</button>
        </div>
    </form>
</div>
<div class="container">
    <h2>Images</h2>
    <?php if (isset($_GET['search'])) { ?>
        <?php if (empty($searchResults)) { ?>
            <p>No results found for '<?php echo htmlspecialchars($_GET['search']); ?>'.</p>
        <?php } else { ?>
            <?php foreach ($searchResults as $image) { ?>
                <div class="form-group">
                    <img src="data:image/jpeg;base64,<?php echo $image['image_data']; ?>" alt="Image" style="max-width: 100%; height: auto;">
                    <p><?php echo $image['descriere']; ?></p>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <?php foreach ($images as $image) { ?>
            <div class="form-group">
                <img src="data:image/jpeg;base64,<?php echo $image['image_data']; ?>" alt="Image" style="max-width: 100%; height: auto;">
                <p><?php echo $image['descriere']; ?></p>
            </div>
        <?php } ?>
    <?php } ?>
</div>
</body>
</html>
