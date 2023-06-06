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
      $mensagem = "<b>Erro!</b> Obra não adicionado";
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

   <h1 style="color:#393166;" class="mt-5 ms-3">Adicionar Obra</h1>
   <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
      <h2 style="color:#393166" class="mb-4">Obras</h2>


      <?php
      // Prepare the statement
      if (mysqli_stmt_prepare($stmt, $query)) {

         // Execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $nome_beacon, $uuid_beacon);
      ?>
            <form action="./scripts/obras/sc_add_obra.php" method="POST" class="was-validated">
               <div class="mb-3 mt-3">
                  <label for="uname" class="form-label">Nome:</label>
                  <input type="text" class="form-control" id="nome" placeholder="Insera o nome da Obra" name="nome_obra" required>
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
         ?>

         <?php
         // Create a prepared statement
         $stmt = mysqli_stmt_init($link);

         // Define the query
         $query = "SELECT id_beacon, nome_beacon
                  FROM beacons 
                  LEFT JOIN obra
                  ON beacons.id_beacon = obra.ref_beacons  
                  where nome_obra IS NULL
                  ORDER BY nome_beacon";

         // Prepare the statement
         if (mysqli_stmt_prepare($stmt, $query)) {

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
               // Bind result variables
               mysqli_stmt_bind_result($stmt, $ref_beacons,  $nome_beacon);
         ?>

               <label for="beacon">Escolhe um beacon:</label>
               <select name="beacon_id" id="beacon">


                  <?php while (mysqli_stmt_fetch($stmt)) {
                     echo "
            <option value=" . $ref_beacons . "> " . $nome_beacon . " </option>";
                  }
                  ?>
               </select>
               <br>
               <button type="submit" class="btn-definir-obra">Adicionar</button>
            </form>

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
      ?>


   </div>
   <?php
   mysqli_close($link);
   ?>