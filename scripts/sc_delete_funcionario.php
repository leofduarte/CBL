<?php
// We need the function!
require_once "../connections/connection.php";

if (isset($_GET["id_funcionario"])) {
   $id_func = $_GET["id_funcionario"];

   // Create a new DB connection
   $link = new_db_connection();

   /* create a prepared statement */
   $stmt = mysqli_stmt_init($link);

   $query = "DELETE FROM funcionarios
              WHERE id_funcionario = ?";

   if (mysqli_stmt_prepare($stmt, $query)) {
      /* Bind paramenters */
      mysqli_stmt_bind_param($stmt, "i", $id_func);
      /* execute the prepared statement */
      if (mysqli_stmt_execute($stmt)) {
         echo "funcionario eliminado com sucesso";
         header("Location: ../funcionarios.php?msg=1");
      } else {
         header("Location: ./funcionarios.php?msg=2");
         echo "Error:" . mysqli_stmt_error($stmt);
      }
   } else {
      echo ("Error description: " . mysqli_error($link));
   }
   /* close statement */
   mysqli_stmt_close($stmt);

   /* close connection */
   mysqli_close($link);
}
