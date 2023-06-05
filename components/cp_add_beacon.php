<?php
// conexão à base de dados
require_once("./connections/connection.php");

// Create a new DB connection
$link = new_db_connection();

// Create a prepared statement
$stmt = mysqli_stmt_init($link);

// Define the query
$query = "SELECT nome_beacon, uuid_beacon FROM beacons";

if (isset($_GET["msg"])) {
   $id_func = $_GET["msg"];
   if ($id_func == "7") {
      $mensagem = "Beacon adicionado com sucesso";
      $color = "bg-success text-white";
   } else if ($id_func == "8") {
      $mensagem = "<b>Erro!</b> Beacon não adicionado";
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

   <h1 style="color:#393166;" class="mt-5 ms-3">Adicionar Beacons</h1>
   <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
      <h2 style="color:#393166" class="mb-4">Beacon</h2>


      <?php
      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $nome_beacon, $uuid_beacon);

            echo '<form action="./scripts/beacons/sc_add_beacon.php" method="POST" class="was-validated">
   <div class="mb-3 mt-3">
      <label for="uname" class="form-label">Nome:</label>
      <input type="text" class="form-control" id="nome" placeholder="Insera o nome do beacon" name="nome_beacon" required>
   </div>

   <div class="mb-3">
      <label for="pwd" class="form-label">UUID:</label>
      <input type="text" class="form-control" id="uuid" placeholder="Insira o UUID" name="uuid" required>
   </div>
   <button href="./scripts/beacons/sc_add_beacon.php" type="submit" class="btn-definir-obra">Submit</button>
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