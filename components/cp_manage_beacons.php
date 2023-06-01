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
      <select class="form-select p-3 px-4 border border-2 border-dark rounded" aria-label="Default select example">
      <option selected>Selecione o Beacon</option>';

      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id_beacon, $uuid);

            // Fetch value
            while (mysqli_stmt_fetch($stmt)) {

               echo '<option value="' . $id_beacon . '">Beacon' . " " . $id_beacon . '</option>';
               echo "<p>$id_beacon <span> -> $uuid </span></p>";
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
      </select>
   </div>