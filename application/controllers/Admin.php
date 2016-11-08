<?php

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /* This will check if the user is loginned if not it will redirect the user to the login screen
     * ********************************************************************************************** */

    public function check_session() {
        if (!$this->session->user_id) {
            redirect('Main_controller/index');
        }
    }

    /* This function will be used to validate submited data. Eg through POST.
     * The function will return the validated data to the calling controller method.
     * ***************************************************************************** */

    public function validate_fields($data) {
        $data = stripslashes($data);
        $data = trim($data);
        $data = htmlentities($data);
        $data = html_escape($data);

        return $data;
    }

    /* Load the header.
     * ********************************** */

    public function load_header() {
        $this->load->view('templates/header');
        $this->load->view('admin/navigation');
        $this->load->view('templates/noti-header');
    }

    /* View the departments page.
     * *************************** */

    public function departments() {
        $this->check_session();

        ## Call the header function to display the headers.
        $this->load_header();
        $this->load->view('admin/departments');
    }

    /* Get all the departments in the system
     * *************************************** */

    public function get_departments() {
        $page = $this->validate_fields($this->input->post('page'));
        $rows = $this->validate_fields($this->input->post('rows'));

        $results = $this->Admin_model->get_departments_db($page, $rows);
        echo json_encode($results);
    }

    /* Save/Udpate the department in the system
     * *************************************** */

    public function save_department() {
        $depart_array = array(
            'name' => $this->validate_fields($this->input->post('name')),
            'description' => $this->validate_fields($this->input->post('description'))
        );

        if (empty($this->input->post('department_id'))) {
            $this->Admin_model->save_department_db($depart_array);
        } else {
            $id = intval($this->validate_fields($this->input->post('department_id')));

            $this->Admin_model->update_department_db($depart_array, $id);
        }
    }

    /* Delete the department in the  system
     * *************************************** */

    public function delete_department() {
        $id = intval($this->validate_fields($this->input->post('department_id')));

        $results = $this->Admin_model->delete_department_db($id);
        echo json_encode($results);
    }

    /* Search through the records to get this User.
     * ************************************************ */

    public function search_department() {
        $search_item = $this->validate_fields($this->input->get('search_name'));
        $page = intval($this->validate_fields($this->input->post('page')));
        $rows = intval($this->validate_fields($this->input->post('rows')));

        $results = $this->Admin_model->search_department_db($search_item, $page, $rows);
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode(array());
        }
    }

}
