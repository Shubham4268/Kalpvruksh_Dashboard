<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manufacturer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->genlib->checkLogin();
        // $this->genlib->superOnly(); 
        $this->load->model('Manufacturer_model');
    }

    public function index()
    {
        $data = [
            'pageContent' => $this->load->view('manufacturer/manufacturer', '', TRUE),
            'pageTitle' => "Manufacturers"
        ];
        $this->load->view('main', $data);
    }

    public function lmlt()
    {
        try {
            $this->genlib->ajaxOnly();
            
            $orderBy = $this->input->get('orderBy', TRUE) ?: "mnf_name";
            $orderFormat = $this->input->get('orderFormat', TRUE) ?: "ASC";
            $limit = (int) $this->input->get('limit', TRUE) ?: 10;
            $pageNumber = (int) $this->uri->segment(3, 0);
            $start = max(0, ($pageNumber - 1) * $limit);

            $totalItems = $this->Manufacturer_model->countAll();
            $manufacturers = $this->Manufacturer_model->getAll($orderBy, $orderFormat, $start, $limit);

            if ($manufacturers === false) {
                throw new Exception("Error fetching manufacturers");
            }

            $this->load->library('pagination');
            $config = $this->genlib->setPaginationConfig($totalItems, "Manufacturer/lmlt", $limit, ['onclick' => 'return lmlt(this.href);']);
            $this->pagination->initialize($config);

            $data = [
                'allManufacturers' => $manufacturers,
                'range' => $totalItems > 0 ? "Showing " . ($start + 1) . "-" . ($start + count($manufacturers)) . " of " . $totalItems : "",
                'links' => $this->pagination->create_links(),
                'sn' => $start + 1
            ];

            $json['manufacturerListTable'] = $this->load->view('manufacturer/manufacturertable', $data, TRUE);
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

        $this->form_validation->set_rules('mnf_name', 'Manufacturer Name', 'required|trim|max_length[100]|is_unique[manufacturers.mnf_name]');
        $this->form_validation->set_rules('contact', 'Contact Info', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]');
        $this->form_validation->set_rules('mnf_address', 'Address', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('dist', 'District', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('tal', 'Taluka', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('town', 'Town', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required|trim|max_length[6]|numeric');

        if ($this->form_validation->run()) {
            $data = $this->input->post(NULL, TRUE);
            $data['adminId'] = $this->session->admin_id;

            $insertedId = $this->Manufacturer_model->add($data);

            $json = $insertedId ? ['status' => 1, 'msg' => "Manufacturer successfully added"] : ['status' => 0, 'msg' => "Unexpected server error! Please try again."];
        } else {
            $json = ['status' => 0, 'msg' => validation_errors()];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function edit()
    {
        $this->genlib->ajaxOnly();
        $this->load->library('form_validation');

        $fields = [
            ['id', 'Manufacturer ID', 'required|trim|numeric'],
            ['mnf_name', 'Manufacturer Name', 'required|trim|max_length[100]'],
            ['contact', 'Contact Info', 'required|trim|max_length[255]'],
            ['email', 'Email', 'required|trim|valid_email|max_length[255]'],
            ['mnf_address', 'Address', 'required|trim|max_length[255]'],
            ['dist', 'District', 'required|trim|max_length[100]'],
            ['tal', 'Taluka', 'required|trim|max_length[100]'],
            ['town', 'Town', 'required|trim|max_length[100]'],
            ['pincode', 'Pincode', 'required|trim|max_length[6]|numeric']
        ];

        foreach ($fields as $field) {
            $this->form_validation->set_rules($field[0], $field[1], $field[2]);
        }

        if ($this->form_validation->run()) {
            $id = $this->input->post('id', TRUE);
            $data = $this->input->post(NULL, TRUE);
            unset($data['id']);

            $updated = $this->Manufacturer_model->edit($id, $data);
            $json = $updated
                ? ['status' => 1, 'msg' => "Manufacturer updated successfully"]
                : ['status' => 0, 'msg' => "Update failed!"];
        } else {
            $json = ['status' => 0];
            foreach ($fields as $field) {
                $error = form_error($field[0]);
                if ($error) {
                    $json[$field[0]] = $error;
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
            $deleted = $this->Manufacturer_model->delete($id);
            $json = $deleted ? ['status' => 1, 'msg' => "Manufacturer deleted successfully"] : ['status' => 0, 'msg' => "Deletion failed!"];
        } else {
            $json = ['status' => 0, 'msg' => "Invalid request"];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}
