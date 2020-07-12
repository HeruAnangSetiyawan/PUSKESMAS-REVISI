<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_operasi_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','operasi/tbl_operasi_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_operasi_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_operasi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kode_operasi' => $row->kode_operasi,
		'nama_operasi' => $row->nama_operasi,
		'biaya' => $row->biaya,
		'tindakan_oleh' => $row->tindakan_oleh,
	    );
            $this->template->load('template','operasi/tbl_operasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('operasi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('operasi/create_action'),
	    'kode_operasi' => set_value('kode_operasi'),
	    'nama_operasi' => set_value('nama_operasi'),
	    'biaya' => set_value('biaya'),
	    'tindakan_oleh' => set_value('tindakan_oleh'),
	);
        $this->template->load('template','operasi/tbl_operasi_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        'kode_operasi' => $this->input->post('kode_operasi',TRUE),
		'nama_operasi' => $this->input->post('nama_operasi',TRUE),
		'biaya' => $this->input->post('biaya',TRUE),
		'tindakan_oleh' => $this->input->post('tindakan_oleh',TRUE),
	    );

            $this->Tbl_operasi_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  
            redirect(site_url('operasi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_operasi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('operasi/update_action'),
		'kode_operasi' => set_value('kode_operasi', $row->kode_operasi),
		'nama_operasi' => set_value('nama_operasi', $row->nama_operasi),
		'biaya' => set_value('biaya', $row->biaya),
		'tindakan_oleh' => set_value('tindakan_oleh', $row->tindakan_oleh),
	    );
            $this->template->load('template','operasi/tbl_operasi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('operasi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_operasi', TRUE));
        } else {
            $data = array(
        'kode_operasi' => $this->input->post('kode_operasi',TRUE),
		'nama_operasi' => $this->input->post('nama_operasi',TRUE),
		'biaya' => $this->input->post('biaya',TRUE),
		'tindakan_oleh' => $this->input->post('tindakan_oleh',TRUE),
	    );

            $this->Tbl_operasi_model->update($this->input->post('kode_operasi', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');              redirect(site_url('operasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_operasi_model->get_by_id($id);

        if ($row) {
            $this->Tbl_operasi_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');              redirect(site_url('operasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('operasi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_operasi', 'nama operasi', 'trim|required');
	$this->form_validation->set_rules('biaya', 'biaya', 'trim|required');
	$this->form_validation->set_rules('tindakan_oleh', 'tindakan oleh', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


	$this->form_validation->set_rules('kode_operasi', 'kode_operasi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_operasi.xls";
        $judul = "tbl_operasi";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Operasi");
	xlsWriteLabel($tablehead, $kolomhead++, "Biaya");
	xlsWriteLabel($tablehead, $kolomhead++, "Tindakan Oleh");

	foreach ($this->Tbl_operasi_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_operasi);
	    xlsWriteNumber($tablebody, $kolombody++, $data->biaya);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tindakan_oleh);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_operasi.doc");

        $data = array(
            'tbl_operasi_data' => $this->Tbl_operasi_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('operasi/tbl_operasi_doc',$data);
    }

}

