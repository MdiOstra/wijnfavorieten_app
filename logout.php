<?php
session_start();

if (isset($_SESSION["loggedInUser"])) {
    $logoutMessage = "Je bent uitgelogd.";
    session_destroy();
} else {
    header("Location: login.php");
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
   
    <title>WIJNFAVORIETEN logout</title>
    
</head>
<?php
$logoutMessage = "Je bent uitgelogd. Tot ziens!";
?>

<body style="background-image: url('IMG_3200.JPG'); background-size: cover;">

<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Wijnfavorieten</a>
    </div>
</nav>

<div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="text-center">
        <?php if (isset($logoutMessage)) : ?>
            <h1 class= "alert alert-success" role="alert"><?php echo $logoutMessage; ?></h1>
            
            <meta http-equiv="refresh" content="2;url=login.php"> <!-- Hier is de verandering -->
        <?php else : ?>
            <p class="text-white">Er is iets misgegaan. <a href="login.php" class="text-white">Ga terug naar de inlogpagina</a>.</p>
        <?php endif; ?>
    </div>
</div>

<footer class="footer text-center p-1 bg-black text-white fixed-bottom">
    <p>&copy; 2024 Wijnfavorieten 
        <a href="mailto:voorbeeld@email.com"><i class="bi bi-envelope ms-2 text-white"></i></a>
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>



</html>