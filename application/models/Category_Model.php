<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Count only non-deleted categories
    public function countAll()
    {
        $this->db->where('isDeleted', 0);
        return $this->db->count_all_results('categories');
    }

    // Get all non-deleted categories
    public function getAll($orderBy = "category_name", $orderFormat = "ASC", $start = 0, $limit = 10)
    {
        $this->db->select("categories.*, manufacturers.mnf_name");
        $this->db->from("categories");
        $this->db->join("manufacturers", "manufacturers.id = categories.mnfId");
        $this->db->where("categories.isDeleted", 0);
        $this->db->order_by($orderBy, $orderFormat);
        $this->db->limit($limit, $start);

        $query = $this->db->get();
        return $query->result();
    }


    // Add a new category
    public function add($data)
    {
        return $this->db->insert('categories', $data) ? $this->db->insert_id() : false;
    }

    // Update category details
    public function edit($id, $data)
    {
        $this->db->where('id', $id)->update('categories', $data);

        return $this->db->affected_rows() > 0 || $this->db->where('id', $id)->count_all_results('categories') > 0;
    }


    // Soft delete a category
    public function delete($id)
    {
        $this->db->where('id', $id)->set('isDeleted', 1)->update('categories');
        return $this->db->affected_rows() > 0;
    }


    // Get category details by ID
    public function getById($id)
    {
        $query = $this->db->where('id', $id)->get('categories');
        return $query->row() ?: false;
    }

    // Search categories by name or description
    public function search($value)
    {
        $this->db->select("categories.*, manufacturers.mnf_name");
        $this->db->from("categories");
        $this->db->join("manufacturers", "manufacturers.id = categories.mnfId");
        $this->db->group_start()
            ->like('category_name', $value)
            ->or_like('category_description', $value)
            ->or_like('manufacturers.mnf_name', $value)
            ->group_end();
        $this->db->where("categories.isDeleted", 0);

        $query = $this->db->get();
        return $query->result();
    }
}
