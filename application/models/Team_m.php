<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_m extends CI_Model{
    public function showAllTeam(){
        $this->db->select("teams.*,
        users.*");
        $this->db->from('teams');
        $this->db->join('users', 'teams.id = users.team_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function addTeam(){
        $field = array(
            'team_id' =>$this->input->post('txtID'),
            'tname'=>$this->input->post('txtTeamName'),
            'lead_tname'=>$this->input->post('txtLeadName'),
            'members'=>$this->input->post('txtMemberName')
        );
        $this->db->insert('team_users', $field);
        if($this->db->affected_rows() > 0){
            return true;

        }else{
            return false;
        }
    }

    public function editTeam(){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$query = $this->db->get('teams');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
    }
    
    public function updateTeam(){
		$id = $this->input->post('txtId');
		$field = array(
            'id' =>$this->input->post('txtID'),
            'tname'=>$this->input->post('txtTeamName'),
            'lead_tname'=>$this->input->post('txtLeadName'),
            'members'=>$this->input->post('txtMemberName')
		);
		$this->db->where('id', $id);
		$this->db->update('teams', $field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
    }
    
    function deleteTeam(){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$this->db->delete('teams');
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

} 