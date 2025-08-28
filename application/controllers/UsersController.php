<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Index.php');
class UsersController extends Index
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'You must login first');
            redirect('admin/login');
        }
        $this->load->model('Users_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function index()
    {
        // Konfigurasi pagination
        $config['base_url'] = site_url('admin/manage_users'); // URL untuk halaman
        $config['total_rows'] = $this->Users_model->count_all(); // Total data
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
        $page = 'admin/pages/user_list';
        $page_data = [
            'data' => $this->Users_model->get_paginated($config['per_page'], $start),
            'pagination' => $this->pagination->create_links()
        ];
        $custom_js = $this->load->view('admin/template/scripts/userScripts', [], TRUE);
        return $this->render_view_admin($title, $page, $page_data, $custom_js);
        // $data = $this->Users_model->get_user();
        // foreach ($data as $item) {
        //     # code...
        //     echo $item->nama;
        // }

    }
    public function tambah_user()
    {
        $this->load->library('form_validation');
        // Set rules validasi
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('sex', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('age', 'Usia', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('telp', 'No. Telp', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Kirim error per input field
            $errors = [
                'nama' => form_error('nama', '', ''),
                'email' => form_error('email', '', ''),
                'sex' => form_error('sex', '', ''),
                'age' => form_error('age', '', ''),
                'telp' => form_error('telp', '', ''),
            ];
            echo json_encode(['status' => 'error', 'errors' => $errors]);
            return;
        }

        // Cek apakah email sudah digunakan
        $email = $this->input->post('email', true);
        if ($this->Users_model->is_email_exist($email)) {
            echo json_encode([
                'status' => 'error',
                'errors' => ['email' => 'Email sudah digunakan.']
            ]);
            return;
        }

        // Siapkan data
        $data = [
            'nama' => $this->input->post('nama', true),
            'email' => $email,
            'sex' => $this->input->post('sex', true),
            'age' => $this->input->post('age', true),
            'telp' => $this->input->post('telp', true),
        ];

        // Simpan ke database
        if ($this->Users_model->addUser($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ke database.']);
        }
    }

    public function edit_user()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('sex', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('age', 'Usia', 'required|numeric');
        $this->form_validation->set_rules('telp', 'No. Telp', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        $data = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'sex' => $this->input->post('sex'),
            'age' => $this->input->post('age'),
            'telp' => $this->input->post('telp'),
        ];
        $update = $this->Users_model->updateUser($id, $data);

        if ($update) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data']);
        }
    }

    public function hapus_user()
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
        $deleted = $this->Users_model->deleteUser($id);

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