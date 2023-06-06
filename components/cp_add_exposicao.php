<?php
// conexão à base de dados
require_once("./connections/connection.php");

// Create a new DB connection
$link = new_db_connection();

// Create a prepared statement
$stmt = mysqli_stmt_init($link);

// Define the query
$query = "SELECT id_sala, nome_sala FROM salas INNER JOIN obra ";

if (isset($_GET["msg"])) {
   $id_func = $_GET["msg"];
   if ($id_func == "7") {
      $mensagem = "Exposicao adicionada com sucesso";
      $color = "bg-success text-white";
   } else if ($id_func == "8") {
      $mensagem = "<b>Erro!</b> Exposicao não adicionada";
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

<div class="container-fluid">

   <h1 style="color:#393166;" class="mt-5 ms-3">Adicionar Exposicao</h1>
   <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
      <h2 style="color:#393166" class="mb-4">Exposicao</h2>


      <?php
      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $nome_beacon, $uuid_beacon);

   echo '<form action="./scripts/exposicoes/sc_add_exposicoes.php" method="POST" class="was-validated">
   <div class="mb-3 mt-3">
      <label for="uname" class="form-label">Nome:</label>
      <input type="text" class="form-control" id="nome" placeholder="Insira o nome da exposicao" name="nome_exposicao" required>
   </div>

 
   <div class="mb-3 mt-3">
      <label for="uname" class="form-label">Descrição:</label>
      <input type="text" class="form-control" id="descricao" placeholder="descrição" name="descricao" required>
   </div>

   
   <div class="mb-3 mt-3">
      <label for="uname" class="form-label">Data:</label>
      <input type="data" class="form-control" id="data_inicio" placeholder="data Inicio:" name="data_inicio" required>
   </div>

   
   <div class="mb-3 mt-3">
      <label for="uname" class="form-label">Data:</label>
      <input type="data" class="form-control" id="data_fim" placeholder="data Fim" name="data_fim" required>
   </div>

  
   <div class="mb-3 mt-3">
      <label for="uname" class="form-label">Sala:</label>
      <input type="text" class="form-control" id="sala" placeholder="Insira a Sala" name="sala" required>
   </div>

   
   <div class="mb-3 mt-3">
      <label for="uname" class="form-label">Obra:</label>
      <input type="text" class="form-control" id="obra" placeholder="obra" name="obra" required>
   </div>



   <button href="./scripts/exposicoes/sc_add_exposicao.php" type="submit" class="btn-definir-obra mt-2"> Adicionar Exposição</button>
   </form>';
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

   </div>
   <?php
   mysqli_close($link);
   ?>