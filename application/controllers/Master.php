<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function guru()
    {
        $this->load->model('User_model', 'user');
        $this->form_validation->set_rules([
            [
                'field' => 'nip',
                'label' => 'NIP',
                'rules' => 'trim|required|is_unique[guru.nip]|is_natural'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|is_unique[user.email]|valid_email'
            ],
            [
                'field' => 'name',
                'label' => 'Nama',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'telepon',
                'label' => 'Telepon',
                'rules' => 'trim|is_natural|required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[8]|max_length[20]',
                'errors' => [
                    'min_length' => '{field} minimun 8 charaters and maximum 20 characters',
                    'max_length' => '{field} minimun 8 charaters and maximum 20 characters',
                ]
            ]
        ]);
        if ($this->form_validation->run()) {
        }
        $data['title'] = 'Data Guru';
        $data['data'] = $this->user->get_guru()->result();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/list-guru', $data);
        $this->load->view('templates/footer');
    }
    public function check()
    {
        if ($this->input->post('type')) {
            $type = $this->input->post('type');
            $key = $this->input->post('key');
            $this->db->select('id, username, email, role_id, is_active');
            $query = $this->db->get_where('user', [$type => $key]);
            if ($query->num_rows() > 0) {
                echo json_encode($query->row_array());
            } else {
                echo json_encode(null);
            }
        } else {
            redirect('auth/blocked');
        }
    }
}
