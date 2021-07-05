<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_model extends CI_Model
{
    public function insertLog($data)
    {
        return $this->db->insert('log', $data);
    }

    public function getDistinctLog($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('ext_no', $keyword);
        }
        $this->db->distinct();
        $this->db->select('ext_no');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('log', $limit, $start)->result_array();
    }

    public function getLogById($id)
    {
        return $this->db->get_where('log', ['id' => $id])->row_array();
    }

    public function getLogDetail($ext_no)
    {
        return $this->db->get_where('log', ['ext_no' => $ext_no]);
    }
}
