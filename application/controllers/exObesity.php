<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Obesity extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Obesity_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        $this->dashboard();
    }

    public function dashboard()
    {
        $data['page_title'] = 'Obesity Prediction Dashboard';
        $this->load->view('obesity/template/header', $data);
        $this->load->view('obesity/dashboard');
        $this->load->view('obesity/template/footer');
    }

    public function predict()
    {
        if ($this->input->post()) {
            $input_data = $this->input->post();
            $result = $this->Obesity_model->predict($input_data);

            if (isset($result['error'])) {
                $this->session->set_flashdata('error', $result['error']);
            } else {
                $data['prediction'] = $result;
                $data['input_data'] = $input_data;
            }
        }

        $data['page_title'] = 'Obesity Prediction';
        $this->load->view('obesity/template/header', $data);
        $this->load->view('obesity/predict', $data);
        $this->load->view('obesity/template/footer');
    }

    public function metrics()
    {
        $result = $this->Obesity_model->get_metrics();

        if (isset($result['error'])) {
            $this->session->set_flashdata('error', $result['error']);
        } else {
            $data['metrics'] = $result;
        }

        $data['page_title'] = 'Model Metrics';
        $this->load->view('obesity/template/header', $data);
        $this->load->view('obesity/metrics', $data);
        $this->load->view('obesity/template/footer');
    }

    public function data_management()
    {
        if ($this->input->post('add')) {
            $input_data = $this->input->post();
            unset($input_data['add']);
            $result = $this->Obesity_model->add_data($input_data);

            if (isset($result['error'])) {
                $this->session->set_flashdata('error', $result['error']);
            } else {
                $this->session->set_flashdata('success', 'Data added successfully');
            }
        } elseif ($this->input->post('update')) {
            $input_data = $this->input->post();
            $index = $input_data['index'];
            unset($input_data['update'], $input_data['index']);
            $result = $this->Obesity_model->update_data($index, $input_data);

            if (isset($result['error'])) {
                $this->session->set_flashdata('error', $result['error']);
            } else {
                $this->session->set_flashdata('success', 'Data updated successfully');
            }
        } elseif ($this->input->post('delete')) {
            $index = $this->input->post('index');
            $result = $this->Obesity_model->delete_data($index);

            if (isset($result['error'])) {
                $this->session->set_flashdata('error', $result['error']);
            } else {
                $this->session->set_flashdata('success', 'Data deleted successfully');
            }
        }

        $result = $this->Obesity_model->get_all_data();

        if (isset($result['error'])) {
            $this->session->set_flashdata('error', $result['error']);
            $data['dataset'] = [];
        } else {
            $data['dataset'] = $result;
        }

        $data['page_title'] = 'Data Management';
        $this->load->view('obesity/template/header', $data);
        $this->load->view('obesity/data_management', $data);
        $this->load->view('obesity/template/footer');
    }
}