<?php
class Item extends CI_Model {

    function get_item_by_id($user_id)
    {
        $this->db->select('users_has_items.items_id');
        $this->db->from('users');
        $this->db->join('users_has_items', 'users_has_items.users_id=users.id');
        $this->db->join('items', 'users_has_items.items_id = items.id');
        $this->db->where('users_id', $user_id);
        return $this->db->get()->result_array();
    }
    function get_items_except_wl($user_id)
    {
        return $this->db->query("SELECT * FROM items
        WHERE id NOT IN ( SELECT users_has_items.items_id FROM users_has_items
        JOIN items ON users_has_items.items_id = items.id
        WHERE users_has_items.users_id = {$user_id}) ")->result_array();
    }
    function get_items_by_name($item)
    {
        return $this->db->query("SELECT * FROM items WHERE item = ?", array($item))->row_array();
    }
    function get_item_by_item_id($item_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_has_items', 'users_has_items.users_id=users.id');
        $this->db->join('items', 'users_has_items.items_id = items.id');
        $this->db->where('items_id', $item_id);
        return $this->db->get()->result_array();
    }
    function add_item($item)
    {
        $query = "INSERT INTO items (item, added_by, created_at, updated_at) VALUES(?,?,?,?)";
        $values = array($item['item'], $item['added_by'], date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"));
        return $this->db->query($query, $values);
    }
    function add_item_to_wl($join)
    {
        $query = "INSERT INTO users_has_items (users_id, items_id) VALUES(?,?)";
        $values = array($join['users_id'], $join['items_id']);
        return $this->db->query($query, $values);
    }
    function all_items_users_id($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_has_items', 'users_has_items.users_id=users.id');
        $this->db->join('items', 'users_has_items.items_id = items.id');
        $this->db->where('users_id', $id);
        return $this->db->get()->result_array();
    }
    function remove_user($id)
    {
        $query = "DELETE FROM users_has_items WHERE users_id = ? AND items_id = ?";
        $where = array($id['users_id'], $id['items_id']);
        return $this->db->query($query, $where);
    }
    function delete_item($id)
    {
        $query1 = "DELETE FROM users_has_items WHERE items_id = ?";
        $where1 = array($id);
        $this->db->query($query1, $where1);
        $query2 = "DELETE FROM items WHERE id = ?";
        $where2 = array($id);
        return $this->db->query($query2, $where2);
    }
}

 ?>
