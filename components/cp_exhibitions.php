<?php
// conexão à base de dados
require_once("connections/connection.php");

if (isset($_GET["id"])) {
   // Store values
   $id_exposicao = (int) $_GET["id"];
   ?>



   <!-- mensagens de error -->
   <?php
   if (isset($_GET["msg"])) {
      // Store values
      $id_func = $_GET["msg"];
      if ($id_func == "1") {
         $mensagem = "Exposição eliminada com sucesso";
         $color = "bg-danger text-white";
      } else if ($id_func == "2") {
         $mensagem = "Erro! Exposição não eliminada";
         $color = "bg-info text-white";
      } elseif ($id_func == "3") {
         $mensagem = "Exposição atualizada com sucesso";
         $color = "bg-success text-white";
      } else if ($id_func == "4") {
         $mensagem = "Erro! Exposição não atualizada";
         $color = "bg-info text-white";
      } else if ($id_func == "5") {
         $mensagem = "Exposição adicionada com sucesso";
         $color = "bg-success text-white";
      } else if ($id_func == "6") {
         $mensagem = "Erro! Exposição não adicionada";
         $color = "bg-info text-white";
      }
      ?>

      <div class="toast-container position-absolute p-3" style="z-index: 99; right: 0; top: 4rem;">
         <div id="liveToast" class="toast <?= $color ?>" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-delay="5000">
            <div class="toast-body">
               <?= $mensagem ?>
            </div>
         </div>
      </div>

      <script>
         window.onload = function () {
            var toastElement = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
         }
      </script>

   <?php } ?>

   <div class="container-fluid">

      <?php
      // Create a new DB connection
      $link = new_db_connection();

      // Create a prepared statement
      $stmt = mysqli_stmt_init($link);

      // Define the query
      $query = "
         SELECT exposicoes.nome_exposicao, salas.nome_sala, obra.nome_obra, exposicoes.data_inicio, exposicoes.data_fim
         FROM exposicoes
         INNER JOIN salas_has_exposicoes 
         ON exposicoes.id_exposicao = salas_has_exposicoes.exposicoes_id_exposicao
         INNER JOIN salas ON salas_has_exposicoes.salas_id_sala = salas.id_sala
         INNER JOIN exposicoes_has_obra
         ON exposicoes.id_exposicao = exposicoes_has_obra.exposicoes_id_exposicao
         INNER JOIN obra 
         ON obra.id_obra = exposicoes_has_obra.obra_id_obra
         WHERE exposicoes.id_exposicao = ?
         ";


      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {
         mysqli_stmt_bind_param($stmt, "i", $id_exposicao);

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $nome_exposicao, $nome_sala, $nome_obra, $data_inicio, $data_fim);
            ?>

            <h1 style="color:#393166;" class="mt-5 ms-3">Exposições</h1>

            <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">


               <table class="data_users mb-5 w-100 text-center">
                  <thead class="text-info" style="border-bottom: 1px solid grey">
                     <tr>
                        <th class="px-4"> ID</th>
                        <th class="px-4">Salas</th>
                        <th class="px-4">Obra</th>
                        <th class="px-4">Data Inicio</th>
                        <th class="px-4">Data Fim</th>
                        <th class="px-4">Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php

                     // Fetch value
                     while (mysqli_stmt_fetch($stmt)) {
                        echo "
                  <tr>
                     <th scope='row' class='my-3 px-4 py-2'>$id_exposicao</th>
                     <td class='my-3 px-4'>$nome_sala</td>
                     <td class='my-3 px-4'>$nome_obra</td>";

                        if ($data_inicio == NULL) {
                           echo "<td class='my-3 px-4 text-info'>Não há registos</td>";
                        } else {
                           echo " <td class='my-3 px-4 text-black'>$data_inicio</td>";
                        }

                        if ($data_fim == NULL) {
                           echo "<td class='my-3 px-4 text-info'>Não há registos</td>";
                        } else {
                           echo " <td class='my-3 px-4 text-black'>$data_fim</td>";
                        }
                        echo "
                     <td class='my-3 px-4'>
                        <a href='./update_exposicoes.php?id=" . $id_exposicao . "'><i class='px-1 text-dark bi bi-pencil-square'></i></a>
                     </td>
                  </tr>
                  ";
                     }
                     ?>
                  </tbody>
               </table>
               <div class="d-flex justify-content-between" style="font-size: 1.2rem;">
                  <span>Showing 1 to 2 of 6 entries</span>
                  <div>
                     <a class="text-roxo" href=""> <span><i class=" bi bi-arrow-left"></i></span></a>
                     <a style="text-decoration: none;"> <span style="background-color: #6E59E4;"
                           class="mx-2 px-3 py-1 rounded text-white">nº</span></a>
                     <a class="text-roxo" href=""> <span><i class="bi bi-arrow-right"></i></span></a>
                  </div>
               </div>
            </div>
            <a class="btn btn-primary mt-4" href="<?php echo (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'exposicoes.php') ?> ">Voltar</a>

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

} else {


   ?>



      <!-- Begin Page Content -->
      <div class="container-fluid">

         <h1 style="color:#393166;" class="mt-5 ms-3">Exposições</h1>
         <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
            <h2 style="color:#393166" class="mb-4 ">Gerir Exposições</h2>


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
                <li style="font-size: 1.2rem">
                <a class="dropdown-item" href="./exposicoes.php?id=' . $id_exposicao . '">' . $nome . '</a>
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
            </select>

         </div>
      </div>
   <?php } ?>