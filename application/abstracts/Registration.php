<?php

abstract class Registration
{
    abstract protected function register();
    abstract protected function get_user_info();

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
}