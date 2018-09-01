<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Event extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isonline) {
            redirect('login');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->session->set_userdata('redirect', current_url());
            }
        }

        $config = array(
            'field' => 'event_judul',
            'title' => 'title',
            'table' => 'event',
            'id' => 'event_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = $this->data->brandname . ' | Event';
        $this->data->title_page = 'Event';
        $this->data->total_event = $this->event->count_rows();
        $this->data->events = $this->event->get_all();
        $this->load->view('Event', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Event > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->event->guid();
        $this->data->events = $this->event->get_all();
        $this->load->view('CRUD_Event', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Event > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->event = $this->event->where('event_kode', $id)->get();
        $this->data->events = $this->event->get_all();
        $this->load->view('CRUD_Event', $this->data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('judul', 'Judul', 'is_unique[event.event_judul]', array('is_unique' => 'Terdapat nama yang sama. Silahkan coba lagi.'));

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $event = $this->event->where_event_kode($id)->get();
        $event_judul = $this->input->post('judul');

        $event_array = array(
            'event_kode' => $id,
            'event_judul' => $event_judul,
            'event_content' => $this->input->post('content'),
            'event_url' => $this->slug->create_uri(array('title' => $this->input->post('judul'))),
            'event_isaktif' => $this->input->post('aktif')
        );

        if ($event) {
            // cek validasi
            if ($this->form_validation->run() === FALSE && $event->event_judul != $event_judul) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('event');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $event_judul)) {
                $this->data->gagal = 'Karakter untuk judul tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('event');
            }

            // update
            $event_update = $this->event->update($event_array, 'event_kode');

            if ($event_update) {
                $this->data->berhasil = 'Event berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('event');
            } else {
                $this->data->gagal = 'Event gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('event');
            }
        } else {
            // cek validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('event');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $event_judul)) {
                $this->data->gagal = 'Karakter untuk judul tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('event');
            }

            // insert
            $event_insert = $this->event->insert($event_array);

            if ($event_insert) {
                $this->data->berhasil = 'Event berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('event');
            } else {
                $this->data->gagal = 'Event gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('event');
            }
        }
    }

    public function hapus($id)
    {

        $event = $this->event->where('event_kode', $id)->delete();
        if ($event) {
            $this->data->berhasil = 'Event berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('event');
        } else {
            $this->data->gagal = 'Event gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('event');
        }
    }
}