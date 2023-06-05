<?php
// We need the function!
require_once "../../connections/connection.php";

if (isset($_GET["id"])) {
   $id_exposicao = $_GET["id"];

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
                 salas.nome_sala = ?,
                 obra.nome_obra = ?,
                 exposicoes.data_inicio = ?,
                 exposicoes.data_fim = ?,
                 salas_has_exposicoes.nome = ?
             WHERE exposicoes.id_exposicao = ?";

   if (mysqli_stmt_prepare($stmt, $query)) {
      // Verificar se os campos do formulário estão definidos
      if (isset($_POST['nome_exposicao'], $_POST['descricao'], $_POST['nome_sala'], $_POST['nome_obra'])) {
         $nome_exposicao = $_POST['nome_exposicao'];
         $descricao = $_POST['descricao'];
         $nome_sala = $_POST['nome_sala'];
         $nome_obra = $_POST['nome_obra'];
         $nome = $_POST['nome'];

         $data_inicio = NULL;
         if(!empty($_POST ['data_inicio'])){
             $data_inicio = $_POST ['data_inicio'];
         }
 
          $data_fim = NULL;
             if(!empty($_POST ['data_fim'])){
                   $data_fim = $_POST ['data_fim'];
             }
 

         mysqli_stmt_bind_param($stmt, 'ssssssi', $nome_exposicao, $nome_sala, $nome_obra, $nome, $id_exposicao, $data_inicio, $data_fim);

         // Executar a consulta
         if (mysqli_stmt_execute($stmt)) {
            // Redirecionar após o sucesso
            header("Location: ../exposicoes.php");
            exit();
         } else {
            // Ação de erro
            echo "Error: " . mysqli_stmt_error($stmt);
         }
       } else {
         echo "Nenhum dado foi enviado!";
         var_dump($_POST);
      }
   } else {
      // Ação de erro
      echo "Error: " . mysqli_error($link);
   }

   mysqli_stmt_close($stmt);
   mysqli_close($link);
}
?>
