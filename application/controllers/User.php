<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]|min_length[8]|max_length[15]|alpha_numeric', [
            'min_length' => 'Username must be contain 8-15 character',
            'max_length' => 'Username must be contain 8-15 character',
            'alpha_numeric' => 'Username can only be alphabetical and numeric'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|is_unique[user.email]|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|max_length[15]', [
            'min_length' => 'Password must be contain 8-15 character',
            'max_length' => 'Password must be contain 8-15 character'
        ]);

        $this->form_validation->set_rules('role_id', 'Role', 'required');
        if ($this->form_validation->run() ==  false) {
            $data['title'] = 'User';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $data['user_role'] = $this->db->get('user_role')->result_array();
            $data['user_list'] = $this->db->query('SELECT user.*, user_role.role FROM user JOIN user_role ON user_role.id = role_id WHERE user.id != 1')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('user/index', $data);
            $this->load->view('templates/footer');
        } else {
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $is_active = ($this->input->post('is_active') !== null) ? $this->input->post('is_active') : 0;
            $data = [
                'username' => $this->input->post('username', true),
                'email' => $this->input->post('email', true),
                'role_id' => $this->input->post('role_id'),
                'password' => $password,
                'is_active' => $is_active
            ];
            $this->db->insert('user', $data);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">User berhasil ditambahkan.</div>');
            redirect('user');
        }
    }

    public function check()
    {
        if ($this->input->post('type')) {
            $type = $this->input->post('type');
            $key = $this->input->post('key');
            $this->db->select('id, username, email, role_id, is_active');
            $query = $this->db->get_where('user', [$type => $key]);
            if ($query->num_rows() > 0) {
                echo json_encode($query->row_array());
            } else {
                echo json_encode(null);
            }
        } else {
            redirect('auth/blocked');
        }
    }

    public function edit()
    {
        $this->form_validation->set_rules('id', 'id', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[8]|max_length[15]|alpha_numeric', [
            'min_length' => 'Username must be contain 8-15 character',
            'max_length' => 'Username must be contain 8-15 character',
            'alpha_numeric' => 'Username can only be alphabetical and numeric'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]|max_length[15]', [
            'min_length' => 'Password must be contain 8-15 character',
            'max_length' => 'Password must be contain 8-15 character'
        ]);
        if ($this->form_validation->run() == false) {
            $data['title'] = 'User';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $data['user_role'] = $this->db->get('user_role')->result_array();
            $data['user_list'] = $this->db->query('SELECT user.*, user_role.role FROM user JOIN user_role ON user_role.id = role_id')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('user/index', $data);
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id');
            if ($id == 1) {
                $this->session->set_flashdata('messages', '<div class="alert alert-success">Akun superuser tidak dapat diedit!.</div>');
                redirect('user');
            }
            $role_id = $this->input->post('role_id');
            $is_active = ($this->input->post('is_active') !== null) ? $this->input->post('is_active') : 0;
            $data = [
                'role_id' => $role_id,
                'is_active' => $is_active
            ];
            if ($this->input->post('password')) {
                $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                var_dump($data);
            }
            $this->db->where('id', $id);
            $this->db->update('user', $data);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">User berhasil diedit.</div>');
            redirect('user');
        }
    }

    public function hapus($id = null)
    {

        if ($id) {
            $this->db->delete('user', ['id' => $id]);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">User berhasil dihapus.</div>');
            redirect('user');
        } else {
            redirect('auth/blocked');
        }
    }

    public function role()
    {
        $this->form_validation->set_rules('role', 'Role', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'User Role';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $this->db->where('id !=', 1);
            $data['user_role'] = $this->db->get('user_role')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('user/user-role', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Role berhasil ditambahkan.</div>');
            redirect('user/role');
        }
    }

    public function getRole()
    {
        if ($this->input->post('id')) {
            echo json_encode($this->db->get_where('user_role', ['id' => $this->input->post('id')])->row_array());
        } else {
            redirect('auth/blocked');
        }
    }

    public function editRole()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $role = $this->input->post('role');
            $this->db->set('role', $role);
            $this->db->where('id', $id);
            $this->db->update('user_role');
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Role berhasil diubah.</div>');
            redirect('user/role');
        } else {
            redirect('auth/blocked');
        }
    }
    public function roleAccess($role_id = null)
    {
        if ($role_id) {
            if ($role_id != 1) {
                $data['title'] = 'Edit User Role';
                $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
                $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
                $data['menu'] = $this->db->get('user_menu')->result_array();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('user/edit-role', $data);
                $this->load->view('templates/footer');
            } else {
                redirect('auth/blocked');
            }
        } else {
            redirect('auth/blocked');
        }
    }

    public function changeRole()
    {
        if ($this->input->post('roleId')) {
            $role_id = $this->input->post('roleId');
            $menu_id = $this->input->post('menuId');

            $data = [
                'role_id' => $role_id,
                'menu_id' => $menu_id
            ];

            $query = $this->db->get_where('user_access_menu', $data);
            if ($query->num_rows() < 1) {
                $this->db->insert('user_access_menu', $data);
            } else {
                $this->db->delete('user_access_menu', $data);
            }
        } else {
            redirect('auth/blocked');
        }
    }
    public function hapusRole($id = null)
    {
        if ($id) {
            $this->db->delete('user_role', ['id' => $id]);
            $this->session->set_flashdata('messages', '<div class="alert alert-danger">Role berhasil dihapus.</div>');
            redirect('user/role');
        } else {
            redirect('auth/blocked');
        }
    }
}
