<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_m extends CI_Model{
    public function showAllTeam(){

        $this->db->select('teams.id, teams.tname, teams.lead_tname')
                ->select('GROUP_CONCAT(users.name SEPARATOR ",") as member', FALSE); 
        $this->db->from('teams');
        $this->db->join('users', 'users.team_id = teams.id', 'RIGHT');
        $this->db->group_by('teams.id');

        $query = $this->db->get();

        if ($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function insertMember(){
        $field = array(
            'name'=>$this->input->post('txtMemberName'),
            'team_id'=>$this->input->post('txtTeamID')
			);
		$this->db->insert('users', $field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
    }
    
    public function addTeam(){
        //$field = array(
			//'tname'=>$this->input->post('txtTeamName'),
			//'lead_tname'=>$this->input->post('txtLeadName')
			//);
        //$this->db->insert('teams', $field);
        
        $member = $this->input->post('txtMemberName');
        
        for($i=0; $i < count($member); $i++){
            $team_id = $this->input->post('txtTeamID');  //ada masalah masukkan team_id  
            $member_data[] = array(
                'team_id' =>$team_id[$i],
                'name' => $member[$i]
            );
        }
        $this->db->insert_batch('users', $member_data);

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        } 
	}

    public function viewTeam(){
		$id = $this->input->get('id');

        $this->db->select('teams.id, teams.tname, teams.lead_tname')
                ->select('GROUP_CONCAT(users.name SEPARATOR ",") as member', FALSE); 
        $this->db->from('teams');
        $this->db->join('users', 'users.team_id = teams.id', 'RIGHT');
        $this->db->group_by('teams.id');
        $this->db->where('id', $id);
		if($query->num_rows() > 0){
			return $query->row();
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