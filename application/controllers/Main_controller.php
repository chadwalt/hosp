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
        if (!$this->session->id) {
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

}
