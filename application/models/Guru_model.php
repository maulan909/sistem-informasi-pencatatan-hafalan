<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $_table = 'guru';
    public function get_guru()
    {
        $this->db->select('guru.*, u.username, u.email, u.password, u.role_id');
        $this->db->join('user u', 'u.username = guru.nip');
        return $this->db->get($this->_table);
    }
}
