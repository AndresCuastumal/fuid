<?php
require 'conexion.php';
$sqlRegistro = $conn->prepare("SELECT f.*, u.nom_usuario AS usuario FROM fuid AS f INNER JOIN usuario AS u ON f.idUsuario=u.id ORDER BY f.no_orden");
if($sqlRegistro->execute()){
    $numero_rows = $sqlRegistro->rowCount();
}
else $numero_rows=1;

//echo $numero_rows;

include("admin/cabecera.php");
?>

<body>
    <div class="container py-3">
       <div class="card">
        
        <div class="row justify-content-end py-2 px-2">
            <div class="col-auto">                
                <a href="admin/nuevoRegistro.php?<?php echo http_build_query(['no_orden' =>$numero_rows]); ?>" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
                <a href="reportepdf.php" class="btn btn-success"><i class="fa-solid fa-print"></i> Imprimir reporte</a>
            </div>
        </div>
        <!-- <table class="table table-sm mt-1 table-bordered table-small table-hover">
            <thead class="table-sm table-primary">
                <tr>
                    <th rowspan="2"><small>No Orden</small></th>
                    <th rowspan="2"><small>Codigo TRD</small></th>
                    <th rowspan="2"><small>Nombre de la serie, subserie o asuntos</small></th>
                    <th colspan="2"><small>Fechas extrems</small></th>
                    <th colspan="4"><small>Unidad de conservación</small></th>
                    <th rowspan="2"><small>Número de folios</small></th>
                    <th rowspan="2"><small>Soporte</small></th>
                    <th rowspan="2"><small>Frecuencia de Consulta</small></th>
                    <th rowspan="2"><small>Notas/ Observaciones</small></th>
                    <th rowspan="2"><small>Usuario</small></th>
                    <th rowspan="2" colspan="3"><small>Acciones</small></th>                    
                </tr>
                <tr>
                    <th><small>Inicial</th>
                    <th><small>Final</small></th>
                    <th><small>caja</small></th>
                    <th><small>Carpeta</small></th>
                    <th><small>Tomo</small></th>
                    <th><small>Otro</small></th>            
                </tr>
            </thead>
        </table> -->
        <div class="table-responsive">
        <table class="table table-sm mt-1 table-bordered table-small table-hover" id="tabla" >
        <thead class="table-sm table-primary">
            <tr>
                <th><small>No Orden</small></th>
                <th><small>Codigo TRD</small></th>
                <th class="text-nowrap"><small>Serie, subserie o asuntos</small></th>
                <th><small>F. ext Inicial</th>
                <th><small>F. ext Final</small></th>                   
                <th><small>udc-caja</small></th>
                <th><small>udc-Carpeta</small></th>
                <th><small>udc-Tomo</small></th>
                <th><small>udc-Otro</small></th>
                <th><small>Número de folios</small></th>
                <th><small>Soporte</small></th>
                <th><small>Frecuencia de consulta</small></th>
                <th><small>Notas/ Observaciones</small></th>
                <th><small>Usuario</small></th>
                <th class="text-secondary"><small></small></td>
                <th class="text-secondary"><small></small></td>
                <th class="text-secondary"><small></small></td>  
            </tr>
        </thead>
        <tbody>
            <?php while($row_registro = $sqlRegistro->fetch(PDO::FETCH_ASSOC)){ ?>
                <tr>
                    <td><small><?= $row_registro['no_orden']; ?></small></td>
                    <td><small><?= $row_registro['cod_trd']; ?></small></td>
                    <td style="max-width: 100%; word-wrap: break-word;"><small><?= $row_registro['nom_serie']; ?></small></td>
                    <td><small><?= $row_registro['fecha_ext_ini']; ?></small></td>
                    <td><small><?= $row_registro['fecha_ext_fin']; ?></small></td>
                    <td><small><?= $row_registro['uc_caja']; ?></small></td>
                    <td><small><?= $row_registro['uc_carpeta']; ?></small></td>
                    <td><small><?= $row_registro['uc_tomo']; ?></small></td>
                    <td><small><?= $row_registro['uc_otro']; ?></small></td>
                    <td><small><?= $row_registro['num_folios']; ?></small></td>
                    <td><small><?= $row_registro['soporte']; ?></small></td>
                    <td><small><?= $row_registro['frc_consulta']; ?></small></td>
                    <td><small><?= $row_registro['observacion']; ?></small></td>
                    <td><small><?= $row_registro['usuario']; ?></small></td>
                    <td>
                        <a href="admin/nuevoRegistro.php?<?php echo http_build_query(['no_orden' =>$row_registro['no_orden']]); ?>" class="btn btn-primary">
                        <i class="fa-solid fa-circle-plus"></i>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaRegFuid" data-bs-id="<?= $row_registro['id']; ?>">
                        <i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaRegFuid" data-bs-id="<?= $row_registro['id']; ?>">
                        <i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            <?php } ?>                
        </tbody>
        </table>
        </div>       

        <?php include("admin/pie.php"); ?>    
