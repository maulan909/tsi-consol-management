<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Additional_model extends CI_Model
{
    public function getDataSettings()
    {
        return $this->db->get('settings')->row_array();
    }

    public function updateDataSettings()
    {
        $input = $this->input->post();
        $total_palet = $input['total_palet'];
        $max_koli = $input['max_koli'];
        $jadwal_backup = $input['jadwal_backup'];

        return $this->db->update('settings', [
            'total_palet' => $total_palet,
            'max_koli' => $max_koli,
            'jadwal_backup' => $jadwal_backup
        ]);
    }
}
