<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler();
	}
    public function dashboard()
    {
        $logged_in = $this->session->userdata('logged_in');
        $id = $logged_in['user_id'];
        $wishlist = $this->Item->all_items_users_id($id);
        $all_items = $this->Item->get_items_except_wl($logged_in['user_id']);
        $this->load->view('dashboard', array(
                                             'logged_in' => $logged_in,
                                             'all_items' => $all_items,
                                             'wishlist' => $wishlist));
    }
    public function wish_list_join($id)
    {
        $logged_in = $this->session->userdata('logged_in');
        $join = array('users_id' => $logged_in['user_id'],
                      'items_id' => $id);
        $item = $this->Item->get_item_by_id($id);
        $this->Item->add_item_to_wl($join);
        redirect('/dashboard');
    }
    public function add_item()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->view('create');
    }
    public function create_item()
    {
		$this->load->library('form_validation');
        $this->form_validation->set_rules('item', 'Item', 'required|is_unique[items.item]', array('is_unique' => '%s  already exists.'));
		if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('create');
        }
        else
        {
			$item = $this->input->post('item');
			$added_by = $this->session->userdata('logged_in');
			$item = array('item' => $item,
						  'added_by' => $added_by['username']);
			$this->Item->add_item($item);
			$query = $this->Item->get_items_by_name($item['item']);
			$join = array('users_id' => $added_by['user_id'],
						  'items_id' => $query['id']);
			$this->Item->add_item_to_wl($join);
			redirect('/dashboard');
        }

    }
    public function remove_wish($id)
    {
        $added_by = $this->session->userdata('logged_in');
        $ids = array('users_id' => $added_by['user_id'],
                     'items_id' => $id);
        $this->Item->remove_user($ids);
        redirect('/dashboard');
    }
    public function show_item($id)
    {
        $item = $this->Item->get_item_by_item_id($id);
        $this->load->view('show_item', array('item' => $item));
    }
    public function destroy($id)
    {
        $this->Item->delete_item($id);
        redirect('/dashboard');
    }
}
?>
