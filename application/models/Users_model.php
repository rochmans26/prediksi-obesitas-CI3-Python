<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
    public function get_user()
    {
        return $this->db->get('tb_users')->result();
    }
    public function get_paginated($limit, $start)
    {
        return $this->db->limit($limit, $start)
            ->where('is_admin', 0)
            ->order_by('id_user', 'DESC')
            ->get('tb_users')
            ->result();
    }
    public function count_all()
    {
        $this->db->where('is_admin', 0);
        return $this->db->count_all('tb_users');
    }
    public function get_dataUser($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('tb_users')->row();
    }
    public function addUser($data)
    {
        return $this->db->insert('tb_users', $data);
    }
    public function updateUser($id, $data)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('tb_users', $data);
    }
    public function deleteUser($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->delete('tb_users');
    }
    public function is_email_exist($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('tb_users');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}