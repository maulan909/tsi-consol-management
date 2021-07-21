<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Package extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Package_model', 'package');
        $this->load->model('Log_model');
    }
    public function index()
    {
        $this->load->library('pagination');
        $data['title'] = 'Waiting Package';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        if ($this->input->post('submit')) {
            $data['keywait'] = $this->input->post('waitsearch');
            $this->session->set_userdata('keywait', $data['keywait']);
        } else {
            $data['keywait'] = $this->session->userdata('keywait');
        }
        $config['base_url'] = base_url('package/index');
        $this->db->like('ca_no', $data['keywait']);
        $this->db->from('tb_order');
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 10;

        $this->pagination->initialize($config);
        $data['start'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['orders'] = $this->package->getWaitList($config['per_page'], $data['start'], $data['keywait']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('package/waiting', $data);
        $this->load->view('templates/footer');
    }
    public function readyToMove()
    {
        $data['title'] = 'Ready To Move';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['orders'] = $this->package->getReadyToMove();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('package/ready-to-move', $data);
        $this->load->view('templates/footer');
    }

    public function readyExport()
    {
        $data['title'] = 'Ready To Move ';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['order'] = $this->package->getReadyToMove();
        //$this->db->get('tb_order')->result_array();
        $this->load->view('package/export', $data);
    }

    public function undetected()
    {
        $data['title'] = 'Undetected';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['lists'] = $this->package->getUndetected();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('package/undetected', $data);
        $this->load->view('templates/footer');
    }

    public function moveDeliver()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        if ($this->input->post('ca')) {
            $this->db->where('ca_no', $this->input->post('ca'));
            $this->db->update('tb_consol', [
                'status' => 1,
                'update_time' => time()
            ]);

            $this->load->model('Consol_model', 'consol');
            $consol = $this->consol->getAllDetailOrderByExt($this->input->post('ca'));
            var_dump($consol);
            $log = [
                'ext_no' => $consol['ca_no'],
                'action' => 'Move To Delivery',
                'palet' => $consol['palet_no'],
                'koli' => $consol['koli'],
                'remarks' => '',
                'time' => time(),
                'user' => $this->session->userdata('username')
            ];
            $this->Log_model->insertLog($log);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">' . $this->input->post('ca') . ' telah di move ke delivery zone</div>');
        } else {
            redirect('auth/blocked');
        }
    }

    public function moved()
    {
        $data['title'] = 'Moved Package';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('package/moved', $data);
        $this->load->view('templates/footer');
    }

    public function moveReverse()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        if (!$this->input->post('ca_no')) redirect('auth/blocked');

        $this->db->where('ca_no', $this->input->post('ca_no'));
        $this->db->update('tb_consol', [
            'status' => 0,
            'update_time' => ''
        ]);

        $this->load->model('Consol_model', 'consol');
        $consol = $this->consol->getAllDetailOrderByExt($this->input->post('ca_no'));
        var_dump($consol);
        $log = [
            'ext_no' => $consol['ca_no'],
            'action' => 'Move To Palet Consol',
            'palet' => $consol['palet_no'],
            'koli' => $consol['koli'],
            'remarks' => '',
            'time' => time(),
            'user' => $this->session->userdata('username')
        ];
        $this->Log_model->insertLog($log);
        $this->session->set_flashdata('messages', '<div class="alert alert-success">' . $this->input->post('ca_no') . ' telah di move ke palet consol</div>');
    }

    public function history()
    {
        $this->load->library('pagination');
        $data['title'] = 'History';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }

        $config['base_url'] = base_url('package/history');
        $this->db->like('order_no', $data['keyword']);
        $this->db->or_like('external_order', $data['keyword']);
        $this->db->from('tb_history');
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 10;

        $this->pagination->initialize($config);
        $data['start'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['histories'] = $this->package->getHistoriesList($config['per_page'], $data['start'], $data['keyword']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('package/history', $data);
        $this->load->view('templates/footer');
    }
    public function backup()
    {
        $this->package->backup();
        redirect('dashboard');
    }
    public function check()
    {
        if (count($this->package->getUndetected()) > 0) {
            $data['undetected'] = true;
        }
        if (count($this->package->getReadyToMove()) > 0) {
            $data['ready'] = true;
        }
        echo json_encode($data);
    }
}
