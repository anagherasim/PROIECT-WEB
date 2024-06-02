<?php
session_start();

$con=mysqli_connect("mysql_db","root","toor","login");

if (!$con) {
    die("Connection failed: ". mysqli_connect_error());
}

$searchResults = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['create'])) {
        $mail = $_POST['mail'];
        $parola = $_POST['parola']; 
        $query = $con->prepare("INSERT INTO login (mail, parola) VALUES (?,?)");
        $query->bind_param('ss', $mail, $parola);
        $query->execute();
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $mail = $_POST['mail'];
        $parola = $_POST['parola'];
        $query = $con->prepare("UPDATE login SET mail =?, parola =? WHERE id =?");
        $query->bind_param('ssi', $mail, $parola, $id);
        $query->execute();
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = $con->prepare("DELETE FROM login WHERE id =?");
        $query->bind_param('i', $id);
        $query->execute();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = $con->prepare("SELECT * FROM login WHERE mail LIKE?");
    $likeSearch = "%$search%";
    $query->bind_param('s', $likeSearch);
    $query->execute();
    $result = $query->get_result();
    while ($user = $result->fetch_assoc()) {
        $searchResults[] = $user;
    }
}


$query = $con->prepare("SELECT * FROM login");
$query->execute();
$result = $query->get_result();
$users = [];
while ($user = $result->fetch_assoc()) {
    $users[] = $user;
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
    
<div class="container">
<a href="index.php"><button type="button">Back to the site</button></a>
    <h2>Create New User</h2>
    <form method="POST" action="zonasecurizatauseri.php">
        <div class="form-group">
            <label for="mail">Email</label>
            <input type="email" name="mail" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="parola">Password</label>
            <input type="password" name="parola" placeholder="Parola" required>
        </div>
        <div class="form-group">
            <button type="submit" name="create">Create</button>
        </div>
    </form>
</div>
<div class="container">
    <h2>Update User</h2>
    <?php foreach ($users as $user) {?>
        <form method="POST" action="zonasecurizatauseri.php">
            <input type="number" name="id" value="<?php echo $user['id'];?>" hidden>
            <div class="form-group">
                <label for="mail">Email</label>
                <input type="email" name="mail" value="<?php echo $user['mail'];?>" required>
            </div>
            <div class="form-group">
                <label for="parola">Password</label>
                <input type="password" name="parola" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="update">Update</button>
            </div>
        </form>
    <?php }?>

</div>
<div class="container">
    <h2>Delete User</h2>
    <form method="POST" action="zonasecurizatauseri.php">
        <div class="form-group">
            <label for="id">User ID</label> 
            <input type="number" name="id" placeholder="User ID" required>
        </div>
        <div class="form-group">
            <button type="submit" name="delete">Delete</button>
        </div>
    </form>
</div>
<div class="container">
    <h2>Search for a user</h2>
    <form method="GET" action="zonasecurizatauseri.php">
        <div class="form-group">
            <label for="search">Search</label>
            <input type="search" name="search" placeholder="Search by email">
        </div>
        <div class="form-group">
            <button type="submit">Search</button>
        </div>
    </form>
    <?php if (!empty($searchResults)) {?>
    <ul>
        <?php foreach ($searchResults as $user) {?>
            <li>
                ID: <?php echo $user['id'];?>, Email: <?php echo $user['mail'];?>
            </li>
        <?php }?>
    </ul>
    <?php } else {?>
    <p>No search results found.</p>
    <?php }?>
</div>


</body>
</html>