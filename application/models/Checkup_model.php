<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkup_model extends CI_Model
{
    // Register new user
    public function create($data)
    {
        return $this->db->insert('tb_checkup', $data);
    }

    // Check user credentials
    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $admin = $this->db->get('tb_admin')->row();

        if ($admin && password_verify($password, $admin->password)) {
            return $admin;
        }
        return false;
    }

    // Check if username exists
    public function username_exists($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('tb_admin')->num_rows() > 0;
    }
    public function get_paginated($limit, $start)
    {
        return $this->db->limit($limit, $start)
            ->order_by('id_checkup', 'DESC')
            ->get('tb_checkup')
            ->result();
    }

    public function count_all()
    {
        return $this->db->count_all('tb_checkup');
    }
    public function get_history()
    {
        return $this->db->get('tb_checkup');
    }

    // public function getData($id)
    // {
    //     $this->db->where('id_checkup', $id);
    //     return $this->db->get('tb_checkup')->row();
    // }
    public function getData($kode)
    {
        $this->db->where('kode_checkup', $kode);
        return $this->db->get('tb_checkup')->row();
    }
    public function deleteCheckup($id)
    {
        $this->db->where('id_checkup', $id);
        return $this->db->delete('tb_checkup');
    }
}