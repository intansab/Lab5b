<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_5b";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch existing user data
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Use a prepared statement to update the user
    $stmt = $conn->prepare("UPDATE users SET name = ?, role = ? WHERE matric = ?");
    $stmt->bind_param("sss", $name, $role, $matric);
    $stmt->execute();
    $stmt->close();

    // Redirect after update
    header("Location: manageuser.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .form-container {
            width: 400px;
            margin: 50px auto; /* Centers the form horizontally */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center; /* Centers text and form fields */
        }

        h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column; /* Arrange fields vertically */
        }

        label {
            margin-bottom: 5px;
            text-align: left;
            font-weight: bold;
            color: #555;
        }

        input[type="text"] {
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            width: 100%; /* Full width of the container */
            box-sizing: border-box;
        }

        button {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #4cae4c;
        }

        a {
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 0.9em;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Update User</h2>
        <form method="POST" action="update.php">
            <label for="matric">Matric:</label>
            <input type="text" name="matric" value="<?php echo htmlspecialchars($user['matric']); ?>" readonly>

            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="level">Access Level:</label>
            <input type="text" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" required>

            <button type="submit">Update</button>
            <a href="manageuser.php">Cancel</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
