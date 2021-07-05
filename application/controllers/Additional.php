<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Additional extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Additional_model', 'additional');
        $this->load->model('Log_model');
    }

    public function index()
    {
        $this->form_validation->set_rules('total_palet', 'Total Palet', 'required|trim|is_natural_no_zero');
        $this->form_validation->set_rules('max_koli', 'Maksimal Koli Per Palet', 'required|trim|is_natural_no_zero');
        $this->form_validation->set_rules('jadwal_backup', 'Jadwal Backup', 'required|trim|is_natural_no_zero');
        if ($this->form_validation->run()) {
            $this->additional->updateDataSettings();
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Settings saved!</div');
            redirect('additional');
        } else {
            $data['title'] = 'Settings';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $data['settings'] = $this->additional->getDataSettings();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('additional/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function log()
    {
        $data['title'] = 'Log';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->load->library('pagination');

        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword_log', $data['keyword']);
        } else {
            $data['keyword'] = $this->session->userdata('keyword_log');
        }

        $config['base_url'] = base_url('additional/log');
        $this->db->distinct();
        $this->db->select('ext_no');
        $this->db->like('ext_no', $data['keyword']);
        $this->db->from('log');
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 8;

        $this->pagination->initialize($config);

        $data['start'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['logs'] = $this->Log_model->getDistinctLog($config['per_page'], $data['start'], $data['keyword']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('additional/log', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id = null)
    {
        $data['id'] = $this->Log_model->getLogById($id);
        if ($id == null || !$data['id']) redirect('auth/blocked');
        $data['title'] = 'Detail Log';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['logs'] = $this->Log_model->getLogDetail($data['id']['ext_no']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('additional/detail', $data);
        $this->load->view('templates/footer');
    }
}
