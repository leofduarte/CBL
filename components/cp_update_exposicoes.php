<?php
if (isset($_GET["id"])) {
   // Store values
   $id = $_GET["id"];
} else {
   header("Location: /exposicoes.php");
   exit();
}

// conexão à base de dados
require_once("./connections/connection.php");


// Create a new DB connection
$link = new_db_connection();

// Create a prepared statement
$stmt = mysqli_stmt_init($link);

// Define the query
$query = "
         SELECT exposicoes.nome_exposicao, salas.nome_sala, obra.nome_obra, exposicoes.data_inicio, exposicoes.data_fim, salas_has_exposicoes.nome
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
?>
<!-- Begin Page Content -->
<div class="container-fluid">
   <h1 style="color:#393166;" class="mt-5 ms-3"> Exposicoes </h1>

   <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
      <h2 style="color:#393166" class="mb-4 ">Editar Exposicoes</h2>

      <!-- Begin Page Content -->
      <div class="container-fluid">
         <?php
         // Prepare the statement
         if (mysqli_stmt_prepare($stmt, $query)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 'i', $id);
            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
               // Bind result variables
               mysqli_stmt_bind_result($stmt, $nome_exposicao, $nome_sala, $nome_obra, $data_inicio, $data_fim, $nome);

               echo
               '<form action="./scripts/sc_add_funcionario.php" method="POST" class="was-validated">

            <div class="mb-3 mt-3">
               <label for="uname" class="form-label">Nome Exposição:</label>
               <input type="text" class="form-control" id="name" value="' . $nome_exposicao . '" name="name" required>
            </div>

            <div class="mb-3 mt-3">
               <label for="uname" class="form-label">Descrição:</label>
               <input type="text" class="form-control" id="name" value="' . $nome . '" name="name" required>
            </div>

            <div class="mb-3 mt-3">
               <label for="uname" class="form-label">Data de Inicio:</label>
               <input type="email" class="form-control" id="email" value="' . $data_inicio . '" name="email" required>
            </div>

            <div class="mb-3 mt-3">
            <label for="uname" class="form-label">Data de Fim:</label>
            <input type="email" class="form-control" id="email" value="' . $data_fim . '" name="email" required>
         </div>';
              
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
   </div>
</div>