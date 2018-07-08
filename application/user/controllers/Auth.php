<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('user_agent');
    }

    public function index()
    {
        redirect('auth/login');

    }

    public function forgot()
    {
        // validation
        $validation = array(

            array(
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'required|valid_email',
            )
        );

        $this->form_validation->set_rules($validation);
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('Forgot', $this->data);
        } else {
            $this->forgot_post();
        }

    }

    private function forgot_post()
    {
        $this->data->email = $this->input->post('email');

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://srv41.niagahoster.com',
            'smtp_port' => 465,
            'smtp_user' => 'dont-reply@kuzeoriginal.com',
            'smtp_pass' => 'p1nacate88',
            'smtp_timeout' => '4',
            'mailtype' => 'html',
            'newline' => "\r\n",
            'charset' => 'utf-8',
            'validation' => TRUE
        );
        $this->email->initialize($config);
        $this->email->from('dont-reply@kuzeoriginal.com', $this->data->brandname);
        $this->email->to($this->data->email);
        $this->email->subject('Anda lupa password?, kami akan kembalikan akun anda.');

        $body = $this->load->view('email/forgot', $this->data);

        $this->email->message($body);

        $this->email->send();

    }

    public function register()
    {
        // validation
        $validation = array(
            array(
                'field' => 'nama',
                'label' => 'Nama Lengkap',
                'rules' => 'required'
            ),

            array(
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'required|valid_email|is_unique[pengguna.pengguna_email]'
            ),
            array(
                'field' => 'notelp',
                'label' => 'No. Telp',
                'rules' => 'required|integer|is_unique[pengguna.pengguna_telp]'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[8]|max_length[15]'
            ),

        );

        $this->form_validation->set_rules($validation);

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('Register', $this->data);
        } else {
            $this->register_post();
        }

    }

    private function register_post()
    {
        $this->data->nama = $this->input->post('nama');
        $this->data->email = $this->input->post('email');
        $this->data->telp = $this->input->post('notelp');
        $this->data->pass = $this->input->post('password');
        $this->data->guid = $this->pengguna->guid();
        $this->data->token = $this->pengguna->guid();


        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://srv41.niagahoster.com',
            'smtp_port' => 465,
            'smtp_user' => 'dont-reply@kuzeoriginal.com',
            'smtp_pass' => 'p1nacate88',
            'smtp_timeout' => '4',
            'mailtype' => 'html',
            'newline' => "\r\n",
            'charset' => 'utf-8',
            'validation' => TRUE
        );
        $this->email->initialize($config);
        $this->email->from('dont-reply@kuzeoriginal.com', $this->data->brandname);
        $this->email->to($this->data->email);
        $this->email->subject('Aktivasi Akun Pengguna ' . $this->data->brandname);

        $body = $this->load->view('email/new', $this->data, TRUE);

        $this->email->message($body);


        if ($this->email->send()) {
            $this->pengguna->insert(array(
                'pengguna_kode' => $this->data->guid,
                'pengguna_username' => $this->data->email,
                'pengguna_nama' => $this->data->nama,
                'pengguna_email' => $this->data->email,
                'pengguna_password' => $this->data->pass,
                'pengguna_tipe' => 2,
                'pengguna_telp' => $this->data->telp,
                'pengguna_token' => $this->data->token
            ));

            $this->data->berhasil = 'Silahkan cek email untuk aktivasi akun anda.';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);
        } else {
            $this->data->gagal = 'E-mail anda tidak valid, silahkan ulangi pendaftaran.';
            $this->session->set_flashdata('berhasil', $this->data->gagal);
        }


        redirect('register');

    }

    public function login()
    {
        // buat validation
        $validation = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required',
                'errors' => array(
                    'required' => '%s tidak boleh kosong'
                )
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
                'errors' => array(
                    'required' => '%s tidak boleh kosong'
                )
            )
        );

        // set validation
        $this->form_validation->set_rules($validation);

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('Login', $this->data);
        } else {
            // get post
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // get database
            $user = $this->pengguna->where(array(
                'pengguna_email' => $email,
                'pengguna_password' => $password
            ))->get();

            if (isset($user->pengguna_isaktif) && $user->pengguna_isaktif) {
                // Update IP Address
                $this->pengguna->where(array(
                    'pengguna_email' => $email,
                ))->update(array(
                    'pengguna_ipaddr' => $_SERVER['REMOTE_ADDR'],
                    'pengguna_login_terakhir' => date('Y-m-d H:i:s')
                ));

                $sessiondata = array(
                    'id' => $user->pengguna_kode,
                    'nama' => $user->pengguna_nama,
                    'email' => $user->pengguna_email,
                    'tipe' => $user->pengguna_tipe,
                    'isonline' => true
                );
                $this->session->set_userdata($sessiondata);


                redirect('/');
            } elseif (isset($user->pengguna_isaktif) && !$user->pengguna_isaktif) {
                $this->data->log = 'Silahkan cek email untuk aktivasi akun anda..';
                $this->load->view('Login', $this->data);
            } else {
                $this->data->log = 'Username atau Password salah.';
                $this->load->view('Login', $this->data);
            }
        }

    }

    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('tipe');
        $this->session->unset_userdata('isonline');
        redirect('/');
    }

    public function aktivasi_akun($id, $token)
    {
        $pengguna = $this->pengguna->where(array(
            'pengguna_kode' => $id,
            'pengguna_token' => $token
        ))->get();

        if ($pengguna) {
            if ($pengguna->pengguna_isaktif == 0) {
                $this->pengguna->where('pengguna_kode', $id)->update(array(
                    'pengguna_isaktif' => 1,
                    'pengguna_token' => $this->pengguna->guid
                ));
                $this->data->berhasil = 'Akun anda sudah aktif, Silahkan login untuk melakukan transaksi.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);
            } else {
                $this->data->gagal = 'Akun ini sudah aktif.';
                $this->session->set_flashdata('gagal', $this->data->gagal);
            }
        } else {
            $this->data->gagal = 'Akun tidak ada atau token sudah kadaluarsa.';
            $this->session->set_flashdata('gagal', $this->data->gagal);
        }

        redirect('login');
    }

    public function recovery_akun()
    {

    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */