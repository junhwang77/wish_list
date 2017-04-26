<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->output->enable_profiler();
	}
    public function index()
    {
        $this->load->helper(array('form', 'url'));
        session_destroy();
        $this->load->view('index');
    }
    public function login()
    {
        $username = $this->input->post('username');
        $this->load->model('User');
        $user = $this->User->get_user_by_username($username);
        $password = md5($this->input->post('login_pass').''.            $user['salt']);
        if ($user && $user['password'] == $password)
        {
            $logged_in = array(
                'user_id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'is_logged_in' => true
            );
            $this->session->set_userdata('logged_in', $logged_in);
            redirect('/dashboard');
        }
        else
        {
            $this->session->set_flashdata("login", "Invalid username or password");
            redirect(base_url());
        }
    }
    public function validate()
    {
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]', array('is_unique' => '%s is already being used.'));
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]', array('required' => 'You must provide a %s.'));
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('index');
        }
        else
        {
            $this->register();
            redirect(base_url());
        }
    }
    public function register()
    {
        $this->load->model('User');
        $username = $this->input->post('username');
        $name = $this->input->post('name');
		$datehired = $this->input->post('datehired');
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $password = md5($this->input->post('password').''.$salt);
        $user_info = array(
            "name" => $name,
            "username" => $username,
            "password" => $password,
            "salt" => $salt,
			"datehired" => $datehired
        );
        $this->User->add_user($user_info);
        $this->session->set_flashdata('registration', 'Registration successful!');
    }
}
