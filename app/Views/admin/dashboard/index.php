<?= $this->extend('admin/layout/template'); ?>
<?= $this->Section('style'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> -->
<?= $this->endSection(); ?>
<?= $this->Section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <!-- <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Primary Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Warning Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Success Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Danger Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <!-- Dropdown for activity filtering -->
                <div class="col-sm-3 mt-3 mb-3">
                    <select class="form-control" id="activityFilter">
                        <option value="" disabled selected>
                            --Pilih Kegiatan--</option>
                        <?php foreach ($target as $l) : ?>
                            <option value="<?= $l->id_keg; ?>">
                                <?= $l->nama_kegiatan; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Grafik Progress Kegiatan (%)

                            </div>
                            <div class="card-body"><canvas id="chartProgress" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Grafik Progress Kegiatan (Dokumen/Ruta)
                            </div>
                            <div class="card-body"><canvas id="chartBarProgress" width="100%" height="40"></canvas></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            // Initial chart display with the first activity in the dropdown
            var selectedActivity;
            var myLineChart;
            var myBarChart;

            // Chart.plugins.register(ChartDataLabels);

            // Function to update chart with selected activity
            function updateChart() {
                selectedActivity = $('#activityFilter').val();

                if (selectedActivity !== null) {
                    // Bentuk URL dengan ID kegiatan yang dipilih
                    var url = '/dashboard/getAggregatedProgress/' + selectedActivity;

                    // Lakukan pemanggilan AJAX ke URL tersebut
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            chartProgress(data);
                            chartBarProgress(data);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });

                }
            }


            // Event handler for activity filter change
            $('#activityFilter').change(function() {
                // Redraw the chart with the selected activity
                updateChart();
            });

            function chartBarProgress(aggregatedProgressData) {

                var maxValue = Math.max.apply(Math, aggregatedProgressData.map(function(item) {
                    return item.target;
                }));

                var labels = getLabelsForLastWeek();

                // Prepare data for Chart.js
                var totalRealisasiData = new Array(labels.length).fill(0);
                for (var i = 0; i < labels.length; i++) {
                    var currentDate = labels[i];

                    // Find entries in aggregatedProgressData for the current date
                    var entriesForDate = aggregatedProgressData.filter(function(item) {
                        return formatDate(item.tgl_input) === currentDate;
                    });

                    // Sum the total_realisasi values for the current date
                    var totalForDate = entriesForDate.reduce(function(sum, entry) {
                        return sum + parseInt(entry.total_realisasi, 10);
                    }, 0);

                    // If it's not the first day, set the value to the sum from the previous day
                    if (i > 0) {
                        totalForDate += totalRealisasiData[i - 1];
                    }
                    // Update the totalRealisasiData
                    totalRealisasiData[i] = totalForDate;

                }
                // Function to format tgl_input to 'MMM DD'
                function formatDate(inputDate) {
                    var date = new Date(inputDate);
                    return date.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric'
                    });
                }
                var chartData = {
                    labels: labels,
                    datasets: [{
                        label: "Total Realisasi",
                        data: totalRealisasiData,
                        backgroundColor: "#68B2A0", // Bar color
                        borderColor: "#68B2A0",
                        borderWidth: 1,
                    }],
                };
                console.log(myBarChart);
                if (myBarChart) {
                    // Destroy the existing chart before creating a new one
                    myBarChart.destroy();
                }

                var ctx2 = document.getElementById("chartBarProgress");
                myBarChart = new Chart(ctx2, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                formatter: Math.round,
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false
                                },
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: maxValue,
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    color: "rgba(0, 0, 0, .125)",
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    return 'Total Realisasi: ' + tooltipItem.yLabel;
                                }
                            }
                        },
                    }
                });

            }

            function chartProgress(aggregatedProgressData) {

                var maxValue = Math.max.apply(Math, aggregatedProgressData.map(function(item) {
                    return item.target;
                }));

                var labels = getLabelsForLastWeek();
                // Prepare data for Chart.js
                var totalRealisasiData = new Array(labels.length).fill(0);
                var totalForDateTemp = new Array(labels.length).fill(0);


                for (var i = 0; i < labels.length; i++) {
                    var currentDate = labels[i];

                    // Find entries in aggregatedProgressData for the current date
                    var entriesForDate = aggregatedProgressData.filter(function(item) {
                        return formatDate(item.tgl_input) === currentDate;
                    });

                    // Sum the total_realisasi values for the current date
                    var totalForDate = entriesForDate.reduce(function(sum, entry) {
                        return sum + parseInt(entry.total_realisasi, 10);
                    }, 0);

                    // If it's not the first day, set the value to the sum from the previous day
                    if (i > 0) {
                        totalForDate += totalRealisasiData[i - 1];
                    }
                    // Update the totalRealisasiData
                    totalRealisasiData[i] = totalForDate;
                    totalForDateTemp[i] = parseFloat(totalRealisasiData[i] / maxValue * 100).toFixed(2);
                }
                // totalRealisasiData[i] = parseFloat((totalForDate / maxValue * 100).toFixed(2));



                // Function to format tgl_input to 'MMM DD'
                function formatDate(inputDate) {
                    var date = new Date(inputDate);
                    return date.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric'
                    });
                }
                var chartData = {
                    labels: labels,
                    datasets: [{
                        label: "Total Realisasi",
                        // Use your dynamic data here
                        data: totalForDateTemp,
                        lineTension: 0.3,
                        backgroundColor: "#E0ECDE",
                        borderColor: "#68B2A0",
                        pointRadius: 7,
                        pointBackgroundColor: "#68B2A0",
                        pointBorderColor: "#68B2A0",
                        pointHoverRadius: 10,
                        pointHoverBackgroundColor: "#2C6975",
                        pointHoverBorderColor: "#2C6975",
                        pointHitRadius: 40,
                        pointBorderWidth: 2,
                        pointStyle: 'circle',
                    }],
                };

                console.log(myLineChart);
                if (myLineChart) {
                    // Destroy the existing chart before creating a new one
                    myLineChart.destroy();
                }

                // Create a new chart
                var ctx = document.getElementById("chartProgress");
                myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                color: '#36A2EB'

                            }
                        },
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    color: "rgba(0, 0, 0, .125)",
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        //         tooltips: {
                        //     enabled: false, // Disable tooltips
                        // },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    return 'Total Realisasi: ' + tooltipItem.yLabel + '%';
                                }
                            }
                        },

                    }
                });
            }

            function getLabelsForLastWeek() {
                // Get current date
                var currentDate = new Date();

                // Generate labels for the last 7 days
                var labels = [];
                for (var i = 6; i >= 0; i--) {
                    var day = new Date(currentDate);
                    day.setDate(currentDate.getDate() - i);
                    labels.push(day.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric'
                    }));
                }

                return labels;
            }
        });
        // Register the datalabels plugin
        // Chart.register(ChartDataLabels);
    </script>
    <?= $this->endSection(); ?>