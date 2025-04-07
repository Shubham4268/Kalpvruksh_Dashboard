<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->genlib->checkLogin();
        // $this->genlib->superOnly(); 
        $this->load->model('Category_Model');
        $this->load->model('Manufacturer_model');
    }

    public function index()
    {
        $allManufacturers = $this->Manufacturer_model->getAll(); // Or just getAll() if unpaginated

        $categoryViewData = [
            'allManufacturers' => $allManufacturers
        ];
        $data = [
            'pageContent' => $this->load->view('category/category', $categoryViewData, TRUE),
            'pageTitle' => "Category"
        ];
        $this->load->view('main', $data);
    }

    public function loadCategoryList()
    {
        try {
            $this->genlib->ajaxOnly();

            $orderBy = $this->input->get('orderBy', TRUE) ?: "category_name";
            $orderFormat = $this->input->get('orderFormat', TRUE) ?: "ASC";
            $limit = (int) $this->input->get('limit', TRUE) ?: 10;
            $pageNumber = (int) $this->uri->segment(3, 0);
            $start = max(0, ($pageNumber - 1) * $limit);

            $totalItems = $this->Category_Model->countAll();
            $categories = $this->Category_Model->getAll($orderBy, $orderFormat, $start, $limit);

            if ($categories === false) {
                throw new Exception("Error fetching categories");
            }

            $this->load->library('pagination');
            $config = $this->genlib->setPaginationConfig($totalItems, "Category/loadCategoryList", $limit, ['onclick' => 'return loadCategoryList(this.href);']);
            $this->pagination->initialize($config);

            $data = [
                'categories' => $categories,
                'range' => $totalItems > 0 ? "Showing " . ($start + 1) . "-" . ($start + count($categories)) . " of " . $totalItems : "",
                'links' => $this->pagination->create_links(),
                'sn' => $start + 1
            ];

            $json['categoryListTable'] = $this->load->view('category/categorytable', $data, TRUE);
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
        } catch (Exception $e) {
            log_message('error', 'LMLT Error: ' . $e->getMessage());
            show_error('An error occurred while fetching data.', 500);
        }
    }

    public function add()
    {
        $this->genlib->ajaxOnly();
        $this->load->library('form_validation');

        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim|max_length[100]|is_unique[categories.category_name]');
        $this->form_validation->set_rules('category_description', 'Description', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('mnfId', 'Manufacturer', 'required|numeric');

        if ($this->form_validation->run()) {
            $data = $this->input->post(NULL, TRUE);
            $data['adminId'] = $this->session->admin_id;

            $insertedId = $this->Category_Model->add($data);

            $json = $insertedId
                ? ['status' => 1, 'msg' => "Category successfully added"]
                : ['status' => 0, 'msg' => "Unexpected server error! Please try again."];
        } else {
            // Return specific field errors for display in form
            $json = [
                'status' => 0,
                'msg' => 'Please correct the errors below.',
                'category_name' => form_error('category_name'),
                'category_description' => form_error('category_description'),
                'mnfId' => form_error('mnfId')
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }


    public function edit()
    {
        $this->genlib->ajaxOnly();
        $this->load->library('form_validation');

        // Validation rules
        $fields = [
            ['id', 'Category ID', 'required|trim|numeric'],
            ['category_name', 'Category Name', 'required|trim|max_length[100]'],
            ['category_description', 'Description', 'required|trim|max_length[255]'],
            ['mnfId', 'Manufacturer', 'required|numeric']
        ];

        foreach ($fields as [$field, $label, $rules]) {
            $this->form_validation->set_rules($field, $label, $rules);
        }

        // On validation success
        if ($this->form_validation->run()) {
            $id = $this->input->post('id', TRUE);
            $data = $this->input->post(NULL, TRUE);
            unset($data['id']); // prevent id from being updated

            $updated = $this->Category_Model->edit($id, $data);

            $json = $updated
                ? ['status' => 1, 'msg' => "Category updated successfully"]
                : ['status' => 0, 'msg' => "Update failed!"];
        }
        // On validation failure
        else {
            $json = ['status' => 0];
            foreach ($fields as [$field]) {
                $error = form_error($field);
                if ($error) {
                    $json[$field] = $error;
                }
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    public function delete()
    {
        $this->genlib->ajaxOnly();
        $id = $this->input->post('id', TRUE);

        if ($id) {
            $deleted = $this->Category_Model->delete($id);
            $json = $deleted
                ? ['status' => 1, 'msg' => "Category deleted successfully"]
                : ['status' => 0, 'msg' => "Deletion failed!"];
        } else {
            $json = ['status' => 0, 'msg' => "Invalid request"];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}
