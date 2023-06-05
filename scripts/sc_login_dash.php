<?php
require_once "../connections/connection.php";

if (isset($_POST["email"]) && isset($_POST["password"])) {
   $email = $_POST['email'];
   $password = $_POST['password'];


   $link = new_db_connection();

   $stmt = mysqli_stmt_init($link);

   $query = "SELECT id_funcionario, nome, email, password_hash FROM funcionarios 
   WHERE email LIKE ?";

   if (mysqli_stmt_prepare($stmt, $query)) {
      mysqli_stmt_bind_param($stmt, 's', $email);

      if (mysqli_stmt_execute($stmt)) {

         mysqli_stmt_bind_result($stmt, $id_funcionario, $nome, $email, $password_hash);

         if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $password_hash)) {
               // Guardar sessão de utilizador
               session_start();
               $_SESSION["id_funcionario"] = $id_funcionario;
               $_SESSION["nome"] = $nome;
               $_SESSION["email"] = $email;


               header("Location: ./inicio.php");
               // Feedback de sucesso
               echo "sucesso de login";
            } else {
               // Feedback de erro
               echo "erro de login";
            }
         }
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
   // Acção de erro
   echo "Campos do formulário por preencher";
}
