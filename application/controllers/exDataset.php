<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dataset extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $this->load->view('upload_csv');
    }

    public function upload()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['file_name'] = 'dataset_' . time();

        $this->load->library('upload', $config);

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        if (!$this->upload->do_upload('csv_file')) {
            $this->session->set_flashdata('msg', $this->upload->display_errors());
            $this->session->set_flashdata('msg_type', 'error');
            redirect('dataset');
        }

        $file_data = $this->upload->data();
        $file_path = $file_data['full_path'];

        if (($handle = fopen($file_path, "r")) !== FALSE) {
            $header = fgetcsv($handle); // skip header

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csv_data = array_combine($header, $data);

                $this->db->insert('tb_dataset', $csv_data);
            }

            fclose($handle);
            unlink($file_path); // optional: hapus file setelah upload

            $this->session->set_flashdata('msg', 'Import berhasil!');
            $this->session->set_flashdata('msg_type', 'success');
        } else {
            $this->session->set_flashdata('msg', 'Gagal membaca file CSV');
            $this->session->set_flashdata('msg_type', 'error');
        }

        redirect('dataset');
    }
}
