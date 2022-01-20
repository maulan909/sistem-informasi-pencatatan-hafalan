<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model', 'user');
    }
    public function guru()
    {
        $data['title'] = 'Data Guru';
        $data['data'] = $this->user->get_guru()->result();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/list-guru', $data);
        $this->load->view('templates/footer');
    }
    public function add_guru()
    {
        $this->form_validation->set_rules([
            [
                'field' => 'nip',
                'label' => 'NIP',
                'rules' => 'trim|required|is_unique[user.username]|is_natural'
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
            $input = $this->input->post();
            $user = [
                'username' => $input['nip'],
                'email' => $input['email'],
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1
            ];
            $guru = [
                'nip' => $input['nip'],
                'name' => $input['name'],
                'alamat' => $input['alamat'],
                'telepon' => 62 . $input['telepon']
            ];
            if ($this->user->insert_user($user) && $this->user->insert_guru($guru)) {
                $this->session->set_flashdata('messages', '<div class="alert alert-success">Guru berhasil ditambahkan.</div>');
            } else {
                $this->session->set_flashdata('messages', '<div class="alert alert-danger">Guru gagal ditambahkan.</div>');
            }
            return redirect('master/guru');
        }
        $data['title'] = 'Tambah Guru';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/add-guru', $data);
        $this->load->view('templates/footer');
    }
    public function edit_guru($id = null)
    {
        if ($id == null) {
            return redirect('master/guru');
        }
        $data['guru'] = $this->user->get_guru(['guru.id' => $id])->row();
        if ($data['guru'] == null) {
            return redirect('master/guru');
        }
        $rules = [
            [
                'field' => 'name',
                'label' => 'Nama',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'telepon',
                'label' => 'Telepon',
                'rules' => 'trim|is_natural|required'
            ]
        ];
        if ($this->input->post('password') != '') {
            array_push($rules, [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[8]|max_length[20]',
                'errors' => [
                    'min_length' => '{field} minimun 8 charaters and maximum 20 characters',
                    'max_length' => '{field} minimun 8 charaters and maximum 20 characters',
                ]
            ]);
        }
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()) {
            $input = $this->input->post();
            if ($input['password'] != '') {
                $user['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
                $this->user->update_user(['username' => $data['guru']->nip], $user);
            }
            $guru = [
                'name' => $input['name'],
                'alamat' => $input['alamat'],
                'telepon' => 62 . $input['telepon']
            ];
            if ($this->user->update_guru(['id' => $data['guru']->id], $guru)) {
                $this->session->set_flashdata('messages', '<div class="alert alert-success">Guru berhasil diedit.</div>');
            } else {
                $this->session->set_flashdata('messages', '<div class="alert alert-danger">Guru gagal diedit.</div>');
            }
            return redirect('master/guru');
        }
        $data['title'] = 'Edit Guru';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/edit-guru', $data);
        $this->load->view('templates/footer');
    }
    public function delete_guru($id)
    {
        if ($id == null) {
            return redirect('master/guru');
        }
        $guru = $this->user->get_guru(['guru.id' => $id])->row();
        if ($guru == null) {
            return redirect('master/guru');
        }
        if ($this->user->delete_guru($guru)) {
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Guru berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('messages', '<div class="alert alert-danger">Guru gagal dihapus.</div>');
        }
        return redirect('master/guru');
    }
    public function import_guru()
    {
        $result = $this->user->import_guru($_FILES['importFile']);
        $this->session->set_flashdata('messages', '<div class="alert alert-' . $result['type'] . '">' . $result['message'] . '.</div>');
        return redirect($result['redirect']);
    }

    public function getguru()
    {
        if ($this->input->post('type')) {
            $type = $this->input->post('type');
            $key = $this->input->post('key');
            $query = $this->user->get_guru([$type => $key]);
            if ($query->num_rows() > 0) {
                echo json_encode($query->row_array());
            } else {
                echo json_encode(null);
            }
        } else {
            redirect('auth/blocked');
        }
    }

    public function siswa()
    {
        $data['title'] = 'Data Siswa';
        $data['data'] = $this->user->get_siswa()->result();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/list-siswa', $data);
        $this->load->view('templates/footer');
    }
    public function add_siswa()
    {
        $this->form_validation->set_rules([
            [
                'field' => 'nis',
                'label' => 'NIS',
                'rules' => 'trim|required|is_unique[user.username]|is_natural'
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
            $input = $this->input->post();
            $user = [
                'username' => $input['nis'],
                'email' => $input['email'],
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'role_id' => 3,
                'is_active' => 1
            ];
            $siswa = [
                'nis' => $input['nis'],
                'name' => $input['name'],
                'kelas_id' => $input['kelas_id'],
                'alamat' => $input['alamat'],
                'telepon' => 62 . $input['telepon']
            ];
            if ($this->user->insert_user($user) && $this->user->insert_siswa($siswa)) {
                $this->session->set_flashdata('messages', '<div class="alert alert-success">Siswa berhasil ditambahkan.</div>');
            } else {
                $this->session->set_flashdata('messages', '<div class="alert alert-danger">Siswa gagal ditambahkan.</div>');
            }
            return redirect('master/siswa');
        }
        $data['title'] = 'Tambah Siswa';
        $this->load->model('Kelas_model', 'kelas');
        $data['kelas'] = $this->kelas->findWhere()->result();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/add-siswa', $data);
        $this->load->view('templates/footer');
    }
    public function edit_siswa($id = null)
    {
        if ($id == null) {
            return redirect('master/siswa');
        }
        $data['siswa'] = $this->user->get_siswa(['siswa.id' => $id])->row();
        if ($data['siswa'] == null) {
            return redirect('master/siswa');
        }
        $rules = [
            [
                'field' => 'name',
                'label' => 'Nama',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'telepon',
                'label' => 'Telepon',
                'rules' => 'trim|is_natural|required'
            ]
        ];
        if ($this->input->post('password') != '') {
            array_push($rules, [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[8]|max_length[20]',
                'errors' => [
                    'min_length' => '{field} minimun 8 charaters and maximum 20 characters',
                    'max_length' => '{field} minimun 8 charaters and maximum 20 characters',
                ]
            ]);
        }
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()) {
            $input = $this->input->post();
            if ($input['password'] != '') {
                $user['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
                $this->user->update_user(['username' => $data['siswa']->nip], $user);
            }
            $siswa = [
                'name' => $input['name'],
                'alamat' => $input['alamat'],
                'telepon' => 62 . $input['telepon'],
                'kelas_id' => $input['kelas_id'],
            ];
            if ($this->user->update_siswa(['id' => $data['siswa']->id], $siswa)) {
                $this->session->set_flashdata('messages', '<div class="alert alert-success">Siswa berhasil diedit.</div>');
            } else {
                $this->session->set_flashdata('messages', '<div class="alert alert-danger">Siswa gagal diedit.</div>');
            }
            return redirect('master/siswa');
        }
        $data['title'] = 'Edit Siswa';
        $this->load->model('Kelas_model', 'kelas');
        $data['kelas'] = $this->kelas->findWhere()->result();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/edit-siswa', $data);
        $this->load->view('templates/footer');
    }
    public function delete_siswa($id)
    {
        if ($id == null) {
            return redirect('master/siswa');
        }
        $siswa = $this->user->get_siswa(['siswa.id' => $id])->row();
        if ($siswa == null) {
            return redirect('master/siswa');
        }
        if ($this->user->delete_siswa($siswa)) {
            $this->session->set_flashdata('messages', '<div class="alert alert-success">Siswa berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('messages', '<div class="alert alert-danger">Siswa gagal dihapus.</div>');
        }
        return redirect('master/siswa');
    }
    public function import_siswa()
    {
        $result = $this->user->import_siswa($_FILES['importFile']);
        $this->session->set_flashdata('messages', '<div class="alert alert-' . $result['type'] . '">' . $result['message'] . '.</div>');
        return redirect($result['redirect']);
    }
    public function getsiswa()
    {
        if ($this->input->post('type')) {
            $type = $this->input->post('type');
            $key = $this->input->post('key');
            $query = $this->user->get_siswa([$type => $key]);
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
