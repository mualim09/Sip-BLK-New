<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model
{

    public $table = 'users';
    public $id = 'id_users';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->join('level', 'level.id_level = users.id_level', 'left');
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();

        // $query=$this->db->query("SELECT * FROM users WHERE level<>'1'");
        // return query;
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->join('level', 'level.id_level = users.id_level', 'left');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    function cek_email($email){
        $this->db->select('email');
        $this->db->where('email', $email);
        return $this->db->get($this->table)->row();

        // $sql = $this->db->query("SELECT email FROM users where email='$email'");
        // $cek = $sql->num_rows();
    }

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_users', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('password', $q);
	$this->db->or_like('id_level', $q);
	$this->db->or_like('status', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->join('level','level.id_level = users.id_level');
        $this->db->where('users.id_level != 1');
        $this->db->like('id_users', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('password', $q);
        $this->db->or_like('users.id_level', $q);
        $this->db->or_like('status', $q);
        $this->db->limit($limit, $start);
        $this->db->order_by($this->id, $this->order);
        return $this->db->get()->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
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

    function verifikasi($id){
        $this->db->set('status', 'Aktif');
        $this->db->where($this->id, $id);
        return $this->db->update($this->table);
    }
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-11-10 08:21:32 */
/* http://harviacode.com */