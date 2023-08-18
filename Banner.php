<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banner extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Umum_model', 'umum');
    }

    public function index()
    {
        $data = [
            'view' => "view/banner/index",
            'sub' => "",
        ];
        $this->load->view($data);
    }

    private function image_handling()
    {

        $old_banner = trim($this->input->post('old_banner', true));
        $new_cover = $_FILES['cover']['name'];

        if (empty($new_cover)) {
            if (empty($old_banner)) {
                $this->output->set_status_header(417);
                echo json_encode([
                    'status' => false,
                    'message' => 'Gambar harus diisi'
                ]);

                die();
            } else {
                return $old_banner;
            }
        }

        $config['upload_path'] = './assets/media/images/foto_banner/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('cover')) {
            $this->output->set_status_header(500);
            echo json_encode([
                'status' => false,
                'message' => $this->upload->display_errors('', '')
            ]);

            die();
        }

        if (!empty($old_banner)) {
            $old_banner_path = $config['upload_path'] . $old_banner;

            if (file_exists($old_banner_path)) {
                unlink($old_banner_path);
            }
        }

        return $this->upload->data('file_name');
    }


    public function dat_list()
    {

        header('Content-Type: application/json');

        $tabel = 'dat_banner';
        $column_order = array();
        $coloumn_search = [];
        $select = "dat_banner.*";
        $order_by = array('id' => 'desc');
        $join = [];
        $group_by = [];
        $where = [];
        $list = $this->umum->get_datatables($tabel, $column_order, $coloumn_search, $order_by, $where, $join, $select, $group_by);
        $data = array();
        $no = @$_POST['start'];

        foreach ($list as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $row[] = $list->img;
            $row[] = $list->id;

            $data[] = $row;
        }

        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->umum->count_all($tabel, $column_order, $coloumn_search, $order_by, $where, $join, $select, $group_by),
            "recordsFiltered" => $this->umum->count_filtered($tabel, $column_order, $coloumn_search, $order_by, $where, $join, $select, $group_by),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function save()
    {

        if ( $this->input->post('id') == '' ) {

        }

        $data = [
            'img' => $this->image_handling(),
        ];

        if ($this->input->post('id') != '') {
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('dat_banner', $data);
            $msg = 'Data berhasil diubah';
        } else {
            $this->db->insert('dat_banner', $data);
            $msg = 'Data berhasil disimpan';
        }

        echo json_encode(['status' => TRUE, 'message' => $msg]);
    }

    public function edit()
    {
        $id = $this->input->get('id', TRUE);
        $data = $this->db->get_where('dat_banner', ['id' => $id])->row();
        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    public function destroy()
    {

        $id = trim($this->input->post('id', true));
        $data = $this->db->get_where('dat_banner', ['id' => $id])->row();
        $file_path = './assets/media/images/foto_banner/';

        if (!empty($data->img)) {
            $cover_path = $file_path . $data->img;
            if (file_exists($cover_path)) {
                unlink($cover_path);
            }
        }

        if ($this->db->delete('dat_banner', ['id' => $id])) {
            echo json_encode([
                'status' => true,
                'message' => 'Banner berhasil dihapus'
            ]);
        } else {
            $this->output->set_status_header(500);
            echo json_encode([
                'status' => false,
                'message' => 'Banner gagal dihapus'
            ]);
        }
    }


}