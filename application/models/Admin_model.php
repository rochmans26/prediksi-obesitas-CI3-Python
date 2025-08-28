<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    // Register new user
    public function register($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('tb_admin', $data);
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
    public function get_user()
    {

    }
    public function get_dataUser($id)
    {

    }
    public function addUser()
    {

    }
    public function updateUser($id)
    {

    }
    public function deleteUser($id)
    {

    }
}