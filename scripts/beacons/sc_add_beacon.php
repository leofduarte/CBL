
<?php
if (isset($_POST["nome_beacon"]) && isset($_POST["uuid"])) {
   require_once "../../connections/connection.php";
   $nome_beacon = $_POST['nome_beacon'];
   $uuid_beacon = $_POST['uuid'];

   $link = new_db_connection();

   $query = "INSERT INTO beacons (nome_beacon, uuid_beacon) VALUES (?,?)";

   $stmt = mysqli_stmt_init($link);

   if (mysqli_stmt_prepare($stmt, $query)) {
      mysqli_stmt_bind_param($stmt, 'ss', $nome_beacon, $uuid_beacon);

      // Devemos validar também o resultado do execute!
      if (mysqli_stmt_execute($stmt)) {
         // Acção de sucesso
         header("Location: ../../add_beacon.php?msg=7");
      } else {
         header("Location: ./add_beacon.php?msg=8");
         // Acção de erro
         echo "Error:" . mysqli_stmt_error($stmt);
      }
   } else {
      // Acção de erro
      echo "Error:" . mysqli_error($link);
   }
   mysqli_stmt_close($stmt);
   mysqli_close($link);
} else {
   echo "Campos do formulário por preencher";
}
