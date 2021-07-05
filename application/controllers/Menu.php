<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $this->form_validation->set_rules('menu_name', 'Menu', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Menu Management';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $this->db->where('id !=', 1);
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu_name')]);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Menu berhasil ditambahkan.</div>');
            redirect('menu');
        }
    }

    public function getmenu()
    {
        if ($this->input->post('id')) {
            echo json_encode($this->db->get_where('user_menu', ['id' => $this->input->post('id')])->row_array());
        } else {
            redirect('auth/blocked');
        }
    }

    public function edit()
    {
        $this->form_validation->set_rules('menu_name', 'Menu', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Menu Management';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $this->db->where('id !=', 1);
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('user_menu', ['menu' => $this->input->post('menu_name')]);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Menu berhasil diedit.</div>');
            redirect('menu');
        }
    }
    public function hapus($id = null)
    {
        if ($id) {
            $this->db->delete('user_menu', ['id' => $id]);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Menu berhasil dihapus.</div>');
            redirect('menu');
        } else {
            redirect('auth/blocked');
        }
    }

    public function submenu()
    {
        $this->form_validation->set_rules('title', 'Submenu Title', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required|trim');
        $this->form_validation->set_rules('url', 'Url', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Submenu Management';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $data['submenu'] = $this->db->query('SELECT user_sub_menu.*, menu FROM user_sub_menu JOIN user_menu ON menu_id = user_menu.id WHERE user_sub_menu.id != 1')->result_array();
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $title      = $this->input->post('title');
            $menu_id    = $this->input->post('menu_id');
            $url        = $this->input->post('url');
            $icon       = $this->input->post('icon');
            $is_active  = ($this->input->post('is_active')) ? $this->input->post('is_active') : 0;

            $data = [
                'title' => $title,
                'menu_id' => $menu_id,
                'url' => $url,
                'icon' => $icon,
                'is_active' => $is_active
            ];

            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Submenu berhasil ditambahkan.</div>');
            redirect('menu/submenu');
        }
    }

    public function getSubmenu()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            echo json_encode($this->db->get_where('user_sub_menu', ['id' => $id])->row_array());
        } else {
            redirect('auth/blocked');
        }
    }

    public function editSubmenu()
    {
        $this->form_validation->set_rules('title', 'Submenu Title', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required|trim');
        $this->form_validation->set_rules('url', 'Url', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Submenu Management';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $data['submenu'] = $this->db->query('SELECT user_sub_menu.*, menu FROM user_sub_menu JOIN user_menu ON menu_id = user_menu.id WHERE user_sub_menu.id != 1')->result_array();
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id');
            $title = $this->input->post('title');
            $menu_id = $this->input->post('menu_id');
            $url = $this->input->post('url');
            $icon = $this->input->post('icon');
            $is_active = ($this->input->post('is_active')) ? $this->input->post('is_active') : 0;

            $data = [
                'title' => $title,
                'menu_id' => $menu_id,
                'url' => $url,
                'icon' => $icon,
                'is_active' => $is_active
            ];
            $this->db->where('id', $id);
            $this->db->update('user_sub_menu', $data);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Submenu berhasil diedit.</div>');
            redirect('menu/submenu');
        }
    }

    public function hapusSubmenu($id = null)
    {
        if ($id) {
            $this->db->delete('user_sub_menu', ['id' => $id]);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Submenu berhasil dihapus.</div>');
            redirect('menu/submenu');
        } else {
            redirect('auth/blocked');
        }
    }
}
