<!-- Content Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Obesity Risk Prediction</h6>

                <!-- Tombol reset -->
                <a href="<?php echo site_url('admin/reset_predict'); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>

            <div class="card-body">
                <!-- Error Message -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger mb-4">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?php echo site_url('admin/predict'); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="Sex">Gender</label>
                            <select class="form-control" id="Sex" name="Sex" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="1" <?= set_select('Sex', '1') ?>>Male</option>
                                <option value="2" <?= set_select('Sex', '2') ?>>Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Age">Age</label>
                            <input type="number" class="form-control" id="Age" name="Age" min="14" max="100"
                                value="<?= set_value('Age') ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Height">Height (cm)</label>
                            <input type="number" class="form-control" id="Height" name="Height" min="100" max="250"
                                value="<?= set_value('Height') ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Overweight_Obese_Family">Family History of Overweight</label>
                            <select class="form-control" id="Overweight_Obese_Family" name="Overweight_Obese_Family"
                                required>
                                <option value="" disabled selected>Select Option</option>
                                <option value="1" <?= set_select('Overweight_Obese_Family', '1') ?>>No</option>
                                <option value="2" <?= set_select('Overweight_Obese_Family', '2') ?>>Yes</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Consumption_of_Fast_Food">Fast Food Consumption</label>
                            <select class="form-control" id="Consumption_of_Fast_Food" name="Consumption_of_Fast_Food"
                                required>
                                <option value="" disabled selected>Select Frequency</option>
                                <option value="1" <?= set_select('Consumption_of_Fast_Food', '1') ?>>Low</option>
                                <option value="2" <?= set_select('Consumption_of_Fast_Food', '2') ?>>Medium</option>
                                <option value="3" <?= set_select('Consumption_of_Fast_Food', '3') ?>>High</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Frequency_of_Consuming_Vegetables">Vegetable Consumption Frequency</label>
                            <select class="form-control" id="Frequency_of_Consuming_Vegetables"
                                name="Frequency_of_Consuming_Vegetables" required>
                                <option value="" disabled selected>Select Frequency</option>
                                <option value="1" <?= set_select('Frequency_of_Consuming_Vegetables', '1') ?>>Never
                                </option>
                                <option value="2" <?= set_select('Frequency_of_Consuming_Vegetables', '2') ?>>Sometimes
                                </option>
                                <option value="3" <?= set_select('Frequency_of_Consuming_Vegetables', '3') ?>>Always
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Number_of_Main_Meals_Daily">Main Meals per Day</label>
                            <select class="form-control" id="Number_of_Main_Meals_Daily"
                                name="Number_of_Main_Meals_Daily" required>
                                <option value="" disabled selected>Select Number</option>
                                <option value="1" <?= set_select('Number_of_Main_Meals_Daily', '1') ?>>1</option>
                                <option value="2" <?= set_select('Number_of_Main_Meals_Daily', '2') ?>>2</option>
                                <option value="3" <?= set_select('Number_of_Main_Meals_Daily', '3') ?>>3</option>
                                <option value="4" <?= set_select('Number_of_Main_Meals_Daily', '4') ?>>4+</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Food_Intake_Between_Meals">Food Intake Between Meals</label>
                            <select class="form-control" id="Food_Intake_Between_Meals" name="Food_Intake_Between_Meals"
                                required>
                                <option value="" disabled selected>Select Frequency</option>
                                <option value="1" <?= set_select('Food_Intake_Between_Meals', '1') ?>>Never</option>
                                <option value="2" <?= set_select('Food_Intake_Between_Meals', '2') ?>>Sometimes</option>
                                <option value="3" <?= set_select('Food_Intake_Between_Meals', '3') ?>>Frequently</option>
                                <option value="4" <?= set_select('Food_Intake_Between_Meals', '4') ?>>Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Smoking">Smoking</label>
                            <select class="form-control" id="Smoking" name="Smoking" required>
                                <option value="" disabled selected>Select Option</option>
                                <option value="1" <?= set_select('Smoking', '1') ?>>No</option>
                                <option value="2" <?= set_select('Smoking', '2') ?>>Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Liquid_Intake_Daily">Daily Liquid Intake</label>
                            <select class="form-control" id="Liquid_Intake_Daily" name="Liquid_Intake_Daily" required>
                                <option value="" disabled selected>Select Amount</option>
                                <option value="1" <?= set_select('Liquid_Intake_Daily', '1') ?>>Less than 1L</option>
                                <option value="2" <?= set_select('Liquid_Intake_Daily', '2') ?>>1-2L</option>
                                <option value="3" <?= set_select('Liquid_Intake_Daily', '3') ?>>More than 2L</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Calculation_of_Calorie_Intake">Calorie Intake Awareness</label>
                            <select class="form-control" id="Calculation_of_Calorie_Intake"
                                name="Calculation_of_Calorie_Intake" required>
                                <option value="" disabled selected>Select Option</option>
                                <option value="1" <?= set_select('Calculation_of_Calorie_Intake', '1') ?>>No</option>
                                <option value="2" <?= set_select('Calculation_of_Calorie_Intake', '2') ?>>Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Physical_Exercise">Physical Exercise</label>
                            <select class="form-control" id="Physical_Exercise" name="Physical_Exercise" required>
                                <option value="" disabled selected>Select Frequency</option>
                                <option value="1" <?= set_select('Physical_Exercise', '1') ?>>Never</option>
                                <option value="2" <?= set_select('Physical_Exercise', '2') ?>>Sometimes</option>
                                <option value="3" <?= set_select('Physical_Exercise', '3') ?>>Regularly</option>
                                <option value="4" <?= set_select('Physical_Exercise', '4') ?>>Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Schedule_Dedicated_to_Technology">Technology Use (daily hours)</label>
                            <select class="form-control" id="Schedule_Dedicated_to_Technology"
                                name="Schedule_Dedicated_to_Technology" required>
                                <option value="" disabled selected>Select Hours</option>
                                <option value="1" <?= set_select('Schedule_Dedicated_to_Technology', '1') ?>>0-2 hours
                                </option>
                                <option value="2" <?= set_select('Schedule_Dedicated_to_Technology', '2') ?>>2-4 hours
                                </option>
                                <option value="3" <?= set_select('Schedule_Dedicated_to_Technology', '3') ?>>4-6 hours
                                </option>
                                <option value="4" <?= set_select('Schedule_Dedicated_to_Technology', '4') ?>>6-8 hours
                                </option>
                                <option value="5" <?= set_select('Schedule_Dedicated_to_Technology', '5') ?>>8+ hours
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Type_of_Transportation_Used">Transportation Type</label>
                            <select class="form-control" id="Type_of_Transportation_Used"
                                name="Type_of_Transportation_Used" required>
                                <option value="" disabled selected>Select Type</option>
                                <option value="1" <?= set_select('Type_of_Transportation_Used', '1') ?>>Walking/Biking
                                </option>
                                <option value="2" <?= set_select('Type_of_Transportation_Used', '2') ?>>Public Transport
                                </option>
                                <option value="3" <?= set_select('Type_of_Transportation_Used', '3') ?>>Car/Motorcycle
                                </option>
                                <option value="4" <?= set_select('Type_of_Transportation_Used', '4') ?>>Mixed</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <!-- Tombol reset -->
                        <!-- <button type="button" class="btn btn-secondary px-4" id="resetFormBtn">
                            <i class="fas fa-undo"></i> Reset
                        </button> -->
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-calculator"></i> Predict
                        </button>
                    </div>
                </form>

                <?php if (isset($data['prediction'])): ?>
                    <div class="mt-5 result-page">
                        <div class="alert alert-info">
                            <h4><i class="fas fa-chart-pie"></i> Prediction Results</h4>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Algorithm Results</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Algorithm</th>
                                                        <th>Result</th>
                                                        <th>Interpretation</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $interpretations = [
                                                        1 => 'Underweight',
                                                        2 => 'Normal weight',
                                                        3 => 'Overweight',
                                                        4 => 'Obese'
                                                    ];
                                                    ?>
                                                    <tr>
                                                        <td><strong>K-Nearest Neighbors</strong></td>
                                                        <td><?= $data['prediction']['KNN_prediction'] ?></td>
                                                        <td><?= $interpretations[$data['prediction']['KNN_prediction']] ?? 'Unknown' ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Random Forest</strong></td>
                                                        <td><?= $data['prediction']['RandomForest_prediction'] ?></td>
                                                        <td><?= $interpretations[$data['prediction']['RandomForest_prediction']] ?? 'Unknown' ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">Your Input Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <tbody>
                                                    <?php foreach ($data['input_data'] as $key => $value): ?>
                                                        <tr>
                                                            <th><?= ucwords(str_replace('_', ' ', $key)) ?></th>
                                                            <td>
                                                                <?php
                                                                if ($key === 'Sex') {
                                                                    echo ($value == 1) ? 'Male' : 'Female';
                                                                } elseif ($key === 'Overweight_Obese_Family' || $key === 'Smoking' || $key === 'Calculation_of_Calorie_Intake') {
                                                                    echo ($value == 1) ? 'No' : 'Yes';
                                                                } else {
                                                                    echo htmlspecialchars($value);
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-4">
                            <h5><i class="fas fa-info-circle"></i> Recommendations</h5>
                            <?php
                            $max_prediction = max($data['prediction']['KNN_prediction'], $data['prediction']['RandomForest_prediction']);
                            if ($max_prediction >= 3): ?>
                                <p>Based on the prediction, you may be at risk of overweight or obesity. Consider:</p>
                                <ul>
                                    <li>Increasing physical activity (at least 30 minutes daily)</li>
                                    <li>Reducing fast food and sugary drinks consumption</li>
                                    <li>Eating more vegetables and fruits</li>
                                    <li>Consulting with a nutritionist or healthcare provider</li>
                                </ul>
                            <?php else: ?>
                                <p>Your weight appears to be in a healthy range. Maintain your good habits:</p>
                                <ul>
                                    <li>Continue regular physical activity</li>
                                    <li>Maintain balanced diet</li>
                                    <li>Monitor your health regularly</li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>