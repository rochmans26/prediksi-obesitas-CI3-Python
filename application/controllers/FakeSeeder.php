<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php'; // pastikan composer autoload diload

class FakeSeeder extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
    }

    public function users($jumlah = 10)
    {
        $faker = Faker\Factory::create();
        $gender = $faker->randomElement(['male', 'female']);
        $dateOfBirth = $faker->dateTimeBetween('-60 years', '-18 years');
        $age = $dateOfBirth->diff(new DateTime('now'))->y;
        for ($i = 0; $i < $jumlah; $i++) {
            $data = [
                'nama' => $faker->name($gender),
                'email' => $faker->unique()->safeEmail,
                'sex' => $gender === 'male' ? 'Laki-laki' : 'Perempuan',
                'age' => $age,
                'telp' => $faker->numerify('08##########')
            ];
            $this->Users_model->addUser($data);
        }

        redirect('admin/manage_users');
    }
}
