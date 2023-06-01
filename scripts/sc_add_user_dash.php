<?php
if (isset($_POST["name"]) && isset($_POST["email"]) &&  isset($_POST["password"]) && isset($_POST["perfil"]) && isset($_POST["estado"])) {
   require_once "../connections/connection.php";
   $nome = $_POST['name'];
   $email = $_POST['email'];
   $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
   $perfil = $_POST['perfil'];
   $estado = $_POST['estado'];

   var_dump($perfil);

   $link = new_db_connection();

   $query = "INSERT INTO funcionarios (nome, email, password_hash, ref_perfil, ref_estado_registo) VALUES (?,?,?,?,?)";

   $stmt = mysqli_stmt_init($link);

   if (mysqli_stmt_prepare($stmt, $query)) {
      mysqli_stmt_bind_param($stmt, 'sssii', $nome, $email, $password_hash, $perfil, $estado);

      // Devemos validar também o resultado do execute!
      if (mysqli_stmt_execute($stmt)) {
         // Acção de sucesso
         echo "registo com sucesso";
         // header("Location: ../index.php");
      } else {
         // Acção de erro
         echo "Error:" . mysqli_stmt_error($stmt);
      }
   } else {
      // Acção de erro
      echo "Error:" . mysqli_error($link);
   }
   mysqli_stmt_close($stmt);
   mysqli_close($link);
} else {
   echo "Campos do formulário por preencher";
}
