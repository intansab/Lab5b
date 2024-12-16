<?php
session_start();

// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_5b";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle DELETE Request
if (isset($_GET['delete'])) {
    $matric = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE matric='$matric'");
    header("Location: manageuser.php"); // Refresh page
}

// Fetch users data
$result = $conn->query("SELECT matric, name, role FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="form-container">
    <h2 style="text-align: center;">Users</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Level</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['matric']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <!-- Update and Delete Buttons -->
                    <a href="update.php?matric=<?php echo $row['matric']; ?>">Update</a> |
                    <a href="manageuser.php?delete=<?php echo $row['matric']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
