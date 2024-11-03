<?php
$servername = "sql205.infinityfree.com";
$username = "if0_37536416";
$password = "3yNZ85cigHvoE7";  
$dbname = "if0_37536416_football"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE user_id = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);  

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: add_score.html");
        exit();
    } else {
        echo "<script>alert('Incorrect email or password. Please try again.'); window.location.href='index.html';</script>";
    }

    $stmt->close();
} else {
    echo "Please provide both email and password.";
}

$conn->close();
?>
