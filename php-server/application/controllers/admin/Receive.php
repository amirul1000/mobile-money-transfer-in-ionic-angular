<?php

/**
 * Author: Amirul Momenin
 * Desc:Receive Controller
 *
 */
class Receive extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('Customlib');
        $this->load->helper(array(
            'cookie',
            'url'
        ));
        $this->load->database();
        $this->load->model('Receive_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of receive table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['receive'] = $this->Receive_model->get_limit_receive($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/receive/index');
        $config['total_rows'] = $this->Receive_model->get_count_receive();
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['_view'] = 'admin/receive/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save receive
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $created_at = "";
        $updated_at = "";

        if ($id <= 0) {
            $created_at = date("Y-m-d H:i:s");
        } else if ($id > 0) {
            $updated_at = date("Y-m-d H:i:s");
        }

        $params = array(
            'agent_users_id' => html_escape($this->input->post('agent_users_id')),
            'send_id' => html_escape($this->input->post('send_id')),
            'subject' => html_escape($this->input->post('subject')),
            'note' => html_escape($this->input->post('note')),
            'phone_no' => html_escape($this->input->post('phone_no')),
            'amount' => html_escape($this->input->post('amount')),
            'status' => html_escape($this->input->post('status')),
            'created_at' => $created_at,
            'updated_at' => $updated_at
        );

        if ($id > 0) {
            unset($params['created_at']);
        }
        if ($id <= 0) {
            unset($params['updated_at']);
        }
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['receive'] = $this->Receive_model->get_receive($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Receive_model->update_receive($id, $params);
                $this->session->set_flashdata('msg', 'Receive has been updated successfully');
                redirect('admin/receive/index');
            } else {
                $data['_view'] = 'admin/receive/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $receive_id = $this->Receive_model->add_receive($params);
                $this->session->set_flashdata('msg', 'Receive has been saved successfully');
                redirect('admin/receive/index');
            } else {
                $data['receive'] = $this->Receive_model->get_receive(0);
                $data['_view'] = 'admin/receive/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    /**
     * Details receive
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['receive'] = $this->Receive_model->get_receive($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/receive/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting receive
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $receive = $this->Receive_model->get_receive($id);

        // check if the receive exists before trying to delete it
        if (isset($receive['id'])) {
            $this->Receive_model->delete_receive($id);
            $this->session->set_flashdata('msg', 'Receive has been deleted successfully');
            redirect('admin/receive/index');
        } else
            show_error('The receive you are trying to delete does not exist.');
    }

    /**
     * Search receive
     *
     * @param $start -
     *            Starting of receive table's index to get query
     */
    function search($start = 0)
    {
        if (! empty($this->input->post('key'))) {
            $key = $this->input->post('key');
            $_SESSION['key'] = $key;
        } else {
            $key = $_SESSION['key'];
        }

        $limit = 10;
        $this->db->like('id', $key, 'both');
        $this->db->or_like('agent_users_id', $key, 'both');
        $this->db->or_like('send_id', $key, 'both');
        $this->db->or_like('subject', $key, 'both');
        $this->db->or_like('note', $key, 'both');
        $this->db->or_like('phone_no', $key, 'both');
        $this->db->or_like('amount', $key, 'both');
        $this->db->or_like('status', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['receive'] = $this->db->get('receive')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/receive/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('agent_users_id', $key, 'both');
        $this->db->or_like('send_id', $key, 'both');
        $this->db->or_like('subject', $key, 'both');
        $this->db->or_like('note', $key, 'both');
        $this->db->or_like('phone_no', $key, 'both');
        $this->db->or_like('amount', $key, 'both');
        $this->db->or_like('status', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $config['total_rows'] = $this->db->from("receive")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['key'] = $key;
        $data['_view'] = 'admin/receive/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Export receive
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'receive_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $this->db->order_by('id', 'desc');
            $receiveData = $this->Receive_model->get_all_receive();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Agent Users Id",
                "Send Id",
                "Subject",
                "Note",
                "Phone No",
                "Amount",
                "Status",
                "Created At",
                "Updated At"
            );
            fputcsv($file, $header);
            foreach ($receiveData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $this->db->order_by('id', 'desc');
            $receive = $this->db->get('receive')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/receive/print_template.php');
            $html = ob_get_clean();
            include (APPPATH . "third_party/mpdf60/mpdf.php");
            $mpdf = new mPDF('', 'A4');
            // $mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);
            // $mpdf->mirrorMargins = true;
            $mpdf->SetDisplayMode('fullpage');
            // ==============================================================
            $mpdf->autoScriptToLang = true;
            $mpdf->baseScript = 1; // Use values in classes/ucdn.php 1 = LATIN
            $mpdf->autoVietnamese = true;
            $mpdf->autoArabic = true;
            $mpdf->autoLangToFont = true;
            $mpdf->setAutoBottomMargin = 'stretch';
            $stylesheet = file_get_contents(APPPATH . "third_party/mpdf60/lang2fonts.css");
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($html);
            // $mpdf->AddPage();
            $mpdf->Output($filePath);
            $mpdf->Output();
            // $mpdf->Output( $filePath,'S');
            exit();
        }
    }
}
//End of Receive controller