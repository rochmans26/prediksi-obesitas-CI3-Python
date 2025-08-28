<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); // Ini wajib dipanggil!


        $this->load->library('form_validation');
        $this->load->model('Admin_model');
        $this->load->model('Users_model');
    }

    // public function index()
    // {
    //     $data['title'] = 'Login';
    //     $this->load->view('admin/auth/template/header', $data);
    //     $this->load->view('admin/auth/login');
    //     $this->load->view('admin/auth/template/footer');
    // }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }

        $data['title'] = 'Login';

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/auth/template/header', $data);
            $this->load->view('admin/auth/login');
            $this->load->view('admin/auth/template/footer');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $admin = $this->Admin_model->login($username, $password);
            $dataAdmin = $this->Users_model->get_dataUser($admin->email_admin);

            if ($admin) {
                $user_data = array(
                    'admin_id' => $admin->id_admin,
                    'username' => $admin->username,
                    'profil' => $dataAdmin,
                    'logged_in' => true
                );

                $this->session->set_userdata($user_data);
                $this->session->set_flashdata('success', 'Login successful!');
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password');
                redirect('admin/login');
            }
        }
    }

    // Register method
    public function register()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }
        $data['title'] = 'Register';

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tb_users.email]');
        $this->form_validation->set_rules('sex', 'Sex', 'required');
        $this->form_validation->set_rules('age', 'Age', 'required|numeric');
        $this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|numeric|min_length[6]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|is_unique[tb_admin.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/auth/template/header', $data);
            $this->load->view('admin/auth/register');
            $this->load->view('admin/auth/template/footer');
        } else {
            $dataToUser = array(
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'sex' => $this->input->post('sex'),
                'age' => $this->input->post('age'),
                'telp' => $this->input->post('telp'),
                'is_admin' => 1
            );
            $dataToAdmin = array(
                'email_admin' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );


            if ($this->Admin_model->register($dataToAdmin) && $this->Users_model->addUser($dataToUser)) {
                $this->session->set_flashdata('success', 'Registration successful! Please login.');
                redirect('admin/login');
            } else {
                $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                redirect('admin/register');
            }
        }
    }

    // Logout method
    public function logout()
    {
        $this->session->set_flashdata('success', 'You have been logged out.');
        $this->session->sess_destroy();

        redirect('admin/login');
    }
}