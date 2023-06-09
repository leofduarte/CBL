<?php
// conexão à base de dados
require_once("connections/connection.php");

if (isset($_SESSION["id_funcionario"])) {
   // Store values
   $id_funcionario = (int) $_SESSION["id_funcionario"];
}

$nome = $_SESSION["nome"];
$email = $_SESSION["email"];



// Create a new DB connection
$link = new_db_connection();

// Create a prepared statement
$stmt = mysqli_stmt_init($link);

// Define the query
$query = "SELECT id_funcionario, nome, email FROM funcionarios
   WHERE id_funcionario = ?";


// Prepare the statement
if (mysqli_stmt_prepare($stmt, $query)) {
   mysqli_stmt_bind_param($stmt, 'i', $id_funcionario);
   // Execute the prepared statement
   if (mysqli_stmt_execute($stmt)) {
      // Bind result variables
      mysqli_stmt_bind_result($stmt, $id_funcionario, $nome, $email);


?>

      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

         <!-- Sidebar Toggle (Topbar) -->
         <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
         </button>

         <!-- Topbar Search -->
         <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
               <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
               <div class="input-group-append">
                  <button class="btn btn-primary" type="button">
                     <i class="fas fa-search fa-sm"></i>
                  </button>
               </div>
            </div>
         </form>


         <!-- Topbar Navbar -->
         <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
               <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-search fa-fw"></i>
               </a>
               <!-- Dropdown - Messages -->
               <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                     <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                           <button class="btn btn-primary" type="button">
                              <i class="fas fa-search fa-sm"></i>
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
            </li>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
               <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo '
               <span class="mr-2 d-none d-lg-inline text-gray-600 small">' . $nome . '</span> 
                 
                  <img class="img-profile rounded-circle" src="https://api.dicebear.com/6.x/pixel-art/svg?seed=' . $id_funcionario . '">
               </a> '; ?>

                  <!-- Dropdown - User Information -->
                  <div class=" dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                     <a class="dropdown-item" href="../profile_settings.php">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                     </a>
                     <a class="dropdown-item" href="#">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                     </a>
                     <a class="dropdown-item" href="#">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Log
                     </a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="./scripts/sc_logout_dash.php" <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                     </a>
                  </div>
            </li>

         </ul>

      </nav>
      <!-- End of Topbar -->


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