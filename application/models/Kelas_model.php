<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas_model extends CI_Model
{
    public function findWhere($where = null)
    {
        return $this->db->get_where('kelas', $where);
    }
}
