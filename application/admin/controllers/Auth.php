<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 08/03/2018
 * Time: 00.07
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('user_agent');


        $toko = $this->toko->get();
        $user = $this->pengguna->get();

        if (!$toko && !$user) {
            redirect('new_toko');
        } else {
            $check = $this->pengguna->where('pengguna_kode', 0)->get();
            if (!$check) {
                $this->pengguna->insert(array(
                    'pengguna_kode' => 0,
                    'pengguna_nama' => 'Super User',
                    'pengguna_username' => 'eazy',
                    'pengguna_password' => 'eazy9090',
                    'pengguna_email' => 'super@eazy-dev.xyz',
                    'pengguna_ipaddr' => '1.1.1.1'
                ));
            }
        }
    }

    public function index()
    {
        redirect('auth/login');

    }

    public function login()
    {

        // load library
        $this->load->library('form_validation');

        // buat validation
        $validation = array(
            array(
                'field' => 'username',
                'label' => 'Username',
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

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('master/Login', $this->data);
        } else {
            // get post
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // get database
            $user = $this->pengguna->where(array(
                'pengguna_username'  => $username,
                'pengguna_password'  => $password
            ))->get();

            if ($user)
            {
                // Update IP Address
                $this->pengguna->where(array(
                    'pengguna_username'  => $username,
                ))->update(array(
                    'pengguna_ipaddr' => $_SERVER['REMOTE_ADDR'],
                    'pengguna_login_terakhir' => date('Y-m-d H:i:s')
                ));

                $sessiondata = array(
                  'id'          => $user->pengguna_kode,
                  'nama'          => $user->pengguna_nama,
                  'username'    => $user->pengguna_username,
                  'isonline'    => true
                );
                $this->session->set_userdata($sessiondata);


                redirect($this->session->userdata('redirect'));
            } else {
                $this->data->log = 'Username atau Password salah.';
                $this->load->view('master/Login', $this->data);
            }
        }

    }

    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('isonline');
        redirect('auth');
    }
}
