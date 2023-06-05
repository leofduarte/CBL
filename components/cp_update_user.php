<?php
if (isset($_GET["id_utilizador"])) {
   // Store values
   $id_user = $_GET["id_utilizador"];


   // conexão à base de dados
   require_once("./connections/connection.php");


   // Create a new DB connection
   $link = new_db_connection();

   // Create a prepared statement
   $stmt = mysqli_stmt_init($link);

   // Define the query
   $query = "SELECT id_utilizador, utilizadores.nome, email
         FROM utilizadores
         INNER JOIN nacionalidades ON ref_nacionalidade = id_nacionalidade 
         WHERE id_utilizador = ?
  ";
?>
   <!-- Begin Page Content -->
   <div class="container-fluid">
      <h1 style="color:#393166;" class="mt-5 ms-3">Editar</h1>

      <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
         <h2 style="color:#393166" class="mb-4 ">Editar Utilizador</h2>

         <!-- Begin Page Content -->
         <div class="container-fluid">
            <?php
            // Prepare the statement
            if (mysqli_stmt_prepare($stmt, $query)) {
               // Bind variables to the prepared statement as parameters
               mysqli_stmt_bind_param($stmt, 'i', $id_user);
               // Execute the prepared statement
               if (mysqli_stmt_execute($stmt)) {
                  // Bind result variables
                  mysqli_stmt_bind_result($stmt, $id_perfil, $role, $nome_func, $email);

                  echo
                  '<form action="./scripts/sc_update_funcionario.php" method="POST" class="was-validated">
            <div class="mb-3 mt-3">
               <label for="uname" class="form-label">Nome:</label>
               <input type="text" class="form-control" id="name" value="' . $nome_func . '" name="name" required>
            </div>
            <div class="mb-3 mt-3">
               <label for="uname" class="form-label">Email:</label>
               <input type="email" class="form-control" id="email" value="' . $email . '" name="email" required>
            </div>
            <div class="mb-3 mt-3">
               <label for="uname" class="form-label">Perfil:</label>
               <br>
            <select class="form-select" id="perfil" name="perfil" required>
            <option>Escolha o Perfil</option>';
                  // Fetch values
                  while (mysqli_stmt_fetch($stmt)) {
                     echo '<option value=' . $id_perfil . '>' . $role . '</option>';
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
         //comecar query nova para o estado

         // Create a prepared statement
         $stmt = mysqli_stmt_init($link);

         $query = "SELECT id_estado_registo, tipo_estado FROM estado_registo";
         // Prepare the statement
         if (mysqli_stmt_prepare($stmt, $query)) {
         ?>
            <div class="mb-3 mt-3">
               <label for="uname" class="form-label">Estado:</label>
               <br>
               <select class="form-select" id="estado" name="estado" required>
                  <option>Escolha o Estado</option>

               <?php
               // Execute the prepared statement
               if (mysqli_stmt_execute($stmt)) {
                  // Bind result variables
                  mysqli_stmt_bind_result($stmt, $id_estado_registo, $tipo_estado);

                  // Fetch values
                  while (mysqli_stmt_fetch($stmt)) {
                     echo '<option value=" ' . $id_estado_registo . '">'  . '' . $tipo_estado . '</option>';
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