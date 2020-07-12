<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dataobat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_obat_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','dataobat/tbl_obat_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_obat_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_obat_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kode_obat' => $row->kode_obat,
		'nama_obat' => $row->nama_obat,
		'jenis_obat' => $row->jenis_obat,
		'dosis_aturan_obat' => $row->dosis_aturan_obat,
        'satuan' => $row->satuan,

	    );
            $this->template->load('template','dataobat/tbl_obat_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dataobat'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('dataobat/create_action'),
	    'kode_obat' => set_value('kode_obat'),
	    'nama_obat' => set_value('nama_obat'),
	    'jenis_obat' => set_value('jenis_obat'),
	    'dosis_aturan_obat' => set_value('dosis_aturan_obat'),
        'satuan' => set_value('satuan'),

	);
        $this->template->load('template','dataobat/tbl_obat_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        'kode_obat' => $this->input->post('kode_obat',TRUE),
		'nama_obat' => $this->input->post('nama_obat',TRUE),
		'jenis_obat' => $this->input->post('jenis_obat',TRUE),
		'dosis_aturan_obat' => $this->input->post('dosis_aturan_obat',TRUE),
        'satuan' => $this->input->post('satuan',TRUE),

	    );

            $this->Tbl_obat_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');       
            redirect(site_url('dataobat'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_obat_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('dataobat/update_action'),
		'kode_obat' => set_value('kode_obat', $row->kode_obat),
		'nama_obat' => set_value('nama_obat', $row->nama_obat),
		'jenis_obat' => set_value('jenis_obat', $row->jenis_obat),
		'dosis_aturan_obat' => set_value('dosis_aturan_obat', $row->dosis_aturan_obat),
        'satuan' => set_value('satuan', $row->satuan),

	    );
            $this->template->load('template','dataobat/tbl_obat_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dataobat'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_obat', TRUE));
        } else {
            $data = array(
        'kode_obat' => $this->input->post('kode_obat',TRUE),
		'nama_obat' => $this->input->post('nama_obat',TRUE),
		'jenis_obat' => $this->input->post('jenis_obat',TRUE),
		'dosis_aturan_obat' => $this->input->post('dosis_aturan_obat',TRUE),
        'satuan' => $this->input->post('satuan',TRUE),

	    );

            $this->Tbl_obat_model->update($this->input->post('kode_obat', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');       
            redirect(site_url('dataobat'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_obat_model->get_by_id($id);

        if ($row) {
            $this->Tbl_obat_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');       
            redirect(site_url('dataobat'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dataobat'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_obat', 'nama obat', 'trim|required');
	$this->form_validation->set_rules('jenis_obat', 'jenis obat', 'trim|required');
	$this->form_validation->set_rules('dosis_aturan_obat', 'dosis aturan obat', 'trim|required');
    $this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


	$this->form_validation->set_rules('kode_obat', 'kode obat', 'trim|required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_obat.xls";
        $judul = "tbl_obat";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Obat");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Obat");
	xlsWriteLabel($tablehead, $kolomhead++, "Dosis Aturan Obat");

	foreach ($this->Tbl_obat_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_obat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_obat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->dosis_aturan_obat);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_obat.doc");

        $data = array(
            'tbl_obat_data' => $this->Tbl_obat_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('dataobat/tbl_obat_doc',$data);
    }

}

