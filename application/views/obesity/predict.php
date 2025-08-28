<!-- Content Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Obesity Risk Prediction</h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('obesity/predict'); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="Sex">Sex</label>
                            <select class="form-control" id="Sex" name="Sex" required>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Age">Age</label>
                            <input type="number" class="form-control" id="Age" name="Age" min="18" max="100" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Height">Height (cm)</label>
                            <input type="number" class="form-control" id="Height" name="Height" min="100" max="250"
                                required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Overweight_Obese_Family">Family History of Overweight</label>
                            <select class="form-control" id="Overweight_Obese_Family" name="Overweight_Obese_Family"
                                required>
                                <option value="1">No</option>
                                <option value="2">Yes</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Consumption_of_Fast_Food">Fast Food Consumption</label>
                            <select class="form-control" id="Consumption_of_Fast_Food" name="Consumption_of_Fast_Food"
                                required>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Frequency_of_Consuming_Vegetables">Vegetable Consumption Frequency</label>
                            <select class="form-control" id="Frequency_of_Consuming_Vegetables"
                                name="Frequency_of_Consuming_Vegetables" required>
                                <option value="1">Never</option>
                                <option value="2">Sometimes</option>
                                <option value="3">Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Number_of_Main_Meals_Daily">Main Meals per Day</label>
                            <select class="form-control" id="Number_of_Main_Meals_Daily"
                                name="Number_of_Main_Meals_Daily" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4+</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Food_Intake_Between_Meals">Food Intake Between Meals</label>
                            <select class="form-control" id="Food_Intake_Between_Meals" name="Food_Intake_Between_Meals"
                                required>
                                <option value="1">Never</option>
                                <option value="2">Sometimes</option>
                                <option value="3">Frequently</option>
                                <option value="4">Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Smoking">Smoking</label>
                            <select class="form-control" id="Smoking" name="Smoking" required>
                                <option value="1">No</option>
                                <option value="2">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Liquid_Intake_Daily">Daily Liquid Intake</label>
                            <select class="form-control" id="Liquid_Intake_Daily" name="Liquid_Intake_Daily" required>
                                <option value="1">Less than 1L</option>
                                <option value="2">1-2L</option>
                                <option value="3">More than 2L</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Calculation_of_Calorie_Intake">Calorie Intake Awareness</label>
                            <select class="form-control" id="Calculation_of_Calorie_Intake"
                                name="Calculation_of_Calorie_Intake" required>
                                <option value="1">No</option>
                                <option value="2">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Physical_Exercise">Physical Exercise</label>
                            <select class="form-control" id="Physical_Exercise" name="Physical_Exercise" required>
                                <option value="1">Never</option>
                                <option value="2">Sometimes</option>
                                <option value="3">Regularly</option>
                                <option value="4">Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Schedule_Dedicated_to_Technology">Technology Use</label>
                            <select class="form-control" id="Schedule_Dedicated_to_Technology"
                                name="Schedule_Dedicated_to_Technology" required>
                                <option value="1">0-2 hours</option>
                                <option value="2">2-4 hours</option>
                                <option value="3">4-6 hours</option>
                                <option value="4">6-8 hours</option>
                                <option value="5">8+ hours</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Type_of_Transportation_Used">Transportation Type</label>
                            <select class="form-control" id="Type_of_Transportation_Used"
                                name="Type_of_Transportation_Used" required>
                                <option value="1">Walking/Biking</option>
                                <option value="2">Public Transport</option>
                                <option value="3">Car/Motorcycle</option>
                                <option value="4">Mixed</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Predict</button>
                </form>

                <?php if (isset($prediction)): ?>
                    <div class="mt-4">
                        <h4>Prediction Results</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Algorithm</th>
                                        <th>Prediction</th>
                                        <th>Interpretation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>K-Nearest Neighbors (KNN)</td>
                                        <td><?php echo $prediction['KNN_prediction']; ?></td>
                                        <td>
                                            <?php
                                            switch ($prediction['KNN_prediction']) {
                                                case 1:
                                                    echo "Underweight";
                                                    break;
                                                case 2:
                                                    echo "Normal weight";
                                                    break;
                                                case 3:
                                                    echo "Overweight";
                                                    break;
                                                case 4:
                                                    echo "Obese";
                                                    break;
                                                default:
                                                    echo "Unknown";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Random Forest</td>
                                        <td><?php echo $prediction['RandomForest_prediction']; ?></td>
                                        <td>
                                            <?php
                                            switch ($prediction['RandomForest_prediction']) {
                                                case 1:
                                                    echo "Underweight";
                                                    break;
                                                case 2:
                                                    echo "Normal weight";
                                                    break;
                                                case 3:
                                                    echo "Overweight";
                                                    break;
                                                case 4:
                                                    echo "Obese";
                                                    break;
                                                default:
                                                    echo "Unknown";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="mt-3">Input Data</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Feature</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($input_data as $key => $value): ?>
                                        <tr>
                                            <td><?php echo ucfirst(str_replace('_', ' ', $key)); ?></td>
                                            <td><?php echo $value; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>