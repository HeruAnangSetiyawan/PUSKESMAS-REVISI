<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paramedis extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_paramedis_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','paramedis/tbl_paramedis_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_paramedis_model->json();
    }

    function cetak(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
      $sql_data_resep = "SELECT prs.kode_paramedis, prs.nama_paramedis, prs.jenis_kelamin, prs.no_izin_paramedis, prs.jenis_kelamin, prs.no_izin_paramedis, prs.tempat_lahir, prs.tanggal_lahir, prs.alamat_tinggal, pol.nama_poli FROM tbl_paramedis as prs, tbl_poli as pol where prs.id_poli = pol.id_poli";

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', array(390,390));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.png', 20, 10, 50);
        //$pdf->Image('', )
        // mencetak string 
        $pdf->Cell(45, 7, '', 0, 0, 'C');
        $pdf->Cell(260, 7, 'PUSKESMAS NUSAMANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 7, '', 0, 0, 'C');
        $pdf->Cell(275, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Barat, Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(80, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 390-20, 35);
        $pdf->Line(10,35.5, 390-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Laporan Data Paramedis', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Kode Paramedis  ', 1, 0, 'C');
        $pdf->Cell(75, 7, 'Nama Paramedis  ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Jenis Kelamin  ', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Nomor Izin Paramedis  ', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Tempat Lahir  ', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Tanggal Lahir  ', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Alamat Tinggal  ', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Nama Poli  ', 1, 1, 'C');



        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->kode_paramedis, 1, 0, 'C');
        $pdf->Cell(75, 7, $r->nama_paramedis, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->jenis_kelamin, 1, 0, 'C');
        $pdf->Cell(50, 7, $r->no_izin_paramedis, 1, 0, 'C');
        $pdf->Cell(35, 7, $r->tempat_lahir, 1, 0, 'C');
        $pdf->Cell(35, 7, date('d-m-Y', strtotime($r->tanggal_lahir)), 1, 0, 'C');
        $pdf->Cell(40, 7, $r->alamat_tinggal, 1, 0, 'C');
        $pdf->Cell(35, 7, $r->nama_poli, 1, 1, 'C');
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(155, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }


    public function read($id) 
    {
        $row = $this->Tbl_paramedis_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kode_paramedis' => $row->kode_paramedis,
		'nama_paramedis' => $row->nama_paramedis,
		'jenis_kelamin' => $row->jenis_kelamin,
		'no_izin_paramedis' => $row->no_izin_paramedis,
		'tempat_lahir' => $row->tempat_lahir,
		'tanggal_lahir' => $row->tanggal_lahir,
		'alamat_tinggal' => $row->alamat_tinggal,
		'id_poli' => $row->id_poli,
	    );
            $this->template->load('template','paramedis/tbl_paramedis_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paramedis'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('paramedis/create_action'),
	    'kode_paramedis' => set_value('kode_paramedis'),
	    'nama_paramedis' => set_value('nama_paramedis'),
	    'jenis_kelamin' => set_value('jenis_kelamin'),
	    'no_izin_paramedis' => set_value('no_izin_paramedis'),
	    'tempat_lahir' => set_value('tempat_lahir'),
	    'tanggal_lahir' => set_value('tanggal_lahir'),
	    'alamat_tinggal' => set_value('alamat_tinggal'),
	    'id_poli' => set_value('id_poli'),
	);
        $this->template->load('template','paramedis/tbl_paramedis_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

        $tt = $this->input->post('tanggal_lahir',TRUE);
            $data = array(
        'kode_paramedis' => $this->input->post('kode_paramedis', TRUE),
		'nama_paramedis' => $this->input->post('nama_paramedis',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'no_izin_paramedis' => $this->input->post('no_izin_paramedis',TRUE),
		'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
		'tanggal_lahir' => date('d-m-Y', strtotime($tt)),
		'alamat_tinggal' => $this->input->post('alamat_tinggal',TRUE),
		'id_poli' => $this->input->post('id_poli',TRUE),
	    );

            $this->Tbl_paramedis_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  
            redirect(site_url('paramedis'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_paramedis_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('paramedis/update_action'),
		'kode_paramedis' => set_value('kode_paramedis', $row->kode_paramedis),
		'nama_paramedis' => set_value('nama_paramedis', $row->nama_paramedis),
		'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
		'no_izin_paramedis' => set_value('no_izin_paramedis', $row->no_izin_paramedis),
		'tempat_lahir' => set_value('tempat_lahir', $row->tempat_lahir),
		'tanggal_lahir' => set_value('tanggal_lahir', $row->tanggal_lahir),
		'alamat_tinggal' => set_value('alamat_tinggal', $row->alamat_tinggal),
		'id_poli' => set_value('id_poli', $row->id_poli),
	    );
            $this->template->load('template','paramedis/tbl_paramedis_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paramedis'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_paramedis', TRUE));
        } else {

        $tt = $this->input->post('tanggal_lahir',TRUE);

        

            $data = array(
        'kode_paramedis' => $this->input->post('kode_paramedis',TRUE),
		'nama_paramedis' => $this->input->post('nama_paramedis',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'no_izin_paramedis' => $this->input->post('no_izin_paramedis',TRUE),
		'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
		'tanggal_lahir' => date('d-m-Y', strtotime($tt)),
		'alamat_tinggal' => $this->input->post('alamat_tinggal',TRUE),
		'id_poli' => $this->input->post('id_poli',TRUE),
	    );

            $this->Tbl_paramedis_model->update($this->input->post('kode_paramedis', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');              redirect(site_url('paramedis'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_paramedis_model->get_by_id($id);

        if ($row) {
            $this->Tbl_paramedis_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');              redirect(site_url('paramedis'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paramedis'));
        }
    }

    public function _rules() 
    {
    $this->form_validation->set_rules('kode_paramedis', 'kode paramedis', 'trim|required');
	$this->form_validation->set_rules('nama_paramedis', 'nama paramedis', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('no_izin_paramedis', 'no izin paramedis', 'trim|required');
	$this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'trim|required');
	$this->form_validation->set_rules('tanggal_lahir', 'tanggal lahir', 'trim|required');
	$this->form_validation->set_rules('alamat_tinggal', 'alamat tinggal', 'trim|required');
	$this->form_validation->set_rules('id_poli', 'id poli', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


	$this->form_validation->set_rules('kode_paramedis', 'kode_paramedis', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_paramedis.xls";
        $judul = "tbl_paramedis";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Paramedis");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Kelamin");
	xlsWriteLabel($tablehead, $kolomhead++, "No Izin Paramedis");
	xlsWriteLabel($tablehead, $kolomhead++, "Tempat Lahir");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Lahir");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat Tinggal");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Poli");

	foreach ($this->Tbl_paramedis_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_paramedis);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_kelamin);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_izin_paramedis);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tempat_lahir);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_lahir);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat_tinggal);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_poli);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_paramedis.doc");

        $data = array(
            'tbl_paramedis_data' => $this->Tbl_paramedis_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('paramedis/tbl_paramedis_doc',$data);
    }

}

