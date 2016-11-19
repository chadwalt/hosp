<?php

/*
 * This controller will controll the main operation of the system.
 * Logins, logouts password checks, etc.
 */

class Main_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /* This function will be used to validate submited data. Eg through POST.
     * The function will return the validated data to the calling controller method.
     * ***************************************************************************** */

    public function validate_fields($data) {
        $data = stripslashes($data);
        $data = trim($data);
        $data = htmlentities($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    /*
     * This will check if the user is logined 
     * if not it will redirect the user to the login screen
     * ******************************************************* */

    public function check_session() {
        if (!$this->session->user_id) {
            redirect('Main_controller/index');
        }
    }

    /* Load the index page, which is the login page.
     * ********************************************** */

    public function index() {
        //$this->output->cache(5);
//        $data['general'] = $this->Main_model->get_logo();
//
//        if (!empty($data['general']->logo)) {
//            $this->session->set_userdata('logo', $data['general']->logo);
//        }
        //$this->load->view("login/signin", $data);
        $this->load->view("login/login");
    }

    /* Validate user logins. 
     * If not vaild redirect the login page.
     * Else redirect to the dashboard.
     * ************************************************* */

    public function validate_login() {
        $username = $this->validate_fields($this->input->post('username'));
        $password = $this->validate_fields($this->input->post('password'));

        if (empty($username) || empty($password)) {
            return FALSE;
        }

        $results = $this->Main_model->get_valid_login($username, $password);

        if ($results) {
            $success = array(
                'msg' => TRUE,
                'redirect_url' => site_url("Main_controller/login_distribute")
            );
            echo json_encode($success);
        } else {
            echo json_encode(array('msg' => FALSE));
        }
    }

    public function login_distribute() {
        $position = $this->session->login_type;

        if ($position === 'admin') {
            redirect('Users/index');
        }
    }

    /* Nagivate the user to the dashboard after successfull login.
     * *********************************************************** */

    public function dashboard() {
        //$this->check_session();
        redirect('Dashboard/index');
    }

    /* Add de
     * **************************************** */

    /* This function will be called when the user logins out of the system.
     * ******************************************************************** */

    public function sign_out() {
//        $info = array('id', 'username', 'fullname', 'picture', 'position');
//        $this->session->unset_userdata($info);
        $this->session->sess_destroy();
        redirect('Main_controller/index');
    }

    /* This function will be used to suspend the account or lock the screen.
     * ******************************************************************** */

    public function suspend_acc() {
        //The User Agent Class provides functions that help identify information about the browser
        // mobile device, or robot visiting your site.
        $this->load->library('user_agent');
        // save the redirect_back data from referral url (where user first was prior to lockscreen)
        $this->session->set_userdata('redirect_back', $this->agent->referrer());

        //Deleting the id session variable it holds access to all the pages.
        $this->session->unset_userdata('id');

        $this->load->view('login/suspend');
    }

    /* This function will be used to save the geenral_settings.
     * ********************************************************* */

    function save_general_settings() {
        $update_array = array(
            'school_name' => htmlentities($this->input->post('school_name')),
            'POBOX' => htmlentities($this->input->post('pobox')),
            'address' => htmlentities($this->input->post('address')),
            'description' => htmlentities($this->input->post('description')),
            'email' => htmlentities($this->input->post('email_address')),
            'phone' => htmlentities($this->input->post('phone')),
        );

        if (!empty($_FILES['logo']['name'])) {
            //echo 'picture there';
            $config['upload_path'] = './logo/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;
            $config['max_width'] = 0;
            $config['max_height'] = 0;

            $this->upload->initialize($config);

            delete_files('./logo/');

            if ($this->upload->do_upload('logo')) {

                $logo_name = array('logo' => $this->upload->data('file_name'));
                $update_array = array_merge($update_array, $logo_name);

                $this->Main_model->save_general_settings_db($update_array);
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            }
        } else {
            $this->Main_model->save_general_settings_db($update_array);
        }

        redirect('Main_controller/general_settings');
    }

    /* This function will be used to update the general settings. 
     * ****************************************************************** */

    function update_general_settings() {
        $update_array = array(
            'school_name' => htmlentities($this->input->post('school_name')),
            'POBOX' => htmlentities($this->input->post('pobox')),
            'address' => htmlentities($this->input->post('address')),
            'description' => htmlentities($this->input->post('description')),
            'email' => htmlentities($this->input->post('email_address')),
            'phone' => htmlentities($this->input->post('phone')),
        );

        if (!empty($_FILES['logo']['name'])) {
            //echo 'picture there';
            $config['upload_path'] = './logo/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;
            $config['max_width'] = 0;
            $config['max_height'] = 0;

            $this->upload->initialize($config);

            delete_files('./logo/');

            if ($this->upload->do_upload('logo')) {
                $logo_name = array('logo' => $this->upload->data('file_name'));
                $update_array = array_merge($update_array, $logo_name);

                $this->Main_model->update_general_settings_db($update_array);
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            }
        } else {
            $this->Main_model->update_general_settings_db($update_array);
        }

        redirect('Main_controller/general_settings');
    }

    /* This function will be used to check if the input password is vaild
     * ******************************************************************* */

    public function suspend_pass_check() {
        $pass = html_escape($this->input->post('password'));

        $result = $this->Main_model->suspend_pass_check_db($pass);
        if ($result) {
            $url = $this->session->redirect_back;
            $this->session->unset_userdata('redirect_back');
            redirect($url);
        } else {
            $error_msg = '<div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Wrong Password Provided.
                          </div>';
            $this->session->set_flashdata('password_error', $error_msg);
            $this->load->view('login/suspend');
        }
    }

    /*
     *  This function will be used to load the general settings page to the user
     * *************************************************************************** */

    public function general_settings() {
        $this->check_session();

        $data['info'] = $this->Main_model->get_general_info();

        if (!empty($data['info']->school_name)) {
            $this->load->view('templates/header');
            $this->load->view('school_settings/general_settings', $data);
        } else {
            $this->load->view('templates/header');
            $this->load->view('school_settings/initial_settings');
        }
    }

    /* Navigate the user to the register page.
     * This will be like a back door.
     * **************************************** */

    public function system_reg() {
        $this->load->view("login/registration");
    }

    /* Register new user to the system.
     * *********************************** */

    public function register_details() {
        $retype_password = $this->validate_fields($this->input->post('retype_password'));
        $password = $this->validate_fields($this->input->post('password'));

        if ($retype_password !== $password) {
            $this->error_flash_message("Password", "didn't match");
            //Return to the registration page with the flash error.
            redirect("Main_controller/system_reg");
        }

        //Checking to find out if its a vaild password.
        $validate_password = stripos($password, "concept");

        if ($validate_password === FALSE) {
            $this->error_flash_message("Permission Denied", "You dont have the right permissions to use this registration.");
            redirect("Main_controller/system_reg");
        }

        $user_details = array(
            'full_name' => ucwords($this->validate_fields($this->input->post('full_name'))),
            'contact' => $this->validate_fields($this->input->post('contact')),
            'address' => ucwords($this->validate_fields($this->input->post('address'))),
            'gender' => $this->validate_fields($this->input->post('gender')),
            'email' => $this->validate_fields($this->input->post('email')),
            'username' => $this->validate_fields($this->input->post('username')),
            'password' => $this->encryption->encrypt($this->validate_fields($this->input->post('password'))),
            'email' => $this->validate_fields($this->input->post('email')),
            'positions' => 'admin',
        );

        if (!empty($user_details['full_name']) && !empty($user_details['username']) && !empty($user_details['password'])) {
            $results = $this->Main_model->save_user_detials($user_details);

            if ($results) {
                // Redirect the user to the login page.
                redirect("Main_controller/index");
            } else {
                $this->error_flash_message("Username", "already taken");
                //Return to the registration page with the flash error.
                redirect("Main_controller/system_reg");
            }
        } else {
            $this->error_flash_message("Fields", "Please provide all required fields");
            //Return to the registration page with the flash error.
            redirect("Main_controller/system_reg");
        }
    }

    /* This function will set the errors flash messages.
     * @param message. String. The message describing the error.
     * ********************************************************** */

    public function error_flash_message($title, $message) {
        $str = '<div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button><i class="fa fa-exclamation-triangle"></i>
                    <strong> ' . $title . '!</strong> ' . $message . '
                </div>';
        $this->session->set_flashdata('reg_errors', $str);
    }

    /* Reset the users password
     * **************************** */

    public function reset_password() {
        $username = $this->validate_fields($this->input->post('username'));

        $result = $this->Main_model->reset_password_db($username);
        echo json_encode($result);
    }

    /* This function will return all the registed patients in the system.
     * ****************************************************************** */

    public function get_patients() {
        $page = intval($this->validate_fields($this->input->post('page')));
        $rows = intval($this->validate_fields($this->input->post('rows')));

        $results = $this->Main_model->get_patients_db($page, $rows);

        echo json_encode($results);
    }

    /* This will save the patient into the system
     * ********************************************** */

    public function save_patient() {
        $patient_data = array(
            'name' => $this->validate_fields($this->input->post('name')),
            'birth_date' => $this->validate_fields($this->input->post('birth_date')),
            'address' => $this->validate_fields($this->input->post('address')),
            'email' => $this->validate_fields($this->input->post('email')),
            'gender' => $this->validate_fields($this->input->post('gender')),
            'blood_group' => $this->validate_fields($this->input->post('blood_group')),
            'age' => $this->validate_fields($this->input->post('age')),
            'phone' => $this->validate_fields($this->input->post('phone')),
        );

        if (!empty($_FILES['upload_picture']['name'])) {
            $config['upload_path'] = './patients_pictures/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['file_name'] = $patient_data['name'];

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('upload_picture')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $patient_data['picture'] = $this->upload->data('file_name');
            }
        }

        if (empty($this->input->post('patient_id'))) {
            $result = $this->Main_model->save_patient_db($patient_data);
        } else {
            $id = intval($this->validate_fields($this->input->post('patient_id')));
            $result = $this->Main_model->update_patient_db($patient_data, $id);
        }

        echo json_encode($result);
    }

    /* Delete the patient from the system.
     * ********************************* */

    function delete_patient() {
        $patient_id = intval($this->validate_fields($this->input->get('patient_id')));

        $result = $this->Main_model->delete_patient_db($patient_id);

        if ($result) {
            echo json_encode(array('success' => TRUE));
        } else {
            echo json_encode(array('success' => FALSE));
        }
    }

    /* Search through the records to get this Patient.
     * ************************************************ */

    public function search_patient() {
        $search_item = $this->validate_fields($this->input->get('search_name'));

        $page = intval($this->input->post('page'));
        $rows = intval($this->input->post('rows'));

        $results = $this->Main_model->search_patient_db($search_item, $page, $rows);
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode(array());
        }
    }

    /* Get all categories.
     * *********************** */

    public function get_categories() {
        $results = $this->Main_model->get_categories_db();
        echo json_encode($results);
    }

    /* Get all suppliers.
     * *********************** */

    public function get_suppliers() {
        $results = $this->Main_model->get_suppliers_db();
        echo json_encode($results);
    }

    /* Get all drugs in the system.
     * *********************** ***** */

    public function get_drugs() {
        $page = $this->validate_fields($this->input->post('page'));
        $rows = $this->validate_fields($this->input->post('rows'));

        $results = $this->Main_model->get_drugs_db($page, $rows);
        echo json_encode($results);
    }

    /* Save the drug in the database.
     * ********************************* */

    public function save_drug() {
        //Loop through to get all the fields tags.
        $drug_array = array();

        foreach ($_REQUEST as $key => $value) {
            $drug_array[$key] = $this->validate_fields($value);
        }

        if (empty($drug_array['id'])) {
            $result = $this->Main_model->save_drug_db($drug_array);
            echo json_encode($result);
        } else {
            $id = intval($drug_array['id']);

            $result = $this->Main_model->update_drug_db($drug_array, $id);
            echo json_encode($result);
        }
    }

    /* Delete the Drug from the system.
     * ********************************* */

    function delete_drug() {
        $id = intval($this->validate_fields($this->input->get('id')));

        $result = $this->Main_model->delete_drug_db($id);

        if ($result) {
            echo json_encode(array('success' => TRUE));
        } else {
            echo json_encode(array('success' => FALSE));
        }
    }
    
    /* Search through the records to get this drug.
     * ************************************************ */

    public function search_drug() {
        $search_item = $this->validate_fields($this->input->get('search_name'));

        $page = intval($this->input->post('page'));
        $rows = intval($this->input->post('rows'));

        $results = $this->Main_model->search_drug_db($search_item, $page, $rows);
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode(array());
        }
    }
}
