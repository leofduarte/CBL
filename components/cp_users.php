<?php
// conexão à base de dados
require_once("connections/connection.php");

?>


<!-- Begin Page Content -->
<div class="container-fluid">

   <h1 style="color:#393166;" class="mt-5 ms-3">Users</h1>

   <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
      <h3 style="color:#393166" class="mb-4 ">Users List
         <a href=" add_user.php" class="m-0" style="color: #6E59E4; cursor: pointer">
            <i class="ml-4 bi bi-plus-circle"></i>
         </a>
      </h3>

      <?php

      // Create a new DB connection
      $link = new_db_connection();

      // Create a prepared statement
      $stmt = mysqli_stmt_init($link);

      // Define the query
      $query = "SELECT id_funcionario, nome, email, role, tipo_estado FROM funcionarios
      INNER JOIN perfil ON ref_perfil = id_perfil
      INNER JOIN estado_registo ON ref_estado_registo = id_estado_registo
      LIMIT 6 ";

      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id_funcionario, $nome, $email, $role, $tipo_estado);
      ?>
            <table class="data_users mb-5 w-100 text-center">
               <thead class="text-info" style="border:2px solid black;">
                  <tr>
                     <th class="px-4">ID</th>
                     <th class="px-4">Nome</th>
                     <th class="px-4">Email</th>
                     <th class="px-4">Perfil</th>
                     <th class="px-4">Estado</th>
                     <th class="px-4">Ações</th>
                  </tr>
               </thead>
               <tbody> <?php

                        // Fetch value
                        while (mysqli_stmt_fetch($stmt)) {
                           echo "
                  <tr>
                     <th scope='row' class='my-3 px-4'>$id_funcionario</th>
                     <td class='my-3 px-4'>$nome</td>
                     <td class='my-3 px-4'>$email</td>
                     <td class='my-3 px-4'>$role</td>";
                           // Estado
                           if ($tipo_estado == 'suspenso') {
                              echo '<td class="my-3 px-4 py-1 badge bg-info text-white ms-2">Suspenso</td>';
                           } elseif ($tipo_estado == 'ativo') {
                              echo '<td class="my-3 px-4 py-1 badge bg-success text-white ms-2">Ativo</td>';
                           } elseif ($tipo_estado == 'inativo') {
                              echo '<td class="my-3 px-4 py-1 badge bg-danger text-white ms-2">Inativo</td>';
                           }

                           echo "
                     <td class='my-3 px-4'>
                        <a href='#'><i class='px-1 text-dark bi bi-pencil-square'></i></a>
                        <a href='#'><i class='px-1 text-dark bi bi-trash'></i></a>
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