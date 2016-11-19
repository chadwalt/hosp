<?php

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /* This will check if the user is loginned if not it will redirect the user to the login screen
     * ********************************************************************************************** */

    public function check_session() {
        if (!$this->session->user_id || $this->session->login_type !== 'admin') {
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
     * ***************** */

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

        if (empty($depart_array['name'])) {
            return;
        }

        if (empty($this->input->post('department_id'))) {
            $result = $this->Admin_model->save_department_db($depart_array);
            echo json_encode($result);
        } else {
            $id = intval($this->validate_fields($this->input->post('department_id')));

            $result = $this->Admin_model->update_department_db($depart_array, $id);
            echo json_encode($result);
        }
    }

    /* Delete the department in the  system
     * *************************************** */

    public function delete_department() {
        $id = intval($this->validate_fields($this->input->post('department_id')));

        $results = $this->Admin_model->delete_department_db($id);
        echo json_encode($results);
    }

    /* Search through the records to get this department.
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

    /* Load the patient page.
     * ************************ */

    public function patients() {
        $this->check_session();

        ## Load the header.
        $this->load_header();
        $this->load->view('main_app/patients');
    }

    /* Load the  categories page.
     * ****************************** */

    public function categories() {
        $this->check_session();

        ## Call the header function to display the headers.
        $this->load_header();
        $this->load->view('admin/categories');
    }

    /* Get all the categories in the system
     * *************************************** */

    public function get_med_categories() {
        $page = $this->validate_fields($this->input->post('page'));
        $rows = $this->validate_fields($this->input->post('rows'));

        $results = $this->Admin_model->get_med_categories_db($page, $rows);
        echo json_encode($results);
    }

    /* Save/Udpate the categories in the system
     * *************************************** */

    public function save_category() {
        $cat_array = array(
            'name' => $this->validate_fields($this->input->post('name')),
            'description' => $this->validate_fields($this->input->post('description'))
        );

        if (empty($cat_array['name'])) {
            return;
        }

        if (empty($this->input->post('id'))) {
            $result = $this->Admin_model->save_category_db($cat_array);
            echo json_encode($result);
        } else {
            $id = intval($this->validate_fields($this->input->post('id')));

            $result = $this->Admin_model->update_category_db($cat_array, $id);
            echo json_encode($result);
        }
    }

    /* Delete the category in the  system
     * *************************************** */

    public function delete_category() {
        $id = intval($this->validate_fields($this->input->post('id')));

        $results = $this->Admin_model->delete_category_db($id);
        echo json_encode($results);
    }

    /* Search through the records to get this category.
     * ************************************************ */

    public function search_category() {
        $search_item = $this->validate_fields($this->input->get('search_name'));
        $page = intval($this->validate_fields($this->input->post('page')));
        $rows = intval($this->validate_fields($this->input->post('rows')));

        $results = $this->Admin_model->search_category_db($search_item, $page, $rows);
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode(array());
        }
    }

    /* Load the  suppliers page.
     * ****************************** */

    public function suppliers() {
        $this->check_session();

        ## Call the header function to display the headers.
        $this->load_header();
        $this->load->view('admin/suppliers');
    }

    /* Get all the suppliers in the system
     * *************************************** */

    public function get_med_suppliers() {
        $page = $this->validate_fields($this->input->post('page'));
        $rows = $this->validate_fields($this->input->post('rows'));

        $results = $this->Admin_model->get_med_suppliers_db($page, $rows);
        echo json_encode($results);
    }

    /* Save/Udpate the suppliers in the system
     * *************************************** */

    public function save_supplier() {
        $supp_array = array(
            'name' => $this->validate_fields($this->input->post('name')),
            'phone' => $this->validate_fields($this->input->post('phone')),
            'email' => $this->validate_fields($this->input->post('email')),
            'address' => $this->validate_fields($this->input->post('address')),
        );

        if (empty($supp_array['name']) || empty($supp_array['address'])) {
            return;
        }

        if (empty($this->input->post('id'))) {
            $result = $this->Admin_model->save_supplier_db($supp_array);
            echo json_encode($result);
        } else {
            $id = intval($this->validate_fields($this->input->post('id')));

            $result = $this->Admin_model->update_supplier_db($supp_array, $id);
            echo json_encode($result);
        }
    }

    /* Delete the supplier in the  system
     * *************************************** */

    public function delete_supplier() {
        $id = intval($this->validate_fields($this->input->post('id')));

        $results = $this->Admin_model->delete_supplier_db($id);
        echo json_encode($results);
    }

    /* Search through the records to get this supplier.
     * ************************************************ */

    public function search_supplier() {
        $search_item = $this->validate_fields($this->input->get('search_name'));
        $page = intval($this->validate_fields($this->input->post('page')));
        $rows = intval($this->validate_fields($this->input->post('rows')));

        $results = $this->Admin_model->search_supplier_db($search_item, $page, $rows);
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode(array());
        }
    }

    /* Load the drugs page.
     * ************************ */

    public function drugs() {
        $this->check_session();

        ## Load the header.
        $this->load_header();
        $this->load->view('main_app/drugs');
    }

}
