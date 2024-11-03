<?php
$servername = "sql205.infinityfree.com";
$username = "if0_37536416";
$password = "3yNZ85cigHvoE7";  
$dbname = "if0_37536416_football"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['team_id'])) {
    $team_id = $_POST['team_id'];

    $sql = "SELECT team_name, coach_name FROM teams WHERE team_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $team_id);
    $stmt->execute();
    $stmt->bind_result($team_name, $coach_name);
    $stmt->fetch();

    if ($team_name) {
        echo json_encode([
            'team_name' => $team_name,
            'coach_name' => $coach_name
        ]);
    } else {
        echo json_encode(['error' => 'No team found with that ID.']);
    }

    $stmt->close();
}

$conn->close();
?>
