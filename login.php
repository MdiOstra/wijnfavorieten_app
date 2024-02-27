<?php

require_once "db.inc.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["wachtwoord"]; 

    $query = "SELECT * FROM gebruikers WHERE username = :username AND wachtwoord = :password";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {   
        session_start();

        $_SESSION["loggedInUser"] = $result["id"]; 
        header("Location: index.php?kleur=rood");
        exit();
    } else {
        $errorMessage = "Onjuiste gebruikersnaam/wachtwoord combinatie";
    }
    $stmt->closeCursor();
    $conn = null;
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
    <title>WIJNFAVORIETEN login</title>
</head>
<body style="background-image: url('inloggen.JPEG'); background-size: cover;">
<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Wijnfavorieten</a>
    </div>
</nav>

<?php if (isset($errorMessage)) : ?>
    <div id="errorMessage" class="alert alert-danger" role="alert" style="position: relative; z-index: 9999;">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>

<script>
    setTimeout(function(){
        var errorMessage = document.getElementById('errorMessage');
        if(errorMessage){
            errorMessage.style.display = 'none';
        }
    }, 2000);
</script>


<form action="login.php" method="post" class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="col-md-6 col-lg-4">
        <div class="mb-3">
            <label for="username" class="form-label"></label>
            <input type="text" id="username" name="username" class="form-control" placeholder="gebruikersnaam" required>
        </div>
        <div class="mb-3">
            <label for="wachtwoord" class="form-label "></label>
            <input type="password" id="wachtwoord" name="wachtwoord" class="form-control" placeholder="wachtwoord" required>
        </div>
        <button type="submit" class="btn btn-outline-light btn-sm">Login</button>
    </div>
</form>

<footer class="footer text-center p-1 bg-black text-white fixed-bottom">
    <p>&copy; 2024 Wijnfavorieten 
        <a href="mailto:voorbeeld@email.com"><i class="bi bi-envelope ms-2 text-white"></i></a>
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
