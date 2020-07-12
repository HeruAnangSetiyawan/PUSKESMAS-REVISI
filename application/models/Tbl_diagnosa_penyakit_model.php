<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_diagnosa_penyakit_model extends CI_Model
{

    public $table = 'tbl_diagnosa_penyakit';
    public $id = 'kode_diagnosa';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('kode_diagnosa,nama_penyakit,ciri_ciri_penyakit,keterangan,ciri_ciri_umum');
        $this->datatables->from('tbl_diagnosa_penyakit');
        //add this line for join
        //$this->datatables->join('table2', 'tbl_diagnosa_penyakit.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('diagnosa/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('diagnosa/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kode_diagnosa');
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
        $this->db->like('kode_diagnosa', $q);
	$this->db->or_like('nama_penyakit', $q);
	$this->db->or_like('ciri_ciri_penyakit', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('ciri_ciri_umum', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kode_diagnosa', $q);
	$this->db->or_like('nama_penyakit', $q);
	$this->db->or_like('ciri_ciri_penyakit', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('ciri_ciri_umum', $q);
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

