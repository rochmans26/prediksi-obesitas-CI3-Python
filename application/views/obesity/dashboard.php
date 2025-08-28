<!-- Content Row -->
<div class="row">
    <!-- Prediction Card -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Make Prediction</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Predict Obesity Risk</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calculator fa-2x text-gray-300"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="<?php echo site_url('obesity/predict'); ?>" class="btn btn-primary">Go to Prediction</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Metrics Card -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Model Performance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">View Metrics</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="<?php echo site_url('obesity/metrics'); ?>" class="btn btn-success">View Metrics</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Data Management Card -->
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Dataset Management</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Manage Obesity Dataset</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-database fa-2x text-gray-300"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="<?php echo site_url('obesity/data_management'); ?>" class="btn btn-info">Manage Data</a>
                </div>
            </div>
        </div>
    </div>
</div>