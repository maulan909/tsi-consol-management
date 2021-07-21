<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Consol extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Consol_model', 'consol');
        $this->load->model('Log_model');
    }
    public function index()
    {
        $data['title'] = 'Team Consol Input';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $consol = $this->consol;
        $data['consol'] = $consol->getAllConsol(0);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('consol/index', $data);
        $this->load->view('templates/footer');
    }

    public function add()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->form_validation->set_rules($this->consol->rules());
        if ($this->form_validation->run()) {
            $this->consol->insert();
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Input data berhasil</div>');
            $this->load->model('Package_model', 'package');
            $picklist = $this->package->getTotalPicklist($this->input->post('ca_no'));
            $send = completeCheck($this->input->post('picklist_ke'), $this->input->post('total_picklist'));
            if ($send) {
                senderBot($this->input->post('ca_no'));
            }
            if ($picklist) {
                if ($picklist['total'] == 1) {
                    $data['title'] = 'Dashboard';
                    $data['id'] = $this->input->post('ca_no');
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('dashboard/index', $data);
                    $this->load->view('templates/footer');
                    $this->load->view('consol/alert', $data);
                } else {
                    redirect('consol/add');
                }
            } else {
                redirect('consol/add');
            }
        } else {
            $data['title'] = 'Tambah Paket Consol';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('consol/add', $data);
            $this->load->view('templates/footer');
        }
    }
    public function edit($id = null)
    {
        if (!$id) redirect('auth/blocked');
        $data['detail'] = $this->consol->getConsolById($id);
        if (!$data['detail']) redirect('auth/blocked');
        $this->form_validation->set_rules($this->consol->rules());
        if ($this->form_validation->run()) {
            $this->consol->update($id);
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Data Berhasil di edit.</div>');
            redirect('consol');
        } else {
            $data['title'] = 'Edit Paket Consol';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('consol/edit', $data);
            $this->load->view('templates/footer');
        }
    }
    public function delete($id = null)
    {
        if (!$id) {
            redirect('auth/blocked');
        }
        $consol = $this->consol->getConsolById($id);
        $log = [
            'ext_no' => $consol['ca_no'],
            'action' => 'Delete',
            'palet' => $consol['palet_no'],
            'koli' => $consol['koli'],
            'remarks' => $consol['remarks'],
            'time' => time(),
            'user' => $this->session->userdata('username')
        ];
        $this->Log_model->insertLog($log);
        $this->consol->delete($id);
        $this->session->set_flashdata('messages', '<div class="alert alert-success">Hapus data berhasil</div>');
        redirect('consol');
    }
    public function get()
    {
        $input = $this->input->post();
        if (isset($input['ca_no']) && $input['ca_no'] != '') {
            $this->load->model('Package_model', 'package');

            echo json_encode($this->consol->getAllDetailOrderByExt($input['ca_no']));
        } else if (isset($input['location']) && $input['location'] != '') {
            echo json_encode($this->consol->getLocation($input['location']));
        } else {
            redirect('auth/blocked');
        }
    }
}
