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
                                <label for="" class="form-label">Keluarga dengan Kelebihan Berat/Obesitas</label>
                                <select class="form-select" name="overweight_obese_family" id="overweight_obese_family">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Ya</option>
                                    <option value="2">Tidak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Konsumsi Makanan Cepat Saji</label>
                                <select class="form-select" name="consumption_of_fast_food"
                                    id="consumption_of_fast_food">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Ya</option>
                                    <option value="2">Tidak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Frekuensi Konsumsi Sayuran</label>
                                <select class="form-select" name="frequency_of_consuming_vegetables"
                                    id="frequency_of_consuming_vegetables">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Jarang</option>
                                    <option value="2">Kadang-kadang</option>
                                    <option value="3">Selalu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Jumlah Makan Utama Harian</label>
                                <select class="form-select" name="number_of_main_meals_daily"
                                    id="number_of_main_meals_daily">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">1-2 kali makan</option>
                                    <option value="2">3 kali makan</option>
                                    <option value="3">Lebih dari 3 kali makan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Asupan Makanan di Antara Waktu Makan</label>
                                <select class="form-select" name="food_intake_between_meals"
                                    id="food_intake_between_meals">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Jarang</option>
                                    <option value="2">Kadang-kadang</option>
                                    <option value="3">Biasanya</option>
                                    <option value="4">Selalu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Merokok</label>
                                <select class="form-select" name="smoking" id="smoking">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Ya</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Asupan Cairan Harian</label>
                                <select class="form-select" name="liquid_intake_daily" id="liquid_intake_daily">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Kurang dari 1L</option>
                                    <option value="2">1-2L</option>
                                    <option value="3">Lebih dari 2L</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Perhitungan Asupan Kalori</label>
                                <select class="form-select" name="calculation_of_calorie_intake"
                                    id="calculation_of_calorie_intake">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Ya</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Olahraga Fisik</label>
                                <select class="form-select" name="physical_exercise" id="physical_exercise">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Tidak ada aktivitas fisik</option>
                                    <option value="2">1-2 hari</option>
                                    <option value="3">3-4 hari</option>
                                    <option value="4">5-6 hari</option>
                                    <option value="5">Lebih dari 6 hari</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Waktu yang Didedikasikan untuk Teknologi</label>
                                <select class="form-select" name="schedule_dedicated_to_technology"
                                    id="schedule_dedicated_to_technology">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">0-2 jam</option>
                                    <option value="2">3-5 jam</option>
                                    <option value="3">Lebih dari 5 jam</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Jenis Transportasi yang Digunakan</label>
                                <select class="form-select" name="type_of_transportation_used"
                                    id="type_of_transportation_used">
                                    <option selected>Pilih Salah Satu</option>
                                    <option value="1">Mobil</option>
                                    <option value="2">Sepeda Motor</option>
                                    <option value="3">Sepeda</option>
                                    <option value="4">Transportasi Umum</option>
                                    <option value="5">Berjalan Kaki</option>
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