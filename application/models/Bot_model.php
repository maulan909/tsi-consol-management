<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bot_model extends CI_Model
{
    private $_table = 'bot_user';
    public $chat_id;

    public function insertChatId($id)
    {
        $count = $this->db->get_where($this->_table, ['chat_id' => $id])->num_rows();
        if ($count === 0) {
            $this->db->insert($this->_table, ['chat_id' => $id]);
        }
    }

    public function getAllChatId()
    {
        return $this->db->get($this->_table)->result_array();
    }
}
