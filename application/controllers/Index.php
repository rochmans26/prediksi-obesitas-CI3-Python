<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends CI_Controller
{
    public function render_view($title, $page, $page_data = [])
    {
        $partials = [
            'head' => $this->load->view('template/head', ['title' => $title], TRUE),
            'foot' => $this->load->view('template/foot', [], TRUE),
            'content' => $this->load->view($page, ['data' => $page_data], TRUE)
        ];
        $this->load->view('template/main', $partials);
    }
    public function index()
    {
        $title = "Obscu App";
        $page = 'index';
        $page_data = [];
        return $this->render_view($title, $page, $page_data);
    }

    public function render_view_admin($title, $page, $page_data, $custom_js)
    {
        $partials = [
            'header' => $this->load->view('admin/template/header', ['title' => $title], TRUE),
            'footer' => $this->load->view('admin/template/footer', [], TRUE),
            'content_pages' => $this->load->view($page, ['data' => $page_data['data'], 'pagination' => $page_data['pagination']], TRUE),
            'sidebar' => $this->load->view('admin/template/sidebar', [], TRUE),
            'navbar' => $this->load->view('admin/template/navbar', [], TRUE),
            'custom_js' => $custom_js,
            'title' => $title
        ];
        $this->load->view('admin/main', $partials);
    }

}