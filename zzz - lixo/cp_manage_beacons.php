<?php
// conexão à base de dados
require_once("connections/connection.php");
?>


<!-- Begin Page Content -->
<div class="container-fluid">

   <h1 style="color:#393166;" class="mt-5 ms-3">Gestor de Beacons</h1>
   <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
      <h2 style="color:#393166" class="mb-4">Beacons</h2>
      <?php
      // Create a new DB connection
      $link = new_db_connection();

      // Create a prepared statement
      $stmt = mysqli_stmt_init($link);

      if (isset($_GET['id_beacon'])) {
         $id_beacon = $_GET['id_beacon'];
      } else {
         $id_beacon = 0;
      }

      // Define the query
      $query = "SELECT id_beacon, nome_beacon, uuid_beacon FROM beacons";


      // btn btn-light border border-2 border-dark-subtle
      echo '      
      <div class="dropdown">
         <a class="btn-definir-beacon px-4  dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">';

      if ($id_beacon == 0) {
         echo '<span>Selecionar Beacon</span>';
      } else {
         echo '<span>Beacon ' . $id_beacon . '</span>';
      }

      echo '  </a>
       <ul class="dropdown-menu">';

      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id_beacon, $nome_beacon, $uuid);

            // Fetch value
            while (mysqli_stmt_fetch($stmt)) {
               echo '
               <li style="font-size: 1.2rem">
               <a class="dropdown-item" href="manage_beacons.php?id_beacon=' . $id_beacon . '">' . $nome_beacon . '</a>
               </li>';
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
   <?php include_once "components/cp_manage_obras.php" ?>
</div>