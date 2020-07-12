<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pendaftaran extends CI_Controller
{
    
    public $rm = array();

    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_pendaftaran_model');
        $this->load->library('form_validation');
    }



   public function index()
    {
        
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'index.php/pendaftaran/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/pendaftaran/index?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/pendaftaran/index';
            $config['first_url'] = base_url() . 'index.php/pendaftaran/index';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tbl_pendaftaran_model->total_rows($q);
        $pendaftaran = $this->Tbl_pendaftaran_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pendaftaran_data' => $pendaftaran,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','pendaftaran/tbl_pendaftaran_list', $data);
    }

    function detail($no_rekmed){

      $no_rawat = substr($this->uri->uri_string(3), 19);
      $sql_no_rekmed = "SELECT no_rekamedis from tbl_pasien";
      $sql_daftar = "SELECT pd.no_rekamedis, pd.no_rawat,ps.nama_pasien FROM tbl_pendaftaran as pd, tbl_pasien as ps WHERE pd.no_rekamedis = ps.no_rekamedis and pd.no_rawat = '$no_rawat'";
      $sql_penyakit = "SELECT pd.no_rekamedis, pd.no_rawat,dg.nama_penyakit FROM tbl_pendaftaran as pd, tbl_diagnosa_penyakit as dg WHERE pd.no_rekamedis and pd.no_rawat = '$no_rawat'";
      $sql_poli_input_rekmed = "SELECT pd.no_rawat,pd.id_poli, p.nama_poli FROM tbl_pendaftaran as pd, tbl_poli as p WHERE pd.no_rawat = '$no_rawat' AND pd.id_poli = p.id_poli";
      $no_rekmed = $this->db->query($sql_daftar)->row()->no_rekamedis; //untuk proses pengambilan data atribut no_rekamedis (yang diambil hanya data atribut itu saja)
      $sql_data_tindakan = "SELECT rt.no_rawat,rt.no_rekamedis,rt.hasil_periksa,rt.nama_obat,rt.tanggal,p.nama_poli, pkt.nama_penyakit, t.nama_tindakan FROM tbl_riwayat_tindakan as rt, tbl_tindakan as t, tbl_poli as p, tbl_diagnosa_penyakit as pkt, tbl_pasien as pas WHERE pas.no_rekamedis = '$no_rekmed' AND rt.no_rekamedis = '$no_rekmed' AND rt.kode_tindakan = t.kode_tindakan AND rt.id_poli = p.id_poli AND rt.kode_penyakit = pkt.kode_diagnosa";
      $sql_data_resep = "SELECT rt.nama_obat, rt.jenis_obat,rt.dosis_aturan_obat,rt.no_rawat,rt.tanggal, pkt.nama_pasien FROM tbl_resep_obat as rt, tbl_pasien as pkt WHERE rt.no_rawat = '$no_rawat' AND rt.no_rekamedis = pkt.no_rekamedis";

      $data['pendaftaran'] = $this->db->query($sql_daftar)->row_array();
      $data['penyakit'] = $this->db->query($sql_penyakit)->row_array();
      $data['baca_poli'] = $this->db->query($sql_poli_input_rekmed)->row_array();
      $data['no_rawat'] = $no_rawat;
      $data['data_tindakan'] = $this->db->query($sql_data_tindakan)->result();
      $data['data_resep'] = $this->db->query($sql_data_resep)->result();
      //$data['nama_obat'] = $this->db->query($sql_nama_obat)->row_array();

      $this->template->load('template', 'pendaftaran/detail', $data);



    }
    function getNoRekamedis($namaPasien){

        $this->db->where('nama_pasien', $namaPasien);
        $pasien = $this->db->get('tbl_pasien')->row_array();
        return $pasien['no_rekamedis'];
    }

     function cetak(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
      $sql_data_resep = "SELECT pd.*, pol.nama_poli, dok.nama_dokter, pas.nama_pasien FROM tbl_pendaftaran as pd, tbl_poli as pol, tbl_dokter as dok, tbl_pasien as pas where pd.kode_dokter_penanggung_jawab=dok.kode_dokter AND pd.id_poli=pol.id_poli AND pd.no_rekamedis=pas.no_rekamedis ORDER BY pd.no_rawat asc ";

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', array(430,380));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.png', 20, 10, 50);
        //$pdf->Image('', )
        // mencetak string 
        $pdf->Cell(45, 7, '', 0, 0, 'C');
        $pdf->Cell(290, 7, 'PUSKESMAS NUSAMANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 7, '', 0, 0, 'C');
        $pdf->Cell(330, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Barat, Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(250, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 440-20, 35);
        $pdf->Line(10,35.5, 440-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(250, 7, 'Laporan Data Pendaftaran', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Nomor Registrasi  ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nomor Rawat  ', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Nomor Rekam Medis  ', 1, 0, 'C');
        $pdf->Cell(75, 7, 'Nama Pasien  ', 1, 0, 'C');
        $pdf->Cell(49, 7, 'Tanggal Daftar  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nama Dokter  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nama Poli  ', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Status Pasien  ', 1, 0, 'C');
        $pdf->Cell(50, 7, 'No BPJS  ', 1, 1, 'C');


        



        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->no_registrasi, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->no_rawat, 1, 0, 'C');
        $pdf->Cell(55, 7, $r->no_rekamedis, 1, 0, 'C');
        $pdf->Cell(75, 7, $r->nama_pasien, 1, 0, 'C');
        $pdf->Cell(49, 7, date('d-m-Y', strtotime($r->tanggal_daftar)), 1, 0, 'C');
        $pdf->Cell(30, 7, $r->nama_dokter, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->nama_poli, 1, 0, 'C');
        $pdf->Cell(35, 7, $r->status_pasien, 1, 0, 'C');
        $pdf->Cell(50, 7, $r->no_bpjs, 1, 1, 'C');
        
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(215, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }

function cetakbulan(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
    $sql_data_resep = "SELECT pd.*, pol.nama_poli, dok.nama_dokter, pas.nama_pasien FROM tbl_pendaftaran as pd, tbl_poli as pol, tbl_dokter as dok, tbl_pasien as pas where pd.kode_dokter_penanggung_jawab=dok.kode_dokter AND pd.id_poli=pol.id_poli AND pd.no_rekamedis=pas.no_rekamedis AND MONTH(pd.tanggal_daftar)=MONTH(NOW()) order by pd.no_rawat asc";

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', array(430,380));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.png', 20, 10, 50);
        //$pdf->Image('', )
        // mencetak string 
        $pdf->Cell(45, 7, '', 0, 0, 'C');
        $pdf->Cell(290, 7, 'PUSKESMAS NUSAMANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 7, '', 0, 0, 'C');
        $pdf->Cell(330, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Bar., Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(250, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 440-20, 35);
        $pdf->Line(10,35.5, 440-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(250, 7, 'Laporan Data Pendaftaran Bulan Ini', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Nomor Registrasi  ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nomor Rawat  ', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Nomor Rekam Medis  ', 1, 0, 'C');
        $pdf->Cell(75, 7, 'Nama Pasien  ', 1, 0, 'C');
        $pdf->Cell(49, 7, 'Tanggal Daftar  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nama Dokter  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nama Poli  ', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Status Pasien  ', 1, 0, 'C');
        $pdf->Cell(50, 7, 'No BPJS  ', 1, 1, 'C');


        



        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->no_registrasi, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->no_rawat, 1, 0, 'C');
        $pdf->Cell(55, 7, $r->no_rekamedis, 1, 0, 'C');
        $pdf->Cell(75, 7, $r->nama_pasien, 1, 0, 'C');
        $pdf->Cell(49, 7, date('d-m-Y', strtotime($r->tanggal_daftar)), 1, 0, 'C');
        $pdf->Cell(30, 7, $r->nama_dokter, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->nama_poli, 1, 0, 'C');
        $pdf->Cell(35, 7, $r->status_pasien, 1, 0, 'C');
        $pdf->Cell(50, 7, $r->no_bpjs, 1, 1, 'C');
        
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(215, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }

    function cetakbulan1(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
     
      $sql_data_resep = "SELECT pd.*, pol.nama_poli, dok.nama_dokter, pas.nama_pasien FROM tbl_pendaftaran as pd, tbl_poli as pol, tbl_dokter as dok, tbl_pasien as pas where pd.kode_dokter_penanggung_jawab=dok.kode_dokter AND pd.id_poli=pol.id_poli AND pd.no_rekamedis=pas.no_rekamedis AND MONTH(pd.tanggal_daftar)=MONTH(NOW()) order by pd.no_rawat asc";

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
        $pdf->Cell(270, 7, 'Jl. Kamal Raya No.18, RT.6/RW.3, Cengkareng Bar., Kecamatan Cengkareng, Kota Jakarta Barat', 0, 1, 'C');
        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Telepon : (1234) 4218872. E-mail: puskesnuri@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 370-20, 35);
        $pdf->Line(10,35.5, 370-20, 35.5);
        
        $pdf->Cell(30, 7, '', 0, 1);

        $pdf->Cell(70, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, 'Laporan Data Pendaftaran Bulan Ini', 0, 1, 'C');




        //tabel hasil rekam medik
        $pdf->Cell(10,7, '',0,0,'C');
        $pdf->Cell(40, 7, 'Nomor Registrasi  ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nomor Rawat  ', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Nomor Rekam Medis  ', 1, 0, 'C');
        $pdf->Cell(75, 7, 'Nama Pasien  ', 1, 0, 'C');
        $pdf->Cell(49, 7, 'Tanggal Daftar  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nama Dokter  ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nama Poli  ', 1, 1, 'C');
        



        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(10,7, '',0,0,'C');
        $pdf->Cell(40, 7, $r->no_registrasi, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->no_rawat, 1, 0, 'C');
        $pdf->Cell(55, 7, $r->no_rekamedis, 1, 0, 'C');
        $pdf->Cell(75, 7, $r->nama_pasien, 1, 0, 'C');
        $pdf->Cell(49, 7, date('d-m-Y', strtotime($r->tanggal_daftar)), 1, 0, 'C');
        $pdf->Cell(30, 7, $r->nama_dokter, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->nama_poli, 1, 1, 'C');
        
        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(110, 10, '', 0, 0);
        $pdf->Cell(155, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }

  function cetakantrian($id){

        
        $sql_pasien = $this->Tbl_pendaftaran_model->get_by_id($id);
        $this->load->library('pdf');
        $pdf = new FPDF();
        $pdf->AddPage('P','A4');

        $tgl=date('Y/m/d');
        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/latar-kartu.png',5,5,100,56);
        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.png',10,9,10,10);
        $pdf->setFont('Arial','B',12);
        $pdf->Cell(90,5,'PUSKESMAS WADAS',0,0,'C');
        $pdf->Cell(10,5,'',0,0,'C');
        $pdf->setFont('Arial','B',10);
        $pdf->Cell(90,5,'',0,1,'C');
        $pdf->setFont('Arial','B',8);
        $pdf->Cell(90,5,'Jl.Pintu Air, Sindangsari, Wadas No.17',0,0,'C');
        $pdf->Cell(10,5,'',0,0,'C');
        $pdf->setFont('Arial','',7);
        $pdf->Cell(90,5,'',0,1,'L');
        $pdf->SetLineWidth(0.2);
        $pdf->Line(10,20,100,20);
        $pdf->setFont('Arial','B',10);
        $pdf->Cell(90,5,'KARTU ANTRIAN',0,0,'C');
        $pdf->Cell(10,5,'',0,0,'C');
        $pdf->setFont('Arial','',7);
        $pdf->Cell(90,5,'',0,1,'L');
        $pdf->SetLineWidth(0.2);
        $pdf->Line(10,25,100,25);
        $pdf->Ln(6);
        
        $pdf->setFont('Arial','',10);
        $pdf->Cell(60, 4, '', 0, 1);
        $pdf->Cell(22,4,'No. Rawat',0,0,'L');
        $pdf->Cell(36,4,': '.$sql_pasien->no_rawat,0,0,'L');
        $pdf->Cell(10,4,'',0,1,'C');
        $pdf->Cell(22,4,'No. Antrian',0,0,'L');
        $pdf->Cell(36,4,': '.$sql_pasien->no_registrasi,0,0,'L');
        $pdf->Cell(10,4,'',0,1,'C');
        $pdf->setFont('Arial','',10);
        $pdf->Cell(22,4,'Nama Pasien',0,0,'L');
        $pdf->Cell(36,4,': '.$sql_pasien->nama_pasien,0,1,'L');
        $pdf->Ln(2);

        $pdf->Output('cetak-kartu-berobat.pdf','I');

            
        }

    public function read() 
    {

        $row = $this->Tbl_pendaftaran_model->get_by_id($id);
        if ($row) {
            $data = array(
        'no_registrasi' => $row->no_registrasi,
        'no_rawat' => $row->no_rawat,
        'no_rekamedis' => $row->no_rekamedis,
        'tanggal_daftar' => $row->tanggal_daftar,
        'kode_dokter_penanggung_jawab' => $row->kode_dokter_penanggung_jawab,
        'id_poli' => $row->id_poli,
        'nama_penanggung_jawab' => $row->nama_penanggung_jawab,
        'hubungan_dengan_penanggung_jawab' => $row->hubungan_dengan_penanggung_jawab,
        'alamat_penanggung_jawab' => $row->alamat_penanggung_jawab,
        );
            $this->template->load('template','pendaftaran/tbl_pendaftaran_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pendaftaran'));
        }
    }

    function autocompleteDokter() {
        $this->db->like('nama_dokter', $_GET['term']);
        $this->db->select('nama_dokter');
        $datadokter = $this->db->get('tbl_dokter')->result();
        foreach ($datadokter as $dokter) {
            $return_arr[] = $dokter->nama_dokter;
        }

        echo json_encode($return_arr);
    }

    

     function autocompletePenyakit() {
        $this->db->like('nama_penyakit', $_GET['term']);
        $this->db->select('nama_penyakit');
        $datapenyakit = $this->db->get('tbl_diagnosa_penyakit')->result();
        foreach ($datapenyakit as $penyakit) {
            $return_arr[] = $penyakit->nama_penyakit;
        }

        echo json_encode($return_arr);
    }

    function PenyakitAuto() {
       autocomplate_json('tbl_diagnosa_penyakit', 'nama_penyakit');

        }

     function autocompletemedicine() {
       autocomplate_json('tbl_obat', 'nama_obat');

        }

        
    

    function autocomplate(){
        autocomplate_json('tbl_obat', 'nama_obat');
    }

    //function autoobat(){
     //   autocomplate_json('tbl_obat', 'nama_obat');
   // }

     function autocompleteTindakan() {
        $this->db->like('nama_tindakan', $_GET['term']);
        $this->db->select('nama_tindakan');
        $datatindakan = $this->db->get('tbl_tindakan')->result();
        foreach ($datatindakan as $tindakan) {
            $return_arr[] = $tindakan->nama_tindakan;
        }

        echo json_encode($return_arr);
    }

    function autocompletePoli() {
        $this->db->like('nama_poli', $_GET['term']);
        $this->db->select('nama_poli');
        $datapoli = $this->db->get('tbl_poli')->result();
        foreach ($datapoli as $poli) {
            $return_arr[] = $poli->nama_poli;
        }

        echo json_encode($return_arr);
    }
   function autonorekamedis(){

         $this->db->like('no_rekamedis', $_GET['term']);
        $this->db->select('no_rekamedis');
        $datapasien = $this->db->get('tbl_pasien')->result();
        foreach ($datapasien as $pasien) {
            $return_array[] = $pasien->no_rekamedis;
        }

        echo json_encode($return_array);   
   }

   function autofill(){

    $no_rekamedis = $_GET['no_rekamedis'];

    $this->db->where('no_rekamedis',$no_rekamedis);

    $pasien = $this->db->get('tbl_pasien')->row_array();
    $data = array(

        'nama_pasien' => $pasien['nama_pasien'],
        'no_bpjs' => $pasien['no_bpjs'],
        'tanggal_lahir' => date('d-m-Y',strtotime($pasien['tanggal_lahir']))
        );

    echo json_encode($data);
   }

    function autofillobat(){

    $nama_obat = $_GET['nama_obat'];

    $this->db->where('nama_obat',$nama_obat);

    $obat = $this->db->get('tbl_obat')->row_array();

    $data = array(
        'jenis_obat' => $obat['jenis_obat'],
        'dosis_aturan_obat' => $obat['dosis_aturan_obat']
        );

    echo json_encode($data);
   }



   function periksa_action(){

        $no_rawat = $this->input->post('no_rawat');
        $no_rekamedis = $this->input->post('no_rekamedis');
        $nama_poli = $this->input->post('nama_poli');
        $poli = $this->db->get_where('tbl_poli',array('nama_poli' => $nama_poli))->row_array();
        $nama_penyakit = $this->input->post('nama_penyakit');
        $penyakit = $this->db->get_where('tbl_diagnosa_penyakit', array('nama_penyakit' => $nama_penyakit))->row_array();
        $nama_dokter = $this->input->post('nama_dokter');
        $dokter = $this->db->get_where('tbl_dokter', array('nama_dokter' => $nama_dokter))->row_array();
        $nama_tindakan = $this->input->post('nama_tindakan');
        $tindakan = $this->db->get_where('tbl_tindakan', array('nama_tindakan' => $nama_tindakan))->row_array();
        $hasil_periksa = $this->input->post('hasil_periksa');
        $nama_obat = $this->input->post('nama_obat');

        $data = array(
            'no_rawat' => $no_rawat,
            'no_rekamedis' => $no_rekamedis,
            'id_poli' => $poli['id_poli'],
            'kode_penyakit' => $penyakit['kode_diagnosa'],
            'kode_tindakan' => $tindakan['kode_tindakan'],
            'hasil_periksa' => $hasil_periksa,
            'nama_obat' => $nama_obat,
            'tanggal' => date('d-m-Y')
           );

        $this->db->insert('tbl_riwayat_tindakan', $data);
        $id_riwayat_tindakan = $this->db->insert_id();

        redirect('pendaftaran/detail/'.$no_rawat);

   }

   function resep_action(){

    $no_rawat = $this->input->post('no_rawat');
    $sql_daftar = "SELECT pd.no_rekamedis, pd.no_rawat,ps.nama_pasien FROM tbl_pendaftaran as pd, tbl_pasien as ps WHERE pd.no_rekamedis = ps.no_rekamedis and pd.no_rawat = '$no_rawat'";
    $data['pendaftaran'] = $this->db->query($sql_daftar)->row_array();

    $kode_resep = $this->input->post('kode_resep');
    $nama_obat = $this->input->post('nama_obats');
    $obat = $this->db->get_where('tbl_obat', array('nama_obat' => $nama_obat))->row_array();
    $jenis_obat = $this->input->post('jenis_obat');
    $obatj = $this->db->get_where('tbl_obat', array('jenis_obat' => $jenis_obat))->row_array();
    $dosis_aturan_obat = $this->input->post('dosis_aturan_obat');
    $jumlah_obat = $this->input->post('jumlah_obat');
    $obatd = $this->db->get_where('tbl_obat', array('dosis_aturan_obat' => $dosis_aturan_obat))->row_array();
    $no_rekamedis = $this->input->post('no_rekamedis');

    $data = array(
        'kode_resep' => $kode_resep,
        'nama_obat' => $nama_obat,
        'jenis_obat' => $jenis_obat,
        'dosis_aturan_obat' => $dosis_aturan_obat,
        'jumlah_obat' => $jumlah_obat,
        'no_rawat' => $no_rawat,
        'no_rekamedis' => $no_rekamedis,
        'tanggal' => date('Y-m-d')
        );
    $this->db->insert('tbl_resep_obat', $data);
    redirect('pendaftaran/detail/'.$no_rawat);
   }

   function rujukan_action(){

    $no_rawat = $this->input->post('no_rawat');
   

    $kode_rujukan = $this->input->post('kode_rujukan');
    $no_rujukan = $this->input->post('no_rujukan');
    $nama_pasien = $this->input->post('nama_pasien');
    $nama_penyakit = $this->input->post('nama_penyakitz');
    $diagnosa = $this->input->post('diagnosa');
    $nama_rumah_sakit = $this->input->post('nama_rumah_sakit');
    $poli_tujuan = $this->input->post('poli_tujuan');

   
    $data = array(
        'kode_rujukan' => $kode_rujukan,
        'no_rujukan' => $no_rujukan,
        'nama_pasien' => $nama_pasien,
        'nama_penyakit' => $nama_penyakit,
        'diagnosa' => $diagnosa,
        'nama_rumah_sakit' => $nama_rumah_sakit,
        'poli_tujuan' => $poli_tujuan,
        'tgl_rujukan' => date('Y-m-d'),
        'no_rawat' => $no_rawat
        );
    $this->db->insert('tbl_rujukan', $data);
    redirect('pendaftaran/detail/'.$no_rawat);
   }

    public function create() 
    {
        $noreg = noRegistrasiotomatis();
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('pendaftaran/create_action'),
        'no_registrasi' => set_value('no_registrasi', $noreg),
        'no_rawat' => set_value('no_rawat'),
        'no_rekamedis' => set_value('no_rekamedis'),
        'tanggal_daftar' => set_value('tanggal_daftar'),
        'kode_dokter_penanggung_jawab' => set_value('kode_dokter_penanggung_jawab'),
        'id_poli' => set_value('id_poli'),
        'nama_penanggung_jawab' => set_value('nama_penanggung_jawab'),
        'hubungan_dengan_penanggung_jawab' => set_value('hubungan_dengan_penanggung_jawab'),
        'alamat_penanggung_jawab' => set_value('alamat_penanggung_jawab'),
        'status_pasien' => set_value('status_pasien'),
        'no_bpjs' => set_value('no_bpjs')

    );
        $this->template->load('template','pendaftaran/tbl_pendaftaran_form', $data);
    }

    function cetakrekamedis(){

        $no_rawat = substr($this->uri->uri_string(3), 27);
      $sql_daftar = "SELECT pd.no_rekamedis, pd.no_rawat,pd.tanggal_daftar,ps.nama_pasien, td.nama_dokter FROM tbl_pendaftaran as pd, tbl_pasien as ps, tbl_dokter as td WHERE pd.no_rekamedis = ps.no_rekamedis and td.kode_dokter = pd.kode_dokter_penanggung_jawab and pd.no_rawat = '$no_rawat'";
      $sql_penyakit = "SELECT pd.no_rekamedis, pd.no_rawat,dg.nama_penyakit FROM tbl_pendaftaran as pd, tbl_diagnosa_penyakit as dg WHERE pd.no_rekamedis and pd.no_rawat = '$no_rawat'";
      $sql_poli_input_rekmed = "SELECT pd.no_rawat,pd.id_poli, p.nama_poli FROM tbl_pendaftaran as pd, tbl_poli as p WHERE pd.no_rawat = '$no_rawat' AND pd.id_poli = p.id_poli";
    
      $no_rekmed = $this->db->query($sql_daftar)->row()->no_rekamedis; //untuk proses pengambilan data atribut no_rekamedis (yang diambil hanya data atribut itu saja)
      $sql_data_tindakan = "SELECT rt.no_rawat,rt.no_rekamedis,rt.hasil_periksa,rt.nama_obat,rt.tanggal,p.nama_poli, pkt.nama_penyakit, t.nama_tindakan FROM tbl_riwayat_tindakan as rt, tbl_tindakan as t, tbl_poli as p, tbl_diagnosa_penyakit as pkt, tbl_pasien as pas WHERE pas.no_rekamedis = '$no_rekmed' AND rt.no_rekamedis = '$no_rekmed' AND rt.kode_tindakan = t.kode_tindakan AND rt.id_poli = p.id_poli AND rt.kode_penyakit = pkt.kode_diagnosa";
      $sql_daftare = "SELECT pd.no_rekamedis, pd.no_rawat,ps.nama_pasien FROM tbl_pendaftaran as pd, tbl_pasien as ps WHERE pd.no_rekamedis = ps.no_rekamedis and pd.no_rawat = '$no_rawat'";

      

    $sql_rekamedis    = "SELECT tr.*,pd.no_rawat,pd.tanggal_daftar 
                        FROM tbl_riwayat_tindakan as tr, tbl_pendaftaran as pd
                        WHERE pd.no_rawat and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('P', 'mm', array(260,260));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Image('http://localhost/puskesmas/assets/foto_profil/logo-rs.jpg', 22, 5, 30);
        //$pdf->Image('', a)
        // mencetak string 
        $pdf->Cell(235, 7, 'PUSKESMAS WADAS', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(235, 7, '          Jl. Pintu Air,Kp. Sindangsari, Desa Wadas No.17, Telukjambe Timur, Karawang.', 0, 1, 'C');
        $pdf->Cell(235, 7, 'Telepon : (0267) 4218872. E-mail: puskeswadas@gmail.com', 0, 1, 'C');
        $pdf->Line(10,35, 260-10, 35);
        $pdf->Line(10,35.5, 260-10, 35.5);
        $pdf->Cell(7, 7, '', 0, 1);
        $pdf->Cell(235, 7, 'Laporan Rekam Medis', 0, 1, 'C');


        //data rekam medik
        $pasien = $this->db->query($sql_daftar)->row_array();
        $pdf->Cell(30, 7, '', 0, 0, 'L');        
        $pdf->Cell(30, 7, 'No.RM', 0, 0, 'L');
        $pdf->Cell(90, 7, ': '.$pasien['no_rekamedis'], 0, 0, 'L'); //90 merupakan jarak antara no_rekamedis dengan isian ditangani oleh

        $pdf->Cell(45, 7, 'Ditangani Oleh', 0, 0, 'L');
        $pdf->Cell(30, 7, ': '.$pasien['nama_dokter'], 0, 1, 'L');
        $pdf->Cell(30, 7, '', 0, 0, 'L');        
        $pdf->Cell(30, 7, 'Nama Pasien', 0, 0, 'L');
        $pdf->Cell(90, 7, ': '.$pasien['nama_pasien'], 0, 0, 'L');

        $pdf->Cell(45, 7, 'Tgl. Pemeriksaan', 0, 0, 'L');
        $pdf->Cell(30, 7, ': '.date('d-m-Y', strtotime($pasien['tanggal_daftar'])) ,0, 1, 'L');
        $pdf->Cell(10, 10, '', 0, 1);


        //tabel hasil rekam medik
        $pdf->Cell(30, 7, 'Poli Tujuan', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nama Penyakit', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nama Tindakan', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Hasil Periksa', 1, 0, 'C');
        $pdf->Cell(39, 7, 'Nama Obat', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Tanggal', 1, 1, 'C');


        $tindakan = $this->db->query($sql_data_tindakan)->result();
        foreach ($tindakan as $t) {
           
        $pdf->Cell(30, 7, $t->nama_poli, 1, 0, 'C');
        $pdf->Cell(45, 7, $t->nama_penyakit, 1, 0, 'C');
        $pdf->Cell(45, 7, $t->nama_tindakan, 1, 0, 'C');
        $pdf->Cell(40, 7, $t->hasil_periksa, 1, 0, 'C');
        $pdf->Cell(39, 7, $t->nama_obat, 1, 0, 'C');
        $pdf->Cell(45, 7, date('d-m-Y', strtotime($t->tanggal)), 1, 1, 'C');

        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(30, 7, '', 0, 0, 'L');        
        $pdf->Cell(155, 10, 'Tanggal Cetak', 0, 0, 'R');
        $pdf->Cell(43, 10, ': '.date('d-m-Y '), 0, 0, 'R');


        $pdf->Output();
    }

    function cetakresepobat(){

    $no_rawat = substr($this->uri->uri_string(3), 27);
      $sql_daftar = "SELECT pd.no_rekamedis, pd.no_rawat,pd.tanggal_daftar,ps.nama_pasien, td.nama_dokter FROM tbl_pendaftaran as pd, tbl_pasien as ps, tbl_dokter as td WHERE pd.no_rekamedis = ps.no_rekamedis and td.kode_dokter = pd.kode_dokter_penanggung_jawab and pd.no_rawat = '$no_rawat'";
      $sql_penyakit = "SELECT pd.no_rekamedis, pd.no_rawat,dg.nama_penyakit FROM tbl_pendaftaran as pd, tbl_diagnosa_penyakit as dg WHERE pd.no_rekamedis and pd.no_rawat = '$no_rawat'";
      $sql_poli_input_rekmed = "SELECT pd.no_rawat,pd.id_poli, p.nama_poli FROM tbl_pendaftaran as pd, tbl_poli as p WHERE pd.no_rawat = '$no_rawat' AND pd.id_poli = p.id_poli";
      $sql_data_resep = "SELECT rt.nama_obat, rt.jenis_obat,rt.dosis_aturan_obat,rt.jumlah_obat,rt.no_rawat,rt.tanggal, pkt.nama_pasien FROM tbl_resep_obat as rt, tbl_pasien as pkt WHERE rt.no_rawat = '$no_rawat' AND rt.no_rekamedis = pkt.no_rekamedis";

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
        //$pdf->Image('', )
        // mencetak string 
        $pdf->Cell(190, 7, 'PUSKESMAS WADAS', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 7, '          Jl. Pintu Air,Kp. Sindangsari, Desa Wadas No.17, Telukjambe Timur, Karawang.', 0, 1, 'C');
        $pdf->Cell(190, 7, 'Telepon : (0267) 4218872. E-mail: puskeswadas@gmail.com', 0, 1, 'C');
        $pdf->Line(20,35, 210-20, 35);
        $pdf->Line(20,35.5, 210-20, 35.5);
        
        $pdf->Cell(7, 7, '', 0, 1);
        $pdf->Cell(190, 7, 'Laporan Resep Obat', 0, 1, 'C');


        //data rekam medik
        $pasien = $this->db->query($sql_daftar)->row_array();
        $pdf->Cell(30, 7, 'Nama Pasien', 0, 0, 'L');
        $pdf->Cell(110, 7, ': '.$pasien['nama_pasien'], 0, 0, 'L');

        $pdf->Cell(30, 7, 'Tanggal', 0, 0, 'L');
        $pdf->Cell(30, 7, ': '.date('d-m-Y') ,0, 1, 'L');
        $pdf->Cell(10, 10, '', 0, 1);


        //tabel hasil rekam medik
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(35, 7, 'Nama Obat : ', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Jenis Obat : ', 1, 0, 'C');
        $pdf->Cell(75, 7, 'Dosis Obat : ', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Jumlah Obat : ', 1, 1, 'C');



        $resep = $this->db->query($sql_data_resep)->result();
        foreach ($resep as $r) {
        $pdf->Cell(1,7, '',0,0,'C');
        $pdf->Cell(35, 7, $r->nama_obat, 1, 0, 'C');
        $pdf->Cell(45, 7, $r->jenis_obat, 1, 0, 'C');
        $pdf->Cell(75, 7, $r->dosis_aturan_obat, 1, 0, 'C');
        $pdf->Cell(30, 7, $r->jumlah_obat, 1, 1, 'C');


        }


        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(130, 10, '', 0, 1);
        $pdf->Cell(155, 10, 'Waktu Cetak', 0, 0, 'R');
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
        $pdf->Cell(30, 7, ': '.date('d-m-Y'), 0, 1, 'L');

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
        $pdf->Cell(43, 10, ': '.date('d-m-Y'), 0, 0, 'R');


        $pdf->Output();
    }

    function getKodeDokter($namaDokter){

        $this->db->where('nama_dokter',$namaDokter);
        $dokter = $this->db->get('tbl_dokter')->row_array();
        return $dokter['kode_dokter'];
    }
    
    public function create_action() 
    {

        $tanggal_daftar = $this->input->post('tanggal_daftar',TRUE);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        'no_rawat' => $this->input->post('no_rawat', TRUE),
        'no_registrasi' => $this->input->post('no_registrasi',TRUE),
        'no_rekamedis' => $this->input->post('no_rekamedis',TRUE),
        'tanggal_daftar' => $this->input->post('tanggal_daftar',TRUE),
        'kode_dokter_penanggung_jawab' =>  $this->getKodeDokter($this->input->post('kode_dokter_penanggung_jawab',TRUE)),
        'id_poli' => $this->input->post('id_poli',TRUE),
        'nama_penanggung_jawab' => $this->input->post('nama_penanggung_jawab',TRUE),
        'hubungan_dengan_penanggung_jawab' => $this->input->post('hubungan_dengan_penanggung_jawab',TRUE),
        'alamat_penanggung_jawab' => $this->input->post('alamat_penanggung_jawab',TRUE),
        'status_pasien' => $this->input->post('status_pasien',TRUE),
        'no_bpjs' => $this->input->post('no_bpjs',TRUE),


        );

            $this->Tbl_pendaftaran_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Masuk
            </div>');  
            redirect(site_url('pendaftaran'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_pendaftaran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pendaftaran/update_action'),
        'no_registrasi' => set_value('no_registrasi', $row->no_registrasi),
        'no_rawat' => set_value('no_rawat', $row->no_rawat),
        'no_rekamedis' => set_value('no_rekamedis', $row->no_rekamedis),
        'tanggal_daftar' => set_value('tanggal_daftar', $row->tanggal_daftar),
        'kode_dokter_penanggung_jawab' => set_value('kode_dokter_penanggung_jawab', $row->kode_dokter_penanggung_jawab),
        'id_poli' => set_value('id_poli', $row->id_poli),
        'nama_penanggung_jawab' => set_value('nama_penanggung_jawab', $row->nama_penanggung_jawab),
        'hubungan_dengan_penanggung_jawab' => set_value('hubungan_dengan_penanggung_jawab', $row->hubungan_dengan_penanggung_jawab),
        'alamat_penanggung_jawab' => set_value('alamat_penanggung_jawab', $row->alamat_penanggung_jawab),
        );
            $this->template->load('template','pendaftaran/tbl_pendaftaran_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pendaftaran'));
        }
    }
    
    public function update_action() 
    {
        
      $tanggal_daftar =  $this->input->post('tanggal_daftar',TRUE);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('no_rawat', TRUE));
        } else {
            $data = array(
        'no_registrasi' => $this->input->post('no_registrasi',TRUE),
        'no_rekamedis' => $this->input->post('no_rekamedis',TRUE),
        'tanggal_daftar' => date('d-m-Y', strtotime($tanggal_daftar)),
        'kode_dokter_penanggung_jawab' => $this->input->post('kode_dokter_penanggung_jawab',TRUE),
        'id_poli' => $this->input->post('id_poli',TRUE),
        'nama_penanggung_jawab' => $this->input->post('nama_penanggung_jawab',TRUE),
        'hubungan_dengan_penanggung_jawab' => $this->input->post('hubungan_dengan_penanggung_jawab',TRUE),
        'alamat_penanggung_jawab' => $this->input->post('alamat_penanggung_jawab',TRUE),
        );

            $this->Tbl_pendaftaran_model->update($this->input->post('no_rawat', TRUE), $data);
             $this->session->set_flashdata('message', '<div class="alert alert-info">Data Berhasil Diupdate
            </div>');       
            redirect(site_url('pendaftaran'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_pendaftaran_model->get_by_id($id);

        if ($row) {
            $this->Tbl_pendaftaran_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data Berhasil Dihapus
            </div>');  
            redirect(site_url('pendaftaran'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pendaftaran'));
        }
    }

    public function _rules() 
    {
    $this->form_validation->set_rules('no_registrasi', 'no registrasi', 'trim|required');
    $this->form_validation->set_rules('no_rekamedis', 'no rekamedis', 'trim|required');
    $this->form_validation->set_rules('no_rawat', 'no rawat', 'trim|required');
    $this->form_validation->set_rules('tanggal_daftar', 'tanggal daftar', 'trim|required');
    $this->form_validation->set_rules('kode_dokter_penanggung_jawab', 'kode dokter penanggung jawab', 'trim|required');
    $this->form_validation->set_rules('id_poli', 'id poli', 'trim|required');
    $this->form_validation->set_rules('nama_penanggung_jawab', 'nama penanggung jawab', 'trim|required');
    $this->form_validation->set_rules('hubungan_dengan_penanggung_jawab', 'hubungan dengan penanggung jawab', 'trim|required');
    $this->form_validation->set_rules('alamat_penanggung_jawab', 'alamat penanggung jawab', 'trim|required');
    $this->form_validation->set_message('required', '{field} wajib diisi');


    $this->form_validation->set_rules('no_rawat', 'no_rawat', 'trim');
    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_pendaftaran.xls";
        $judul = "tbl_pendaftaran";
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
    xlsWriteLabel($tablehead, $kolomhead++, "No Registrasi");
    xlsWriteLabel($tablehead, $kolomhead++, "No Rekamedis");
    xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Daftar");
    xlsWriteLabel($tablehead, $kolomhead++, "Kode Dokter Penanggung Jawab");
    xlsWriteLabel($tablehead, $kolomhead++, "Id Poli");
    xlsWriteLabel($tablehead, $kolomhead++, "Nama Penanggung Jawab");
    xlsWriteLabel($tablehead, $kolomhead++, "Hubungan Dengan Penanggung Jawab");
    xlsWriteLabel($tablehead, $kolomhead++, "Alamat Penanggung Jawab");

    foreach ($this->Tbl_pendaftaran_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
        xlsWriteLabel($tablebody, $kolombody++, $data->no_registrasi);
        xlsWriteLabel($tablebody, $kolombody++, $data->no_rekamedis);
        xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_daftar);
        xlsWriteNumber($tablebody, $kolombody++, $data->kode_dokter_penanggung_jawab);
        xlsWriteLabel($tablebody, $kolombody++, $data->id_poli);
        xlsWriteLabel($tablebody, $kolombody++, $data->nama_penanggung_jawab);
        xlsWriteLabel($tablebody, $kolombody++, $data->hubungan_dengan_penanggung_jawab);
        xlsWriteLabel($tablebody, $kolombody++, $data->alamat_penanggung_jawab);

        $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_pendaftaran.doc");

        $data = array(
            'tbl_pendaftaran_data' => $this->Tbl_pendaftaran_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('pendaftaran/tbl_pendaftaran_doc',$data);
    }

}

