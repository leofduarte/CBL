<?php
if (isset($_GET["id_funcionario"])) {
   // Store values
   $id_func = $_GET["id_funcionario"];


   // conexão à base de dados
   require_once("./connections/connection.php");


   // Create a new DB connection
   $link = new_db_connection();

   // Create a prepared statement
   $stmt = mysqli_stmt_init($link);

   // Define the query
   $query = "SELECT id_perfil, role, nome, email, ref_estado_registo
         FROM perfil
         INNER JOIN funcionarios 
         ON ref_perfil = id_perfil
         WHERE id_funcionario = ?
  ";
?>
   <!-- Begin Page Content -->
   <div class="container-fluid">
      <h1 style="color:#393166;" class="mt-5 ms-3">Funcionários</h1>

      <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
         <h2 style="color:#393166" class="mb-4 ">Editar Funcionários</h2>

         <!-- Begin Page Content -->
         <div class="container-fluid">
            <form action="./scripts/sc_update_funcionario.php" method="POST" class="was-validated">
               <?php
               // Prepare the statement
               if (mysqli_stmt_prepare($stmt, $query)) {
                  // Bind variables to the prepared statement as parameters
                  mysqli_stmt_bind_param($stmt, 'i', $id_func);
                  // Execute the prepared statement
                  if (mysqli_stmt_execute($stmt)) {
                     // Bind result variables
                     mysqli_stmt_bind_result($stmt, $id_perfil, $role, $nome_func, $email, $ref_estado_registo);

                     if (mysqli_stmt_fetch($stmt)) {
                        echo "yooo " . $role;
                        echo
                        '
                           <div class="mb-3 mt-3">
                              <label for="uname" class="form-label">Nome:</label>
                              <input type="text" class="form-control" id="name" value="' . $nome_func . '" name="name" required>
                           </div>
                           <div class="mb-3 mt-3">
                              <label for="uname" class="form-label">Email:</label>
                              <input type="email" class="form-control" id="email" value="' . $email . '" name="email" required>
                           </div>
                        ';
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

               // Create a prepared statement
               $stmt = mysqli_stmt_init($link);
               $query = "SELECT id_perfil, role FROM perfil";

               if (mysqli_stmt_prepare($stmt, $query)) {
                  // Bind variables to the prepared statement as parameters
                  // mysqli_stmt_bind_param($stmt, 'i', $id_func);
                  // Execute the prepared statement
                  if (mysqli_stmt_execute($stmt)) {
                     // Bind result variables
                     mysqli_stmt_bind_result($stmt, $id_perfil, $roleNome);

                     echo '<div class="mb-3 mt-3">
                           <label for="uname" class="form-label">Perfil:</label>
                           <br>
                           <select class="form-select" id="perfil" name="perfil" required>
                              <option>Escolha o Perfil</option>';
                     // Fetch values
                     while (mysqli_stmt_fetch($stmt)) {
               ?>
                        <option value='<?= $id_perfil ?>' <?php if ($role == $roleNome) {
                                                               echo 'selected';
                                                            }  ?>> <?= $roleNome ?> </option>'
                     <?php
                     }
                     echo "</select>
                           </div>";
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

               // Create a prepared statement
               $stmt = mysqli_stmt_init($link);
               $query = "SELECT id_estado_registo, tipo_estado FROM estado_registo";

               if (mysqli_stmt_prepare($stmt, $query)) {
                  // Bind variables to the prepared statement as parameters
                  // mysqli_stmt_bind_param($stmt, 'i', $id_func);
                  // Execute the prepared statement
                  if (mysqli_stmt_execute($stmt)) {
                     // Bind result variables
                     mysqli_stmt_bind_result($stmt, $id_estado_registo, $tipo_estado);

                     echo '<div class="mb-3 mt-3">
                           <label for="uname" class="form-label">Estado:</label>
                           <br>
                           <select class="form-select" id="estado" name="estado" required>
                              <option>Escolha o Estado</option>';
                     // Fetch values
                     while (mysqli_stmt_fetch($stmt)) {
                     ?>
                        <option value="<?= $id_estado_registo ?>" <?php if ($ref_estado_registo == $id_estado_registo) {
                                                                     echo "selected";
                                                                  } ?>><?= $tipo_estado ?></option>'
               <?php
                     }
                     echo "</select>
                           </div>";
                  } else {
                     // Execute error
                     echo "Error: " . mysqli_stmt_error($stmt);
                  }
               } else {
                  // Errors related with the query
                  echo "Error: " . mysqli_error($link);
               }

               ?>

               <button type="submit" class="btn btn-primary">Submit</button>
               <?php
               // Close connection
               mysqli_close($link);
               ?>
            </form>

            <!-- //! funcionario nao é eliminado, mas o estado é alterado para "inativo" -->
            <a href='./scripts/sc_delete_funcionario.php?id_funcionario=" . $id_funcionario . "'><i class='text-dark bi bi-trash'></i> Eliminar funcionário</a>
         </div>
      </div>
   <?php
} else {
   header("Location: /funcionarios.php");
   exit();
}
   ?>