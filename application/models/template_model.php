<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_model extends CI_Model 
{
	function get_records( $type = "all", $how_many, $offset = 0, $include_unpub = false ) 
	{
		if( $type != "all" ) 
		{
		
			$this->db->where('type',$type);
		}
		if( !$include_unpub ) 
		{
			$this->db->where( 'status', 'published' );
		}
		$this->db->order_by( "date", "desc" ); 
		$query = $this->db->get( 'template', $how_many, $offset );
		return $query->result();
	}
	
	function get_record( $id ) 
	{
		$this->db->where( "id", $id );
		$query = $this->db->get( 'template' );
		return $query;
	}
	
	function add_record( $data ) 
	{	
		$this->db->insert('template', $data);
		return true;
	}
	
	function update_record( $id, $data ) 
	{
		$this->db->where("id", $id);
		$this->db->update('template', $data);
		return true;
	}
	
	function delete_record( $id ) 
	{	
		$this->db->where( 'id', $id );
		$this->db->delete( 'template' );
	}
	
}

?>
