<?php
include("administrador/config/db.php");

function obtenerListaHorarios($conexion)
{
    $query = "SELECT * FROM Horario";
    $sentenciaSQL = $conexion->prepare($query);
    $sentenciaSQL->execute();
    return $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener lista de horarios
$listahorarios = obtenerListaHorarios($conexion);

// Filtros
$diaFiltrado = isset($_GET['dia']) ? $_GET['dia'] : '';
$horaFiltrada = isset($_GET['hora']) ? $_GET['hora'] : '';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
<header>
    <nav>
        <ul>
            <li><a href="index.html">Inicio</a></li>
            <li><a href="horarios.php">Horarios</a></li>
        </ul>
    </nav>
</header>
<h1>Horarios</h1>

<form action="horarios.php" method="get" class="filtro">
    <div class="filtro-container">
        <label for="dia">Filtrar por día:</label>
        <select name="dia" id="dia">
            <option value="">Todos</option>
            <option value="Lunes" <?php if($diaFiltrado == 'Lunes') echo 'selected'; ?>>Lunes</option>
            <option value="Martes" <?php if($diaFiltrado == 'Martes') echo 'selected'; ?>>Martes</option>
            <option value="Miércoles" <?php if($diaFiltrado == 'Miércoles') echo 'selected'; ?>>Miércoles</option>
            <option value="Jueves" <?php if($diaFiltrado == 'Jueves') echo 'selected'; ?>>Jueves</option>
            <option value="Viernes" <?php if($diaFiltrado == 'Viernes') echo 'selected'; ?>>Viernes</option>
            <option value="Sábado" <?php if($diaFiltrado == 'Sábado') echo 'selected'; ?>>Sábado</option>
        </select>
        <label for="hora">Filtrar por hora:</label>
        <select name="hora" id="hora">
            <option value="">Todas</option>
            <?php foreach ($listahorarios as $horario) { ?>
                <option value="<?php echo $horario['horario_entrada']; ?>" <?php if($horaFiltrada == $horario['horario_entrada']) echo 'selected'; ?>><?php echo $horario['horario_entrada']; ?></option>
            <?php } ?>
        </select>
    </div>
    <input type="submit" value="Filtrar" class="filtro-btn">
</form>

<br>
<br>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th class="horario">Horario</th>
                <th class="lunes">Lunes</th>
                <th class="martes">Martes</th>
                <th class="miercoles">Miércoles</th>
                <th class="jueves">Jueves</th>
                <th class="viernes">Viernes</th>
                <th class="sabado">Sábado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listahorarios as $horario): ?>
                <?php if (($diaFiltrado == '' || $horario['dia'] == $diaFiltrado) && ($horaFiltrada == '' || $horario['horario_entrada'] == $horaFiltrada)): ?>
                    <tr>
                        <td><?= $horario['horario_entrada'] ?></td>

                        <?php $dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"); ?>
                        <?php foreach ($dias as $dia): ?>
                            <td>
                                <?php if ($horario['dia'] == $dia): ?>
                                    Aula: <?= $horario['aula'] ?><br>
                                    Materia: <?= $horario['materia'] ?><br>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>