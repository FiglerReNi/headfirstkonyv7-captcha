<?php
require_once 'authorize.php';
require_once 'kapcs.php';

$query1 = "SELECT * FROM guitarwarsscore";

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
    <h1>Guitar Wars - High Scores Administration</h1>
    <div class="line">
        <p>Below is a list of all Guitar Wars high scores. Use this page to remove scores as needed</p>
    </div>
    <div class="container">

        <?php
        while ($row = mysqli_fetch_array($result)) {
            $tomb[] = $row;
        }
        for ($i = 0; $i < count($tomb); $i++) {
            $pont = $tomb[$i]['pont'];
            $nev = $tomb[$i]['nev'];
            $datum = $tomb[$i]['datum'];
            $elfogadva = $tomb[$i]['elfogadva'];
            echo "<div class=\"d-flex\">";
            echo "<div  class=\"p-2\"><strong>'$nev'</strong></div>";
            echo "<div  class=\"p-2\" style='color: red;'><strong>'$datum'</strong></div>";
            echo "<div  class=\"p-2\" style='color: blue;'><strong>'$pont'</strong></div>";
            if ($elfogadva == 0) {
                echo '<div class="ml-auto p-2"><a href="accept.php?id=' . $tomb[$i]['id'] . '&amp;datum=' . $datum . '&amp;nev=' . $nev . '&amp;pont=' . $pont . '&amp;fajl=' . $tomb[$i]['fajl'] . '">Accept/</a>';
                echo '<a href="removescore.php?id=' . $tomb[$i]['id'] . '&amp;datum=' . $datum . '&amp;nev=' . $nev . '&amp;pont=' . $pont . '&amp;fajl=' . $tomb[$i]['fajl'] . '">Remove</a></div>';
            } else {
                echo '<div  class="ml-auto p-2"><a href="removescore.php?id=' . $tomb[$i]['id'] . '&amp;datum=' . $datum . '&amp;nev=' . $nev . '&amp;pont=' . $pont . '&amp;fajl=' . $tomb[$i]['fajl'] . '">Remove</a></div>';
            }
            echo "</div>";
        }
        mysqli_close($kapcs);
        $tomb = array_reverse($tomb);
        ?>

    </div>
</div>
</body>
</html>