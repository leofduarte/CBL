<?php
// conexão à base de dados
require_once("connections/connection.php");

// Create a new DB connection
$link = new_db_connection();

// Create a prepared statement
$stmt = mysqli_stmt_init($link);

// Define the query
$query = "SELECT id_funcionario, nome, role , email, tipo_estado FROM funcionarios
   INNER JOIN perfil ON ref_perfil = id_perfil 
   INNER JOIN estado_registo ON ref_estado_registo = id_estado_registo";

// Prepare the statement
if (mysqli_stmt_prepare($stmt, $query)) {

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $id_funcionario, $nome, $role, $email, $tipo_estado);
    } else {
        // Execute error
        echo "Error: " . mysqli_stmt_error($stmt);
    }
} else {
    // Errors related with the query
    echo "Error: " . mysqli_error($link);
}
// Close statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($link);
?>

<!-- Página LOGIN -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Custom styles for this template-->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles-dash.css">
    <!-- <link href="./css/sb-admin-2.css" rel="stylesheet"> -->
</head>


<div class="d-flex ">
    <div>
        <img class="vh-100" src="img/login_img.jpg" alt="login imagem">
    </div>
    <div class="d-flex justify-content-center flex-column">
        <img class="logo_vertical" src="img/logo_vertical_dashboard.svg" alt="logotipo">
        <form action="./scripts/sc_login_dash.php" method="post">
            <div class="mb-3 mt-3">
                <input class="input-login" type="text" placeholder="Email" name="email" required>
            </div>
            <div class="mb-3">
                <input class="input-login" type="password" placeholder="Password" name="password" required>
            </div>
            <button type="submit" class="btn-submit btn btn-primary px-4">Submit</button>
        </form>
    </div>
</div>

<?php var_dump($_SESSION); ?>