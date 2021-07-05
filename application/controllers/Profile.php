<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Profile_model', 'profile');
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[user.email]');
        if ($this->form_validation->run()) {
            $this->profile->updateEmail();
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Email Berhasil diedit/ ditambahkan</div>');
            redirect('profile');
        } else {
            $data['title'] = 'Profile';
            $this->db->join('user_role', 'user_role.id = role_id');
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('profile/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->form_validation->set_rules('old_password', 'Old Password', 'required|trim');
        $this->form_validation->set_rules('password1', 'New Password', 'required|trim|matches[password2]|min_length[8]|max_length[15]', [
            'min_length' => 'Password must be contain 8 - 15 Characters',
            'max_length' => 'Password must be contain 8 - 15 Characters'
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run()) {
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('password1');
            if (password_verify($old_password, $data['user']['password'])) {
                if ($new_password != $old_password) {
                    $this->profile->updatePassword();
                    $this->session->set_flashdata('messages', '<div class="alert alert-success">Change password success!</div>');
                    redirect('profile/changepassword');
                } else {
                    $this->session->set_flashdata('messages', '<div class="alert alert-danger">The New Password cannot be same as Old Password!</div>');
                    redirect('profile/changepassword');
                }
            } else {
                $this->session->set_flashdata('messages', '<div class="alert alert-danger">The Old Password is wrong!</div>');
                redirect('profile/changepassword');
            }
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('profile/change-password', $data);
            $this->load->view('templates/footer');
        }
    }
}
