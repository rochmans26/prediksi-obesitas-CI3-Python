<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Index.php');
class Checkup extends Index
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Obesity_model');
        $this->load->model('Checkup_model');
        $this->load->model('SendEmail');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }
    public function index()
    {
        $title = "Obscu App | Form";
        $page = 'pages/form-checkup';
        $page_data = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'telp' => $this->input->post('telp'),
            'sex' => $this->input->post('sex'),
            'age' => $this->input->post('age')
        ];
        return $this->render_view($title, $page, $page_data);
    }

    private function generate_kode_unik($panjang = 8)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $kode = '';

        do {
            // Generate kode acak
            for ($i = 0; $i < $panjang; $i++) {
                $kode .= $characters[rand(0, strlen($characters) - 1)];
            }

            // Cek apakah kode sudah ada di database
            $this->db->where('kode_checkup', $kode);
            $query = $this->db->get('tb_checkup');

            // Jika kode sudah ada, reset dan generate ulang
            if ($query->num_rows() > 0) {
                $kode = '';
            }

        } while (empty($kode));

        return $kode;
    }

    private function addUser($data)
    {
        $message = '';
        if ($this->Users_model->get_dataUser($data['email']) == null) {
            $dataUser = [
                "nama" => $this->input->post("nama"),
                "email" => $this->input->post("email"),
                "telp" => $this->input->post("telp"),
                "sex" => $this->input->post("sex"),
                "age" => $this->input->post("age")
            ];
            $this->Users_model->addUser($dataUser);
            $message = 'User Ditambahkan!';
        } else {
            $message = 'User Sudah Ada!';
        }

        return json_encode($message);
    }
    private function addCheckUp($kode, $data)
    {
        $result = true;
        $dataCheckUp = [
            "email_user" => $data["email"],
            "kode_checkup" => $kode,
            "tanggal_checkup" => date('Y-m-d'),
            "Sex" => $data["sex"],
            "Age" => $data["age"],
            "Height" => $data["height"],
            "Overweight_Obese_Family" => $data["overweight_obese_family"],
            "Consumption_of_Fast_Food" => $data["consumption_of_fast_food"],
            "Frequency_of_Consuming_Vegetables" => $data["frequency_of_consuming_vegetables"],
            "Number_of_Main_Meals_Daily" => $data["number_of_main_meals_daily"],
            "Food_Intake_Between_Meals" => $data["food_intake_between_meals"],
            "Smoking" => $data["smoking"],
            "Liquid_Intake_Daily" => $data["liquid_intake_daily"],
            "Calculation_of_Calorie_Intake" => $data["calculation_of_calorie_intake"],
            "Physical_Exercise" => $data["physical_exercise"],
            "Schedule_Dedicated_to_Technology" => $data["schedule_dedicated_to_technology"],
            "Type_of_Transportation_Used" => $data["type_of_transportation_used"]
        ];

        if ($this->Checkup_model->create($dataCheckUp)) {
            return $result;
        } else {
            return false;
        }
    }
    private function sendCheckupResult($input_data, $result, $kode)
    {
        $dataEmail = [
            "nama" => $input_data["nama"],
            "email" => $input_data["email"],
            "data" => [
                "tanggal_checkup" => date('Y-m-d'),
                "hasil" => $result,
                "usia" => $input_data["age"],
                "link" => base_url('checkup/predict_result/' . $kode)
            ]
        ];
        return $this->SendEmail->typeMessage(4, $input_data["email"], $input_data["nama"], $dataEmail);
    }
    public function prosesCheckup()
    {
        $interpretations = [
            1 => 'Underweight',
            2 => 'Normal weight',
            3 => 'Overweight',
            4 => 'Obese'
        ];
        $input_data = $this->input->post();

        $data = array(
            "Sex" => $input_data["sex"],
            "Age" => $input_data["age"],
            "Height" => $input_data["height"],
            "Overweight_Obese_Family" => $input_data["overweight_obese_family"],
            "Consumption_of_Fast_Food" => $input_data["consumption_of_fast_food"],
            "Frequency_of_Consuming_Vegetables" => $input_data["frequency_of_consuming_vegetables"],
            "Number_of_Main_Meals_Daily" => $input_data["number_of_main_meals_daily"],
            "Food_Intake_Between_Meals" => $input_data["food_intake_between_meals"],
            "Smoking" => $input_data["smoking"],
            "Liquid_Intake_Daily" => $input_data["liquid_intake_daily"],
            "Calculation_of_Calorie_Intake" => $input_data["calculation_of_calorie_intake"],
            "Physical_Exercise" => $input_data["physical_exercise"],
            "Schedule_Dedicated_to_Technology" => $input_data["schedule_dedicated_to_technology"],
            "Type_of_Transportation_Used" => $input_data["type_of_transportation_used"]
        );

        $kode = $this->generate_kode_unik();
        $this->addUser($input_data);
        $insert_checkup = $this->addCheckUp($kode, $input_data);
        $getPredict = $this->Obesity_model->predict($data);
        $result = $interpretations[$getPredict['RandomForest_prediction']];
        if ($insert_checkup == true) {
            $this->sendCheckupResult($input_data, $result, $kode);
            return $this->predict_result($kode);
        } else {
            return $this->session->set_flashdata('message', 'Gagal proses data checkup!');
        }
    }

    public function predict_result($kode)
    {
        $getDataCheckup = $this->Checkup_model->getData($kode);
        $data = array(
            "Sex" => $getDataCheckup->Sex,
            "Age" => $getDataCheckup->Age,
            "Height" => $getDataCheckup->Height,
            "Overweight_Obese_Family" => $getDataCheckup->Overweight_Obese_Family,
            "Consumption_of_Fast_Food" => $getDataCheckup->Consumption_of_Fast_Food,
            "Frequency_of_Consuming_Vegetables" => $getDataCheckup->Frequency_of_Consuming_Vegetables,
            "Number_of_Main_Meals_Daily" => $getDataCheckup->Number_of_Main_Meals_Daily,
            "Food_Intake_Between_Meals" => $getDataCheckup->Food_Intake_Between_Meals,
            "Smoking" => $getDataCheckup->Smoking,
            "Liquid_Intake_Daily" => $getDataCheckup->Liquid_Intake_Daily,
            "Calculation_of_Calorie_Intake" => $getDataCheckup->Calculation_of_Calorie_Intake,
            "Physical_Exercise" => $getDataCheckup->Physical_Exercise,
            "Schedule_Dedicated_to_Technology" => $getDataCheckup->Schedule_Dedicated_to_Technology,
            "Type_of_Transportation_Used" => $getDataCheckup->Type_of_Transportation_Used
        );
        $result = $this->Obesity_model->predict($data);
        $page_data = [
            'prediction' => $result,
            'input_data' => $data,
            'title' => "Obscu App | Result"
        ];
        return $this->load->view('pages/result', $page_data);
    }

    public function riwayatCheckUp()
    {
        $config['base_url'] = site_url('admin/manage_users'); // URL untuk halaman
        $config['total_rows'] = $this->Checkup_model->count_all(); // Total data
        $config['per_page'] = 10; // Data per halaman
        $config['uri_segment'] = 3;

        // Tambahan styling Bootstrap 4 (SB Admin 2)
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        // Ambil data sesuai halaman
        $start = $this->uri->segment(3) ?? 0;
        $title = " Data";
        $page = 'admin/pages/checkup_list';
        $page_data = [
            'data' => $this->Checkup_model->get_paginated($config['per_page'], $start),
            'pagination' => $this->pagination->create_links()
        ];
        $custom_js = $this->load->view('admin/template/scripts/riwayatCheckupScripts', [], TRUE);
        return $this->render_view_admin($title, $page, $page_data, $custom_js);
    }

    public function hapus_riwayat()
    {
        $id = $this->input->post('id');

        if (!$id) {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID tidak ditemukan.'
            ]);
            return;
        }

        // Contoh: gunakan model untuk hapus
        $deleted = $this->Checkup_model->deleteCheckup($id);

        if ($deleted) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil dihapus.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menghapus data.'
            ]);
        }
    }
}