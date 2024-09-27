<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "rock_paper_scissors";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Store game result
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $player1_name = $_POST['player1'];
    $player2_name = $_POST['player2'];
    $player1_score = $_POST['score1'];
    $player2_score = $_POST['score2'];

    $stmt = $conn->prepare("INSERT INTO game_results (player1_name, player2_name, player1_score, player2_score) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $player1_name, $player2_name, $player1_score, $player2_score);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stone Paper Scissors</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Stone Paper Scissors Game</h1>
    <form id="game-form">
        <label for="player1">Player 1 Name:</label>
        <input type="text" id="player1" required>

        <label for="player2">Player 2 Name:</label>
        <input type="text" id="player2" required>

        <h2>Choose Your Move:</h2>
        <select id="move1">
            <option value="stone">Stone</option>
            <option value="paper">Paper</option>
            <option value="scissors">Scissors</option>
        </select>
        <select id="move2">
            <option value="stone">Stone</option>
            <option value="paper">Paper</option>
            <option value="scissors">Scissors</option>
        </select>
        <button type="button" onclick="playRound()">Play Round</button>
    </form>
    
    <div id="result"></div>
    <div id="score"></div>

    <script>
        let rounds = 0;
        let player1Score = 0;
        let player2Score = 0;

        function playRound() {
            if (rounds >= 6) {
                document.getElementById("result").innerHTML = "Game Over! Final Scores - Player 1: " + player1Score + ", Player 2: " + player2Score;
                return;
            }
            rounds++;

            const player1Move = document.getElementById("move1").value;
            const player2Move = document.getElementById("move2").value;
            let roundResult;

            if (player1Move === player2Move) {
                roundResult = "It's a tie!";
            } else if ((player1Move === "stone" && player2Move === "scissors") || 
                       (player1Move === "scissors" && player2Move === "paper") || 
                       (player1Move === "paper" && player2Move === "stone")) {
                roundResult = "Player 1 wins this round!";
                player1Score++;
            } else {
                roundResult = "Player 2 wins this round!";
                player2Score++;
            }

            document.getElementById("result").innerHTML = roundResult;
            document.getElementById("score").innerHTML = "Scores - Player 1: " + player1Score + ", Player 2: " + player2Score;
        }
    </script>
</body>
</html>
