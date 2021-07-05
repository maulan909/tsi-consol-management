<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Consol_model extends CI_Model
{
    private $_table = 'tb_consol';
    public $id,
        $ca_no,
        $palet_no,
        $remarks,
        $koli,
        $status = 0;

    public function rules()
    {
        return [
            [
                'field' => 'ca_no',
                'label' => 'External Order No',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'palet_no',
                'label' => 'Lokasi Palet',
                'rules' => 'required|trim|is_natural_no_zero'
            ],
            [
                'field' => 'koli',
                'label' => 'Jumlah Koli',
                'rules' => 'required|trim|is_natural'
            ]

        ];
    }

    public function getAllConsol($status = null)
    {
        if ($status !== null) {
            $this->db->where('status', $status);
        }
        return $this->db->get($this->_table)->result_array();
    }

    public function getConsolById($id)
    {
        return $this->db->get_where($this->_table, ['id_pack_consol' => $id])->row_array();
    }

    public function getAllDetailOrderByExt($ext_no)
    {
        $data = [];
        $history = $this->db->get_where('tb_history', ['external_order' => $ext_no])->row_array();
        if ($history) {
            $data['status'] = 'done';
        } else {
            // $this->db->where('ca_no', $ext_no);
            $consol = $this->db->query("SELECT palet_no, status, (SELECT SUM(koli) FROM tb_consol WHERE ca_no = '$ext_no') as koli FROM tb_consol WHERE ca_no =  '$ext_no'")->row_array();
            $picklist = $this->package->getTotalPicklist($ext_no);
            if ($consol) {
                if ($consol['status'] == 1) {
                    $data['status'] = 'moved';
                } else {
                    if ($picklist['consol'] == $picklist['total']) {
                        $data['status'] = 'full';
                    } else {
                        $data['status'] = 'part';
                    }
                }
                $data['palet_no'] = $consol['palet_no'];
                $data['koli'] = $consol['koli'];
                $data['ca_no'] = $ext_no;
                $data['consol'] = $picklist['consol'];
                $data['picklist'] = $picklist['total'];
                $data['kota'] = $picklist['kota'];
                $data['zona'] = $picklist['zona'];
            } else if ($picklist['consol'] == 0 && $picklist['total'] > 0) {
                $data['status'] = 'first';
                $data['palet_no'] = null;
                $data['koli'] = 0;
                $data['ca_no'] = $ext_no;
                $data['consol'] = $picklist['consol'];
                $data['picklist'] = $picklist['total'];
                $data['kota'] = $picklist['kota'];
                $data['zona'] = $picklist['zona'];
            }
        }

        return $data;
    }

    public function insert()
    {
        $input = $this->input->post();
        $this->ca_no = strtoupper($input['ca_no']);
        $this->palet_no = $input['palet_no'];
        $this->remarks = (isset($input['remarks'])) ? $input['remarks'] : 0;
        $this->koli = $input['koli'];
        $data = [
            'id_pack_consol' => $this->id,
            'ca_no' => $this->ca_no,
            'palet_no' => $this->palet_no,
            'remarks' => $this->remarks,
            'koli' => $this->koli
        ];
        $log = [
            'ext_no' => $this->ca_no,
            'action' => 'Add',
            'palet' => $this->palet_no,
            'koli' => $this->koli,
            'remarks' => $this->remarks,
            'time' => time(),
            'user' => $this->session->userdata('username')
        ];
        $this->Log_model->insertLog($log);
        return $this->db->insert($this->_table, $data);
    }

    public function update()
    {
        $input = $this->input->post();
        $this->id = $input['id'];
        $this->ca_no = $input['ca_no'];
        $this->palet_no = $input['palet_no'];
        $this->remarks = (isset($input['remarks'])) ? $input['remarks'] : 0;
        $this->koli = $input['koli'];

        $data = [
            'ca_no' => $this->ca_no,
            'palet_no' => $this->palet_no,
            'remarks' => $this->remarks,
            'koli' => $this->koli
        ];
        $log = [
            'ext_no' => $this->ca_no,
            'action' => 'Edit',
            'palet' => $this->palet_no,
            'koli' => $this->koli,
            'remarks' => $this->remarks,
            'time' => time(),
            'user' => $this->session->userdata('username')
        ];
        $this->Log_model->insertLog($log);
        $this->db->where('id_pack_consol', $this->id);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ['id_pack_consol' => $id]);
    }

    public function getLocation($location)
    {
        $settings = $this->db->get('settings')->row_array();
        $availablePalet = $settings['total_palet'];
        $max_koli = $settings['max_koli'];
        $suggest = [];

        if ($location <= $availablePalet && $location > 0) {
            $consol = $this->db->query("SELECT SUM(koli) as koli FROM tb_consol WHERE palet_no = {$location} AND status = 0")->row_array();
            if ($consol['koli'] > $max_koli) {
                $data['status'] = 'overload';

                for ($i = 1; $i <= $availablePalet; $i++) {
                    $all_loc = $this->db->query("SELECT SUM(koli) as koli FROM tb_consol WHERE palet_no = '$i' AND status = 0")->row_array();
                    if ($all_loc === null) {
                        $all_loc['koli'] = 0;
                    }
                    array_push($suggest, $all_loc['koli']);
                }
                $data['suggest'] = array_search(min($suggest), $suggest) + 1;
            }
        } else {
            $data['status'] = 'reject';
        }
        return $data;
    }
}
