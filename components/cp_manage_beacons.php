<?php
// conexão à base de dados
require_once("connections/connection.php");
?>

<!-- Begin Page Content -->
<div class="container-fluid">

   <h1 style="color:#393166;" class="mt-5 ms-3">Gestor de Beacons</h1>
   <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 my-5">

      <?php
      // Create a new DB connection
      $link = new_db_connection();

      // Create a prepared statement
      $stmt = mysqli_stmt_init($link);

      // Define the query
      $query = "SELECT id_beacon, uuid_beacon FROM beacons";

      echo '      
      <div class="dropdown">
         <a class="btn btn-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Selecione o Beacon
         </a>
       <ul class="dropdown-menu">';

      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id_beacon, $uuid);

            // Fetch value
            while (mysqli_stmt_fetch($stmt)) {
               echo '
               <li style="text-align: center; font-size: 1.2rem"><a class="dropdown-item" href="manage_beacons.php?id=' . $id_beacon . '">Beacon' . " " . $id_beacon . '</a></li>';
            }
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
      ?>

      </ul>
   </div>


   <?php
   //! NOVO STMT
   // Create a prepared statement
   $stmt = mysqli_stmt_init($link);

   // Define the query
   $query = "SELECT id_obra, nome_obra, ref_beacons FROM obra";


   // Prepare the statement
   if (mysqli_stmt_prepare($stmt, $query)) {

      // Execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
         // Bind result variables
         mysqli_stmt_bind_result($stmt, $id_obra, $nome_obra, $ref_beacons);

         // Fetch value
         if ($ref_beacons == NULL) {
            if (mysqli_stmt_fetch($stmt)) {
               echo '<p class="mt-5 fs-5">Selecione um beacon para gerir as suas definições.</p>';
            }
         }
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

</div>