<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Package_model extends CI_Model
{
    public function getReadyToMove()
    {
        $consol = $this->db->query('SELECT DISTINCT ca_no FROM tb_consol WHERE status = 0')->result_array();
        $conss = [];
        foreach ($consol as $cons) {
            $order = $this->db->get_where('tb_order', ['ca_no' => $cons['ca_no']])->result_array();
            if (in_array($cons['ca_no'], array_column($order, 'ca_no'))) {
                array_push($conss, $cons['ca_no']);
            }
        }
        return $conss;
    }
    public function getUndetected()
    {
        $consol = $this->db->query('SELECT DISTINCT ca_no FROM tb_consol WHERE status = 0')->result_array();
        $conss = [];
        foreach ($consol as $cons) {
            $order = $this->db->get_where('tb_order', ['ca_no' => $cons['ca_no']])->result_array();
            if (!in_array($cons['ca_no'], array_column($order, 'ca_no'))) {
                array_push($conss, $cons['ca_no']);
            }
        }
        return $conss;
    }

    public function getAllMoved()
    {
        $query = $this->db->query('SELECT DISTINCT ca_no FROM tb_consol WHERE status = 1')->result_array();
        $moved = [];
        $i = 0;
        foreach ($query as $q) {
            array_push($moved, $q['ca_no']);
            // $moved[$i] = $this->db->get_where('tb_consol', ['ca_no' => $q['ca_no']])->row_array();
            // $i++;
        }
        return $moved;
    }
    public function getTotalPicklist($ca_no, $status = null)
    {
        $order = $this->db->get_where('tb_order', ['ca_no' => $ca_no])->row_array();
        $data = [];
        if ($order) {
            $picklist = $this->db->get_where('tb_picklist', ['ca_id' => $order['id']])->num_rows();
            if ($status === null) {
                $consol = $this->db->get_where('tb_consol', ['ca_no' => $ca_no])->num_rows();
            } else {
                $consol = $this->db->get_where('tb_consol', [
                    'ca_no' => $ca_no,
                    'status' => $status
                ])->num_rows();
            }
            $data = [
                'total' => $picklist,
                'consol' => $consol,
                'kekurangan' => ($picklist - $consol)
            ];
        } else {
            $data = [
                'total' => 'n/a',
                'consol' => 'n/a',
                'kekurangan' => 'n/a'
            ];
        }

        return $data;
    }
    public function getLocation($ca_no)
    {
        $query = $this->db->get_where('tb_consol', ['ca_no' => $ca_no])->row_array();
        if ($query) {
            return $query['palet_no'];
        } else {
            return '';
        }
    }
    public function getTotalKoli($ca_no)
    {
        $frozen = 0;
        $dry = 0;
        foreach ($this->db->get_where('tb_consol', ['ca_no' => $ca_no])->result_array() as $koli) {
            if ($koli['remarks'] == 1) {
                $frozen += $koli['koli'];
            } else {
                $dry += $koli['koli'];
            }
        }
        return $data = [
            'dry' => $dry,
            'frozen' => $frozen
        ];
    }

    public function getHistoriesList($limit, $start, $keyword = null)
    {
        $this->db->order_by('id', 'DESC');
        if ($keyword != null) {
            $this->db->like('order_no', $keyword);
            $this->db->or_like('external_order', $keyword);
        }
        return $this->db->get('tb_history', $limit, $start)->result_array();
    }
    public function getAllMovedBak()
    {
        $query = $this->db->query('SELECT DISTINCT ca_no FROM tb_consol WHERE status = 1')->result_array();
        $moved = [];
        $i = 0;
        foreach ($query as $q) {
            $moved[$i] = $this->db->get_where('tb_consol', ['ca_no' => $q['ca_no']])->row_array();
            $i++;
        }
        return $moved;
    }

    public function backup()
    {
        $settings = $this->db->get('settings')->row_array();
        $jadwal_backup = $settings['jadwal_backup'];
        
        $data = $this->package->getAllMovedBak();
        foreach ($data as $dat) {
            if (((60 * 60 * 24 * $jadwal_backup) + $dat['update_time']) < time()) {
                $order = $this->db->get_where('tb_order', ['ca_no' => $dat['ca_no']])->row_array();
                $koli = $this->package->getTotalKoli($dat['ca_no']);
                if ($order) {
                    $picklist = $this->package->getTotalPicklist($dat['ca_no']);
                    $hasil = [
                        'order_no' => $order['order_no'],
                        'external_order' => $dat['ca_no'],
                        'total_picklist' => $picklist['total'],
                        'palet_no' => $dat['palet_no'],
                        'total_koli' => $koli['dry'] + $koli['frozen'],
                        'consol_date' => strtotime($dat['tgl']),
                        'move_date' => $dat['update_time']
                    ];
                    $this->db->insert('tb_history', $hasil);
                    $this->db->delete('tb_picklist', ['ca_id' => $order['id']]);
                    $this->db->delete('tb_order', ['ca_no' => $dat['ca_no']]);
                    $this->db->delete('tb_consol', ['ca_no' => $dat['ca_no']]);
                } else {
                    $hasil = [
                        'order_no' => '',
                        'external_order' => $dat['ca_no'],
                        'total_picklist' => '',
                        'palet_no' => $dat['palet_no'],
                        'total_koli' => $koli['dry'] + $koli['frozen'],
                        'consol_date' => strtotime($dat['tgl']),
                        'move_date' => $dat['update_time']
                    ];
                    $this->db->insert('tb_history', $hasil);
                    $this->db->delete('tb_consol', ['ca_no' => $dat['ca_no']]);
                }
            }
        }
    }
}
