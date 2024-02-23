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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Controleer of er een afbeelding is geüpload
        if (!empty($_FILES['image']['tmp_name'])) {
            // Lees de afbeeldingsgegevens
            $img_tmp_name = $_FILES['image']['tmp_name'];
            $img_filename = $_FILES['image']['name'];
            $img_filetype = strtolower(pathinfo($img_filename, PATHINFO_EXTENSION));

            // Controleer of het bestandstype wordt ondersteund
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            if (!in_array($img_filetype, $allowed_types)) {
                throw new Exception('Bestandstype niet ondersteund. Alleen JPG, JPEG, PNG en GIF zijn toegestaan.');
            }

            // Resize de afbeelding naar maximaal 320x240 met behoud van aspectverhouding
            $target_width = 320;
            $target_height = 240;
            list($width, $height) = getimagesize($img_tmp_name);
            $aspect_ratio = $width / $height;

            if ($width > $target_width || $height > $target_height) {
                if ($aspect_ratio > 1) { // Landscape
                    $target_width = $target_height * $aspect_ratio;
                } else { // Portret
                    $target_height = $target_width / $aspect_ratio;
                }
            }

            $resized_img = imagecreatetruecolor($target_width, $target_height);
            $source_img = imagecreatefromstring(file_get_contents($img_tmp_name));
            imagecopyresampled($resized_img, $source_img, 0, 0, 0, 0, $target_width, $target_height, $width, $height);

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

            $upload_directory = 'uploads/';
            $new_img_filename = uniqid() . "_" . $img_filename; 
            $target_path = $upload_directory . $new_img_filename;

            // Sla de geresized afbeelding op met exif-gegevens
            if (!imagejpeg($resized_img, $target_path, 80)) {
                throw new Exception('Fout bij het opslaan van de afbeelding.');
            }

            $merk = isset($_POST['merk']) ? htmlspecialchars($_POST['merk'], ENT_QUOTES, 'UTF-8') : '';
            $naam = isset($_POST['naam']) ? htmlspecialchars($_POST['naam'], ENT_QUOTES, 'UTF-8') : '';
            $kleur = isset($_POST['kleur']) ? htmlspecialchars($_POST['kleur'], ENT_QUOTES, 'UTF-8') : '';
            $wprijs = isset($_POST['wprijs']) ? htmlspecialchars($_POST['wprijs'], ENT_QUOTES, 'UTF-8') : '';
            $rprijs = isset($_POST['rprijs']) ? htmlspecialchars($_POST['rprijs'], ENT_QUOTES, 'UTF-8') : '';
            $land = isset($_POST['land']) ? htmlspecialchars($_POST['land'], ENT_QUOTES, 'UTF-8') : '';
            $streek = isset($_POST['streek']) ? htmlspecialchars($_POST['streek'], ENT_QUOTES, 'UTF-8') : '';
            $info = isset($_POST['info']) ? htmlspecialchars($_POST['info'], ENT_QUOTES, 'UTF-8') : '';
            $rating = isset($_POST['rating']) ? htmlspecialchars($_POST['rating'], ENT_QUOTES, 'UTF-8') : '';

            $sql_insert_wine = "INSERT INTO wines (merk, naam, kleur, wprijs, rprijs, land, streek, info, rating) 
                                VALUES (:merk, :naam, :kleur, :wprijs, :rprijs, :land, :streek, :info, :rating)";
            $stmt_insert_wine = $conn->prepare($sql_insert_wine);
            $stmt_insert_wine->bindParam(':merk', $merk);
            $stmt_insert_wine->bindParam(':naam', $naam);
            $stmt_insert_wine->bindParam(':kleur', $kleur);
            $stmt_insert_wine->bindParam(':wprijs', $wprijs);
            $stmt_insert_wine->bindParam(':rprijs', $rprijs);
            $stmt_insert_wine->bindParam(':land', $land);
            $stmt_insert_wine->bindParam(':streek', $streek);
            $stmt_insert_wine->bindParam(':info', $info);
            $stmt_insert_wine->bindParam(':rating', $rating);
            $stmt_insert_wine->execute();

            // Haal het ID op van de zojuist toegevoegde wijn
            $wine_id = $conn->lastInsertId();

            // Voeg de afbeeldingsinformatie toe aan de 'images' tabel
            $sql_insert_image = "INSERT INTO images (wine_id, filename) VALUES (:wine_id, :filename)";
            $stmt_insert_image = $conn->prepare($sql_insert_image);
            $stmt_insert_image->bindParam(':wine_id', $wine_id);
            $stmt_insert_image->bindParam(':filename', $new_img_filename); 
            // Gebruik de nieuwe bestandsnaam
            $stmt_insert_image->execute();

            $message = "<i class='fa-solid fa-wine-bottle'></i> Je wijnfavoriet is toegevoegd aan je overzicht! ";
        } else {
            $errors .= "Afbeelding is te groot. Kies max. 10mb!";
        }
    } catch (Exception $e) {
        $errors .= "Er is een fout opgetreden: " . $e->getMessage();
    }
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
    <title>WIJNFAVORIETEN insert</title>   
</head>

<body class="bg-dark">

<?php
if (isset($message)) {
    echo "<div class='alert-container'>";
    echo "<div id='successMessage' class='alert alert-success' role='alert'>";
    echo $message;
    echo "</div>";
    echo "</div>";
    echo "<script>";
    echo "setTimeout(function() {";
    echo "window.location.href = 'index.php';";
    echo "}, 2000);";
    echo "</script>";
} elseif (!empty($errors)) {
    echo "<div class='alert-container'>";
    echo "<div class='alert alert-danger' role='alert'>";
    echo $errors;
    echo "</div>";
    echo "</div>";
    echo "<script>";
    echo "setTimeout(function() {";
    echo "window.location.href = 'insert.php';";
    echo "}, 2000);";
    echo "</script>";
}
?>




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
                echo "<a href='index.php' class='btn btn-md btn-dark me-2 rounded-pill'><i class='fa-solid fa-arrow-rotate-left'></i></a>";
                echo "<button type='submit' name='delete' class='btn btn-md btn-dark me-2 rounded-pill' onclick=\"return confirm('Weet je zeker dat je deze wijn wilt verwijderen?')\">";
                echo "<i class='fa-solid fa-trash'></i>";
                echo "</button>";
                echo "<a href='logout.php' class='btn btn-md btn-dark me-2 rounded-pill' onclick=\"return confirm('Weet je zeker dat je wilt uitloggen?')\">";
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

<h2>Wijn toevoegen</h2>



<form action="insert.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

<style>
    /* Stijl voor het voorbeeldvenster */
    #imagePreview {
        max-width: 240px; 
        max-height: 320px; 
    }
</style>

<label for="fileInput" class="custom-file-upload btn btn-secondary mb-2" style="font-size: 0.9rem;">
    <i class="bi bi-image"></i> of <i class="bi bi-camera"></i>
</label>
<span id="fileName" class="text-danger"><br>Geen bestand geselecteerd* (max 10mb!)</span>
<br>
<img id="imagePreview" src="#" alt="Voorbeeldafbeelding" style="display: none;"> 

<input type="file" id="fileInput" name="image" accept="image/*" capture="camera" onchange="updateImagePreview(this)" required>

<script>
    function updateImagePreview(input) {
        var fileNameDisplay = document.getElementById('fileName');
        var imagePreview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                fileNameDisplay.textContent = input.files[0].name;
                
                fileNameDisplay.classList.remove('text-danger'); 
                imagePreview.style.display = 'block';
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            fileNameDisplay.textContent = 'Geen bestand geselecteerd';
            fileNameDisplay.classList.add('text-danger'); 
            imagePreview.style.display = 'none';
            imagePreview.src = '#';
        }
    }
</script>

<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="mb-3">
            <label for="merk" class="form-label">Merk</label>
            <input type="text" id="merk" name="merk" class="form-control" placeholder="Merk" required>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="mb-3">
            <label for="naam" class="form-label">Naam</label>
            <input type="text" id="naam" name="naam" class="form-control" placeholder="Naam" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="mb-3">
            <label for="kleur" class="form-label">Kleur</label>
            <select id="kleur" name="kleur" class="form-select" required>
                <option value="rood">Rood</option>
                <option value="wit">Wit</option>
                <option value="rosé">Rosé</option>
                <option value="mousserend">Mousserend</option>
            </select>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="mb-3">
            <label for="wprijs" class="form-label">Winkelprijs(€)</label>
            <input type="number" id="wprijs" name="wprijs" class="form-control" placeholder="Winkelprijs" min="0" step="0.01" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="mb-3">
            <label for="rprijs" class="form-label">Restaurantprijs(€)</label>
            <input type="number" id="rprijs" name="rprijs" class="form-control" placeholder="Restaurantprijs" min="0" step="0.01" required>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="mb-3">
            <label for="land" class="form-label">Land</label>
            <input type="text" id="land" name="land" class="form-control" placeholder="Land" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="mb-3">
            <label for="streek" class="form-label">Streek</label>
            <textarea id="streek" name="streek" class="form-control" placeholder="Streek" required></textarea>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="mb-3">
            <label for="info" class="form-label">Informatie</label>
            <textarea id="info" name="info" class="form-control" placeholder="Informatie" required></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="number" id="rating" name="rating" class="form-control" placeholder="Rating 0 tot 5" min="0" max="5" required>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
    </div>
</div>
<button type="submit" class="btn btn-secondary" style="font-size: 0.9rem;"><i class='fa-solid fa-wine-bottle'></i> Toevoegen</button>
</form>
</div>
</div>

<footer class="footer text-center p-1 bg-black text-white fixed-bottom">
    <p>&copy; 2024 Wijnfavorieten <a href="mailto:voorbeeld@email.com"><i class="bi bi-envelope ms-2 text-white"></i></a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function validateForm() {
        var fileInput = document.getElementById('fileInput');
        if (fileInput.files.length === 0) {
            alert('Selecteer een afbeelding voordat je het formulier instuurt.');
            return false; 
        }
        return true; 
    }
</script>
</body>
</html>
