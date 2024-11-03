<?php

$servername = "sql205.infinityfree.com";
$username = "if0_37536416";
$password = "3yNZ85cigHvoE7";
$dbname = "if0_37536416_football";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['score_match_id'], $_POST['team1_score'], $_POST['team2_score'], $_POST['winner_team_id'])) {
    $match_id = $_POST['score_match_id'];
    $team1_score = (int)$_POST['team1_score'];
    $team2_score = (int)$_POST['team2_score'];
    $winner_team_id = $_POST['winner_team_id'];

    $sql_insert = "INSERT INTO matchresults (match_id, team1_score, team2_score, winner_team_id) 
                   VALUES (?, ?, ?, ?)";

    $stmt_insert = $conn->prepare($sql_insert);

    if ($stmt_insert === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt_insert->bind_param("siis", $match_id, $team1_score, $team2_score, $winner_team_id);

    if ($stmt_insert->execute()) {
        echo "New match result added successfully for Match ID: $match_id.";
    } else {
        // Check if the error is due to a duplicate match_id (primary key constraint)
        if ($conn->errno === 1062) { 
            echo "Error: A match result for Match ID $match_id already exists.";
        } else {
            echo "Error adding new match result: " . $stmt_insert->error;
        }
    }

    $stmt_insert->close();

} else {
    echo "Please provide all required fields.";
}

$conn->close();
?>