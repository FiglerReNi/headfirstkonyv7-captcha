<?php
header('Refresh: 300');
require_once 'kapcs.php';

$query1 = "SELECT * FROM guitarwarsscore WHERE elfogadva = 1 ";

$result = mysqli_query($kapcs, $query1) or die ($query1);
?>

<!DOCTYPE html>
<html lang="hu-HU">
<head>
    <meta charset="UTF-8">
    <title>Guitar Wars - High Scores</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Guitar Wars - High Scores</h1>
    <div class="line">
        <p>Welcome Guitar Warrior, do you have what it takes to crack the high score list? If so just,
            <a href="addscores.php"> add your own score.</a></p>
    </div>
    <div>
        <?php
        while ($row = mysqli_fetch_array($result)) {
            $tomb[] = $row;
        }
        usort($tomb, function ($a, $b) {
            return $b['pont'] - $a['pont'];
        });
        echo "<h2 class='h2'>TOP SCORE: " . $tomb[0]['pont'] . "</h2>";
        for ($i = 0; $i < count($tomb); $i++) {
            $pont = $tomb[$i]['pont'];
            $nev = $tomb[$i]['nev'];
            $datum = $tomb[$i]['datum'];
            $file = $tomb[$i]['fajl'];
                echo "<table>";
                echo "<tr><td><strong>$pont</strong><br>";
                echo "<strong>Name: </strong>$nev<br>";
                echo "<strong>Date: </strong>$datum</td>";
                if (!empty($file)) {
                    echo '<td><img src="' . target_dir . $file . '" alt="score image"></td></tr>';
                } else {
                    echo '<td><img src="' . alapkep . '" alt="score images"></td></tr>';
                }
                echo "</table>";
                echo "<br>";
        }
        mysqli_close($kapcs);
        ?>
    </div>
</div>
</body>
</html>