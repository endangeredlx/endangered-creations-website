<?php

class Picture_model extends CI_Model {
	
	function add_album_record ( $data ) {
		
		$this->db->insert('photo_albums',$data); 
		return true;
		
	}
	
	function get_album_record ( $id ) {
		
		$this->db->where('id',$id);
		$query = $this->db->get('photo_albums');
		return $query;
		
	}
	
	function get_comments( $id ) {
		
		$this->db->where('entry_type','photo');
		$this->db->where('entry_id',$id);
		
		$query = $this->db->get('comments');
		
		return $query->result();
	
	}
	
	function get_album_records ( $how_many, $offset = 0, $unpub = false ) {
		
		if( !$unpub ) {
			
			$this->db->where('status','published');
		
		}
		
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get('photo_albums',$how_many,$offset);
		return $query->result();
		
	}
	
	function update_album_record ($id, $data) {
		
		$this->db->where('id',$id);
		$this->db->update('photo_albums',$data);
		
	}
	
	function create_pic_row ( $id ) {
		
		$data = array(
			"ref_id" => $id,
			"date" 	 => time(),
		);
		$this->db->insert('photos',$data); 
		return $this->db->insert_id();
		
	}
	
	function make_album_cover ($pid, $aid) {
		
		$this->db->where('id',$pid);
		$photo_query = $this->db->get('photos');
		$photo = $photo_query->row();
		$this->db->flush_cache();
		
		$update = array(
			'large' 	  	=> $photo->large,
			'large_width' 	=> $photo->large_width,
			'large_height'	=> $photo->large_height,
			'small'		  	=> $photo->small,
			'small_width' 	=> $photo->small_width,
			'small_height' 	=> $photo->small_height,
			'square' 		=> $photo->square,
			'square_width'	=> $photo->square_width
		);
		
		$this->db->where('id',$aid);
		$this->db->update('photo_albums',$update);
		
	}
	
	function delete_photo_album_record($id) {
		
		$this->db->where('id',$id);
		$this->db->delete('photo_albums');
		
	}
	
	function get_album_pictures($id) {
		
		$this->db->where('ref_id',$id);
		$this->db->order_by('order desc');
		$query = $this->db->get('photos');
		$this->db->flush_cache();
		
		return $query;
		
	}
	
	function delete_photo_record($id) {
		
		$this->db->where('id',$id);
		$this->db->delete('photos');
		$this->db->flush_cache();
		
	}
	
	function reorder_photos($aid) {
		
		
		$this->db->where('ref_id',$aid);
		$this->db->order_by('order asc');
		$records = $this->db->get('photos');
		
		$count = 1;
		
		if( $records->num_rows() > 0) : foreach($records->result() as $row) :
			
			$this->db->flush_cache();
			$this->db->where('id',$row->id);
			$update = array('order' => $count);
			$this->db->update('photos',$update);
			
			$count++;
		
		endforeach;
		
		endif;
		
		return true;
		
	}
	
	function get_photo_record ($id) {
		
		$this->db->where('id',$id);
		$query = $this->db->get('photos');
		
		return $query;
		
	}
	
	function get_next_id ($data , $num) {
		
		$this->db->where(array('ref_id' => $data->ref_id, 'order' => (($data->order) - 1)));
		
		$next_info = $this->db->get('photos');
		
		if($next_info->num_rows() == 0 ) {
			
			$this->db->flush_cache();
			
			$this->db->where(array('ref_id' => $data->ref_id, 'order' => $num));
			
			$true_next = $this->db->get('photos');
			
			//print_r($true_next);
			
			$true_next_info = $true_next->row();
			
			$next = $true_next_info->id;
			
		} else {
			
			$next_num = $next_info->row();
			
			$next = $next_num->id;
			
		}
		
		return $next;
		
	}
	
	function get_prev_id ($data) {
		
		$this->db->where(array('ref_id' => $data->ref_id, 'order' => (($data->order) + 1)));
		
		$prev_info = $this->db->get('photos');
		
		if($prev_info->num_rows() == 0 ) {
			
			$this->db->flush_cache();
			
			$this->db->where(array('ref_id' => $data->ref_id, 'order' => 1));
			$true_prev = $this->db->get('photos');
			
			$true_prev_info = $true_prev->row();
			
			$prev = $true_prev_info->id;
			
		} else {
			
			$prev_num = $prev_info->row();
			
			$prev = $prev_num->id;
			
		}
		
		return $prev;
		
	}
	
	function switch_order ($myid, $swid) {
		
		$this->db->where('id',$myid);
		$myid_order = $this->db->get('photos');
		$my_order = $myid_order->row();
		$this->db->flush_cache();
		
		$this->db->where('id',$swid);
		$swid_order = $this->db->get('photos');
		$sw_order = $swid_order->row();
		$this->db->flush_cache();
		
		$this->db->where('id',$myid);
		$this->db->update('photos',array('order'=>$sw_order->order));
		$this->db->flush_cache();
		
		$this->db->where('id',$swid);
		$this->db->update('photos',array('order'=>$my_order->order));
		$this->db->flush_cache();
		
	}
	
	function update_photo_record ($id, $data) {
		
		$this->db->where('id',$id);
		$this->db->update('photos',$data);
		
	}
	
}

?>
