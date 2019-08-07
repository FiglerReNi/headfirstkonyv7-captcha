<?php
session_start();
require_once 'kapcs.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guitar Wars - Add your High Score</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<?php
if (isset($_POST['submit'])) {
    $nev = mysqli_real_escape_string($kapcs, trim($_POST['nev']));
    $score = mysqli_real_escape_string($kapcs, trim($_POST['score']));
    $file = mysqli_real_escape_string($kapcs, trim($_FILES['file']['name']));
    $check = mysqli_real_escape_string($kapcs, trim($_POST['check']));
    $megjelenik = false;
    if (empty($nev) && empty($score)) {
        echo "<h6 class='container'>Név és Score mezőt nem töltötted ki<br></h6>";
        $megjelenik = true;
    } elseif (empty($nev)) {
        echo "<h6 class='container'>Név mezőt nem töltötted ki<br></h6>";
        $megjelenik = true;
    } elseif (empty($score)) {
        echo "<h6 class='container'>Score mezőt nem töltötted ki<br></h6>";
        $megjelenik = true;
    } else if (!(is_numeric($score))) {
        echo "<h6 class='container'>Score mezőbe csak számot írhatsz<br></h6>";
        $megjelenik = true;
    }  elseif (empty($file)) {
        echo "<h6 class='container'>Nem töltötted fel a képernyőképet<br><h6>";
        $megjelenik = true;
    } elseif (empty($check)) {
        echo "<h6 class='container'>Ellenőrző mezőt nem töltötted ki<br></h6>";
        $megjelenik = true;
    } elseif($_SESSION['text'] != sha1($check)){
        echo "<h6 class='container'>Ellenőrző mezőt rosszul töltötted ki<br></h6>";
        $megjelenik = true;
    } else {
        $target_file = target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $txtFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Csak képet tölthetsz fel.<br>";
            $uploadOk = 0;
        }
        if ($txtFileType != "jpeg" && $txtFileType != "gif" && $txtFileType != "png" && $txtFileType != "jpg") {
            echo "JPG vagy GIF formátumot tölthetsz csak fel.<br>";
            $uploadOk = 0;
        }
        if ($_FILES["file"]["size"] > 500000) {
            echo "Túl nagy fájl.<br>";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sikertelen feltöltés.";
            $megjelenik = true;
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $query = "INSERT INTO guitarwars.guitarwarsscore (datum, nev, pont, fajl)
              VALUES
              (NOW(), '$nev', '$score', '$file')";
                $result = mysqli_query($kapcs, $query) or die($query);
                ?>
                <div class="container">
                    <div class="line">
                        <h1>Guitar Wars - Add your High Score</h1>
                        <p>Thanks for adding your new high score!</p>
                        <label><strong>Név: </strong><?php echo $nev; ?></label><br>
                        <label><strong>Score: </strong><?php echo $score; ?></label>
                        <p><a href="highscores.php"><< Back to high scores</a></p>
                    </div>
                </div>
                <?php
            } else {
                echo "Hiba a feltöltéskor." . $_FILES["file"]["error"];;
            }
        }
    }
    if ($megjelenik) {
        ?>

        <div class="container">
            <h1>Guitar Wars - Add your High Score</h1>
            <div class="line_a">
                <form class="addform" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>"
                      method="post">
                    <label>Név: </label>
                    <input class="addinput" type="text" name="nev" value="<?php echo $nev; ?>"><br>
                    <label>Score: </label>
                    <input class="addinput" type="number" name="score" value="<?php echo $score; ?>"><br>
                    <label>Screen shot:</label>
                    <input type="file" name="file" value=""><br>
                    <label>Check:</label>
                    <input style="margin-left:1.2%" type="text" name="check">
                    <img  src='captcha_kep.php' ><br>
                    <input type="submit" name="submit" value="Add"><br>
                </form>
            </div>
        </div>
        <?php
    }
} else {
    ?>

    <div class="container">
        <h1>Guitar Wars - Add your High Score</h1>
        <div class="line_a">
            <form class="addform" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>"
                  method="post">
                <label>Név: </label>
                <input class="addinput" type="text" name="nev"><br>
                <label>Score: </label>
                <input class="addinput" type="number" name="score"><br>
                <label>Screen shot:</label>
                <input type="file" name="file"><br>
                <label>Check:</label>
                <input style="margin-left:1.2%" type="text" name="check">
                <img  src='captcha_kep.php' ><br>
                <input type="submit" name="submit" value="Add"><br>
            </form>
        </div>
    </div>

    <?php
}
@unlink($_FILES["file"]["tmp_name"]);
mysqli_close($kapcs);
?>

</body>
</html>

