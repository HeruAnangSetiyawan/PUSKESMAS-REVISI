<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dokter extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_dokter_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','dokter/tbl_dokter_list');
    } 

    function cetak(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
      $sql_data_resep = "SELECT dok.kode_dokter,dok.nama_dokter,dok.jenis_kelamin,dok.nomor_induk_dokter,dok.tempat_lahir,dok.tgl_lahir,dok.alamat, pol.nama_poli FROM tbl_dokter as dok, tbl_poli as pol WHERE dok.id_poli = pol.id_poli";

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', array(380,380));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image(base_url().'assets/foto_profil/logo-rs.png', 20, 10, 50);
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
        $pdf->Cell(190, 7, 'Laporan Data Dokter', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Kode Dokter ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nama Dokter  ', 1, 0, 'C');
        $pdf->Cell(60, 7, 'Jenis Kelamin  ', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Nomor Induk Dokter  ', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Tempat Lahir  ', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Tanggal Lahir  ', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Alamat  ', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Nama Poli  ', 1, 1, 'C');



        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->kode_dokter, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->nama_dokter, 1, 0, 'C');
        $pdf->Cell(60, 7, $r->jenis_kelamin, 1, 0, 'C');
        $pdf->Cell(50, 7, $r->nomor_induk_dokter, 1, 0, 'C');
        $pdf->Cell(35, 7, $r->tempat_lahir, 1, 0, 'C');
        $pdf->Cell(35, 7, date('d-m-Y',strtotime($r->tgl_lahir)), 1, 0, 'C');
        $pdf->Cell(50, 7, $r->alamat, 1, 0, 'C');
        $pdf->Cell(40, 7, $r->nama_poli, 1, 1, 'C');
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


    function cetakrujukan(){

        $no_rawat = substr($this->uri->uri_string(3), 25);
      $sql_daftar = "SELECT pd.no_rekamedis, pd.no_rawat,pd.tanggal_daftar,ps.nama_pasien, td.nama_dokter FROM tbl_pendaftaran as pd, tbl_pasien as ps, tbl_dokter as td WHERE pd.no_rekamedis = ps.no_rekamedis and td.kode_dokter = pd.kode_dokter_penanggung_jawab and pd.no_rawat = '$no_rawat'";
      $sql_penyakit = "SELECT pd.no_rekamedis, pd.no_rawat,dg.nama_penyakit FROM tbl_pendaftaran as pd, tbl_diagnosa_penyakit as dg WHERE pd.no_rekamedis and pd.no_rawat = '$no_rawat'";
      $sql_rujukan = "SELECT * FROM tbl_rujukan where no_rawat = '$no_rawat'";
      $sql_data_rujukan = "SELECT nama_penyakit, diagnosa, poli_tujuan FROM tbl_rujukan where no_rawat = '$no_rawat'";
      $sql_data_tindakan = "SELECT rt.id_poli, rt.kode_penyakit,rt.kode_tindakan,rt.no_rawat,rt.hasil_periksa,rt.nama_obat,rt.tanggal,p.nama_poli, pkt.nama_penyakit, t.nama_tindakan FROM tbl_riwayat_tindakan as rt, tbl_tindakan as t, tbl_poli as p, tbl_diagnosa_penyakit as pkt WHERE rt.no_rawat = '$no_rawat' AND rt.kode_tindakan = t.kode_tindakan AND rt.id_poli = p.id_poli AND rt.kode_penyakit = pkt.kode_diagnosa";

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', 'A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.jpg', 4, 5, 30);
        //$pdf->Image('', a)
        // mencetak string 
        $pdf->Cell(190, 7, 'PUSKESMAS WADAS', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 7, '          Jl. Pintu Air,Kp. Sindangsari, Desa Wadas No.17, Telukjambe Timur, Karawang.', 0, 1, 'C');
        $pdf->Cell(190, 7, 'Telepon : (0267) 4218872. E-mail: puskeswadas@gmail.com', 0, 1, 'C');
        $pdf->Line(20,35, 210-20, 35);
        $pdf->Line(20,35.5, 210-20, 35.5);
        $pdf->Cell(7, 7, '', 0, 1);
        $pdf->Cell(190, 7, 'Laporan Rujukan', 0, 1, 'C');


        //data rekam medik
        $rujukan = $this->db->query($sql_rujukan)->row_array();
        $pdf->Cell(30, 7, 'No.Rujukan', 0, 0, 'L');
        $pdf->Cell(80, 7, ': '.$rujukan['no_rujukan'], 0, 0, 'L'); //90 merupakan jarak antara no_rekamedis dengan isian ditangani oleh

        $pdf->Cell(45, 7, 'Tanggal Dirujuk', 0, 0, 'L');
        $pdf->Cell(30, 7, ': '.date('d-m-Y', strtotime($rujukan['tgl_rujukan'])), 0, 1, 'L');

        $pdf->Cell(30, 7, 'Nama Pasien', 0, 0, 'L');
        $pdf->Cell(80, 7, ': '.$rujukan['nama_pasien'], 0, 0, 'L');

        $pdf->Cell(45, 7, 'Nama Rumah Sakit', 0, 0, 'L');
        $pdf->Cell(30, 7, ': '.$rujukan['nama_rumah_sakit'] ,0, 1, 'L');
        $pdf->Cell(10, 10, '', 0, 1);


        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(44, 7, 'Nama Penyakit', 1, 0, 'C');
        $pdf->Cell(105, 7, 'Diagnosa', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Poli Tujuan', 1, 1, 'C');//1,(1) => (1) digunakan agar textnya bisa dilanjutkan ke bawah 

        $hasil_rujukan = $this->db->query($sql_rujukan)->result();
        foreach ($hasil_rujukan as $hr) {
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(44, 7, $hr->nama_penyakit, 1, 0, 'C');
        $pdf->Cell(105, 7, $hr->diagnosa, 1, 0, 'C');
        $pdf->Cell(45, 7, $hr->poli_tujuan, 1, 1, 'C');
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(155, 10, 'Waktu Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y H:i:s'), 0, 0, 'R');


        $pdf->Output();
    }

    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_dokter_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_dokter_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kode_dokter' => $row->kode_dokter,
		'nama_dokter' => $row->nama_dokter,
		'jenis_kelamin' => $row->jenis_kelamin,
		'nomor_induk_dokter' => $row->nomor_induk_dokter,
		'tempat_lahir' => $row->tempat_lahir,
		'tgl_lahir' => $row->tgl_lahir,
		'alamat' => $row->alamat,
		'id_poli' => $row->id_poli,
	    );
            $this->template->load('template','dokter/tbl_dokter_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dokter'));
        }
    }

    
    public function create() 
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('dokter/create_action'),
	    'kode_dokter' => set_value('kode_dokter'),
	    'nama_dokter' => set_value('nama_dokter'),
	    'jenis_kelamin' => set_value('jenis_kelamin'),
	    'nomor_induk_dokter' => set_value('nomor_induk_dokter'),
	    'tempat_lahir' => set_value('tempat_lahir'),
	    'tgl_lahir' => set_value('tgl_lahir'),
	    'alamat' => set_value('alamat'),
	    'id_poli' => set_value('id_poli'),
	);
        $this->template->load('template','dokter/tbl_dokter_form', $data);
    }
    
    public function create_action() 
    {

        $tgl =   $this->input->post('tgl_lahir',TRUE);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        'kode_dokter' => $this->input->post('kode_dokter', TRUE),
		'nama_dokter' => $this->input->post('nama_dokter',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'nomor_induk_dokter' => $this->input->post('nomor_induk_dokter',TRUE),
		'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
		'tgl_lahir' => date('d-m-Y',strtotime($tgl)),
		'alamat' => $this->input->post('alamat',TRUE),
		'id_poli' => $this->input->post('id_poli',TRUE),
	    );

            $this->Tbl_dokter_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  

            redirect(site_url('dokter'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_dokter_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('dokter/update_action'),
		'kode_dokter' => set_value('kode_dokter', $row->kode_dokter),
		'nama_dokter' => set_value('nama_dokter', $row->nama_dokter),
		'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
		'nomor_induk_dokter' => set_value('nomor_induk_dokter', $row->nomor_induk_dokter),
		'tempat_lahir' => set_value('tempat_lahir', $row->tempat_lahir),
		'tgl_lahir' => set_value('tgl_lahir', $row->tgl_lahir),
		'alamat' => set_value('alamat', $row->alamat),
		'id_poli' => set_value('id_poli', $row->id_poli),
	    );
            $this->template->load('template','dokter/tbl_dokter_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dokter'));
        }
    }
    
    public function update_action() 
    {

        $tgl = $this->input->post('tgl_lahir',TRUE);

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_dokter', TRUE));
        } else {
            $data = array(
        'kode_dokter' => $this->input->post('kode_dokter',TRUE),
		'nama_dokter' => $this->input->post('nama_dokter',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'nomor_induk_dokter' => $this->input->post('nomor_induk_dokter',TRUE),
		'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
        'tgl_lahir' => date('d-m-Y',strtotime($tgl)),
		'alamat' => $this->input->post('alamat',TRUE),
		'id_poli' => $this->input->post('id_poli',TRUE),
	    );

            $this->Tbl_dokter_model->update($this->input->post('kode_dokter', TRUE), $data);
             $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');  
            redirect(site_url('dokter'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_dokter_model->get_by_id($id);

        if ($row) {
            $this->Tbl_dokter_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');  
            redirect(site_url('dokter'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dokter'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_dokter', 'nama dokter', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('nomor_induk_dokter', 'nomor induk dokter', 'trim|required');
	$this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'trim|required');
	$this->form_validation->set_rules('tgl_lahir', 'tgl lahir', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('id_poli', 'id poli', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');

	$this->form_validation->set_rules('kode_dokter', 'kode_dokter', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_dokter.xls";
        $judul = "tbl_dokter";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Dokter");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Kelamin");
	xlsWriteLabel($tablehead, $kolomhead++, "Nomor Induk Dokter");
	xlsWriteLabel($tablehead, $kolomhead++, "Tempat Lahir");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Lahir");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Poli");

	foreach ($this->Tbl_dokter_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_dokter);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_kelamin);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nomor_induk_dokter);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tempat_lahir);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_lahir);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->id_poli);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_dokter.doc");

        $data = array(
            'tbl_dokter_data' => $this->Tbl_dokter_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('dokter/tbl_dokter_doc',$data);
    }

}

