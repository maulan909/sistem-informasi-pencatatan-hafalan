<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function insert_user($data)
    {
        return $this->db->insert('user', $data);
    }

    public function update_user($where, $data)
    {
        return $this->db->update('user', $data, $where);
    }

    public function get_guru($where = null)
    {
        $this->db->select('guru.*, u.username, u.email, u.password, u.role_id, ur.role');
        $this->db->join('user u', 'u.username = guru.nip', 'left');
        $this->db->join('user_role ur', 'ur.id = u.role_id', 'left');
        $where['role_id'] = 2;
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->get('guru');
    }

    public function insert_guru($data)
    {
        return $this->db->insert('guru', $data);
    }
    public function update_guru($where, $data)
    {
        return $this->db->update('guru', $data, $where);
    }

    public function delete_guru($data)
    {
        $this->db->delete('user', ['username' => $data->nip]);
        return $this->db->delete('guru', ['id' => $data->id]);
    }

    public function import_guru($file)
    {
        if ($file) {
            $name = explode('.', $file['name']);
            if (end($name) !== 'xls') {
                return [
                    'redirect' => 'master/guru',
                    'type' => 'danger',
                    'message' => 'Hanya menerima file .xls'
                ];
            }
            $tempFile = $file['tmp_name'];
            chmod($tempFile, 0777);
            include_once APPPATH . 'libraries\ExcelReader\Spreadsheet_Excel_Reader.php';
            $data = new Spreadsheet_Excel_Reader($tempFile, false);
            $activeRow = $data->rowcount(0);
            $a = 0;
            for ($i = 3; $i <= $activeRow; $i++) {
                $bucket = [
                    'nip' => $data->val($i, 1),
                    'name' => $data->val($i, 3),
                    'alamat' => $data->val($i, 4),
                    'telepon' => $data->val($i, 5),
                ];
                $user = [
                    'username' => $data->val($i, 1),
                    'email' => $data->val($i, 2),
                    'password' => password_hash($data->val($i, 1), PASSWORD_DEFAULT),
                    'role_id' => 2,
                    'is_active' => 1,
                ];
                if ($i === 3) {
                    if ($data->val($i, 1) == 'NIP' && $data->val($i, 3) == 'Nama' && $data->val($i, 4) == 'Alamat' && $data->val($i, 5) == 'Telepon') {
                        continue;
                    } else {
                        return [
                            'redirect' => 'master/guru',
                            'type' => 'danger',
                            'message' => 'Template File tidak sesuai'
                        ];
                        break;
                    }
                }
                if ($i > 3) {
                    if ($data->val($i, 1) == '' && $data->val($i, 3) == '' && $data->val($i, 4) == '' && $data->val($i, 5) == '') {
                        echo 'mati';
                        die;
                        return [
                            'redirect' => 'master/guru',
                            'type' => 'success',
                            'message' => 'Berhasil Impor Data Guru'
                        ];
                        break;
                    } else {
                        if (!$this->get_guru(['guru.nip' => $bucket['nip']])->row()) {
                            $this->insert_guru($bucket);
                            $this->insert_user($user);
                            $a++;
                        }
                    }
                }
            }
            return [
                'redirect' => 'master/guru',
                'type' => 'success',
                'message' => 'Berhasil Impor Data Guru'
            ];
        }
    }
    public function get_siswa($where = null)
    {
        $this->db->select('siswa.*, u.username, u.email, u.password, u.role_id, ur.role, k.name as kelas');
        $this->db->join('user u', 'u.username = siswa.nis', 'left');
        $this->db->join('user_role ur', 'ur.id = u.role_id', 'left');
        $this->db->join('kelas k', 'k.id = siswa.kelas_id', 'left');
        $where['role_id'] = 3;
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->get('siswa');
    }

    public function insert_siswa($data)
    {
        return $this->db->insert('siswa', $data);
    }
    public function update_siswa($where, $data)
    {
        return $this->db->update('siswa', $data, $where);
    }

    public function delete_siswa($data)
    {
        $this->db->delete('user', ['username' => $data->nis]);
        return $this->db->delete('siswa', ['id' => $data->id]);
    }
    public function import_siswa($file)
    {
        if ($file) {
            $name = explode('.', $file['name']);
            if (end($name) !== 'xls') {
                return [
                    'redirect' => 'master/siswa',
                    'type' => 'danger',
                    'message' => 'Hanya menerima file .xls'
                ];
            }
            $tempFile = $file['tmp_name'];
            chmod($tempFile, 0777);
            include_once APPPATH . 'libraries\ExcelReader\Spreadsheet_Excel_Reader.php';
            $data = new Spreadsheet_Excel_Reader($tempFile, false);
            $activeRow = $data->rowcount(0);
            $a = 0;
            $this->load->model('Kelas_model', 'kelas');
            $kelas = [];
            foreach ($this->kelas->findWhere()->result() as $k) {
                $kelas[$k->name] = $k->id;
            }
            for ($i = 3; $i <= $activeRow; $i++) {
                $bucket = [
                    'nis' => $data->val($i, 1),
                    'name' => $data->val($i, 3),
                    'alamat' => $data->val($i, 4),
                    'telepon' => $data->val($i, 5),
                    'kelas_id' => $kelas[$data->val($i, 6)],
                ];
                $user = [
                    'username' => $data->val($i, 1),
                    'email' => $data->val($i, 2),
                    'password' => password_hash($data->val($i, 1), PASSWORD_DEFAULT),
                    'role_id' => 3,
                    'is_active' => 1,
                ];
                if ($i === 3) {
                    if ($data->val($i, 1) == 'NIS' && $data->val($i, 3) == 'Nama' && $data->val($i, 4) == 'Alamat' && $data->val($i, 5) == 'Telepon') {
                        continue;
                    } else {
                        return [
                            'redirect' => 'master/siswa',
                            'type' => 'danger',
                            'message' => 'Template File tidak sesuai'
                        ];
                        break;
                    }
                }
                if ($i > 3) {
                    if ($data->val($i, 1) == '' && $data->val($i, 3) == '' && $data->val($i, 4) == '' && $data->val($i, 5) == '') {
                        echo 'mati';
                        die;
                        return [
                            'redirect' => 'master/siswa',
                            'type' => 'success',
                            'message' => 'Berhasil Impor Data Siswa'
                        ];
                        break;
                    } else {
                        if (!$this->get_siswa(['siswa.nis' => $bucket['nis']])->row()) {
                            $this->insert_siswa($bucket);
                            $this->insert_user($user);
                            $a++;
                        }
                    }
                }
            }
            return [
                'redirect' => 'master/siswa',
                'type' => 'success',
                'message' => 'Berhasil Impor Data Siswa'
            ];
        }
    }
}
