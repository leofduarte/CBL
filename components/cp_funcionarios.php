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
   $query = "SELECT id_funcionario, nome, email, role, id_estado_registo, tipo_estado FROM funcionarios
      INNER JOIN perfil ON ref_perfil = id_perfil
      INNER JOIN estado_registo ON ref_estado_registo = id_estado_registo
      ";


   //* FILTRAR COMENTÁRIOS
   if (isset($_GET['filterBy'])) {
      if ($_GET['filterBy'] == 'ativo') {
         $query = $query . " AND tipo_estado = 'Ativo'";
      } else if ($_GET['filterBy'] == 'inativo') {
         $query = $query . " AND tipo_estado = 'Inativo'";
      } else if ($_GET['filterBy'] == 'suspenso') {
         $query = $query . " AND tipo_estado = 'Suspenso'";
      }
   }

   if (isset($_GET['filterBy'])) {
      if ($_GET['filterBy'] == 'ativo') {
         $active = "btn-secondary text-white";
      } else if ($_GET['filterBy'] == 'inativo') {
         $inactive = "btn-secondary text-white";
      } else if ($_GET['filterBy'] == 'suspenso') {
         $suspended = "btn-secondary text-white";
      }
   }


   //* ORDENAR COMENTÁRIOS
   $textoOrdenacao = "";
   if (isset($_GET['orderBy'])) {
      if ($_GET['orderBy'] == 'nome') {
         if ($_GET['order']) {
            if ($_GET['order'] == 'DESC') {
               $query = $query . " ORDER BY nome DESC";
               $textoOrdenacao = "Nome DESC";
            } else {
               $query = $query . " ORDER BY nome ASC";
               $textoOrdenacao = "Nome ASC";
            }
         }
      } else if ($_GET['orderBy'] == 'estado') {
         if ($_GET['order']) {
            if ($_GET['order'] == 'DESC') {
               $query = $query . " ORDER BY tipo_estado DESC";
               $textoOrdenacao = "Estado DESC";
            } else {
               $query = $query . " ORDER BY tipo_estado ASC";
               $textoOrdenacao = "Estado ASC";
            }
         }
      }
   }

   // Prepare the statement
   if (mysqli_stmt_prepare($stmt, $query)) {
      // Execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
         // Bind result variables
         mysqli_stmt_bind_result($stmt, $id_funcionario, $nome, $email, $role, $id_estado_registo, $tipo_estado);
   ?>

         <h1 style="color:#393166;" class="mt-5 ms-3">Funcionários</h1>
         <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
            <div class="d-flex justify-content-between">
               <h2 style="color:#393166 justify-content-start" class="mb-4 ">Lista de Funcionários</h2>

               <div class="dropdown d-flex align-content-middle me-4" style="margin: 0 0 1rem 0; right: 0;">
                  <button class=" btn text-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                     <span>Filtrar Por </span></button>
                  <ul class="dropdown-menu w-100 p-0" aria-labelledby="dropdownMenuButton">
                     <li>
                        <a href="./funcionarios.php" class="btn text-dark w-100" type="button" id="todos">
                           <span>Todos</span>
                        </a>
                     </li>
                     <hr class="p-0 m-0">
                     <li>
                        <a href="./funcionarios.php?filterBy=ativo" class="btn w-100 <?= $active ?>" type="button" id="ativo">
                           <span>Ativo</span>
                        </a>
                     </li>
                     <hr class="p-0 m-0">
                     <li>
                        <a href="./funcionarios.php?filterBy=inativo" class="btn w-100 <?= $inactive ?>" type="button" id="inativo">
                           <span>Inativo</span>
                        </a>
                     </li>
                     <hr class="p-0 m-0">
                     <li>
                        <a href="./funcionarios.php?filterBy=suspenso" class="btn w-100 <?= $suspended ?>" type="button" id="suspenso">
                           <span>Suspenso</span>
                        </a>
                     </li>
                  </ul>
               </div>

               <div class="dropdown d-flex justify-content-end align-content-middle" style="margin: 0 1rem 1rem 0; right:0;">
                  <button class="btn text-dark dropdown-toggle p-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                     Ordenar: <?= $textoOrdenacao ?>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                     <li><a class="dropdown-item" href="./funcionarios.php?orderBy=nome&order=ASC">Nome ASC</a></li>
                     <li><a class="dropdown-item" href="./funcionarios.php?orderBy=nome&order=DESC">Nome DESC</a></li>
                     <li><a class="dropdown-item" href="./funcionarios.php?orderBy=estado&order=DESC">Estado DESC</a></li>
                     <li><a class="dropdown-item" href="./funcionarios.php?orderBy=estado&order=ASC">Estado ASC</a></li>

                  </ul>
               </div>
            </div>
            <table class="data_users mb-5 w-100 text-center">
               <thead class="text-info" style="border-bottom: 1px solid grey">
                  <tr>
                     <th class="px-4">ID</th>
                     <th class="px-4">Nome</th>
                     <th class="px-4">Email</th>
                     <th class="px-4">Perfil</th>
                     <th class="px-4">Estado</th>
                     <th class="px-4">Ações</th>
                  </tr>
               </thead>
               <tbody>

                  <?php
                  // Fetch value
                  while (mysqli_stmt_fetch($stmt)) {
                     echo "
                  <tr>
                     <th scope='row' class='my-3 px-4'>$id_funcionario</th>
                     <td class='my-3 px-4'>$nome</td>
                     <td class='my-3 px-4'>$email</td>
                     <td class='my-3 px-4'>$role</td>";
                     // Estado
                     if ($tipo_estado == 'Suspenso') {
                        echo '<td class="my-3 px-4 py-1 badge bg-info text-white ms-2">Suspenso</td>';
                     } elseif ($tipo_estado == 'Ativo') {
                        echo '<td class="my-3 px-4 py-1 badge bg-success text-white ms-2">Ativo</td>';
                     } elseif ($tipo_estado == 'Inativo') {
                        echo '<td class="my-3 px-4 py-1 badge bg-danger text-white ms-2">Inativo</td>';
                     }

                     echo "
                     <td class='my-3 px-4'>
                        <a href='./update_funcionario.php?id_funcionario=" . $id_funcionario . "'><i class='px-1 text-dark bi bi-pencil-square'></i></a>

                     </td>
                  </tr>";
                  } ?>
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