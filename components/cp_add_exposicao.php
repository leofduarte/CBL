<?php
// conexão à base de dados
require_once("./connections/connection.php");

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
      <form action="./scripts/exposicoes/sc_add_exposicoes.php" method="POST" class="was-validated">
         <div class="mb-3 mt-3">
            <label for="nome_exposicao" class="form-label">Nome:*</label>
            <input type="text" class="form-control" id="nome" placeholder="Insira o nome da exposicao" name="nome_exposicao" required>
         </div>


         <div class="mb-3 mt-3">
            <label for="descricao" class="form-label">Descrição:*</label>
            <input type="text" class="form-control" id="descricao" placeholder="descrição" name="descricao" required>
         </div>


         <div class="mb-3 mt-3">
            <label for="data_inicio" class="form-label">Data Inicio:</label>
            <input type="data" class="form-control" id="data_inicio" placeholder="data Inicio:" name="">
         </div>


         <div class="mb-3 mt-3">
            <label for="data_fim" class="form-label">Data Fim:</label>
            <input type="data" class="form-control" id="data_fim" placeholder="data Fim" name="data_fim">
         </div>

         <button href="./scripts/exposicoes/sc_add_exposicao.php" type="submit" class="btn-definir-obra mt-2"> Adicionar Exposição</button>
      </form>
   </div>
</div>