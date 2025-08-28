<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'You must login first');
            redirect('admin/login');
        }
        $this->load->model('Obesity_model');
    }

    public function render_view($title, $page, $page_data = [], $custom_js = [])
    {
        $partials = [
            'header' => $this->load->view('admin/template/header', ['title' => $title], TRUE),
            'footer' => $this->load->view('admin/template/footer', [], TRUE),
            'content_pages' => $this->load->view($page, ['data' => $page_data], TRUE),
            'sidebar' => $this->load->view('admin/template/sidebar', [], TRUE),
            'navbar' => $this->load->view('admin/template/navbar', [], TRUE),
            'custom_js' => $custom_js,
            'title' => $title
        ];
        $this->load->view('admin/main', $partials);
    }

    public function index()
    {
        $title = "Dashboard";
        $page = 'admin/pages/blank';
        $page_data = [];
        $custom_js = $this->load->view('admin/template/scripts/dashboardScripts', [], TRUE);
        return $this->render_view($title, $page, $page_data, $custom_js);
    }

    public function metrics()
    {
        $result = $this->Obesity_model->get_metrics();

        $title = "Model Metrics";
        $page = 'admin/pages/metrics';
        $page_data = [
            'metrics' => $result,
        ];
        $custom_js = $this->load->view('admin/template/scripts/metricScripts', ['metrics' => $result], TRUE);
        return $this->render_view($title, $page, $page_data, $custom_js);
    }

    public function predict()
    {
        $title = "Obesity Prediction";
        $page = 'admin/pages/predict';
        $page_data = [];
        $custom_js = $this->load->view('admin/template/scripts/predictScripts', [], TRUE); // Tambahkan JS khusus jika diperlukan

        if ($this->input->post()) {
            $input_data = $this->input->post();
            $result = $this->Obesity_model->predict($input_data);

            if (isset($result['error'])) {
                $this->session->set_flashdata('error', $result['error']);
            } else {
                $page_data = [
                    'prediction' => $result,
                    'input_data' => $input_data
                ];
            }
            echo json_encode($input_data);
        }

        return $this->render_view($title, $page, $page_data, $custom_js);
    }

    public function reset_predict()
    {
        redirect('admin/predict');
        // return $this->render_view($title, $page, $page_data, $custom_js);
    }
}