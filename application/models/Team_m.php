<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_m extends CI_Model{
    public function showAllTeam(){

        $this->db->select('teams.id, teams.tname, teams.lead_tname')
                ->select('GROUP_CONCAT(users.uname SEPARATOR ",") as member', FALSE); 
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
            'uname'=>$this->input->post('txtMemberName'),
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

        $team_data = array(
            'id' => $this->db->insert_id(),
            'tname' => $this->input->post('txtTeamName'),
            'lead_tname' => $this->input->post('txtLeadName')
            );
            $FirstTable = $this->db->insert('teams', $team_data);
            
            $member = $this->input->post('txtMemberName');
            $team_id = $this->db->insert_id();

            for($i=0; $i < count($member); $i++){
                $member_data[] = array(
                    'team_id' =>$team_id,
                    'uname' => $member[$i]
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
                ->select('GROUP_CONCAT(users.uname SEPARATOR ",") as member', FALSE); 
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
        $this->db->select('teams.id, teams.tname, teams.lead_tname');
        $this->db->from('teams');
        $this->db->join('users', 'users.team_id = teams.id', 'RIGHT');
        $this->db->where('teams.id', $id);
        $query = $this->db->get();
        
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
    }
    
    public function updateTeam(){
		$id = $this->input->post('txtTeamID');
		$field = array(
            'id' =>$this->input->post('txtTeamID'),
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