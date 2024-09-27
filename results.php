<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Game Results</h1>
    <table>
        <tr>
            <th>Player 1</th>
            <th>Player 2</th>
            <th>Player 1 Score</th>
            <th>Player 2 Score</th>
            <th>Date</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root"; // Change this to your database username
        $password = ""; // Change this to your database password
        $dbname = "rock_paper_scissors";
        $conn = new mysqli($servername, $username, $password, $dbname);
        $result = $conn->query("SELECT * FROM game_results ORDER BY created_at DESC");

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['player1_name']}</td>
                    <td>{$row['player2_name']}</td>
                    <td>{$row['player1_score']}</td>
                    <td>{$row['player2_score']}</td>
                    <td>{$row['created_at']}</td>
                  </tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
