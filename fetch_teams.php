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

    $sql = "SELECT team1_id, team2_id FROM matches WHERE match_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $match_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $team1_id = $row['team1_id'];
        $team2_id = $row['team2_id'];

        $sql_teams = "SELECT team_name FROM teams WHERE team_id = ? OR team_id = ?";
        $stmt_teams = $conn->prepare($sql_teams);
        $stmt_teams->bind_param("ss", $team1_id, $team2_id);
        $stmt_teams->execute();
        $teams_result = $stmt_teams->get_result();

        if ($teams_result->num_rows == 2) {
            $team_names = $teams_result->fetch_all(MYSQLI_ASSOC);
            $response = array(
                'success' => true,
                'team1_name' => $team_names[0]['team_name'],
                'team2_name' => $team_names[1]['team_name']
            );
            echo json_encode($response);
        } else {
            echo json_encode(array('success' => false));
        }
        $stmt_teams->close();
    } else {
        echo json_encode(array('success' => false));
    }
    $stmt->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'No match_id provided'));
}

$conn->close();
?>
