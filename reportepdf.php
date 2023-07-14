<?php
require('config/fpdf/fpdf.php');

// Paso 1: Conexión a la base de datos
require('conexion.php');

// Paso 2: Consulta SQL
$sqlRegistro = $conn->prepare("SELECT f.*, u.*, s.*, c.*
                              FROM fuid AS f
                              INNER JOIN usuario AS u ON f.idUsuario = u.id
                              INNER JOIN subdependencia AS s ON s.id = u.dependencia
                              INNER JOIN cargo AS c ON c.id = u.cargo
                              ORDER BY f.no_orden");
$sqlRegistro->execute();

// Paso 3: Generación del archivo PDF
$pdf = new FPDF('L');

//$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Paso 4: Iterar sobre los registros y generar el reporte HTML y PDF
$contador = 0;
while ($row = $sqlRegistro->fetch(PDO::FETCH_ASSOC)) {
    // Paso 5: Contador de registros
    $contador++;

    // Paso 6: Generar reporte cada 10 registros
    if (($contador-1) %20 == 0) {
        // Crear una nueva hoja para el reporte
        if($contador!=1){
            // Si no es el primer registro, generar el pie de página en la página anterior
            $pdf->SetY(-40); // Posición vertical del pie de página
            $pdf->SetFont('Arial', 'I', 6);
            $pdf->Cell(93, 4, 'ELABORADO POR: ' . $row['nom_usuario'].' '.$row['ape_usuario'], 1);
            $pdf->Cell(93, 4, 'ENTREGADO POR: ' . $row['nom_usuario'].' '.$row['ape_usuario'], 1);
            $pdf->Cell(92, 4, 'RECIBIDO POR: ' . $row['jefe_subdependencia'], 1, 1, 1);
            $pdf->Cell(93, 4, 'CARGO: ' . $row['nom_cargo'], 1);
            $pdf->Cell(93, 4, 'CARGO: ' . $row['nom_cargo'], 1);
            $pdf->Cell(92, 4, 'CARGO: ' . $row['cargo_jefe'], 1, 1, 1);
            $pdf->Cell(93, 6, 'FIRMA: _____________________________________________________________________', 1);
            $pdf->Cell(93, 6, 'FIRMA: _____________________________________________________________________', 1);
            $pdf->Cell(92, 6, 'FIRMA: _____________________________________________________________________', 1, 1);
            $pdf->Cell(93, 4, 'Lugar: Secretaria Municipal de Salud        Fecha:____/_____/______', 1);
            $pdf->Cell(93, 4, 'Lugar: Secretaria Municipal de Salud        Fecha:____/_____/______', 1);
            $pdf->Cell(92, 4, 'Lugar: Secretaria Municipal de Salud        Fecha:____/_____/______', 1);
            
        
        }
        $pdf->AddPage();
        // Incrustar el logo en el encabezado
        $pdf->Image('images/logo.png', 16, 11, 18); // Ajusta la ruta y las coordenadas según tus necesidades

        // Generar encabezado del reporte PDF
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(30, 15, '', 1);
        $pdf->Cell(248, 5, 'PROCESO DE GESTION DOCUMENTAL', 1, 1, 'C');
        $pdf->Cell(30, 15, '', 2);
        $pdf->Cell(248, 5, 'FORMATO UNICO DE INVENTARIO DOCUMENTAL', 1, 1, 'C');
        $pdf->Cell(30, 15, '', 2);
        $pdf->Cell(62, 5, 'VIGENCIA : 24 jul 2015', 1);$pdf->Cell(62, 5, 'VERSION : 02', 1);$pdf->Cell(62, 5, 'CODIGO : GD-F-007', 1);$pdf->Cell(62, 5, 'CONSECUTIVO', 1, 1);
        $pdf->Cell(216, 5, 'ENTIDAD REMITENTE : ALCALDIA DE PASTO', 1);
        $pdf->Cell(62, 5, 'REGISTRO DE ENTRADA', 1, 1, 'C');
        $pdf->Cell(216, 5, 'ENTIDAD PRODUCTORA : SECRETARIA DE SALUD', 1);
        $pdf->Cell(21, 5, 'DIA', 1);$pdf->Cell(21, 5, 'MES', 1);$pdf->Cell(20, 5, 'ANIO', 1, 1, 1);
        $pdf->Cell(216, 5, 'UNIDAD ADMINISTRATIVA: SUBSECRETARIA DE SALUD PUBLICA', 1);
        $pdf->Cell(21, 5, '', 1);$pdf->Cell(21, 5, '', 1);$pdf->Cell(20, 5, '', 1, 1, 1);
        $pdf->Cell(278, 5, 'OFICINA PRODUCTORA : SALUD AMBIENTAL', 1, 1, 1);
        $pdf->Cell(278, 5, 'OBJETO : ENTREGA DE INVENTARIO INDIVIDUAL', 1, 1, 1);
        $pdf->Ln();
        // Generar encabezado de la tabla
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(14, 10, 'No.Orden', 1);
        $pdf->Cell(14, 10, 'Cod.TRD', 1);
        $pdf->Cell(80, 10, 'Nombre de Serie', 1);
        $pdf->Cell(16, 10, 'fec.Ext. Ini', 1);
        $pdf->Cell(16, 10, 'Fec.Ext. Fin', 1);
        $pdf->Cell(9, 10, 'Caja', 1);
        $pdf->Cell(12, 10, 'Carpeta', 1);
        $pdf->Cell(9, 10, 'Tomo', 1);
        $pdf->Cell(9, 10, 'Otro', 1);
        $pdf->Cell(14, 10, 'No.Folios', 1);
        $pdf->Cell(15, 10, 'Soporte', 1);
        $pdf->Cell(20, 10, 'Frec.Consulta', 1);
        $pdf->Cell(50, 10, 'Observacion', 1);

         
        
        $pdf->Ln();
        // ... continuar con los campos que necesites mostrar en el reporte

        // Generar contenido de la tabla
        $pdf->SetFont('Arial', '', 8);
    }

    // Mostrar los datos del registro actual en el reporte PDF
    $pdf->Cell(14, 5, $row['no_orden'], 1);
    $pdf->Cell(14, 5, $row['cod_trd'], 1);
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(80, 5, $row['nom_serie'], 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(16, 5, $row['fecha_ext_ini'], 1);
    $pdf->Cell(16, 5, $row['fecha_ext_fin'], 1);
    $pdf->Cell(9, 5, $row['uc_caja'], 1);
    $pdf->Cell(12, 5, $row['uc_carpeta'], 1);
    $pdf->Cell(9, 5, $row['uc_tomo'], 1);
    $pdf->Cell(9, 5, $row['uc_otro'], 1);
    $pdf->Cell(14, 5, $row['num_folios'], 1);
    $pdf->Cell(15, 5, $row['soporte'], 1);
    $pdf->Cell(20, 5, $row['frc_consulta'], 1);
    $pdf->Cell(50, 5, $row['observacion'], 1);
    // ... continuar con los campos que necesites mostrar en el reporte
    
    if ($contador == $sqlRegistro->rowCount()) {
        $pdf->SetY(-37); // Posición vertical del pie de página
        $pdf->SetFont('Arial', 'I', 6);
        $pdf->SetY(-40); // Posición vertical del pie de página
        $pdf->SetFont('Arial', 'I', 6);
        $pdf->Cell(93, 4, 'ELABORADO POR: ' . $row['nom_usuario'].' '.$row['ape_usuario'], 1);
        $pdf->Cell(93, 4, 'ENTREGADO POR: ' . $row['nom_usuario'].' '.$row['ape_usuario'], 1);
        $pdf->Cell(92, 4, 'RECIBIDO POR: ' . $row['nom_usuario'].' '.$row['ape_usuario'], 1, 1, 1);
        $pdf->Cell(93, 4, 'CARGO: ' . $row['nom_usuario'].' '.$row['ape_usuario'], 1);
        $pdf->Cell(93, 4, 'CARGO: ' . $row['nom_usuario'].' '.$row['ape_usuario'], 1);
        $pdf->Cell(92, 4, 'CARGO:' . $row['nom_usuario'].' '.$row['ape_usuario'], 1, 1, 1);
        $pdf->Cell(93, 6, 'FIRMA: _____________________________________________________________________', 1);
        $pdf->Cell(93, 6, 'FIRMA: _____________________________________________________________________', 1);
        $pdf->Cell(92, 6, 'FIRMA: _____________________________________________________________________', 1, 1);
        $pdf->Cell(93, 4, 'Lugar: Secretaria Municipal de Salud        Fecha:____/_____/______', 1);
        $pdf->Cell(93, 4, 'Lugar: Secretaria Municipal de Salud        Fecha:____/_____/______', 1);
        $pdf->Cell(92, 4, 'Lugar: Secretaria Municipal de Salud        Fecha:____/_____/______', 1);
    }

    $pdf->Ln(); 
      
}

// Paso 7: Cerrar la conexión a la base de datos
//$conn->close();

// Llamar al método AliasNbPages()
// Definir método Footer()
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15); // Habilitar salto automático de página y establecer el espacio para el pie de página

$pdf->Output('reporte.pdf?v=' . time(), 'I');

// Paso 9: Configurar el encabezado HTTP y enviar el archivo PDF al navegador
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="reporte.pdf"');
readfile('reporte.pdf');
?>
