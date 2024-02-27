<?php
session_start(); 

require_once "db.inc.php";

if (!isset($_SESSION["loggedInUser"])) {
    header("Location: login.php");
    exit();
}

error_reporting(E_ALL); 
ini_set('display_errors', 1);

if (!isset($_GET['kleur'])) {
    header("Location: index.php?kleur=rood");
    exit();
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
   
    <title>WIJNFAVORIETEN home</title>
    
 

    
</head>
<body class="bg-dark">



      <div class="row">

<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
<div class="container-fluid">

<div class="col-3">
        <a class="navbar-brand" href="index.php">Wijnfavorieten</a>

</div>
<div class="col-6 d-flex justify-content-end align-items-center">
               </div>
               <button class="navbar-toggler" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarSupportedContent" 
        aria-controls="navbarSupportedContent" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
</div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">            
            </ul>
            <div class="btn-group" role="group" aria-label="Kleuren">
            <a href="?kleur=rood" class="btn btn-dark btn-md ms-2 me-2 rounded-pill <?php 
            echo (isset($_GET['kleur']) && $_GET['kleur'] == 'rood') ? 'active' : ''; ?>" title="ROOD">
    <i class="fa-solid fa-wine-glass" style="color:#800000;"></i>
</a>
<a href="?kleur=wit" class="btn btn-dark btn-md me-2 rounded-pill <?php 
    echo (isset($_GET['kleur']) && $_GET['kleur'] == 'wit') ? 'active' : ''; ?>" title="WIT">
    <i class="fa-solid fa-wine-glass" style="color:#EEEDC4;"></i>
</a>
<a href="?kleur=rosé" class="btn btn-dark btn-md me-2 rounded-pill <?php 
    echo (isset($_GET['kleur']) && $_GET['kleur'] == 'rosé') ? 'active' : ''; ?>" title="ROSÉ">
    <i class="fa-solid fa-wine-glass" style="color:#FFB9B9;"></i>
</a>
<a href="?kleur=mousserend" class="btn btn-dark btn-md me-2 rounded-pill <?php 
    echo (isset($_GET['kleur']) && $_GET['kleur'] == 'mousserend') ? 'active' : ''; ?>" title="MOUSSEREND">
    <i class="fa-solid fa-wine-glass" style="color:#ffcc66;"></i>
</a>
<a href='insert.php' class='btn btn-dark btn-md me-2 rounded-pill' title='TOEVOEGEN'> <i class='bi bi-plus-lg'></i></a>
<a href='logout.php' class='btn btn-dark btn-md me-2 rounded-pill' title='UITLOGGEN' onclick="return confirm('Weet je zeker dat je wilt uitloggen?')"><i class='fa-solid fa-right-from-bracket'></i></a>
</div>  
</div>
</div>
</nav>
</div>
<div class="container bg-dark px-1 px-sm-0">
    <div class="content-wrapper bg-dark px-2 px-sm-0 "> 

<?php
    
if (isset($_GET['kleur'])) {
        $kleur = $_GET['kleur'];
        echo "<h2 class='text-white text-center'>" . ucfirst($kleur) . "</h2>";
            
        $kleurColumn = isset($_GET["{$kleur}_column"]) ? $_GET["{$kleur}_column"] : "naam";
        $kleurOrder = isset($_GET["{$kleur}_order"]) ? $_GET["{$kleur}_order"] : "ASC";
            
        $kleurSQL = "SELECT wines.*, images.filename 
                        FROM wines 
                        LEFT JOIN images ON wines.id = images.wine_id 
                        WHERE kleur = :kleur 
                        ORDER BY $kleurColumn $kleurOrder";

        $kleurPrepared = $conn->prepare($kleurSQL);
        $kleurPrepared->bindParam(':kleur', $kleur);
        $kleurPrepared->execute();

    if ($kleurPrepared->rowCount() > 0) {
        $kleurPrepared->setFetchMode(PDO::FETCH_ASSOC);
        echo "<div class='row'>";
        echo "<div class='col-12'>";
        echo "<div class='table-responsive rounded'>";
        echo "<table class='table table-bordered table-outer-border'>";
        echo "<tr class='table-dark text-white'>";
        echo "<th class='border-0'></th>";
                

        echo "<th class='border-0'><a href='?kleur=$kleur&{$kleur}_column=merk&{$kleur}_order=" .
        ($kleurColumn === "merk" && $kleurOrder === "ASC" ? "DESC" : "ASC") .
        "'class='text-white'>Merk";
        echo $kleurColumn === "merk" && $kleurOrder === "ASC" ? "<i class='bi bi-arrow-down'></i>" : "<i class='bi bi-arrow-up'></i></i>";
        echo "</a></th>";
        echo "<th class='border-0'><a href='?kleur=$kleur&{$kleur}_column=naam&{$kleur}_order=" .
            ($kleurColumn === "naam" && $kleurOrder === "ASC" ? "DESC" : "ASC") .
            "'class='text-white'>Naam";
        echo $kleurColumn === "naam" && $kleurOrder === "ASC" ? "<i class='bi bi-arrow-down'></i>" : "<i class='bi bi-arrow-up'></i></i>";
        echo "</a></th>";
        echo "<th class='border-0'><a href='?kleur=$kleur&{$kleur}_column=wprijs&{$kleur}_order=" .
            ($kleurColumn === "wprijs" && $kleurOrder === "ASC" ? "DESC" : "ASC") .
            "'class='text-white'>Winkelprijs";
        echo $kleurColumn === "wprijs" && $kleurOrder === "ASC" ? "<i class='bi bi-arrow-down'></i>" : "<i class='bi bi-arrow-up'></i></i>";
        echo "</a></th>";
        echo "<th class='border-0'><a href='?kleur=$kleur&{$kleur}_column=rating&{$kleur}_order=" .
            ($kleurColumn === "rating" && $kleurOrder === "ASC" ? "DESC" : "ASC") .
            "'class='text-white'>Rating";
        echo $kleurColumn === "rating" && $kleurOrder === "ASC" ? "<i class='bi bi-arrow-down'></i>" : "<i class='bi bi-arrow-up'></i></i>";
        echo "</a></th>";
        echo "<th class='border-0'></th>";
        echo "</tr>";
        while ($row = $kleurPrepared->fetch()) {
            echo "<tr class='table-dark text-white'>";
            echo "<td>";
            if (!empty($row["filename"])) {
                echo "<img src='uploads/" . $row["filename"] . "' width='60' height='80'>";
            } else {
                echo "Geen afbeelding beschikbaar";
            }
            echo "</td>";
            echo "<td>" . $row["merk"] . "</td>";
            echo "<td>" . $row["naam"] . "</td>";
            echo "<td>€" . $row["wprijs"] . "</td>";
            echo "<td>" . $row["rating"] . "</td>";
            echo "<td><a href='detail.php?id=" . $row["id"] . "' class='text-white icon-hover' title='DETAILS' tabindex='0'>";
            echo "<i class='bi bi-info-circle icon-bold'></i>";
            echo "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<h4 class='text-white text-center'> Nog geen wijnfavoriet voor $kleur in je overzicht. Wil je er één toevoegen ";
        echo "<a href='insert.php' class='btn btn-secondary btn-md me-2 rounded-pill'> <i class='bi bi-plus-lg'></i></a> ?";
        echo "</h4>";        
    }
}
?>
        
    </div>
</div> 
<footer class="footer text-center p-1 bg-black text-white fixed-bottom">
    <p>&copy; 2024 Wijnfavorieten <a href="mailto:voorbeeld@email.com"><i class="bi bi-envelope ms-2 text-white"></i></a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

   </body>
</html>