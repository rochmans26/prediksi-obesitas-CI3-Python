<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Index.php');
use PhpOffice\PhpSpreadsheet\IOFactory;
class DatasetController extends Index
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'You must login first');
            redirect('admin/login');
        }
        $this->load->model('Dataset_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->helper('symptom');
        $this->load->model('Obesity_model');
    }

    public function index()
    {
        // Konfigurasi pagination
        $all_data = $this->Obesity_model->get_all_data();
        // echo json_encode(count($count));
        $config['base_url'] = site_url('admin/manage_dataset'); // URL untuk halaman
        $config['total_rows'] = count($all_data); // Total data
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

        // Potong data sesuai pagination
        $paginated_data = array_slice($all_data, $start, $config['per_page']);
        $title = "Dataset";
        $page = 'admin/pages/dataset_list';
        $page_data = [
            'data' => $paginated_data,
            'pagination' => $this->pagination->create_links()
        ];
        $custom_js = $this->load->view('admin/template/scripts/datasetScripts', [], TRUE);
        return $this->render_view_admin($title, $page, $page_data, $custom_js);



        // $data = $this->Dataset_model->get_user();
        // foreach ($data as $item) {
        //     # code...
        //     echo $item->nama;
        // }

    }

    public function tambah_data()
    {
        // Periksa apakah request adalah AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->load->library('form_validation');

        // Set rules validasi
        $this->form_validation->set_rules('sex', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('age', 'Usia', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('height', 'Tinggi Badan', 'required|numeric|greater_than[100]');
        $this->form_validation->set_rules('overweight_obese_family', 'Obesitas Turunan Keluarga', 'required');
        $this->form_validation->set_rules('consumption_of_fast_food', 'Konsumsi Makanan Cepat Saji', 'required');
        $this->form_validation->set_rules('frequency_of_consuming_vegetables', 'Frekuensi Konsumsi Sayur', 'required');
        $this->form_validation->set_rules('number_of_main_meals_daily', 'Jumlah Makan Utama per Hari', 'required');
        $this->form_validation->set_rules('food_intake_between_meals', 'Camilan di Antara Waktu Makan', 'required');
        $this->form_validation->set_rules('smoking', 'Merokok', 'required');
        $this->form_validation->set_rules('liquid_intake_daily', 'Asupan Cairan Harian', 'required');
        $this->form_validation->set_rules('calculation_of_calorie_intake', 'Perhitungan Asupan Kalori', 'required');
        $this->form_validation->set_rules('physical_exercise', 'Olahraga Fisik', 'required');
        $this->form_validation->set_rules('schedule_dedicated_to_technology', 'Waktu untuk Teknologi', 'required');
        $this->form_validation->set_rules('type_of_transportation_used', 'Jenis Transportasi', 'required');
        $this->form_validation->set_rules('class', 'Kelas Berat Badan', 'required');

        if ($this->form_validation->run() === FALSE) {
            $errors = [];
            foreach ($this->input->post() as $key => $value) {
                $errors[$key] = form_error($key);
            }

            $response = [
                'status' => 'error',
                'errors' => $errors,
                'message' => 'Validasi gagal'
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($response));
            return;
        }

        // Siapkan data
        $data = [
            'Sex' => $this->input->post('sex', true),
            'Age' => $this->input->post('age', true),
            'Height' => $this->input->post('height', true),
            'Overweight_Obese_Family' => $this->input->post('overweight_obese_family', true),
            'Consumption_of_Fast_Food' => $this->input->post('consumption_of_fast_food', true),
            'Frequency_of_Consuming_Vegetables' => $this->input->post('frequency_of_consuming_vegetables', true),
            'Number_of_Main_Meals_Daily' => $this->input->post('number_of_main_meals_daily', true),
            'Food_Intake_Between_Meals' => $this->input->post('food_intake_between_meals', true),
            'Smoking' => $this->input->post('smoking', true),
            'Liquid_Intake_Daily' => $this->input->post('liquid_intake_daily', true),
            'Calculation_of_Calorie_Intake' => $this->input->post('calculation_of_calorie_intake', true),
            'Physical_Exercise' => $this->input->post('physical_exercise', true),
            'Schedule_Dedicated_to_Technology' => $this->input->post('schedule_dedicated_to_technology', true),
            'Type_of_Transportation_Used' => $this->input->post('type_of_transportation_used', true),
            'Class' => $this->input->post('class', true)
        ];

        // Simpan ke database
        $result = $this->Obesity_model->add_data($data);

        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan',
                'data' => $result // Jika API mengembalikan data yang baru dibuat
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($response));
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Gagal menyimpan data ke database'
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode($response));
        }
    }

    public function edit_data()
    {
        // $id = $this->input->post('id');
        $id = $this->input->post('id', true);

        $this->form_validation->set_rules('sex', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('age', 'Usia', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('height', 'Tinggi Badan', 'required|numeric|greater_than[100]');
        $this->form_validation->set_rules('overweight_obese_family', 'Obesitas Turunan Keluarga', 'required');
        $this->form_validation->set_rules('consumption_of_fast_food', 'Konsumsi Makanan Cepat Saji', 'required');
        $this->form_validation->set_rules('frequency_of_consuming_vegetables', 'Frekuensi Konsumsi Sayur', 'required');
        $this->form_validation->set_rules('number_of_main_meals_daily', 'Jumlah Makan Utama per Hari', 'required');
        $this->form_validation->set_rules('food_intake_between_meals', 'Camilan di Antara Waktu Makan', 'required');
        $this->form_validation->set_rules('smoking', 'Merokok', 'required');
        $this->form_validation->set_rules('liquid_intake_daily', 'Asupan Cairan Harian', 'required');
        $this->form_validation->set_rules('calculation_of_calorie_intake', 'Perhitungan Asupan Kalori', 'required');
        $this->form_validation->set_rules('physical_exercise', 'Olahraga Fisik', 'required');
        $this->form_validation->set_rules('schedule_dedicated_to_technology', 'Waktu untuk Teknologi (Gadget/Komputer)', 'required');
        $this->form_validation->set_rules('type_of_transportation_used', 'Jenis Transportasi yang Digunakan', 'required');
        $this->form_validation->set_rules('class', 'Kelas Berat Badan', 'required');



        if ($this->form_validation->run() === FALSE) {
            $errors = [];
            foreach ($this->input->post() as $key => $value) {
                $errors[$key] = form_error($key);
            }

            $response = [
                'status' => 'error',
                'errors' => $errors,
                'message' => 'Validasi gagal'
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($response));
            return;
        }

        $data = [
            'Sex' => (int) $this->input->post('sex', true),
            'Age' => (int) $this->input->post('age', true),
            'Height' => (int) $this->input->post('height', true),
            'Overweight_Obese_Family' => (int) $this->input->post('overweight_obese_family', true),
            'Consumption_of_Fast_Food' => (int) $this->input->post('consumption_of_fast_food', true),
            'Frequency_of_Consuming_Vegetables' => (int) $this->input->post('frequency_of_consuming_vegetables', true),
            'Number_of_Main_Meals_Daily' => (int) $this->input->post('number_of_main_meals_daily', true),
            'Food_Intake_Between_Meals' => (int) $this->input->post('food_intake_between_meals', true),
            'Smoking' => (int) $this->input->post('smoking', true),
            'Liquid_Intake_Daily' => (int) $this->input->post('liquid_intake_daily', true),
            'Calculation_of_Calorie_Intake' => (int) $this->input->post('calculation_of_calorie_intake', true),
            'Physical_Exercise' => (int) $this->input->post('physical_exercise', true),
            'Schedule_Dedicated_to_Technology' => (int) $this->input->post('schedule_dedicated_to_technology', true),
            'Type_of_Transportation_Used' => (int) $this->input->post('type_of_transportation_used', true),
            'Class' => (int) $this->input->post('class', true)
        ];
        $update = $this->Obesity_model->update_data($id, $data);

        if ($update) {
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil diubah',
                'data' => $update // Jika API mengembalikan data yang baru dibuat
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($response));
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Gagal menyimpan data ke database'
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode($response));
        }
    }

    public function hapus_data()
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
        $result = $this->Obesity_model->delete_data($id);

        if ($result) {
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

    // public function upload_csv()
    // {
    //     $config['upload_path'] = './uploads/';
    //     $config['allowed_types'] = 'csv';
    //     $config['file_name'] = 'dataset_' . time();

    //     $this->load->library('upload', $config);

    //     if (!is_dir($config['upload_path'])) {
    //         mkdir($config['upload_path'], 0777, true);
    //     }

    //     if (!$this->upload->do_upload('csv_file')) {
    //         $this->session->set_flashdata('msg', strip_tags($this->upload->display_errors()));
    //         $this->session->set_flashdata('msg_type', 'error');
    //         redirect('admin/manage_dataset');
    //     }

    //     $file_data = $this->upload->data();
    //     $file_path = $file_data['full_path'];

    //     if (($handle = fopen($file_path, "r")) !== FALSE) {
    //         $header = fgetcsv($handle);

    //         // Cek apakah header sesuai
    //         $expected_headers = [
    //             'Sex',
    //             'Age',
    //             'Height',
    //             'Overweight_Obese_Family',
    //             'Consumption_of_Fast_Food',
    //             'Frequency_of_Consuming_Vegetables',
    //             'Number_of_Main_Meals_Daily',
    //             'Food_Intake_Between_Meals',
    //             'Smoking',
    //             'Liquid_Intake_Daily',
    //             'Calculation_of_Calorie_Intake',
    //             'Physical_Exercise',
    //             'Schedule_Dedicated_to_Technology',
    //             'Type_of_Transportation_Used',
    //             'Class'
    //         ];

    //         if ($header !== $expected_headers) {
    //             fclose($handle);
    //             unlink($file_path);
    //             $this->session->set_flashdata('msg', 'Kolom CSV tidak sesuai format yang diharapkan!');
    //             $this->session->set_flashdata('msg_type', 'error');
    //             redirect('admin/manage_dataset');
    //         }

    //         $imported = 0;

    //         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    //             $csv_data = array_combine($header, $data);

    //             // Cek data kosong
    //             if (in_array(null, $csv_data, true) || in_array('', $csv_data, true)) {
    //                 continue; // skip baris
    //             }
    //             $this->db->insert('tb_dataset', $csv_data);
    //             $imported++;
    //         }

    //         fclose($handle);
    //         unlink($file_path);

    //         $this->session->set_flashdata('msg', "$imported data berhasil diimpor.");
    //         $this->session->set_flashdata('msg_type', 'success');
    //     } else {
    //         $this->session->set_flashdata('msg', 'Gagal membaca file CSV.');
    //         $this->session->set_flashdata('msg_type', 'error');
    //     }

    //     redirect('admin/manage_dataset');
    // }
    // public function tambah_data()
    // {
    //     $this->load->library('form_validation');

    //     // Validasi input
    //     $this->form_validation->set_rules('sex', 'Jenis Kelamin', 'required');
    //     $this->form_validation->set_rules('age', 'Usia', 'required|numeric|greater_than[0]');
    //     $this->form_validation->set_rules('height', 'Tinggi Badan', 'required|numeric|greater_than[100]');
    //     $this->form_validation->set_rules('overweight_obese_family', 'Obesitas Turunan Keluarga', 'required');
    //     $this->form_validation->set_rules('consumption_of_fast_food', 'Konsumsi Makanan Cepat Saji', 'required');
    //     $this->form_validation->set_rules('frequency_of_consuming_vegetables', 'Frekuensi Konsumsi Sayur', 'required');
    //     $this->form_validation->set_rules('number_of_main_meals_daily', 'Jumlah Makan Utama per Hari', 'required');
    //     $this->form_validation->set_rules('food_intake_between_meals', 'Camilan di Antara Waktu Makan', 'required');
    //     $this->form_validation->set_rules('smoking', 'Merokok', 'required');
    //     $this->form_validation->set_rules('liquid_intake_daily', 'Asupan Cairan Harian', 'required');
    //     $this->form_validation->set_rules('calculation_of_calorie_intake', 'Perhitungan Asupan Kalori', 'required');
    //     $this->form_validation->set_rules('physical_exercise', 'Olahraga Fisik', 'required');
    //     $this->form_validation->set_rules('schedule_dedicated_to_technology', 'Waktu untuk Teknologi', 'required');
    //     $this->form_validation->set_rules('type_of_transportation_used', 'Jenis Transportasi', 'required');
    //     $this->form_validation->set_rules('class', 'Kelas Berat Badan', 'required');

    //     if ($this->form_validation->run() === FALSE) {
    //         echo json_encode([
    //             'status' => 'error',
    //             'errors' => [
    //                 'sex' => form_error('sex'),
    //                 'age' => form_error('age'),
    //                 'height' => form_error('height'),
    //                 'overweight_obese_family' => form_error('overweight_obese_family'),
    //                 'consumption_of_fast_food' => form_error('consumption_of_fast_food'),
    //                 'frequency_of_consuming_vegetables' => form_error('frequency_of_consuming_vegetables'),
    //                 'number_of_main_meals_daily' => form_error('number_of_main_meals_daily'),
    //                 'food_intake_between_meals' => form_error('food_intake_between_meals'),
    //                 'smoking' => form_error('smoking'),
    //                 'liquid_intake_daily' => form_error('liquid_intake_daily'),
    //                 'calculation_of_calorie_intake' => form_error('calculation_of_calorie_intake'),
    //                 'physical_exercise' => form_error('physical_exercise'),
    //                 'schedule_dedicated_to_technology' => form_error('schedule_dedicated_to_technology'),
    //                 'type_of_transportation_used' => form_error('type_of_transportation_used'),
    //                 'class' => form_error('class')
    //             ]
    //         ]);
    //         return;
    //     }

    //     // Siapkan data, sesuaikan dengan huruf besar di database
    //     $data = [
    //         'Sex' => $this->input->post('sex', true),
    //         'Age' => $this->input->post('age', true),
    //         'Height' => $this->input->post('height', true),
    //         'Overweight_Obese_Family' => $this->input->post('overweight_obese_family', true),
    //         'Consumption_of_Fast_Food' => $this->input->post('consumption_of_fast_food', true),
    //         'Frequency_of_Consuming_Vegetables' => $this->input->post('frequency_of_consuming_vegetables', true),
    //         'Number_of_Main_Meals_Daily' => $this->input->post('number_of_main_meals_daily', true),
    //         'Food_Intake_Between_Meals' => $this->input->post('food_intake_between_meals', true),
    //         'Smoking' => $this->input->post('smoking', true),
    //         'Liquid_Intake_Daily' => $this->input->post('liquid_intake_daily', true),
    //         'Calculation_of_Calorie_Intake' => $this->input->post('calculation_of_calorie_intake', true),
    //         'Physical_Exercise' => $this->input->post('physical_exercise', true),
    //         'Schedule_Dedicated_to_Technology' => $this->input->post('schedule_dedicated_to_technology', true),
    //         'Type_of_Transportation_Used' => $this->input->post('type_of_transportation_used', true),
    //         'Class' => $this->input->post('class', true)
    //     ];

    //     // Simpan ke database
    //     if ($this->Obesity_model->add_data($data)) {
    //         echo json_encode(['status' => 'success']);
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ke database.']);
    //     }
    // }

    // public function tes_insert()
    // {
    //     $data = [
    //         'Sex' => '1',
    //         'Age' => 20,
    //         'Height' => 170,
    //         'Overweight_Obese_Family' => '1',
    //         'Consumption_of_Fast_Food' => '2',
    //         'Frequency_of_Consuming_Vegetables' => '1',
    //         'Number_of_Main_Meals_Daily' => '3',
    //         'Food_Intake_Between_Meals' => '2',
    //         'Smoking' => '0',
    //         'Liquid_Intake_Daily' => '2',
    //         'Calculation_of_Calorie_Intake' => '1',
    //         'Physical_Exercise' => '2',
    //         'Schedule_Dedicated_to_Technology' => '3',
    //         'Type_of_Transportation_Used' => '1',
    //         'Class' => 'Obese'
    //     ];

    //     if ($this->Dataset_model->addDataset($data)) {
    //         echo "Sukses insert!";
    //     } else {
    //         echo "Gagal insert!";
    //     }
    // }

    // public function edit_data()
    // {
    //     // Pastikan request adalah POST
    //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //         echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    //         return;
    //     }

    //     $id = $this->input->post('id');
    //     // echo $id;

    //     // Validasi ID
    //     // if (empty($id)) {
    //     //     echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
    //     //     return;
    //     // }

    //     $this->form_validation->set_rules('sex', 'Jenis Kelamin', 'required');
    //     $this->form_validation->set_rules('age', 'Usia', 'required|numeric|greater_than[0]');
    //     $this->form_validation->set_rules('height', 'Tinggi Badan', 'required|numeric|greater_than[100]');
    //     $this->form_validation->set_rules('overweight_obese_family', 'Obesitas Turunan Keluarga', 'required');
    //     $this->form_validation->set_rules('consumption_of_fast_food', 'Konsumsi Makanan Cepat Saji', 'required');
    //     $this->form_validation->set_rules('frequency_of_consuming_vegetables', 'Frekuensi Konsumsi Sayur', 'required');
    //     $this->form_validation->set_rules('number_of_main_meals_daily', 'Jumlah Makan Utama per Hari', 'required');
    //     $this->form_validation->set_rules('food_intake_between_meals', 'Camilan di Antara Waktu Makan', 'required');
    //     $this->form_validation->set_rules('smoking', 'Merokok', 'required');
    //     $this->form_validation->set_rules('liquid_intake_daily', 'Asupan Cairan Harian', 'required');
    //     $this->form_validation->set_rules('calculation_of_calorie_intake', 'Perhitungan Asupan Kalori', 'required');
    //     $this->form_validation->set_rules('physical_exercise', 'Olahraga Fisik', 'required');
    //     $this->form_validation->set_rules('schedule_dedicated_to_technology', 'Waktu untuk Teknologi (Gadget/Komputer)', 'required');
    //     $this->form_validation->set_rules('type_of_transportation_used', 'Jenis Transportasi yang Digunakan', 'required');
    //     $this->form_validation->set_rules('class', 'Kelas Berat Badan', 'required');

    //     if ($this->form_validation->run() == FALSE) {
    //         echo json_encode([
    //             'status' => 'error',
    //             'errors' => $this->form_validation->error_array()
    //         ]);
    //         return;
    //     }

    //     // Cek apakah data dengan ID tersebut ada
    //     $existing_data = $this->Obesity_model->get_data_by_id($id);
    //     if (!$existing_data) {
    //         echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    //         return;
    //     }

    //     $data = [
    //         'Sex' => $this->input->post('sex', true),
    //         'Age' => $this->input->post('age', true),
    //         'Height' => $this->input->post('height', true),
    //         'Overweight_Obese_Family' => $this->input->post('overweight_obese_family', true),
    //         'Consumption_of_Fast_Food' => $this->input->post('consumption_of_fast_food', true),
    //         'Frequency_of_Consuming_Vegetables' => $this->input->post('frequency_of_consuming_vegetables', true),
    //         'Number_of_Main_Meals_Daily' => $this->input->post('number_of_main_meals_daily', true),
    //         'Food_Intake_Between_Meals' => $this->input->post('food_intake_between_meals', true),
    //         'Smoking' => $this->input->post('smoking', true),
    //         'Liquid_Intake_Daily' => $this->input->post('liquid_intake_daily', true),
    //         'Calculation_of_Calorie_Intake' => $this->input->post('calculation_of_calorie_intake', true),
    //         'Physical_Exercise' => $this->input->post('physical_exercise', true),
    //         'Schedule_Dedicated_to_Technology' => $this->input->post('schedule_dedicated_to_technology', true),
    //         'Type_of_Transportation_Used' => $this->input->post('type_of_transportation_used', true),
    //         'Class' => $this->input->post('class', true)
    //     ];

    //     try {
    //         $update = $this->Obesity_model->update_data($id, $data);

    //         if ($update) {
    //             echo json_encode(['status' => 'success']);
    //         } else {
    //             echo json_encode(['status' => 'error', 'message' => 'Tidak ada perubahan data']);
    //         }
    //     } catch (Exception $e) {
    //         echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data: ' . $e->getMessage()]);
    //     }
    // }



}