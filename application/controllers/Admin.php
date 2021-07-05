<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $upload_file = isset($_FILES['csv']['name']) ? $_FILES['csv']['name'] : '';
        if ($upload_file) {
            $allowed_types = 'csv';
            $tmp = explode('.', $_FILES['csv']['name']);
            $file_type = end($tmp);

            if ($file_type == $allowed_types) {
                //open file
                $file_data = fopen($_FILES['csv']['tmp_name'], 'r');
                fgetcsv($file_data);

                while ($row = fgetcsv($file_data)) {
                    $picklist = escapeString($row[0]);
                    $tgl = escapeString($row[1]);
                    $order_no = escapeString($row[2]);
                    $client_no = escapeString($row[3]);
                    $city = escapeString($row[5]);
                    $zone = escapeString($row[6]);
                    // if (substr($order_no,0,2) != 'JK') {
                    $this->db->where('external_order', $client_no);
                    $this->db->or_where('order_no', $order_no);
                    $history = $this->db->get_where('tb_history')->row_array();
                    if ($history) {
                    } else {
                        $ca = $this->db->get_where('tb_order', ['ca_no' => $client_no])->row_array();
                        $ca = isset($ca) ? $ca['id'] : null;
                        if (!$ca) {
                            $this->db->insert('tb_order', [
                                'order_no' => $order_no,
                                'ca_no' => $client_no,
                                'city' => $city,
                                'zone' => $zone
                            ]);
                            $insert_id = $this->db->insert_id();
                            $this->db->insert('tb_picklist', [
                                'picklist_no' => $picklist,
                                'ca_id' => $insert_id,
                                'tgl' => $tgl,
                            ]);
                        } else {
                            $cek = $this->db->get_where('tb_picklist', [
                                'picklist_no' => $picklist,
                                'ca_id' => $ca
                            ]);
                            if ($cek->num_rows() < 1) {
                                $this->db->insert('tb_picklist', [
                                    'picklist_no' => $picklist,
                                    'ca_id' => $ca,
                                    'tgl' => $tgl
                                ]);
                            }
                        }
                    }
                    // }
                }

                $this->session->set_flashdata('messages', '<div class="alert alert-success">Upload Data Berhasil</div>');
                redirect('admin');
            }
            $this->session->set_flashdata('messages', '<div class="alert alert-danger">Upload Gagal!, format file bukan .csv</div>');
            redirect('admin');
        } else {
            $data['title'] = 'Admin File Upload';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('admin/index', $data);
            $this->load->view('templates/footer');
        }
    }
}
