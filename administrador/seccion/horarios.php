<?php include('../template/header.php'); ?>

<?php
$textID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$horario_entrada = (isset($_POST['horario_entrada'])) ? $_POST['horario_entrada'] : "";
$horario_salida = (isset($_POST['horario_salida'])) ? $_POST['horario_salida'] : "";
$aula = (isset($_POST['aula'])) ? $_POST['aula'] : "";
$dia = (isset($_POST['dia'])) ? $_POST['dia'] : "";
$materia = (isset($_POST['materia'])) ? $_POST['materia'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include('../config/db.php');

switch ($accion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO Horario (horario_entrada, horario_salida, aula, dia, materia) VALUES (:horario_entrada, :horario_salida, :aula, :dia, :materia);");
        $sentenciaSQL->bindParam(':horario_entrada', $horario_entrada);
        $sentenciaSQL->bindParam(':horario_salida', $horario_salida);
        $sentenciaSQL->bindParam(':aula', $aula);
        $sentenciaSQL->bindParam(':dia', $dia);
        $sentenciaSQL->bindParam(':materia', $materia);
        $sentenciaSQL->execute();
        header("Location: horarios.php");
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM Horario WHERE id = :id;");
        $sentenciaSQL->bindParam(':id', $textID);
        $sentenciaSQL->execute();
        header("Location: horarios.php");
        break;
}
$sentenciaSQL = $conexion->prepare("SELECT * FROM Horario;");
$sentenciaSQL->execute();
$listaHorarios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Horarios</h1>

<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            Datos del horario
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="horario_entrada">Horario de entrada:</label>
                    <select class="form-control" name="horario_entrada" id="horario_entrada" required>
                        <option value="">Seleccione un horario</option>
                        <option value="13:10">13:10 - 13:55</option>
                        <option value="13:55">13:55 - 14:40</option>
                        <option value="14:45">14:45 - 15:30</option>
                        <option value="15:30">15:30 - 16:15</option>
                        <option value="16:15">16:15 - 17:00</option>
                        <option value="17:05">17:05 - 17:50</option>
                        <option value="17:50">17:50 - 18:35</option>
                        <option value="18:35">18:35 - 19:20</option>
                        <option value="19:20">19:20 - 20:05</option>
                        <option value="20:10">20:10 - 20:55</option>
                        <option value="20:55">20:55 - 21:40</option>
                        <option value="21:40">21:40 - 22:25</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="aula">Aula:</label>
                    <select class="form-control" name="aula" id="aula" required>
                        <option value="">Seleccione un aula</option>
                        <option value="G101">G101</option>
                        <option value="G102">G102</option>
                        <option value="G103">G103</option>
                        <option value="G104">G104</option>
                        <option value="G105">G105</option>
                        <option value="G201">G201</option>
                        <option value="G202">G202</option>
                        <option value="G203">G203</option>
                        <option value="G301">G301</option>
                        <option value="G302">G302</option>
                        <option value="G303">G303</option>
                        <option value="H101">H101</option>
                        <option value="H102">H102</option>
                        <option value="H103">H103</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dia">Día:</label>
                    <select class="form-control" name="dia" id="dia" required>
                        <option value="">Seleccione un día</option>
                        <option value="Lunes">Lunes</option>
                        <option value="Martes">Martes</option>
                        <option value="Miércoles">Miércoles</option>
                        <option value="Jueves">Jueves</option>
                        <option value="Viernes">Viernes</option>
                        <option value="Sábado">Sábado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="materia">Materia:</label>
                    <input type="text" class="form-control" name="materia" id="materia" required>
                </div>
                <br>
                <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
            </form>
        </div>
    </div>
</div>

<div class="col-md-8">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Horario de entrada</th>
                <th>Aula</th>
                <th>Día</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaHorarios as $horario) { ?>
                <tr>
                    <td><?php echo $horario['id']; ?></td>
                    <td><?php echo date("H:i", strtotime($horario['horario_entrada'])) . " - " . date("H:i", strtotime($horario['horario_entrada'] . "+45 minutes")); ?></td>
                    <td><?php echo $horario['aula']; ?></td>
                    <td><?php echo $horario['dia']; ?></td>
                    <td><?php echo $horario['materia']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="txtID" value="<?php echo $horario['id']; ?>">
                            <button type="submit" name="accion" value="Borrar" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../template/footer.php'; ?>