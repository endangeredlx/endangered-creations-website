<?php

class Login_model extends CI_Model 
{
	public function validate()
	{
		$this->db->where( 'login', $this->input->post('login') );
		$this->db->where( 'password', md5( $this->input->post('password') ) );
		$query = $this->db->get( 'admin' );
		$data = array();
		
		if($query->num_rows == 1)
		{
			foreach( $query->result() as $row ) 
			{	
				$data['id']	= $row->id;
				$data['login'] = $row->login;
				$data['alias'] = $row->alias;
				$data['privilege'] = $row->privilege;
				$data['valid'] = true;
			}
		} 
		else 
		{
			$data['valid'] = false;
		}
		return $data;
	}
	
	public function create_member()
	{
		$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),			
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password'))						
		);
		
		$insert = $this->db->insert('admin', $new_member_insert_data);
		return $insert;
	}
}
