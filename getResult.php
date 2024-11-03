
<?php
$servername = "sql205.infinityfree.com";
$username = "if0_37536416";
$password = "3yNZ85cigHvoE7";  
$dbname = "if0_37536416_football"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['match_id'])) {
    $match_id = $_POST['match_id'];

    $sql = "SELECT team1_score, team2_score, winner_team_id FROM matchresults WHERE match_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $match_id);
    $stmt->execute();
    $stmt->bind_result($team1_score, $team2_score, $winner_team_id);
    $stmt->fetch();

    if ($team1_score !== null) {
        echo json_encode([
            'team1_score' => $team1_score,
            'team2_score' => $team2_score,
            'winner_team_id' => $winner_team_id
        ]);
    } else {
        echo json_encode(['error' => 'No match result found with that ID.']);
    }

    $stmt->close();
}

$conn->close();
?>
