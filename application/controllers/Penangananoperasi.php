<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penangananoperasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_penanganan_operasi_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','penangananoperasi/tbl_penanganan_operasi_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_penanganan_operasi_model->json();
    }

    function cetak(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
      $sql_data_resep = "SELECT * FROM tbl_penanganan_operasi";

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', array(360,360));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.png', 20, 10, 50);
        //$pdf->Image('', )
        // mencetak string 
        $pdf->Cell(45, 7, '', 0, 0, 'C');
        $pdf->Cell(230, 7, 'PUSKESMAS NUSAMANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 7, '', 0, 0, 'C');
        $pdf->Cell(270, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Barat, Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 370-20, 35);
        $pdf->Line(10,35.5, 370-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Laporan Data Penanganan Operasi', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(20,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Nama Pasien  ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Status Pasien  ', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Nama Operasi  ', 1, 0, 'C');
        $pdf->Cell(75, 7, 'Biaya  ', 1, 0, 'C');
        $pdf->Cell(49, 7, 'Ditangani Oleh  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Tgl Operasi  ', 1, 1, 'C');
        



        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(20,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->nama_pasien, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->status_pasien, 1, 0, 'C');
        $pdf->Cell(55, 7, $r->nama_operasi, 1, 0, 'C');
        $pdf->Cell(75, 7, $r->biaya, 1, 0, 'C');
        $pdf->Cell(49, 7, $r->ditangani_oleh, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->tgl_operasi, 1, 1, 'C');
        
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(155, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }
    

   function cetakid($id){

        $no_rawat = substr($this->uri->uri_string(3), 25);
        $poperasi = $this->Tbl_penanganan_operasi_model->get_by_id($id);
     

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
        $pdf->Line(10,35, 224-20, 35);
        $pdf->Line(10,35.5, 224-20, 35.5);
        $pdf->Cell(7, 7, '', 0, 1);
        $pdf->Cell(190, 7, 'Laporan Pembayaran Operasi', 0, 1, 'C');


        //data rekam medik
      


        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Nama Pasien', 1, 0, 'C');
        $pdf->Cell(28, 7, 'Status Pasien', 1, 0, 'C');
        $pdf->Cell(58, 7, 'Nama Operasi', 1, 0, 'C');
        $pdf->Cell(23, 7, 'Biaya', 1, 0, 'C');
        $pdf->Cell(23, 7, 'Dibayar', 1, 0, 'C');
        $pdf->Cell(23, 7, 'Kembalian', 1, 1, 'C');



        //1,(1) => (1) digunakan agar textnya bisa dilanjutkan ke bawah 
       
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, $poperasi->nama_pasien, 1, 0, 'C');
        $pdf->Cell(28, 7, $poperasi->status_pasien, 1, 0, 'C');
        $pdf->Cell(58, 7, $poperasi->nama_operasi, 1, 0, 'C');
        $pdf->Cell(23, 7, $poperasi->biaya, 1, 0, 'C');
        $pdf->Cell(23, 7, $poperasi->dibayar, 1, 0, 'C');
        $pdf->Cell(23, 7, $poperasi->kembalian, 1, 1, 'C');

        
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(155, 10, 'Tanggal Operasi', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.$poperasi->tgl_operasi, 0, 0, 'R');


        $pdf->Cell(130, 13, '', 0, 1);
        $pdf->Cell(130, 13, '', 0, 1);
        $pdf->Cell(150, 13, 'Waktu Cetak', 0, 0, 'R');
        $pdf->Cell(47, 14, ': '.date('d-m-Y'), 0, 0, 'R');


        $pdf->Output();

        
            }

    public function read($id) 
    {
        $row = $this->Tbl_penanganan_operasi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_penanganan' => $row->id_penanganan,
		'nama_pasien' => $row->nama_pasien,
        'no_bpjs' => $row->no_bpjs,
        'status_pasien' => $row->status_pasien,
		'nama_operasi' => $row->nama_operasi,
		'biaya' => $row->biaya,
		'ditangani_oleh' => $row->ditangani_oleh,
        'keterangan' => $row->keterangan,
		'tgl_operasi' => $row->tgl_operasi,
	    );
            $this->template->load('template','penangananoperasi/tbl_penanganan_operasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penangananoperasi'));
        }
    }


     function autooperasi() {
        $this->db->like('nama_operasi', $_GET['term']);
        $this->db->select('nama_operasi');
        $dataoperasi = $this->db->get('tbl_operasi')->result();
        foreach ($dataoperasi as $operasi) {
            $return_arr[] = $operasi->nama_operasi;
        }

        echo json_encode($return_arr);
    }

     function autofill(){

    $nama_operasi = $_GET['nama_operasi'];

    $this->db->where('nama_operasi',$nama_operasi);

    $operasi= $this->db->get('tbl_operasi')->row_array();
    $data = array(
        'biaya' => $operasi['biaya'],
        );

    echo json_encode($data);
   }

   function autoisi(){

    $nama_pasien = $_GET['nama_pasien'];

    $this->db->where('nama_pasien',$nama_pasien);

    $pasien = $this->db->get('tbl_pasien')->row_array();
    $data = array(
        'no_bpjs' => $pasien['no_bpjs'],
        );

    echo json_encode($data);
   }

     function autopasien() {
        $this->db->like('nama_pasien', $_GET['term']);
        $this->db->select('nama_pasien');
        $datapasien = $this->db->get('tbl_pasien')->result();
        foreach ($datapasien as $pasien) {
            $return_arr[] = $pasien->nama_pasien;
        }

        echo json_encode($return_arr);
    }
    public function create() 
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('penangananoperasi/create_action'),
	    'id_penanganan' => set_value('id_penanganan'),
	    'nama_pasien' => set_value('nama_pasien'),
        'no_bpjs' => set_value('no_bpjs'),
        'status_pasien' => set_value('status_pasien'),
	    'nama_operasi' => set_value('nama_operasi'),
	    'biaya' => set_value('biaya'),
	    'ditangani_oleh' => set_value('ditangani_oleh'),
	    'dibayar' => set_value('dibayar'),
	    'kembalian' => set_value('kembalian'),
        'keterangan' => set_value('keterangan'),
	    'tgl_operasi' => set_value('tgl_operasi'),
	);
        $this->template->load('template','penangananoperasi/tbl_penanganan_operasi_form', $data);
    }
    
    public function create_action() 
    {

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

        $tgl = $this->input->post('tgl_operasi',TRUE);
            $data = array(
		'nama_pasien' => $this->input->post('nama_pasien',TRUE),
        'no_bpjs' => $this->input->post('nama_pasien',TRUE),
        'status_pasien' => $this->input->post('status_pasien',TRUE),
		'nama_operasi' => $this->input->post('nama_operasi',TRUE),
		'biaya' => $this->input->post('biaya',TRUE),
		'ditangani_oleh' => $this->input->post('ditangani_oleh',TRUE),
		'dibayar' => $this->input->post('dibayar',TRUE),
		'kembalian' => $this->input->post('kembalian',TRUE),
        'keterangan' => $this->input->post('keterangan',TRUE),
        'tgl_operasi' => date('d-m-Y', strtotime($tgl))

	    );

            $this->Tbl_penanganan_operasi_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  
            redirect(site_url('penangananoperasi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_penanganan_operasi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('penangananoperasi/update_action'),
		'id_penanganan' => set_value('id_penanganan', $row->id_penanganan),
		'nama_pasien' => set_value('nama_pasien', $row->nama_pasien),
        'no_bpjs' => set_value('no_bpjs', $row->nama_pasien),
        'status_pasien' => set_value('nama_pasien', $row->status_pasien),
		'nama_operasi' => set_value('nama_operasi', $row->nama_operasi),
		'biaya' => set_value('biaya', $row->biaya),
		'ditangani_oleh' => set_value('ditangani_oleh', $row->ditangani_oleh),
		'dibayar' => set_value('dibayar', $row->dibayar),
		'kembalian' => set_value('kembalian', $row->kembalian),
        'keterangan' => set_value('keterangan', $row->keterangan),
		'tgl_operasi' => set_value('tgl_operasi', $row->tgl_operasi),
	    );
            $this->template->load('template','penangananoperasi/tbl_penanganan_operasi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penangananoperasi'));
        }
    }
    
    public function update_action() 
    {
        
        $tgl_operasi = $this->input->post('tgl_operasi');

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_penanganan', TRUE));
        } else {
            $data = array(
		'nama_pasien' => $this->input->post('nama_pasien',TRUE),
        'no_bpjs' => $this->input->post('no_bpjs',TRUE),
        'status_pasien' => $this->input->post('status_pasien',TRUE),
		'nama_operasi' => $this->input->post('nama_operasi',TRUE),
		'biaya' => $this->input->post('biaya',TRUE),
		'ditangani_oleh' => $this->input->post('ditangani_oleh',TRUE),
		'dibayar' => $this->input->post('dibayar',TRUE),
		'kembalian' => $this->input->post('kembalian',TRUE),
        'keterangan' => $this->input->post('keterangan',TRUE),
        'tgl_operasi' => date('d-m-Y', strtotime($tgl_operasi)),

	    );

            $this->Tbl_penanganan_operasi_model->update($this->input->post('id_penanganan', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');  
            redirect(site_url('penangananoperasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_penanganan_operasi_model->get_by_id($id);

        if ($row) {
            $this->Tbl_penanganan_operasi_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');  
            redirect(site_url('penangananoperasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penangananoperasi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_pasien', 'nama pasien', 'trim|required');
	$this->form_validation->set_rules('nama_operasi', 'nama operasi', 'trim|required');
    $this->form_validation->set_rules('status_pasien', 'status_pasien', 'trim|required');
	$this->form_validation->set_rules('biaya', 'biaya', 'trim|required');
	$this->form_validation->set_rules('ditangani_oleh', 'ditangani oleh', 'trim|required');
	$this->form_validation->set_rules('dibayar', 'dibayar', 'trim|required');
	$this->form_validation->set_rules('kembalian', 'kembalian', 'trim|required');
    $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('tgl_operasi', 'tgl operasi', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


	$this->form_validation->set_rules('id_penanganan', 'id_penanganan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_penanganan_operasi.xls";
        $judul = "tbl_penanganan_operasi";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pasien");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Operasi");
	xlsWriteLabel($tablehead, $kolomhead++, "Biaya");
	xlsWriteLabel($tablehead, $kolomhead++, "Ditangani Oleh");
	xlsWriteLabel($tablehead, $kolomhead++, "Dibayar");
	xlsWriteLabel($tablehead, $kolomhead++, "Kembalian");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Operasi");

	foreach ($this->Tbl_penanganan_operasi_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_pasien);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_operasi);
	    xlsWriteNumber($tablebody, $kolombody++, $data->biaya);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ditangani_oleh);
	    xlsWriteNumber($tablebody, $kolombody++, $data->dibayar);
	    xlsWriteNumber($tablebody, $kolombody++, $data->kembalian);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_operasi);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_penanganan_operasi.doc");

        $data = array(
            'tbl_penanganan_operasi_data' => $this->Tbl_penanganan_operasi_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('penangananoperasi/tbl_penanganan_operasi_doc',$data);
    }

}

