<?php
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
function getStatistics($connect){
    // Género dos pacientes
    $sql_demographics = "SELECT GENDER, COUNT(*) as count FROM Pacient GROUP BY Pacient.GENDER";
    $result_demographics = $connect->query($sql_demographics);
    $demographics = [];
    while ($row = $result_demographics->fetch_assoc()) {
        $demographics[] = $row;
    }

    //Idade dos pacientes
    $sql_age_distribution = "SELECT 
    CASE 
        WHEN FLOOR(DATEDIFF(CURRENT_DATE(), BIRTH_DATE) / 365.25) BETWEEN 0 AND 18 THEN '0-18'
        WHEN FLOOR(DATEDIFF(CURRENT_DATE(), BIRTH_DATE) / 365.25) BETWEEN 19 AND 35 THEN '19-35'
        WHEN FLOOR(DATEDIFF(CURRENT_DATE(), BIRTH_DATE) / 365.25) BETWEEN 36 AND 50 THEN '36-50'
        WHEN FLOOR(DATEDIFF(CURRENT_DATE(), BIRTH_DATE) / 365.25) BETWEEN 51 AND 65 THEN '51-65'
        WHEN FLOOR(DATEDIFF(CURRENT_DATE(), BIRTH_DATE) / 365.25) > 65 THEN '65+'
    END as age_range,
    COUNT(*) as count
    FROM Pacient
    GROUP BY age_range
    ORDER BY 
        CASE 
            WHEN age_range = '0-18' THEN 1
            WHEN age_range = '19-35' THEN 2
            WHEN age_range = '36-50' THEN 3
            WHEN age_range = '51-65' THEN 4
            WHEN age_range = '65+' THEN 5
            ELSE 6
        END";
    $result_age_distribution = $connect->query($sql_age_distribution);
    $age_distribution = [];
    while ($row = $result_age_distribution->fetch_assoc()) {
        $age_distribution[] = $row;
    }

    //Distritos dos pacientes
    $sql_locations = "SELECT DISTRICT, COUNT(*) as count FROM Pacient GROUP BY Pacient.DISTRICT";
    $result_locations = $connect->query($sql_locations);
    $locations = [];
    while ($row = $result_locations->fetch_assoc()) {
        $locations[] = $row;
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <h2>Estatísticas dos Pacientes</h2>
    <div class="content-chart">
        <div class="chart-container">
            <h3>Distribuição por Género</h3>
            <canvas id="demographicsChart" height="200px"></canvas>
        </div>
        <div class="chart-container">
            <h3>Distribuição por Idade</h3>
            <br><br><br>
            <canvas id="ageDistributionChart" height="200px"></canvas>
        </div>
        <div class="chart-container">
            <h3>Distribuição por Distrito</h3>
            <canvas id="locationsChart" height="200px"></canvas>
        </div>
    </div>

    <script>
        // Distribuição por Género
        const demographicsData = <?php echo json_encode($demographics); ?>;
        const demographicsLabelsMap = {
            '0': 'Feminino',
            '1': 'Masculino',
        };
        const demographicsLabels = demographicsData.map(item => demographicsLabelsMap[item.GENDER]);
        const demographicsCounts = demographicsData.map(item => item.count);

        const demographicsChartCtx = document.getElementById('demographicsChart').getContext('2d');
        new Chart(demographicsChartCtx, {
            type: 'pie',
            data: {
                labels: demographicsLabels,
                datasets: [{
                    label: 'Número de Pacientes',
                    data: demographicsCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            }

        });

        // Distribuição por idades
        const ageDistributionData = <?php echo json_encode($age_distribution); ?>;
        const ageDistributionLabels = ageDistributionData.map(item => item.age_range);
        const ageDistributionCounts = ageDistributionData.map(item => item.count);

        const ageDistributionChartCtx = document.getElementById('ageDistributionChart').getContext('2d');
        new Chart(ageDistributionChartCtx, {
            type: 'bar',
            data: {
                labels: ageDistributionLabels,
                datasets: [{
                    label: 'Número de Pacientes',
                    data: ageDistributionCounts,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }

        });

        // Distribuição por Distrito
        const locationsData = <?php echo json_encode($locations); ?>;
        const locationsLabels = locationsData.map(item => item.DISTRICT);
        const locationsCounts = locationsData.map(item => item.count);

        const locationsChartCtx = document.getElementById('locationsChart').getContext('2d');
        new Chart(locationsChartCtx, {
            type: 'pie',
            data: {
                labels: locationsLabels,
                datasets: [{
                    label: 'Número de Pacientes',
                    data: locationsCounts,
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            }

        });

    </script>

    <h2>Estatísticas das Classificações</h2>
    <div class="content-chart">
        <div class="chart-container">
            <h3>Número de Medições por Classificação</h3>
            <br><br><br>
            <canvas id="classificationsChart" height="200px"></canvas>
        </div>
        <?php
        // Obter número de medições por classificação
        $sql_classifications = "SELECT STATE_DOCTOR, COUNT(*) as count FROM Measurement GROUP BY Measurement.STATE_DOCTOR";
        $result_classifications = $connect->query($sql_classifications);
        $classifications = [];
        while ($row = $result_classifications->fetch_assoc()) {
            $classifications[] = $row;
        }
        ?>
        <script>
            // Dados de medições por classificação
            const classificationsData = <?php echo json_encode($classifications); ?>;
            // Mapear códigos de STATE_DOCTOR para rótulos legíveis
            const stateDoctorLabelsMap = {
                'U': 'Alerta Urgente',
                'A': 'Alerta',
                'N': 'Normal'
            };
            // Inicializar os contadores com zero
            const initialCounts = {
                'Alerta Urgente': 0,
                'Alerta': 0,
                'Normal': 0
            };
            // Preencher os contadores com os valores do banco de dados
            classificationsData.forEach(item => {
                const label = stateDoctorLabelsMap[item.STATE_DOCTOR];
                initialCounts[label] = item.count;
            });

            // Labels e counts ordenados
            const classificationsLabels = ['Alerta Urgente', 'Alerta', 'Normal'];
            const classificationsCounts = classificationsLabels.map(label => initialCounts[label]);

            const classificationsChartCtx = document.getElementById('classificationsChart').getContext('2d');
            new Chart(classificationsChartCtx, {
                type: 'bar',
                data: {
                    labels: classificationsLabels,
                    datasets: [{
                        label: 'Número de Medições',
                        data: classificationsCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <?php
        // Consulta SQL para obter contagens de STATE_SAD
        $sql_counts = "SELECT STATE_SAD, STATE_DOCTOR, COUNT(*) as count
        FROM Measurement
        GROUP BY STATE_SAD, STATE_DOCTOR";

        $result_counts = $connect->query($sql_counts);

        $confusionMatrixData = [];

        while ($row = $result_counts->fetch_assoc()) {
            if (!$row['STATE_DOCTOR']) {
                continue;
            }
            $sadPrediction = $row['STATE_SAD'] == 1 ? 'Normal' : ($row['STATE_SAD'] == 2 ? 'Alerta' : 'Alerta Urgente');
            $doctorClassification = $row['STATE_DOCTOR'] == 'N' ? 'Normal' : ($row['STATE_DOCTOR'] == 'A' ? 'Alerta' : 'Alerta Urgente');
            $count = (int)$row['count'];

            // Construir a matriz de confusão
            if (!isset($confusionMatrixData[$sadPrediction])) {
                $confusionMatrixData[$sadPrediction] = [];
            }
            $confusionMatrixData[$sadPrediction][$doctorClassification] = $count;
        }


        ?>

        <div class="chart-container">
            <h3>Comparação entre classificação do SAD e médico</h3>
            <br><br>
            <canvas id="stackedBarChart" height="200px"></canvas>
        </div>

        <script>
            // Dados da Matriz de Confusão (vindos do PHP)
            const confusionMatrixData = <?php echo json_encode($confusionMatrixData); ?>;

            // Labels das categorias
            const sadCategories = <?php echo json_encode(array_keys($confusionMatrixData)); ?>;
            const doctorCategories = Array.from(new Set([].concat(...Object.values(confusionMatrixData).map(Object.keys))));

            // Dados para os datasets do gráfico
            const datasets = doctorCategories.map((doctor, index) => {
                return {
                    label: doctor,
                    data: sadCategories.map(sad => confusionMatrixData[sad][doctor] || 0),
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ][index % 6], // Usando o operador módulo para ciclar pelas cores se houver mais categorias que cores definidas
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ][index % 6], // Usando o operador módulo para ciclar pelas cores se houver mais categorias que cores definidas
                    stack: 'stack 1',
                    borderWidth: 1
                };
            });

            // Configuração do gráfico de barras empilhadas
            const ctx = document.getElementById('stackedBarChart').getContext('2d');
            const stackedBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: sadCategories,
                    datasets: datasets
                },
                options: {
                    scales: {
                        x: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'SAD'
                            }
                        },
                        y: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'Número de Ocorrências'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });

        </script>
    </div>
<?php }?>