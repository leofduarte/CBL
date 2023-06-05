<?php
// conexão à base de dados
require_once("connections/connection.php");

?>

<!-- Begin Page Content -->
<div class="container-fluid">

   <h1 style="color:#393166;" class="mt-5 ms-3">Manage Exhbitions</h1>
   <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-2 my-5">
   <div style="border-radius: 2rem; background-color:#E9E5FF;" class="p-4 my-5 mx-5">

      <?php
      // Create a new DB connection
      $link = new_db_connection();

      // Create a prepared statement
      $stmt = mysqli_stmt_init($link);

      // Define the query
      $query = "SELECT id_exposicao, nome_exposicao FROM exposicoes";

      echo '      
      <div class="dropdown">
         <a class="btn btn-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Selecione a exposição
         </a>
       <ul class="dropdown-menu">';


      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id_exposicao, $nome);

            // Fetch value
            while (mysqli_stmt_fetch($stmt)) {
                echo '
                <li style="font-size: 1.2rem"><a class="dropdown-item" href="manage_exhibitions.php?id_exposicao=' . $id_exposicao . '">'  . $nome. '</a></li>';
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
      </select>
   </div>

   <?php
   //! NOVO STMT
   // Create a prepared statement
   $stmt = mysqli_stmt_init($link);

    // Verify the query string requirements
    if (isset($_GET["id_exposicao"])) {
        // Store values
        $id_exposicao = (int) $_GET["id_exposicao"];
    }

   // Define the query
   $query = "SELECT nome_exposicao FROM exposicoes
            WHERE id_exposicao = ?";


   // Prepare the statement
   if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $id_exposicao);
      // Execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
         // Bind result variables
         mysqli_stmt_bind_result($stmt, $nome_exposicao);

         // Fetch value
            if (mysqli_stmt_fetch($stmt)) {
                echo '<p class="mt-5 fs-5">'. $nome_exposicao. '</p>';
            } else{
                echo '<p class="mt-5 fs-5">Selecione uma exposição.</p>';
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
