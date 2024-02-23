<?php
session_start(); 

include 'db.inc.php';

if (!isset($_SESSION["loggedInUser"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
   <link rel="stylesheet" href="styles.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WIJNFAVORIETEN Detail</title>
</head>
<body class="bg-dark">

<div class="row">
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
            <!-- Navbar links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Add any other navbar links here if needed -->
            </ul>

            <!-- Button group voor knoppen -->
            <div class='btn-group'>
                <!-- Dynamische inhoud voor bewerken, toevoegen en uitloggen -->
                <?php
                if (isset($_GET["id"])) {
                    $wineID = $_GET["id"];
                    echo "<a href='edit.php?id=$wineID' class='btn btn-md btn-dark text-white me-2 rounded-pill'><i class='fas fa-edit'></i></a>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='wine_id' value='$wineID'>";
                    echo "<a href='insert.php' class='btn btn-md btn-dark me-2 rounded-pill'> <i class='bi bi-plus-lg'></i></a>";
                    echo "<a href='index.php' class='btn btn-md btn-dark me-2 rounded-pill'><i class='fa-solid fa-arrow-rotate-left'></i></a>";
                    echo "<button type='submit' name='delete' class='btn btn-md btn-dark me-2 rounded-pill' onclick=\"return confirm('Weet je zeker dat je deze wijn wilt verwijderen?')\">";
                    echo "<i class='fa-solid fa-trash'></i>";
                    echo "</button>";

                    echo "<a href='logout.php' class='btn btn-md btn-dark me-2 rounded-pill' onclick=\"return confirm('Weet je zeker dat je wilt uitloggen?')\">";
                    echo "<i class='fa-solid fa-right-from-bracket'></i>";
                    echo "</a>";
                    echo "</form>";
                }
                ?>
            </div>
        </div>
    </div>
</nav>


            </div>


            


<div class="container bg-dark px-1 px-sm-0">
    <div class="content-wrapper bg-dark px-2 px-sm-0 "> 
    <main>
   <?php 
    if (isset($_GET["id"])) {
        $wineID = $_GET["id"]; 
        $strSQL = "SELECT wines.*, images.filename 
                     FROM wines 
                     LEFT JOIN images ON wines.id = images.wine_id 
                     WHERE wines.id = :wineID";
        $prepared = $conn->prepare($strSQL);
        $prepared->bindParam(":wineID", $wineID, PDO::PARAM_INT); 
        $prepared->execute();
      
        if ($prepared->rowCount() > 0) {
            $wine = $prepared->fetch(PDO::FETCH_ASSOC);
            echo "<div class='card table-bordered table-outer-border mb-2'>"; 
            echo "<div class='row g-0'>";
            echo "<div class='col-lg-4 bg-dark d-flex justify-content-center align-items-center'>";
            echo "<img src='uploads/" . $wine["filename"] . "' class='card-img-top mt-2 rounded-3' alt='Wijnafbeelding' style='width: 240px; height: 320px;'>";
            echo "</div>";
            // Toon tekst in een kolom 
            echo "<div class='col-lg-8'>";
            echo "<div class='card-body bg-dark text-white'>";
            echo "<h2 class='card-title bg-dark text-white'>" . $wine["naam"] . "</h2>";
            echo "<table class='table table-dark'>";
            // Tabel met details
            echo "<tr><th style='width: 30%;'>Details</th><th style='width: 70%;'></th></tr>";
            echo "<tr><td>Merk</td><td>" . $wine["merk"] . "</td></tr>";
            echo "<tr><td>Naam</td><td>" . $wine["naam"] . "</td></tr>";
            echo "<tr><td>Kleur</td><td>" . $wine["kleur"] . "</td></tr>";
            echo "<tr><td>Winkelprijs</td><td>€" . $wine["wprijs"] . "</td></tr>";
            echo "<tr><td>Restaurantprijs</td><td>" . $wine["rprijs"] . "</td></tr>";
            echo "<tr><td>Land</td><td>" . $wine["land"] . "</td></tr>";
            echo "<tr><td>Streek</td><td>" . $wine["streek"] . "</td></tr>";
            echo "<tr><td>Extra informatie</td><td>" . $wine["info"] . "</td></tr>";
            echo "<tr><td>Beoordeling</td><td>" . $wine["rating"] . "</td></tr>";
            echo "</table>";
            echo "</div>"; 
            echo "</div>"; 
            echo "</div>"; 
            echo "</div>"; 
        } else {
            echo "Wijn met id $wineid bestaat niet.";
        }
    } else {
        echo "Wijn-id is niet gespecificeerd in de URL.";
    } 
    if (isset($_POST['delete'])) {
        $wineID = $_POST['wine_id'];
        $deleteWineSQL = "DELETE FROM wines WHERE id = :wineID";
        $deleteImageSQL = "DELETE FROM images WHERE wine_id = :wineID";
        $deleteWineStmt = $conn->prepare($deleteWineSQL);
        $deleteImageStmt = $conn->prepare($deleteImageSQL);
        $deleteWineStmt->bindParam(":wineID", $wineID, PDO::PARAM_INT);
        $deleteImageStmt->bindParam(":wineID", $wineID, PDO::PARAM_INT);
        if ($deleteWineStmt->execute() && $deleteImageStmt->execute()) {
            $imageFilename = $wine['filename'];
            $upload_directory = 'uploads/';
            $imagePath = $upload_directory . $imageFilename;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            echo "<p>Wijn met ID $wineID is succesvol verwijderd.</p>";
            echo "<script>window.location = 'index.php';</script>";
        } else {
            echo "<p>Fout bij het verwijderen van de wijn.</p>";
        }
    }
    ?>
   </main>
        </div>
        </div>
        <footer class="footer text-center p-1 bg-black text-white fixed-bottom">
    <p>&copy; 2024 Wijnfavorieten <a href="mailto:voorbeeld@email.com"><i class="bi bi-envelope ms-2 text-white"></i></a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn = null; ?>
