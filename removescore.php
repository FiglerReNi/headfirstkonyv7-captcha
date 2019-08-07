<?php
require_once 'authorize.php';
require_once 'kapcs.php'
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
    <h1>Guitar Wars - Remove a High Score</h1>
    <div>
        <?php
        if (isset($_GET['id']) && isset($_GET['datum']) && isset($_GET['nev']) && isset($_GET['pont']) && isset($_GET['fajl'])) {
            $id = $_GET['id'];
            $date = $_GET['datum'];
            $nev = $_GET['nev'];
            $score = $_GET['pont'];
            $fajl = $_GET['fajl'];
            ?>
            <div class="line">
                <p>Are you sure you want to delete the following high score?</p>
            </div>
            <div>
                <form class="addform" action="removescore.php" method="post">
                    <label class="strong">Name: </label>
                    <input class="addinput, inv" type="text" name="name" value="<?php echo $nev; ?>"><br>
                    <label class="strong">Date: </label>
                    <input class="addinput, inv" type="text" name="date" value="<?php echo $date; ?>"><br>
                    <label class="strong">Score: </label>
                    <input class="addinput, inv" type="text" name="score" value="<?php echo $score; ?>">
                    <input type="hidden" name="adat" value="<?php echo $id; ?>">
                    <input type="hidden" name="utvonal" value="<?php echo $fajl; ?>">
                    <p></p>
                    <input type="radio" name="pont" value="yes" checked>yes</input>
                    <input type="radio" name="pont" value="no">no</input><br>
                    <input class="sub, btn btn-dark" type="submit" name="submit" value="Submit">
                    <p></p>
                    <p><a href="admin.php"><< Back to admin page</a></p>
                </form>
            </div>
            <?php
        }
        if (isset($_POST['submit'])) {
            $pont = $_POST['score'];
            $name = $_POST['name'];
            $adat = $_POST['adat'];
            $torles = $_POST['pont'];
            $utvonal = $_POST['utvonal'];
            if ($torles == "yes") {
                ?>
                <div>
                    <div class="line">
                    </div>
                    <br>
                    <p>The high score of "<?php echo $pont ?>" for "<?php echo $name ?>" was successfully removed.</p>
                    <p><a href="admin.php"><< Back to admin page</a></p>
                </div>
                <?php
                @unlink(target_dir . $utvonal);
                $query2 = "DELETE FROM guitarwarsscore WHERE id = '$adat' LIMIT 1";
                mysqli_query($kapcs, $query2);
            } else {
                ?>
                <div class="line">
                </div>
                <br>
                <p>Törlés visszavonva.</p>
                <p><a href="admin.php"><< Back to admin page</a></p>
                <?php
            }
        }
        ?>
    </div>
</div>
</body>
</html>
