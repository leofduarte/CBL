<?php
// We need the function!
require_once "../connections/connection.php";

if (isset($_GET["id_obra"])) {
   $id_obra = $_GET["id_obra"];

   // Create a new DB connection
   $link = new_db_connection();

   /* create a prepared statement */
   $stmt = mysqli_stmt_init($link);

   $query = "UPDATE obra
              SET nome_obra = ?, ref_beacons = ?
              WHERE id_obra = ?";

   if (mysqli_stmt_prepare($stmt, $query)) {
      /* Bind paramenters */
      mysqli_stmt_bind_param($stmt, "si", $nome_obra, $ref_beacons);
      /* execute the prepared statement */
      if (mysqli_stmt_execute($stmt)) {
         header("Location: ../obras.php?msg=10");
      } else {
         echo "Error:" . mysqli_stmt_error($stmt);
      }
   } else {
      header("Location: ../obras.php?msg=11");
      echo ("Error description: " . mysqli_error($link));
   }
   /* close statement */
   mysqli_stmt_close($stmt);

   /* close connection */
   mysqli_close($link);
}
