<section id="form-checkup" style="margin-top: 15vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="d-flex justify-content-center my-2">
                        <img class="" src="<?= base_url('assets/img/obscu-logo.png') ?>" alt="Title" width="150px" />
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-center">Obscu Form</h4>
                        <form action="<?= site_url('checkup/prosesCheckup') ?>" method="post">
                            <input type="hidden" name="nama" value="<?= $data["nama"] ?>">
                            <input type="hidden" name="email" value="<?= $data["email"] ?>">
                            <input type="hidden" name="telp" value="<?= $data["telp"] ?>">
                            <input type="hidden" name="sex" value="<?= $data["sex"] ?>">
                            <input type="hidden" name="age" value="<?= $data["age"] ?>">
                            <div class="mb-3">
                                <label for="" class="form-label">Tinggi Badan</label>
                                <input type="number" name="height" id="height" class="form-control"
                                    placeholder="Tinggi badan dalam sentimeter(cm)" aria-describedby="height" />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Overweight_Obese_Family</label>
                                <select class="form-select" name="overweight_obese_family" id="overweight_obese_family">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Consumption_of_Fast_Food</label>
                                <select class="form-select" name="consumption_of_fast_food"
                                    id="consumption_of_fast_food">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Frequency_of_Consuming_Vegetables</label>
                                <select class="form-select" name="frequency_of_consuming_vegetables"
                                    id="frequency_of_consuming_vegetables">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Rarely</option>
                                    <option value="2">Sometimes</option>
                                    <option value="3">Always</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Number_of_Main_Meals_Daily</label>
                                <select class="form-select" name="number_of_main_meals_daily"
                                    id="number_of_main_meals_daily">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">1-2</option>
                                    <option value="2">3</option>
                                    <option value="3">3+</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Food_Intake_Between_Meals</label>
                                <select class="form-select" name="food_intake_between_meals"
                                    id="food_intake_between_meals">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Rarely</option>
                                    <option value="2">Sometimes</option>
                                    <option value="3">Usually</option>
                                    <option value="4">Always</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Smoking</label>
                                <select class="form-select" name="smoking" id="smoking">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Liquid_Intake_Daily</label>
                                <select class="form-select" name="liquid_intake_daily" id="liquid_intake_daily">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">amount smaller than one liter</option>
                                    <option value="2">within the range of 1 to 2 liters</option>
                                    <option value="3">In excess of 2 liters</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Calculation_of_Calorie_Intake</label>
                                <select class="form-select" name="calculation_of_calorie_intake"
                                    id="calculation_of_calorie_intake">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Physical_Excercise</label>
                                <select class="form-select" name="physical_exercise" id="physical_exercise">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">No Physical Activity</option>
                                    <option value="2">In the range of 1-2 days</option>
                                    <option value="3">In the range of 3-4 days</option>
                                    <option value="4">In the range of 5-6 days</option>
                                    <option value="5">6+ days</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Schedule_Dedicated_to_Technology</label>
                                <select class="form-select" name="schedule_dedicated_to_technology"
                                    id="schedule_dedicated_to_technology">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Between 0 and 2 hours</option>
                                    <option value="2">Between 3 and 5 hours</option>
                                    <option value="3">Exceeding five hours</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Type_of_Transportation_Used</label>
                                <select class="form-select" name="type_of_transportation_used"
                                    id="type_of_transportation_used">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Automobile</option>
                                    <option value="2">Motorbike</option>
                                    <option value="3">Bike</option>
                                    <option value="4">Public Transportation</option>
                                    <option value="5">Walking</option>
                                </select>
                            </div>
                            <div class="mb-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" name="submit">Check
                                    Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>