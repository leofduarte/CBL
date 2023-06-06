<?php
if (isset($_GET["id"])) {
    // Store values
    $id = $_GET["id"];
} else {
    header("Location: /exposicoes.php");
    exit();
}

// Connection to the database
require_once("./connections/connection.php");

// Create a new DB connection
$link = new_db_connection();

// Create a prepared statement
$stmt = mysqli_stmt_init($link);

// Define the query
$query = "
    SELECT exposicoes.nome_exposicao, salas.nome_sala, obra.nome_obra, exposicoes.data_inicio, exposicoes.data_fim, salas_has_exposicoes.nome
    FROM exposicoes
    INNER JOIN salas_has_exposicoes ON exposicoes.id_exposicao = salas_has_exposicoes.exposicoes_id_exposicao
    INNER JOIN salas ON salas_has_exposicoes.salas_id_sala = salas.id_sala
    INNER JOIN exposicoes_has_obra ON exposicoes.id_exposicao = exposicoes_has_obra.exposicoes_id_exposicao
    INNER JOIN obra ON obra.id_obra = exposicoes_has_obra.obra_id_obra
    WHERE exposicoes.id_exposicao = ?
";

// Begin Page Content
echo '<div class="container-fluid">
    <h1 style="color:#393166;" class="mt-5 ms-3"> Exposicoes </h1>

    <div style="border-radius: 2rem; background-color:#F4F2FF;" class="p-4 mb-5 mt-4">
        <h2 style="color:#393166" class="mb-4 ">Editar Exposicoes</h2>

        <!-- Begin Page Content -->
        <div class="container-fluid">';

// Prepare the statement
if (mysqli_stmt_prepare($stmt, $query)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, 'i', $id);
    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $nome_exposicao, $nome_sala, $nome_obra, $data_inicio, $data_fim, $descricao);

        // Fetch the values
        mysqli_stmt_fetch($stmt);

        echo '<form action="./scripts/exposicoes/sc_update_exposicao.php?id='.$id.'" method="POST" class="was-validated">

            <div class="mb-3 mt-3">
                <label for="nome_exposicao" class="form-label">Nome Exposição:</label>
                <input type="text" class="form-control" id="nome_exposicao" value="' . $nome_exposicao . '" name="nome_exposicao" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <input type="text" class="form-control" id="descricao" value="' . htmlspecialchars($descricao) . '" name="descricao" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="data_inicio" class="form-label">Data de Inicio:</label>
                <input type="date" class="form-control" id="data_inicio" value="' . $data_inicio . '" name="data_inicio">
            </div>

            <div class="mb-3 mt-3">
                <label for="data_fim" class="form-label">Data de Fim:</label>
                <input type="date" class="form-control" id="data_fim" value="' . $data_fim . '" name="data_fim">
            </div>';

    } else {
        // Execute error
        echo "Error: " . mysqli_stmt_error($stmt);
    }
} else {
    // Errors related to the query
    echo "Error: " . mysqli_error($link);
}
// Close statement
mysqli_stmt_close($stmt);

// Create a prepared statement for the "Sala" select field
$stmt = mysqli_stmt_init($link);

$query_sala = "SELECT id_sala, nome_sala FROM salas";
// Prepare the statement
if (mysqli_stmt_prepare($stmt, $query_sala)) {
    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $id_sala, $nome_sala);

        echo '<div class="mb-3 mt-3">
            <label for="sala" class="form-label">Sala:</label>
            <br>
            <select class="form-select" id="sala" name="sala" required>
                <option>Escolha a sala</option>';

        // Fetch values
        while (mysqli_stmt_fetch($stmt)) {
            echo '<option value="' . htmlspecialchars($id_sala) . '">' . htmlspecialchars($nome_sala) . '</option>';
        }

        echo '</select>
        </div>';
    } else {
        // Execute error
        echo "Error: " . mysqli_stmt_error($stmt);
    }
} else {
    // Errors related to the query
    echo "Error: " . mysqli_error($link);
}
// Close statement
mysqli_stmt_close($stmt);

// Create a prepared statement for the "Obra" select field
$stmt = mysqli_stmt_init($link);

$query_obra = "
    SELECT obra.nome_obra, obra.id_obra
    FROM exposicoes
    INNER JOIN salas_has_exposicoes ON exposicoes.id_exposicao = salas_has_exposicoes.exposicoes_id_exposicao
    INNER JOIN salas ON salas_has_exposicoes.salas_id_sala = salas.id_sala
    INNER JOIN exposicoes_has_obra ON exposicoes.id_exposicao = exposicoes_has_obra.exposicoes_id_exposicao
    INNER JOIN obra ON obra.id_obra = exposicoes_has_obra.obra_id_obra
    WHERE exposicoes.id_exposicao = ?
";

// Prepare the statement
if (mysqli_stmt_prepare($stmt, $query_obra)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, 'i', $id);
    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $nome_obra, $id_obra);

        echo '<div class="mb-3 mt-3">
            <label for="obra" class="form-label">Obra:</label>
            <br>
            <select class="form-select" id="obra" name="obra" required>
                <option>Escolha a Obra</option>';

        // Fetch values
        while (mysqli_stmt_fetch($stmt)) {
            echo '<option value="' . $id_obra. '">' . $nome_obra . '</option>';
        }

        echo '</select>
        </div>';
    } else {
        // Execute error
        echo "Error: " . mysqli_stmt_error($stmt);
    }
} else {
    // Errors related to the query
    echo "Error: " . mysqli_error($link);
}
// Close statement
mysqli_stmt_close($stmt);
?>

<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
<?php
// Close connection
mysqli_close($link);
?>
