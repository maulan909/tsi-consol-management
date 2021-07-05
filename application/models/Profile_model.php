<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    private $_table = ('user');
    public $email,
        $username;
    private $password;

    public function UpdateEmail()
    {
        $input = $this->input->post();
        $this->username = $this->session->userdata('username');
        $this->email = $input['email'];
        $this->db->where('username', $this->username);
        return $this->db->update($this->_table, ['email' => $this->email]);
    }

    public function updatePassword()
    {
        $input = $this->input->post();
        $this->username = $this->session->userdata('username');
        $this->password = password_hash($input['password1'], PASSWORD_DEFAULT);
        $this->db->where('username', $this->username);
        return $this->db->update($this->_table, ['password' => $this->password]);
    }
}
