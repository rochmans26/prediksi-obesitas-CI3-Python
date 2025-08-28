</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Obesity Prediction System <?php echo date('Y'); ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url('assets/sbadmin2/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url('assets/sbadmin2/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

<!-- Page level plugins -->
<!-- TAMBAHKAN DataTables di sini -->
<script src="<?php echo base_url('assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/sbadmin2/vendor/chart.js/Chart.min.js'); ?>"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo base_url('assets/sbadmin2/js/sb-admin-2.min.js'); ?>"></script>

<!-- Custom scripts -->
<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>

<script>
    $(document).ready(function () {
        // Handle edit button click
        $('.edit-btn').click(function () {
            var index = $(this).data('index');

            // Set the index in the form
            $('#editIndex').val(index);

            // Populate form fields with data from the row
            $('#editSex').val($(this).data('sex'));
            $('#editAge').val($(this).data('age'));
            $('#editHeight').val($(this).data('height'));
            $('#editOverweight_Obese_Family').val($(this).data('family'));
            $('#editConsumption_of_Fast_Food').val($(this).data('fastfood'));
            $('#editFrequency_of_Consuming_Vegetables').val($(this).data('vegetables'));
            $('#editNumber_of_Main_Meals_Daily').val($(this).data('meals'));
            $('#editFood_Intake_Between_Meals').val($(this).data('betweenmeals'));
            $('#editSmoking').val($(this).data('smoking'));
            $('#editLiquid_Intake_Daily').val($(this).data('liquid'));
            $('#editCalculation_of_Calorie_Intake').val($(this).data('calorie'));
            $('#editPhysical_Exercise').val($(this).data('exercise'));
            $('#editSchedule_Dedicated_to_Technology').val($(this).data('technology'));
            $('#editType_of_Transportation_Used').val($(this).data('transport'));
            $('#editClass').val($(this).data('class'));

            // Show the modal
            $('#editDataModal').modal('show');
        });

        // Initialize DataTable
        $('#dataTable').DataTable();
    });
</script>
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Example
    var ctx = document.getElementById("metricsChart");
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Accuracy", "Precision", "Recall", "F1 Score"],
            datasets: [
                {
                    label: "KNN",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: [
                        <?php echo $metrics['KNN']['accuracy'] * 100; ?>,
                        <?php echo $metrics['KNN']['precision'] * 100; ?>,
                        <?php echo $metrics['KNN']['recall'] * 100; ?>,
                        <?php echo $metrics['KNN']['f1'] * 100; ?>
                    ],
                },
                {
                    label: "Random Forest",
                    backgroundColor: "#1cc88a",
                    hoverBackgroundColor: "#17a673",
                    borderColor: "#1cc88a",
                    data: [
                        <?php echo $metrics['Random Forest']['accuracy'] * 100; ?>,
                        <?php echo $metrics['Random Forest']['precision'] * 100; ?>,
                        <?php echo $metrics['Random Forest']['recall'] * 100; ?>,
                        <?php echo $metrics['Random Forest']['f1'] * 100; ?>
                    ],
                }
            ],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 100,
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function (value, index, values) {
                            return value + '%';
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: true
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + tooltipItem.yLabel + '%';
                    }
                }
            },
        }
    });
</script>
</body>

</html>