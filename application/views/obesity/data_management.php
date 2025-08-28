<!-- Content Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Dataset Management</h6>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addDataModal">
                        <i class="fas fa-plus"></i> Add New Data
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Index</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Height</th>
                                <th>Family History</th>
                                <th>Fast Food</th>
                                <th>Vegetables</th>
                                <th>Class</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataset as $index => $row): ?>
                                <tr>
                                    <td><?php echo $index; ?></td>
                                    <td><?php echo $row['Sex'] == 1 ? 'Male' : 'Female'; ?></td>
                                    <td><?php echo $row['Age']; ?></td>
                                    <td><?php echo $row['Height']; ?></td>
                                    <td><?php echo $row['Overweight_Obese_Family'] == 1 ? 'No' : 'Yes'; ?></td>
                                    <td>
                                        <?php
                                        switch ($row['Consumption_of_Fast_Food']) {
                                            case 1:
                                                echo 'Low';
                                                break;
                                            case 2:
                                                echo 'Medium';
                                                break;
                                            case 3:
                                                echo 'High';
                                                break;
                                            default:
                                                echo $row['Consumption_of_Fast_Food'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($row['Frequency_of_Consuming_Vegetables']) {
                                            case 1:
                                                echo 'Never';
                                                break;
                                            case 2:
                                                echo 'Sometimes';
                                                break;
                                            case 3:
                                                echo 'Always';
                                                break;
                                            default:
                                                echo $row['Frequency_of_Consuming_Vegetables'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($row['Class']) {
                                            case 1:
                                                echo 'Underweight';
                                                break;
                                            case 2:
                                                echo 'Normal';
                                                break;
                                            case 3:
                                                echo 'Overweight';
                                                break;
                                            case 4:
                                                echo 'Obese';
                                                break;
                                            default:
                                                echo $row['Class'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-btn" data-index="<?php echo $index; ?>"
                                            data-sex="<?php echo $row['Sex']; ?>" data-age="<?php echo $row['Age']; ?>"
                                            data-height="<?php echo $row['Height']; ?>"
                                            data-family="<?php echo $row['Overweight_Obese_Family']; ?>"
                                            data-fastfood="<?php echo $row['Consumption_of_Fast_Food']; ?>"
                                            data-vegetables="<?php echo $row['Frequency_of_Consuming_Vegetables']; ?>"
                                            data-meals="<?php echo $row['Number_of_Main_Meals_Daily']; ?>"
                                            data-betweenmeals="<?php echo $row['Food_Intake_Between_Meals']; ?>"
                                            data-smoking="<?php echo $row['Smoking']; ?>"
                                            data-liquid="<?php echo $row['Liquid_Intake_Daily']; ?>"
                                            data-calorie="<?php echo $row['Calculation_of_Calorie_Intake']; ?>"
                                            data-exercise="<?php echo $row['Physical_Exercise']; ?>"
                                            data-technology="<?php echo $row['Schedule_Dedicated_to_Technology']; ?>"
                                            data-transport="<?php echo $row['Type_of_Transportation_Used']; ?>"
                                            data-class="<?php echo $row['Class']; ?>" data-target="#editDataModal"
                                            data-toggle="modal">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form method="post" action="<?php echo site_url('obesity/data_management'); ?>"
                                            style="display:inline;">
                                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                                            <button type="submit" name="delete" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this record?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
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

<!-- Add Data Modal -->
<div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Add New Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" action="<?php echo site_url('obesity/data_management'); ?>">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="addSex">Sex</label>
                            <select class="form-control" id="addSex" name="Sex" required>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="addAge">Age</label>
                            <input type="number" class="form-control" id="addAge" name="Age" min="18" max="100"
                                required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="addHeight">Height (cm)</label>
                            <input type="number" class="form-control" id="addHeight" name="Height" min="100" max="250"
                                required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="addOverweight_Obese_Family">Family History of Overweight</label>
                            <select class="form-control" id="addOverweight_Obese_Family" name="Overweight_Obese_Family"
                                required>
                                <option value="1">No</option>
                                <option value="2">Yes</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="addConsumption_of_Fast_Food">Fast Food Consumption</label>
                            <select class="form-control" id="addConsumption_of_Fast_Food"
                                name="Consumption_of_Fast_Food" required>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="addFrequency_of_Consuming_Vegetables">Vegetable Consumption Frequency</label>
                            <select class="form-control" id="addFrequency_of_Consuming_Vegetables"
                                name="Frequency_of_Consuming_Vegetables" required>
                                <option value="1">Never</option>
                                <option value="2">Sometimes</option>
                                <option value="3">Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="addNumber_of_Main_Meals_Daily">Main Meals per Day</label>
                            <select class="form-control" id="addNumber_of_Main_Meals_Daily"
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
                            <label for="addFood_Intake_Between_Meals">Food Intake Between Meals</label>
                            <select class="form-control" id="addFood_Intake_Between_Meals"
                                name="Food_Intake_Between_Meals" required>
                                <option value="1">Never</option>
                                <option value="2">Sometimes</option>
                                <option value="3">Frequently</option>
                                <option value="4">Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="addSmoking">Smoking</label>
                            <select class="form-control" id="addSmoking" name="Smoking" required>
                                <option value="1">No</option>
                                <option value="2">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="addLiquid_Intake_Daily">Daily Liquid Intake</label>
                            <select class="form-control" id="addLiquid_Intake_Daily" name="Liquid_Intake_Daily"
                                required>
                                <option value="1">Less than 1L</option>
                                <option value="2">1-2L</option>
                                <option value="3">More than 2L</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="addCalculation_of_Calorie_Intake">Calorie Intake Awareness</label>
                            <select class="form-control" id="addCalculation_of_Calorie_Intake"
                                name="Calculation_of_Calorie_Intake" required>
                                <option value="1">No</option>
                                <option value="2">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="addPhysical_Exercise">Physical Exercise</label>
                            <select class="form-control" id="addPhysical_Exercise" name="Physical_Exercise" required>
                                <option value="1">Never</option>
                                <option value="2">Sometimes</option>
                                <option value="3">Regularly</option>
                                <option value="4">Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="addSchedule_Dedicated_to_Technology">Technology Use</label>
                            <select class="form-control" id="addSchedule_Dedicated_to_Technology"
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
                            <label for="addType_of_Transportation_Used">Transportation Type</label>
                            <select class="form-control" id="addType_of_Transportation_Used"
                                name="Type_of_Transportation_Used" required>
                                <option value="1">Walking/Biking</option>
                                <option value="2">Public Transport</option>
                                <option value="3">Car/Motorcycle</option>
                                <option value="4">Mixed</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="addClass">Obesity Class</label>
                            <select class="form-control" id="addClass" name="Class" required>
                                <option value="1">Underweight</option>
                                <option value="2">Normal weight</option>
                                <option value="3">Overweight</option>
                                <option value="4">Obese</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <!-- <input type="submit" value="Add Data" name="add" class="btn btn-primary"> -->
                    <button type="submit" name="add" class="btn btn-primary">Add Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Data Modal -->
<div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" action="<?php echo site_url('obesity/data_management'); ?>">
                <div class="modal-body">
                    <input type="hidden" name="index" id="editIndex">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="editSex">Sex</label>
                            <select class="form-control" id="editSex" name="Sex" required>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editAge">Age</label>
                            <input type="number" class="form-control" id="editAge" name="Age" min="18" max="100"
                                required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editHeight">Height (cm)</label>
                            <input type="number" class="form-control" id="editHeight" name="Height" min="100" max="250"
                                required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editOverweight_Obese_Family">Family History of Overweight</label>
                            <select class="form-control" id="editOverweight_Obese_Family" name="Overweight_Obese_Family"
                                required>
                                <option value="1">No</option>
                                <option value="2">Yes</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editConsumption_of_Fast_Food">Fast Food Consumption</label>
                            <select class="form-control" id="editConsumption_of_Fast_Food"
                                name="Consumption_of_Fast_Food" required>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editFrequency_of_Consuming_Vegetables">Vegetable Consumption Frequency</label>
                            <select class="form-control" id="editFrequency_of_Consuming_Vegetables"
                                name="Frequency_of_Consuming_Vegetables" required>
                                <option value="1">Never</option>
                                <option value="2">Sometimes</option>
                                <option value="3">Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editNumber_of_Main_Meals_Daily">Main Meals per Day</label>
                            <select class="form-control" id="editNumber_of_Main_Meals_Daily"
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
                            <label for="editFood_Intake_Between_Meals">Food Intake Between Meals</label>
                            <select class="form-control" id="editFood_Intake_Between_Meals"
                                name="Food_Intake_Between_Meals" required>
                                <option value="1">Never</option>
                                <option value="2">Sometimes</option>
                                <option value="3">Frequently</option>
                                <option value="4">Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editSmoking">Smoking</label>
                            <select class="form-control" id="editSmoking" name="Smoking" required>
                                <option value="1">No</option>
                                <option value="2">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editLiquid_Intake_Daily">Daily Liquid Intake</label>
                            <select class="form-control" id="editLiquid_Intake_Daily" name="Liquid_Intake_Daily"
                                required>
                                <option value="1">Less than 1L</option>
                                <option value="2">1-2L</option>
                                <option value="3">More than 2L</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editCalculation_of_Calorie_Intake">Calorie Intake Awareness</label>
                            <select class="form-control" id="editCalculation_of_Calorie_Intake"
                                name="Calculation_of_Calorie_Intake" required>
                                <option value="1">No</option>
                                <option value="2">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editPhysical_Exercise">Physical Exercise</label>
                            <select class="form-control" id="editPhysical_Exercise" name="Physical_Exercise" required>
                                <option value="1">Never</option>
                                <option value="2">Sometimes</option>
                                <option value="3">Regularly</option>
                                <option value="4">Always</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editSchedule_Dedicated_to_Technology">Technology Use</label>
                            <select class="form-control" id="editSchedule_Dedicated_to_Technology"
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
                            <label for="editType_of_Transportation_Used">Transportation Type</label>
                            <select class="form-control" id="editType_of_Transportation_Used"
                                name="Type_of_Transportation_Used" required>
                                <option value="1">Walking/Biking</option>
                                <option value="2">Public Transport</option>
                                <option value="3">Car/Motorcycle</option>
                                <option value="4">Mixed</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editClass">Obesity Class</label>
                            <select class="form-control" id="editClass" name="Class" required>
                                <option value="1">Underweight</option>
                                <option value="2">Normal weight</option>
                                <option value="3">Overweight</option>
                                <option value="4">Obese</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="update" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>