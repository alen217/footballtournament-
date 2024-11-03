<?php
$servername = "sql205.infinityfree.com";
$username = "if0_37536416";
$password = "3yNZ85cigHvoE7";  
$dbname = "if0_37536416_football";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['player_id'])) {
    $player_id = $_POST['player_id'];

    $sql = "
        SELECT p.player_name, p.age, p.position, t.team_name
        FROM players p
        JOIN teams t ON p.team_id = t.team_id
        WHERE p.player_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $player_id);
    $stmt->execute();
    $stmt->bind_result($player_name, $age, $position, $team_name);
    $stmt->fetch();

    if ($player_name) {
        echo json_encode([
            'player_name' => $player_name,
            'team_name' => $team_name,
            'age' => $age,
            'position' => $position
        ]);
    } else {
        echo json_encode(['error' => 'No player found with that ID.']);
    }

    $stmt->close();
}

$conn->close();
?>
