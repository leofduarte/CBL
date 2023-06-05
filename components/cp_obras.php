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
      } else if ($id_func == "3") {
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
   <h1 style="color:#393166;" class="mt-5 ms-3">Obras</h1>
   <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
      <h2 style="color:#393166" class="mb-4 ">Lista de Obras</h2>

      <?php
      // Create a new DB connection
      $link = new_db_connection();

      // Create a prepared statement
      $stmt = mysqli_stmt_init($link);

      // Define the query

// Define the query
$query = "SELECT id_obra ,nome_obra, nome_beacon, ref_beacons
FROM obra 
 INNER JOIN beacons 
ON beacons.id_beacon = obra.ref_beacons order by id_obra asc ";



      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id_obra, $nome_obra, $nome_beacon, $ref_beacons);
      ?>
            <table class="data_users mb-5 w-100 text-center">
               <thead class="text-info" style="border-bottom: 1px solid grey">
                  <tr>
                     <th class="px-4">ID</th>
                     <th class="px-4">Nome</th>
                     <th class="px-4">Obra associada</th>
                     <th class="px-4">Ações</th>
                  </tr>
               </thead>
               <tbody> <?php

                        // Fetch value
                        while (mysqli_stmt_fetch($stmt)) {
                           echo "
                  <tr>
                     <th scope='row' class='my-3 px-4 py-2'>$id_obra</th>
                     <td class='my-3 px-4'>$nome_obra</td>   
                     ";
                           if ($ref_beacons == NULL) {
                              echo "<td class='my-3 px-4 text-info'>Sem beacon associado</td>";
                           } else {
                              echo " <td class='my-3 px-4 text-black'>$nome_beacon</td>";
                           }
                           echo "
                     <td class='my-3 px-4'>
                        <a href='./update_obra.php?id_obra=" . $id_obra . "'><i class='px-1 text-dark bi bi-pencil-square'></i></a>
                     </td>
                  </tr>
                  ";
                        }
                        ?> </tbody>
            </table>
            <div class="d-flex justify-content-between" style="font-size: 1.2rem;">
               <span>Showing 1 to 2 of 6 entries</span>
               <div>
                  <a class="text-roxo" href=""> <span><i class=" bi bi-arrow-left"></i></span></a>
                  <a style="text-decoration: none;"> <span style="background-color: #6E59E4;" class="mx-2 px-3 py-1 rounded text-white">nº</span></a>
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