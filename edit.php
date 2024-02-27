<?php

use function imagecreatetruecolor;
use function imagecopyresampled;
use function imagejpeg;

session_start();

require_once "db.inc.php";

if (!isset($_SESSION["loggedInUser"])) {
    header("Location: login.php");
    exit();
}

$errors = '';

try {
    // Haal de bestaande gegevens van de wijn op
    $wineID = $_GET["id"];
    $sql_select_wine = "SELECT * FROM wines WHERE id = :wineID";
    $stmt_select_wine = $conn->prepare($sql_select_wine);
    $stmt_select_wine->bindParam(":wineID", $wineID, PDO::PARAM_INT);
    $stmt_select_wine->execute();
    $wine = $stmt_select_wine->fetch(PDO::FETCH_ASSOC);

    // Haal het bestaande afbeeldingsbestand op
    $sql_select_image = "SELECT filename FROM images WHERE wine_id = :wineID";
    $stmt_select_image = $conn->prepare($sql_select_image);
    $stmt_select_image->bindParam(":wineID", $wineID, PDO::PARAM_INT);
    $stmt_select_image->execute();
    $image = $stmt_select_image->fetch(PDO::FETCH_ASSOC);

    // URL van het bestaande afbeeldingsbestand
    $imageURL = 'uploads/' . $image['filename'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Controleer of rating binnen het bereik van 0 en 5 ligt
        if ($_POST['rating'] < 0 || $_POST['rating'] > 5) {
            $errors .= "Rating moet tussen 0 en 5 liggen.<br>";
        }

        // Controleer of er een afbeelding is geüpload
        if (!empty($_FILES['fileToUpload']['tmp_name'])) {
            // Lees de afbeeldingsgegevens
            $img_tmp_name = $_FILES['fileToUpload']['tmp_name'];
            $img_filename = $_FILES['fileToUpload']['name'];

            // Resize de afbeelding naar maximaal 320x240
            $target_width = 320;
            $target_height = 240;
            list($width, $height) = getimagesize($img_tmp_name);
            $aspect_ratio = $width / $height;

            if ($width > $target_width || $height > $target_height) {
                if ($target_width / $target_height > $aspect_ratio) {
                    $target_width = $target_height * $aspect_ratio;
                } else {
                    $target_height = $target_width / $aspect_ratio;
                }
            }

            $resized_img = imagecreatetruecolor($target_width, $target_height);
            $source_img = imagecreatefromstring(file_get_contents($img_tmp_name));
            imagecopyresampled($resized_img, $source_img, 0, 0, 0, 0, $target_width, $target_height, $width, $height);

            // Kopieer exif-gegevens van de oorspronkelijke afbeelding naar de aangepaste afbeelding
            if (function_exists('exif_read_data')) {
                $exif = exif_read_data($img_tmp_name);
                if ($exif !== false) {
                    if (!empty($exif['Orientation'])) {
                        switch ($exif['Orientation']) {
                            case 3:
                                $resized_img = imagerotate($resized_img, 180, 0);
                                break;
                            case 6:
                                $resized_img = imagerotate($resized_img, -90, 0);
                                break;
                            case 8:
                                $resized_img = imagerotate($resized_img, 90, 0);
                                break;
                        }
                    }
                }
            }

            // Verplaats en hernoem de geüploade afbeelding
            $upload_directory = 'uploads/';
            $new_img_filename = uniqid() . "_" . $img_filename; // Unieke bestandsnaam met prefix
            $target_path = $upload_directory . $new_img_filename;

            // Sla de op maat gemaakte afbeelding op
            imagejpeg($resized_img, $target_path, 80);

            echo "Het bestand " . htmlspecialchars($new_img_filename) . " is succesvol geüpload.";

            // Update de afbeeldingsinformatie in de database
            $updateImageSQL = "UPDATE images SET filename = :filename WHERE wine_id = :wineID";
            $updateImageStmt = $conn->prepare($updateImageSQL);
            $updateImageStmt->bindParam(":filename", $new_img_filename, PDO::PARAM_STR);
            $updateImageStmt->bindParam(":wineID", $wineID, PDO::PARAM_INT);
            if ($updateImageStmt->execute()) {
                echo "<p>Afbeelding is succesvol gekoppeld aan de wijn.</p>";
                // Verwijder het oude afbeeldingsbestand als het bestaat
                if (file_exists($upload_directory . $image['filename'])) {
                    unlink($upload_directory . $image['filename']);
                }
            } else {
                echo "<p>Er is een fout opgetreden bij het koppelen van de afbeelding aan de wijn.</p>";
            }
        }

        // Update de andere velden in de database
        $updateWineSQL = "UPDATE wines SET merk = :merk, 
                                       naam = :naam, 
                                       kleur = :kleur, 
                                       wprijs = :wprijs, 
                                       rprijs = :rprijs, 
                                       land = :land, 
                                       streek = :streek, 
                                       info = :info, 
                                       rating = :rating 
                                       WHERE id = :wineID";

        $updateWineStmt = $conn->prepare($updateWineSQL);
        $updateWineStmt->bindParam(":merk", $_POST['merk'], PDO::PARAM_STR);
        $updateWineStmt->bindParam(":naam", $_POST['naam'], PDO::PARAM_STR);
        $updateWineStmt->bindParam(":kleur", $_POST['kleur'], PDO::PARAM_STR);
        $updateWineStmt->bindParam(":wprijs", $_POST['wprijs'], PDO::PARAM_STR);
        $updateWineStmt->bindParam(":rprijs", $_POST['rprijs'], PDO::PARAM_STR);
        $updateWineStmt->bindParam(":land", $_POST['land'], PDO::PARAM_STR);
        $updateWineStmt->bindParam(":streek", $_POST['streek'], PDO::PARAM_STR);
        $updateWineStmt->bindParam(":info", $_POST['info'], PDO::PARAM_STR);
        $updateWineStmt->bindParam(":rating", $_POST['rating'], PDO::PARAM_STR);
        $updateWineStmt->bindParam(":wineID", $wineID, PDO::PARAM_INT);
        if ($updateWineStmt->execute()) {
            $message = "<i class='fa-solid fa-wine-bottle'></i> Je wijnfavoriet is aangepast! "; 
        } else {
            $errors .= "<p>Er is een fout opgetreden bij het bijwerken van de wijngegevens.</p>";
        }
    }
} catch (Exception $e) {
    // Vang de uitzondering op en geef een gepaste foutmelding weer
    $errors .= "Kies een afbeelding van maximaal 10 mb.";
    // JavaScript om na 2 seconden terug te keren naar het formulier
    echo "<script>
            setTimeout(function() {
                window.location.href = 'edit.php?id=" . $wineID . "'; // Vervang 'edit.php?id=' door de juiste URL van je formulier
            }, 2000);
          </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="styles.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WIJNFAVORIETEN - aanpassen</title>
    
<body class="bg-dark">

<div class="alert-container">
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo ($errors); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($message)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'index.php?kleur=rood';
            }, 2000);
        </script>
    <?php endif; ?>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Wijnfavorieten</a>
        <button class="navbar-toggler" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarSupportedContent" 
        aria-controls="navbarSupportedContent" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <div class='btn-group'>
                <?php
                echo "<a href='index.php' class='btn btn-md btn-dark me-2 rounded-pill' title='HOME'><i class='fa-solid fa-arrow-rotate-left'></i></a>";
                echo "<a href='logout.php' class='btn btn-md btn-dark me-2 rounded-pill' title='UITLOGGEN' onclick=\"return confirm('Weet je zeker dat je wilt uitloggen?')\">";
                echo "<i class='fa-solid fa-right-from-bracket'></i>";
                echo "</a>";
                
                echo "</form>";
                ?>
            </div>
        </div>
    </div>
</nav>
<div class="container bg-dark text-white px-1 px-sm-0">
<div class="content-wrapper bg-dark px-2 px-sm-0 ">

<h2>Wijn bewerken</h2>

<form action="edit.php?id=<?php echo htmlspecialchars($_GET["id"]); ?>" method="post" enctype="multipart/form-data">
    <label for="currentImage">Huidige afbeelding:</label><br>
    <img src="<?php echo htmlspecialchars($imageURL); ?>" alt="Current Image" style="width: 240px; height: 320px;">
    <br><br>
<label for="fileToUpload" class="custom-file-upload btn btn-secondary mb-2" style="font-size: 0.9rem;">
    <i class="bi bi-image"></i> of <i class="bi bi-camera"></i>
</label>
<span id="fileName" class="text-white"><br>Geen nieuwe afbeelding geselecteerd (max 10mb!)</span>
<br>
<img id="imagePreview" src="#" alt="Voorbeeldafbeelding" style="display: none; max-width: 240px; max-height: 320px;">
<input type="file" name="fileToUpload" id="fileToUpload" style="display:none;" onchange="updateImagePreview(this)" accept="image/*" capture="camera"><br><br>

<script>
    function updateImagePreview(input) {
        var fileNameDisplay = document.getElementById('fileName');
        var imagePreview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                fileNameDisplay.textContent = input.files[0].name;
                imagePreview.style.display = 'block';
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            fileNameDisplay.textContent = 'Geen bestand geselecteerd';
            imagePreview.style.display = 'none';
            imagePreview.src = '#';
        }
    }
</script>

<form>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="merk" class="form-label">Merk:</label>
            <input type="text" name="merk" id="merk" value="<?php echo htmlspecialchars($wine['merk']); ?>" class="form-control" required>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="naam" class="form-label">Naam:</label>
            <input type="text" name="naam" id="naam" value="<?php echo htmlspecialchars($wine['naam']); ?>" class="form-control" required>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="kleur" class="form-label">Kleur:</label>
            <select name="kleur" id="kleur" class="form-select" required>
                <option value="rood" <?php if ($wine['kleur'] == 'rood') {
                    echo 'selected'; 
                                     } ?>>Rood</option>
                <option value="wit" <?php if ($wine['kleur'] == 'wit') {
                    echo 'selected'; 
                                    } ?>>Wit</option>
                <option value="rosé" <?php if ($wine['kleur'] == 'rosé') {
                    echo 'selected'; 
                                     } ?>>Rosé</option>
                <option value="mousserend" <?php if ($wine['kleur'] == 'mousserend') {
                    echo 'selected'; 
                                           } ?>>Mousserend</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="wprijs" class="form-label">Winkelprijs(€):</label>
            <input type="number" step="0.01" name="wprijs" id="wprijs" value="<?php echo htmlspecialchars($wine['wprijs']); ?>" class="form-control" required>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="rprijs" class="form-label">Restaurantprijs(€):</label>
            <input type="number" step="0.01" name="rprijs" id="rprijs" value="<?php echo htmlspecialchars($wine['rprijs']); ?>" class="form-control" required>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="land" class="form-label">Land:</label>
            <input type="text" name="land" id="land" value="<?php echo htmlspecialchars($wine['land']); ?>" class="form-control" required>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="streek" class="form-label">Streek:</label>
            <textarea name="streek" id="streek" class="form-control" required><?php echo htmlspecialchars($wine['streek']); ?></textarea>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="info" class="form-label">Informatie:</label>
            <textarea name="info" id="info" class="form-control" required><?php echo htmlspecialchars($wine['info']); ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="rating" class="form-label">Rating:</label>
            <input type="number" min="0" max="5" name="rating" id="rating" value="<?php echo htmlspecialchars($wine['rating']); ?>" class="form-control" required>
        </div>
    </div>
    <button type="submit" class="btn btn-secondary mt-2" style="font-size: 0.9rem;"><i class='fa-solid fa-wine-bottle'></i> Aanpassen</button>
</form>
</div>
</div>
<footer class="footer text-center p-1 bg-black text-white fixed-bottom">
    <p>&copy; 2024 Wijnfavorieten <a href="mailto:voorbeeld@email.com"><i class="bi bi-envelope ms-2 text-white"></i></a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
