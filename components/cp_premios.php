<?php
// conexão à base de dados
require_once("connections/connection.php");
?>

<!-- Begin Page Content -->
<div class="container-fluid">

   <?php
   if (isset($_GET["msg"])) {
      // Store values
      $id_func = $_GET["msg"];
      if ($id_func == "1") {
         $mensagem = "Funcionário eliminado com sucesso";
         $color = "bg-danger text-white";
      } else if ($id_func == "2") {
         $mensagem = "Erro! Funcionário não eliminado";
         $color = "bg-info text-white";
      } elseif ($id_func == "3") {
         $mensagem = "Funcionário atualizado com sucesso";
         $color = "bg-success text-white";
      } else if ($id_func == "4") {
         $mensagem = "Erro! Funcionário não atualizado";
         $color = "bg-info text-white";
      } else if ($id_func == "5") {
         $mensagem = "Funcionário adicionado com sucesso";
         $color = "bg-success text-white";
      } else if ($id_func == "6") {
         $mensagem = "Erro! Funcionário não adicionado";
         $color = "bg-info text-white";
      }
   ?>


      <div class="toast-container position-absolute p-3" style="z-index: 99; right: 0; top: 4rem;">
         <div id="liveToast" class="toast <?= $color ?>" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-body">
               <?= $mensagem ?>
            </div>
         </div>
      </div>

      <script>
         window.onload = function() {
            var toastElement = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
         }
      </script>

   <?php } ?>


   <?php

   // Create a new DB connection
   $link = new_db_connection();

   // Create a prepared statement
   $stmt = mysqli_stmt_init($link);

   // Define the query
   $query = "SELECT id_premio, descricao FROM premios
   inner join jogos";

   // Prepare the statement
   if (mysqli_stmt_prepare($stmt, $query)) {
      // Execute the prepared statement  
      if (mysqli_stmt_execute($stmt)) {
         // Bind result variables
         mysqli_stmt_bind_result($stmt, $id_premio, $descricao);
   ?>

         <h1 style="color:#393166;" class="mt-5 ms-3">Prémios</h1>
         <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
            <div class="d-flex justify-content-between">
               <h2 style="color:#393166 justify-content-start" class="mb-4 ">Lista de Prémios</h2>
            </div>


            <table class="data_users mb-5 w-100 text-center">
               <thead class="text-info" style="border-bottom: 1px solid grey">
                  <tr>
                     <th class="px-4">ID</th>
                     <th class="px-4">Descrição</th>
                  </tr>
               </thead>
               <tbody>

                  <?php
                  // Fetch value
                  while (mysqli_stmt_fetch($stmt)) {
                     echo "
                        <tr>
                           <th scope='row' class='my-3 px-4 py-3'>$id_premio</th>
                           <td class='my-3 px-4'>$descricao</td>
                        </tr>";
                  }
                  ?>
               </tbody>
            </table>
            <div class="d-flex justify-content-between" style="font-size: 1.2rem;">
               <span>Showing 1 to 2 of 6 entries</span>
               <div>
                  <a class="text-roxo" href=""> <span><i class=" bi bi-arrow-left"></i></span></a>
                  <a style="text-decoration: none;" href="#"> <span style="background-color: #6E59E4;" class="mx-2 px-3 py-1 rounded text-white">nº</span></a>
                  <a class="text-roxo" href=""> <span><i class="bi bi-arrow-right"></i></span></a>
               </div>
            </div>
         </div>

   <?php

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