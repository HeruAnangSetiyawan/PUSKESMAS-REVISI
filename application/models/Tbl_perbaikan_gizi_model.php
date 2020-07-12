<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_perbaikan_gizi_model extends CI_Model
{

    public $table = 'tbl_perbaikan_gizi';
    public $id = 'id_gizi';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_gizi,nama_anak,nama_tindakan,nama_obat,jumlah,satuan,tanggal');
        $this->datatables->from('tbl_perbaikan_gizi');
        //add this line for join
        //$this->datatables->join('table2', 'tbl_perbaikan_gizi.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('perbaikangizi/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_gizi');
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
        $this->db->like('id_gizi', $q);
	$this->db->or_like('nama_anak', $q);
	$this->db->or_like('nama_tindakan', $q);
	$this->db->or_like('nama_obat', $q);
	$this->db->or_like('jumlah', $q);
	$this->db->or_like('satuan', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_gizi', $q);
	$this->db->or_like('nama_anak', $q);
	$this->db->or_like('nama_tindakan', $q);
	$this->db->or_like('nama_obat', $q);
	$this->db->or_like('jumlah', $q);
	$this->db->or_like('satuan', $q);
	$this->db->or_like('tanggal', $q);
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

