<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengeluaranobat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_pengeluaran_obat_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','pengeluaranobat/tbl_pengeluaran_obat_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_pengeluaran_obat_model->json();
    }

    function cetak(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
      $sql_data_resep = "SELECT * FROM tbl_pengeluaran_obat";

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
        $pdf->Cell(190, 7, 'Laporan Data Pengeluaran Obat', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'No. Terima Obat  ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nama Pasien  ', 1, 0, 'C');
        $pdf->Cell(75, 7, 'Nama Obat  ', 1, 0, 'C');
        $pdf->Cell(49, 7, 'Jenis Obat  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Jumlah  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Satuan  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Keterangan  ', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Tgl Serah Obat  ', 1, 1, 'C');








        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->no_terima_obat, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->nama_pasien, 1, 0, 'C');
        $pdf->Cell(75, 7, $r->nama_obat, 1, 0, 'C');
        $pdf->Cell(49, 7, $r->jenis_obat, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->jumlah, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->satuan, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->keterangan, 1, 0, 'C');
        $pdf->Cell(40, 7, $r->tgl_serah_obat, 1, 1, 'C');
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(155, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }

    function cetaklabel($id){

        $sql_pluar_obat = $this->Tbl_pengeluaran_obat_model->get_by_id($id);
        $this->load->library('pdf');
        $pdf = new FPDF();
        $pdf->AddPage('P','A4');

        $tgl=date('Y/m/d');
        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/latar-kartu.png',5,5,100,56);
        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.jpg',10,9,10,10);
        $pdf->setFont('Arial','B',12);
        $pdf->Cell(90,5,'PUSKESMAS WADAS',0,0,'C');
        $pdf->Cell(10,5,'',0,1,'C');
        $pdf->setFont('Arial','B',10);
        $pdf->setFont('Arial','B',8);
        $pdf->Cell(90,5,'Jl.Pintu Air, Sindangsari, Wadas No.17',0,0,'C');
        $pdf->Cell(10,5,'',0,1,'C');
        $pdf->setFont('Arial','',7);
        $pdf->SetLineWidth(0.2);
        $pdf->Line(10,20,100,20);
        $pdf->setFont('Arial','B',10);
        $pdf->Cell(90,5,'',0,0,'C');
        $pdf->Cell(10,5,'',0,1,'C');
        $pdf->setFont('Arial','',7);
        $pdf->SetLineWidth(0.2);
        $pdf->Line(10,25,100,25);
        $pdf->Ln(6);
        
        $pdf->setFont('Arial','',9);
        $pdf->Cell(60, 4, '', 0, 1);
        $pdf->Cell(42,4,'Nama Pasien',0,0,'L');
        $pdf->Cell(36,4,': '.$sql_pluar_obat->nama_pasien,0,0,'L');
        $pdf->Cell(10,4,'',0,1,'C');
        $pdf->setFont('Arial','',10);
        $pdf->Cell(42,4,'Nama Obat',0,0,'L');
        $pdf->Cell(36,4,': '.$sql_pluar_obat->nama_obat,0,1,'L');
        $pdf->Cell(42,4,'Dosis Aturan Obat',0,0,'L');
        $pdf->Cell(36,4,': '.$sql_pluar_obat->dosis_aturan_obat,0,1,'L');
        $pdf->Ln(2);

        $pdf->Output('cetak-label-obat.pdf','I');

            }


    public function read($id) 
    {
        $row = $this->Tbl_pengeluaran_obat_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_pengeluaran' => $row->id_pengeluaran,
		'no_terima_obat' => $row->no_terima_obat,
		'nama_pasien' => $row->nama_pasien,
		'kode_obat' => $row->kode_obat,
		'nama_obat' => $row->nama_obat,
		'jenis_obat' => $row->jenis_obat,
		'dosis_aturan_obat' => $row->dosis_aturan_obat,
		'jumlah' => $row->jumlah,
        'satuan' => $row->satuan,
		'keterangan' => $row->keterangan,
		'tgl_serah_obat' => $row->tgl_serah_obat,
	    );
            $this->template->load('template','pengeluaranobat/tbl_pengeluaran_obat_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengeluaranobat'));
        }
    }

    function autopasien(){

      autocomplate_json('tbl_pasien', 'nama_pasien');
    
    }

     function obatauto(){
        autocomplate_json('tbl_obat', 'nama_obat');
    }

     function autofill(){

    $nama_obat = $_GET['nama_obat'];

    $this->db->where('nama_obat',$nama_obat);

    $obat= $this->db->get('tbl_obat')->row_array();
    $data = array(
        'kode_obat' => $obat['kode_obat'],
        'jenis_obat' => $obat['jenis_obat'],
        'dosis_aturan_obat' => $obat['dosis_aturan_obat'],
        'satuan' => $obat['satuan'],

        );

    echo json_encode($data);
   }

    public function create() 
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('pengeluaranobat/create_action'),
	    'id_pengeluaran' => set_value('id_pengeluaran'),
	    'no_terima_obat' => set_value('no_terima_obat'),
	    'nama_pasien' => set_value('nama_pasien'),
	    'kode_obat' => set_value('kode_obat'),
	    'nama_obat' => set_value('nama_obat'),
	    'jenis_obat' => set_value('jenis_obat'),
	    'dosis_aturan_obat' => set_value('dosis_aturan_obat'),
	    'jumlah' => set_value('jumlah'),
        'satuan' => set_value('satuan'),
	    'keterangan' => set_value('keterangan'),
	    'tgl_serah_obat' => set_value('tgl_serah_obat'),
	);
        $this->template->load('template','pengeluaranobat/tbl_pengeluaran_obat_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_pengeluaran' => $this->input->post('id_pengeluaran',TRUE),
        'no_terima_obat' => $this->input->post('no_terima_obat', TRUE),
		'nama_pasien' => $this->input->post('nama_pasien',TRUE),
		'kode_obat' => $this->input->post('kode_obat',TRUE),
		'nama_obat' => $this->input->post('nama_obat',TRUE),
		'jenis_obat' => $this->input->post('jenis_obat',TRUE),
		'dosis_aturan_obat' => $this->input->post('dosis_aturan_obat',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
        'satuan' => $this->input->post('satuan',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'tgl_serah_obat' => $this->input->post('tgl_serah_obat',TRUE),
	    );

            $this->Tbl_pengeluaran_obat_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  
            redirect(site_url('pengeluaranobat'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_pengeluaran_obat_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pengeluaranobat/update_action'),
		'id_pengeluaran' => set_value('id_pengeluaran', $row->id_pengeluaran),
		'no_terima_obat' => set_value('no_terima_obat', $row->no_terima_obat),
		'nama_pasien' => set_value('nama_pasien', $row->nama_pasien),
		'kode_obat' => set_value('kode_obat', $row->kode_obat),
		'nama_obat' => set_value('nama_obat', $row->nama_obat),
		'jenis_obat' => set_value('jenis_obat', $row->jenis_obat),
		'dosis_aturan_obat' => set_value('dosis_aturan_obat', $row->dosis_aturan_obat),
		'jumlah' => set_value('jumlah', $row->jumlah),
        'satuan' => set_value('satuan', $row->jumlah),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'tgl_serah_obat' => set_value('tgl_serah_obat', $row->tgl_serah_obat),
	    );
            $this->template->load('template','pengeluaranobat/tbl_pengeluaran_obat_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengeluaranobat'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('no_terima_obat', TRUE));
        } else {
            $data = array(
		'id_pengeluaran' => $this->input->post('id_pengeluaran',TRUE),
		'nama_pasien' => $this->input->post('nama_pasien',TRUE),
		'kode_obat' => $this->input->post('kode_obat',TRUE),
		'nama_obat' => $this->input->post('nama_obat',TRUE),
		'jenis_obat' => $this->input->post('jenis_obat',TRUE),
		'dosis_aturan_obat' => $this->input->post('dosis_aturan_obat',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
        'satuan' => $this->input->post('satuan',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'tgl_serah_obat' => $this->input->post('tgl_serah_obat',TRUE),
	    );

            $this->Tbl_pengeluaran_obat_model->update($this->input->post('no_terima_obat', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');  
            redirect(site_url('pengeluaranobat'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_pengeluaran_obat_model->get_by_id($id);

        if ($row) {
            $this->Tbl_pengeluaran_obat_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');  
            redirect(site_url('pengeluaranobat'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengeluaranobat'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_pengeluaran', 'id pengeluaran', 'trim|required');
	$this->form_validation->set_rules('nama_pasien', 'nama pasien', 'trim|required');
	$this->form_validation->set_rules('kode_obat', 'kode obat', 'trim|required');
	$this->form_validation->set_rules('nama_obat', 'nama obat', 'trim|required');
	$this->form_validation->set_rules('jenis_obat', 'jenis obat', 'trim|required');
	$this->form_validation->set_rules('dosis_aturan_obat', 'dosis aturan obat', 'trim|required');
	$this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('tgl_serah_obat', 'tgl serah obat', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


	$this->form_validation->set_rules('no_terima_obat', 'no_terima_obat', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_pengeluaran_obat.xls";
        $judul = "tbl_pengeluaran_obat";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Id Pengeluaran");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pasien");
	xlsWriteLabel($tablehead, $kolomhead++, "Kode Obat");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Obat");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Obat");
	xlsWriteLabel($tablehead, $kolomhead++, "Dosis Aturan Obat");
	xlsWriteLabel($tablehead, $kolomhead++, "Jumlah");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Serah Obat");

	foreach ($this->Tbl_pengeluaran_obat_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->id_pengeluaran);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_pasien);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kode_obat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_obat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_obat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->dosis_aturan_obat);
	    xlsWriteNumber($tablebody, $kolombody++, $data->jumlah);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_serah_obat);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_pengeluaran_obat.doc");

        $data = array(
            'tbl_pengeluaran_obat_data' => $this->Tbl_pengeluaran_obat_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('pengeluaranobat/tbl_pengeluaran_obat_doc',$data);
    }

}

