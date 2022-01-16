<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_guru($where = null)
    {
        $this->db->select('guru.*, u.username, u.email, u.password, u.role_id, ur.role');
        $this->db->join('user u', 'u.username = guru.nip', 'left');
        $this->db->join('user_role ur', 'ur.id = u.role_id', 'left');
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->get('guru');
    }
}
