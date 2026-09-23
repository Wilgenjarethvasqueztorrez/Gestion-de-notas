<!doctype html>  
<html lang="es">  
  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>Promedios del Estudiante</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
    <link rel="stylesheet" href="../../src/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <link rel="stylesheet" href="../src/css/styles.css">
</head>  
  
<body class="promedios-page">
    <main class="container promedios-shell pt-4" id="contenido-pdf">
        <?php  
        require("../Config/Conexion.php");  
  
        // Obtener ID del alumno (tabla alumnos.id)  
        $alumno_id = intval($_GET['Id']);  
  
        // Información del estudiante  
        $sqlAlumno = $conexion->query("SELECT usuarios.nombre,  
                                              usuarios.apellido,  
                                              usuarios.correo,  
                                              usuarios.rol_sistema,  
                                              alumnos.estado  
                                       FROM alumnos  
                                       INNER JOIN usuarios ON alumnos.alumno_id = usuarios.id  
                                       WHERE alumnos.id = $alumno_id");  
        $alumno = $sqlAlumno ? $sqlAlumno->fetch_assoc() : null;
        if (!$alumno) {
            http_response_code(404);
            exit('<div class="alert alert-danger">No se encontró el alumno solicitado.</div>');
        }
  
        // Promedio general del estudiante  
        $sqlGeneral = $conexion->query("SELECT AVG(notas.valor) as promedio  
                                        FROM notas  
                                        INNER JOIN matricula ON notas.matricula_id = matricula.id  
                                        WHERE matricula.alumno_id = $alumno_id");  
        $promedioGeneral = $sqlGeneral->fetch_assoc()['promedio'] ?? 0;  
  
        // Promedios por AÑO  
        $sqlAnios = $conexion->query("SELECT years.id, years.nombre,  
                                             AVG(notas.valor) as promedio  
                                      FROM notas  
                                      INNER JOIN matricula ON notas.matricula_id = matricula.id  
                                      INNER JOIN parciales ON notas.parcial_id = parciales.id  
                                      INNER JOIN years ON parciales.year_id = years.id  
                                      WHERE matricula.alumno_id = $alumno_id  
                                      GROUP BY years.id, years.nombre  
                                      ORDER BY years.nombre DESC");  
        $promediosAnio = [];  
        while ($row = $sqlAnios->fetch_assoc()) {  
            $promediosAnio[] = $row;  
        }  

        // Promedios por año y parcial  
        $sqlPromediosParcial = $conexion->query("SELECT years.nombre as year_nombre,  
                                                       parciales.numero as parcial_numero,  
                                                       AVG(notas.valor) as promedio  
                                                FROM notas  
                                                INNER JOIN matricula ON notas.matricula_id = matricula.id  
                                                INNER JOIN parciales ON notas.parcial_id = parciales.id  
                                                INNER JOIN years ON parciales.year_id = years.id  
                                                WHERE matricula.alumno_id = $alumno_id  
                                                GROUP BY years.id, parciales.id, years.nombre, parciales.numero  
                                                ORDER BY years.nombre DESC, parciales.numero ASC");  
        $promediosAnioParcial = [];  
        while ($row = $sqlPromediosParcial->fetch_assoc()) {  
            $promediosAnioParcial[] = $row;  
        }  
        ?>  
  
        <div class="promedios-toolbar d-flex justify-content-between align-items-center mb-3">
            <a href="../pages/alumno.php" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Volver a Estudiantes  
            </a>  
            <button id="btnExportarPDF" class="btn btn-danger">  
                <i class="bi bi-file-pdf"></i> Exportar PDF  
            </button>  
        </div>  
  
        <header class="promedios-hero">
            <p class="mb-1 text-uppercase small fw-semibold">Rendimiento académico</p>
            <h1><i class="bi bi-bar-chart-line-fill me-2"></i>Promedios de <?php echo htmlspecialchars(strtoupper($alumno['nombre'] . " " . $alumno['apellido']), ENT_QUOTES, 'UTF-8'); ?></h1>
        </header>
  
        <div class="student-summary mb-3">
            <strong>Rol:</strong> <?php echo htmlspecialchars($alumno['rol_sistema'], ENT_QUOTES, 'UTF-8'); ?><br>
            <strong>Estado:</strong>  
            <?php  
            if ($alumno['estado'] == 'Activo') {  
                echo '<span class="badge bg-success">Activo</span>';  
            } elseif ($alumno['estado'] == 'Graduado') {  
                echo '<span class="badge bg-primary">Graduado</span>';  
            } else {  
                echo '<span class="badge bg-secondary">Suspendido</span>';  
            }  
            ?>  
        </div>  
  
        <!-- Cards: promedio general + por año -->  
        <div class="average-grid">
            <article class="average-card">
                <h2>Promedio general</h2>
                <p class="value"><?php echo number_format($promedioGeneral, 2); ?></p>
                <small>Histórico</small>
            </article>
            <?php foreach ($promediosAnio as $anio) { ?>  
                <article class="average-card">
                    <h2>Año <?php echo htmlspecialchars($anio['nombre'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p class="value"><?php echo number_format($anio['promedio'], 2); ?></p>
                    <small>Promedio anual</small>
                </article>
            <?php } ?>  
        </div>
  
        <div class="charts-grid">
            <section class="chart-panel">
                <h2><i class="bi bi-graph-up-arrow me-2"></i>Evolución por año</h2>
                <div class="chart-wrap"><canvas id="promediosChart"></canvas></div>
            </section>
            <section class="chart-panel">
                <h2><i class="bi bi-pie-chart-fill me-2"></i>Distribución de promedios</h2>
                <div class="chart-wrap"><canvas id="distribucionChart"></canvas></div>
            </section>
        </div>
  
        <!-- Tabla de promedios por año y parcial -->  
        <div class="grades-panel">
            <h2 class="mb-3"><i class="bi bi-table me-2"></i>Promedio por año y parcial</h2>
            <div class="table-container">
            <table class="table table-hover">  
                <thead>  
                    <tr>  
                        <th>Año</th>  
                        <th>Parcial</th>  
                        <th>Promedio</th>  
                    </tr>  
                </thead>  
                <tbody>  
                    <?php  
                          // Promedio de todas las notas del mismo año y parcial  
                    $sql = $conexion->query("SELECT years.nombre as year_nombre,  
                                                    parciales.numero as parcial_numero,  
                                                    AVG(notas.valor) as promedio  
                                             FROM notas  
                                             INNER JOIN matricula ON notas.matricula_id = matricula.id  
                                             INNER JOIN parciales ON notas.parcial_id = parciales.id  
                                             INNER JOIN years ON parciales.year_id = years.id  
                                             WHERE matricula.alumno_id = $alumno_id  
                                       GROUP BY years.id, parciales.id, years.nombre, parciales.numero  
                                             ORDER BY years.nombre DESC, parciales.numero ASC");  
                    while ($resultado = $sql->fetch_assoc()) {  
                    ?>  
                        <tr>  
                            <td><?php echo $resultado['year_nombre']; ?></td>  
                            <td>Parcial <?php echo $resultado['parcial_numero']; ?></td>  
                            <td><?php echo number_format($resultado['promedio'], 2); ?></td>  
                        </tr>  
                    <?php } ?>  
                </tbody>  
                <tfoot>  
                    <tr class="table-info">  
                        <td colspan="2"><strong>Promedio General:</strong></td>  
                        <td><strong><?php echo number_format($promedioGeneral, 2); ?></strong></td>  
                    </tr>  
                </tfoot>  
            </table>  
            </div>
        </div>

        <!-- Detalle de clases y notas por parcial -->
        <div style="margin-top: 20px;" class="grades-panel detail-panel">
            <h2 class="mb-3"><i class="bi bi-journal-text me-2"></i>Clases y notas por parcial</h2>
            <div class="table-container">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Año</th>
                            <th>Parcial</th>
                            <th>Clase</th>
                            <th>Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlDetalle = $conexion->query("SELECT years.nombre AS year_nombre,
                                                               parciales.numero AS parcial_numero,
                                                               clases.nombre AS clase_nombre,
                                                               notas.valor
                                                        FROM notas
                                                        INNER JOIN matricula ON notas.matricula_id = matricula.id
                                                        INNER JOIN clases ON matricula.clase_id = clases.id
                                                        INNER JOIN parciales ON notas.parcial_id = parciales.id
                                                        INNER JOIN years ON parciales.year_id = years.id
                                                        WHERE matricula.alumno_id = $alumno_id
                                                        ORDER BY years.nombre ASC, parciales.numero ASC, clases.nombre ASC");
                        while ($detalle = $sqlDetalle->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($detalle['year_nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>Parcial <?php echo (int) $detalle['parcial_numero']; ?></td>
                                <td><?php echo htmlspecialchars($detalle['clase_nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><span class="badge bg-primary"><?php echo (int) $detalle['valor']; ?></span></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>  

  
    <?php include('../src/includes/Dependencias/sweetalert.php'); ?>  
  
    <script>  
        window.datosEstudiante = <?php echo json_encode([
            'nombre' => $alumno['nombre'] . ' ' . $alumno['apellido'],
            'rol' => $alumno['rol_sistema'],
            'estado' => $alumno['estado'],
            'promedioGeneral' => (float) $promedioGeneral,
            'promediosAnio' => $promediosAnio,
            'promediosAnioParcial' => $promediosAnioParcial,
            'fechaActual' => date('Y-m-d H:i:s')
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('btnExportarPDF').addEventListener('click', generarPDF);

            const years = window.datosEstudiante.promediosAnio.slice().reverse();
            const labels = years.map(item => `Año ${item.nombre}`);
            const values = years.map(item => Number(item.promedio));
            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { color: '#e2e8f0' } } },
                scales: {
                    x: { ticks: { color: '#cbd5e1' }, grid: { color: 'rgba(255,255,255,.08)' } },
                    y: { beginAtZero: true, max: 100, ticks: { color: '#cbd5e1', stepSize: 10 }, grid: { color: 'rgba(255,255,255,.08)' } }
                }
            };

            new Chart(document.getElementById('promediosChart'), {
                type: 'line',
                data: { labels, datasets: [{ label: 'Promedio anual', data: values, borderColor: '#7de8f2', backgroundColor: 'rgba(0,172,193,.2)', fill: true, tension: .35, pointBackgroundColor: '#f44336', pointRadius: 5 }] },
                options: chartOptions
            });

            new Chart(document.getElementById('distribucionChart'), {
                type: 'doughnut',
                data: { labels: labels.length ? labels : ['Sin calificaciones'], datasets: [{ data: values.length ? values : [1], backgroundColor: ['#00acc1', '#f44336', '#1976d2', '#ffd166', '#20c997'], borderColor: '#282c36', borderWidth: 3 }] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { color: '#e2e8f0', padding: 14 } } } }
            });
        });

        function generarPDF() {
            if (!window.jspdf || typeof window.jspdf.jsPDF !== 'function') {
                window.alert('No se pudo cargar jsPDF. Verifique su conexión a internet.');
                return;
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');

            if (typeof doc.autoTable !== 'function') {
                window.alert('No se pudo cargar el complemento de tablas para el PDF.');
                return;
            }

            const datos = window.datosEstudiante;
            const nombre = datos.nombre.trim();
            const fecha = new Date(datos.fechaActual).toLocaleString('es-ES');

            doc.setFillColor(25, 118, 210);
            doc.rect(0, 0, 210, 34, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(18);
            doc.text('REPORTE DE PROMEDIOS', 105, 15, { align: 'center' });
            doc.setFontSize(11);
            doc.text('Gestión de notas', 105, 24, { align: 'center' });

            doc.setTextColor(40, 44, 54);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(11);
            doc.text(`Estudiante: ${nombre}`, 15, 47);
            doc.text(`Rol: ${datos.rol}`, 15, 55);
            doc.text(`Estado: ${datos.estado}`, 15, 63);
            doc.text(`Promedio general: ${Number(datos.promedioGeneral).toFixed(2)}`, 15, 71);

            const promediosAnuales = datos.promediosAnio.map(item => [
                `Año ${item.nombre}`,
                Number(item.promedio).toFixed(2)
            ]);

            doc.autoTable({
                startY: 80,
                head: [['Periodo', 'Promedio']],
                body: promediosAnuales.length ? promediosAnuales : [['Sin calificaciones', '0.00']],
                theme: 'grid',
                headStyles: { fillColor: [0, 172, 193], textColor: [255, 255, 255] },
                styles: { fontSize: 10 }
            });

            const promediosPorAnioParcial = datos.promediosAnioParcial.map(item => [
                `Año ${item.year_nombre}`,
                `Parcial ${item.parcial_numero}`,
                Number(item.promedio).toFixed(2)
            ]);

            doc.autoTable({
                startY: doc.lastAutoTable.finalY + 12,
                head: [['Año', 'Parcial', 'Promedio']],
                body: promediosPorAnioParcial.length ? promediosPorAnioParcial : [['Sin calificaciones', '-', '0.00']],
                theme: 'grid',
                headStyles: { fillColor: [25, 118, 210], textColor: [255, 255, 255] },
                styles: { fontSize: 9 }
            });

            const detalle = Array.from(document.querySelectorAll('.detail-panel tbody tr')).map(row =>
                Array.from(row.cells).map(cell => cell.textContent.trim())
            );

            doc.autoTable({
                startY: doc.lastAutoTable.finalY + 12,
                head: [['Año', 'Parcial', 'Clase', 'Nota']],
                body: detalle.length ? detalle : [['-', 'Sin calificaciones', '-', '-']],
                theme: 'grid',
                headStyles: { fillColor: [25, 118, 210], textColor: [255, 255, 255] },
                styles: { fontSize: 9 }
            });

            const totalPaginas = doc.internal.getNumberOfPages();
            for (let pagina = 1; pagina <= totalPaginas; pagina++) {
                doc.setPage(pagina);
                doc.setFontSize(8);
                doc.setTextColor(100, 100, 100);
                doc.text(`Generado: ${fecha} | Página ${pagina} de ${totalPaginas}`, 15, 290);
            }

            const nombreSeguro = nombre.normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-zA-Z0-9]+/g, '_')
                .replace(/^_|_$/g, '')
                .toLowerCase();
            doc.save(`promedios_${nombreSeguro || 'estudiante'}.pdf`);
        }
    </script>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
  
</html>