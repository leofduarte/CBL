<?php
//? PÁGINA QUE ESTÁ INCORPORADA NA PÁGINA DE GESTÃO DE BEACONS (components/cp_manage_beacons.php)

require_once("connections/connection.php");


// Create a prepared statement
$stmt = mysqli_stmt_init($link);

if (isset($_GET['id_beacon'])) {
   $ref_beacons = $_GET['id_beacon'];

   // Define the query
   $query = "SELECT id_obra, nome_obra
            FROM obra 
            WHERE ref_beacons = ?";


   // Prepare the statement
   if (mysqli_stmt_prepare($stmt, $query)) {
      mysqli_stmt_bind_param($stmt, 'i', $ref_beacons);
      // Execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
         // Bind result variables
         mysqli_stmt_bind_result($stmt, $id_obra, $nome_obra);

         echo '<select class="form-select" aria-label="Default select example" name="obra">';

         // Fetch value
         if (mysqli_stmt_fetch($stmt)) {
            echo ' <option selected value="' . $id_obra . '">' . $nome_obra . '</option>';
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

   //    //? COMECA O NOVO STMT
   //    $stmt = mysqli_stmt_init($link);

   //    // Define the query
   //    $query = "SELECT id_obra, nome_obra 
   //     FROM obra 
   //     WHERE ref_beacons = ?";


   //    // Prepare the statement
   //    if (mysqli_stmt_prepare($stmt, $query)) {
   //       mysqli_stmt_bind_param($stmt, 'i', $ref_beacons);
   //       // Execute the prepared statement
   //       if (mysqli_stmt_execute($stmt)) {
   //          // Bind result variables
   //          mysqli_stmt_bind_result($stmt, $id_obra, $nome_obra);

   //          echo '
   //          <select class="form-select" aria-label="Default select example" name="obra">';
   //          // Fetch value
   //          if (mysqli_stmt_fetch($stmt)) {
   //             echo '<option selected value="' . $id_obra . '">' . $nome_obra . '</option>';
   //          }
   //       } else {
   //          // Execute error
   //          echo "Error: " . mysqli_stmt_error($stmt);
   //       }
   //    } else {
   //       // Errors related with the query
   //       echo "Error: " . mysqli_error($link);
   //    }
   //    // Close statement
   //    mysqli_stmt_close($stmt);
   // 
?>

   </select>

   <?php
   // Close connection
   mysqli_close($link);
   ?>


<?php
} else {
   echo '<h3 class="mt-5">Selecione um beacon para gerir as suas definições.</h3>';
}
