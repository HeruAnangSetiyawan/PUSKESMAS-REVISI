<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_pengeluaran_obat_model extends CI_Model
{

    public $table = 'tbl_pengeluaran_obat';
    public $id = 'no_terima_obat';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_pengeluaran,no_terima_obat,nama_pasien,nama_obat,jenis_obat,jumlah,satuan,keterangan,tgl_serah_obat');
        $this->datatables->from('tbl_pengeluaran_obat');
        //add this line for join
        //$this->datatables->tbl('table2', 'tbl_pengeluaran_obat.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('pengeluaranobat/cetaklabel/$1'),'<i class="fa fa-print" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
            ".anchor(site_url('pengeluaranobat/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'no_terima_obat');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('no_terima_obat', $q);
	$this->db->or_like('id_pengeluaran', $q);
	$this->db->or_like('nama_pasien', $q);
	$this->db->or_like('kode_obat', $q);
	$this->db->or_like('nama_obat', $q);
	$this->db->or_like('jenis_obat', $q);
	$this->db->or_like('dosis_aturan_obat', $q);
	$this->db->or_like('jumlah', $q);
    $this->db->or_like('satuan', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('tgl_serah_obat', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('no_terima_obat', $q);
	$this->db->or_like('id_pengeluaran', $q);
	$this->db->or_like('nama_pasien', $q);
	$this->db->or_like('kode_obat', $q);
	$this->db->or_like('nama_obat', $q);
	$this->db->or_like('jenis_obat', $q);
	$this->db->or_like('dosis_aturan_obat', $q);
	$this->db->or_like('jumlah', $q);
    $this->db->or_like('satuan', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('tgl_serah_obat', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

