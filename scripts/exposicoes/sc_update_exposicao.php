<?php
// We need the function!
require_once "../../connections/connection.php";

if (isset($_GET["id"])) {
   $id_exposicao = $_GET["id"];
}

   if (isset($_POST['nome_exposicao']) && isset($_POST['descricao']) && isset($_POST['nome_sala']) && isset($_POST['nome_obra'])) {
      $nome_exposicao = $_POST['nome_exposicao'];
      $descricao = $_POST['descricao'];
      $id_sala = $_POST['sala'];
      $id_obra = $_POST['obra'];

      $data_inicio = NULL;
      if(!empty($_POST ['data_inicio'])){
          $data_inicio = $_POST ['data_inicio'];
      }

       $data_fim = NULL;
          if(!empty($_POST ['data_fim'])){
                $data_fim = $_POST ['data_fim'];
          }
   // Create a new DB connection
   $link = new_db_connection();

   /* create a prepared statement */
   $stmt = mysqli_stmt_init($link);

   /* Define the query */
   $query = "UPDATE exposicoes
             INNER JOIN salas_has_exposicoes ON exposicoes.id_exposicao = salas_has_exposicoes.exposicoes_id_exposicao
             INNER JOIN salas ON salas_has_exposicoes.salas_id_sala = salas.id_sala
             INNER JOIN exposicoes_has_obra ON exposicoes.id_exposicao = exposicoes_has_obra.exposicoes_id_exposicao
             INNER JOIN obra ON obra.id_obra = exposicoes_has_obra.obra_id_obra
             SET exposicoes.nome_exposicao = ?,
                 salas.id_sala = ?, /*sala*/ 
                 obra.id_obra = ?, /*obra*/
                 exposicoes.data_inicio = ?, /*data do inicio*/
                 exposicoes.data_fim = ?, /*data do fim*/
                 salas_has_exposicoes.nome = ? /*descrição*/
             WHERE exposicoes.id_exposicao = ?";

   if (mysqli_stmt_prepare($stmt, $query)) {
      // Verificar se os campos do formulário estão definidos

         mysqli_stmt_bind_param($stmt, 'siiiss', $nome_exposicao, $id_sala, $id_obra, $id_exposicao, $data_inicio, $data_fim);

         // Executar a consulta
         if (mysqli_stmt_execute($stmt)) {
            // Redirecionar após o sucesso
            header("Location: ../../exposicoes.php");
            exit();
         } else {
           echo "erro";
            // Ação de erro
            echo "Error: " . mysqli_stmt_error($stmt);
         }
      
   } else {
      echo "erro 2";
      // Ação de erro
      echo "Error: " . mysqli_error($link);
   }
   echo "erro 3";

   mysqli_stmt_close($stmt);
   mysqli_close($link);
} var_dump($_POST);
?>
