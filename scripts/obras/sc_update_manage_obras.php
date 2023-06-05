<?php
session_start();
require_once "../../connections/connection.php";

if (isset($_POST["genero"]) && ($_POST["genero"] != "") && (isset($_SESSION["id_genero"]))) {
   $tipo = $_POST["genero"];
   $id = $_SESSION["id_genero"];

   // Create a new DB connection
   $link = new_db_connection();

   /* create a prepared statement */
   $stmt = mysqli_stmt_init($link);

   $query = "UPDATE obra
             SET ref_beacon = ?
             WHERE id_obra = ?";

   if (mysqli_stmt_prepare($stmt, $query)) {
      /* Bind paramenters */
      mysqli_stmt_bind_param($stmt, "si", $tipo, $id);
      /* execute the prepared statement */
      if (mysqli_stmt_execute($stmt)) {
         header("Location: ./../../generos.php?msg=6");
      } else {
         echo "Error:" . mysqli_stmt_error($stmt);
      }
   } else {
      echo ("Error description: " . mysqli_error($link));
   }
   /* close statement */
   mysqli_stmt_close($stmt);
   /* close connection */
   mysqli_close($link);
} else {
   header("Location: ./../../generos.php");
}
