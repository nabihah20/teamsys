<?php
    header('Content-Type: application/json');
    require_once('connection_pdo.php');

    $action= (isset($_GET['action']))?$_GET['action']:'read';

    switch($action){
        case 'add':

                $result = $conn->prepare("INSERT INTO teams(tname,lead_tname)
                VALUES(:tname,:lead_tname)");

                $answer=$result->execute(array(
                    "tname" =>$_POST['tname'],
                    "lead_tname" =>$_POST['lead_tname']
                ));

                $searchID = $conn->prepare("SELECT max(id) FROM teams");
                $searchID ->execute();
                $team_id_current = $searchID ->fetchColumn();

                $nama=$_POST['nama'];
                foreach ($nama as $nama_new) {
                    $result3 = $conn->prepare("INSERT INTO users(team_id, nama)
                    VALUES('$team_id_current',:nama)");
                    $result3->bindParam(":nama", $nama_new);
                    $result3->execute();
                }
			
                echo json_encode($answer);
  
            break;
        case 'delete':
                $result=false;

                if(isset($_POST['mesy_id'])){
                    $ID = $_POST['mesy_id'];
                    //Status '4'- Batal
                    $result=$conn->prepare("UPDATE mesy 
                    SET mesy_status='4',
                        color='#000000',
                        textColor='#fff'
                    WHERE mesy_id=:mesy_id");
                    $answer= $result->execute(array("mesy_id"=>$ID));
                }
                echo json_encode($answer);
            break;
        case 'edit':

                $mesy_tarikh = $_POST['mesy_tarikh'];
                $sql = $conn->query("SELECT DATE_FORMAT('$mesy_tarikh', '%m')");
                $mesy_bulan=$sql->fetchColumn();

                $result = $conn->prepare("UPDATE mesy SET
                title=:title,
                bil=:bil,
                mesy_huraian=:mesy_huraian,
                color=:color,
                textColor=:textColor,
                start=:start,
                end=:end,
                jab_id=:jab_id,
                mesy_pengerusi=:mesy_pengerusi,
                mesy_lokasi=:mesy_lokasi,
                mesy_tarikh=:mesy_tarikh,
                mesy_bulan='$mesy_bulan',
                mesy_status=:mesy_status
                WHERE mesy_id=:mesy_id
                ");

                $answer=$result->execute(array(
                    "mesy_id"=>$_POST['mesy_id'],
                    "title" =>$_POST['title'],
                    "mesy_huraian" =>$_POST['mesy_huraian'],
                    "color" =>$_POST['color'],
                    "textColor" =>$_POST['textColor'],
                    "start" =>$_POST['start'],
                    "end" =>$_POST['end'],
                    
                    //from <select>
                    "jab_id" =>$_POST['jab_id'],
                    //"agensi_id" =>$_POST['agensi_id'],
                    "mesy_lokasi" =>$_POST['mesy_lokasi'],

                    "mesy_pengerusi" =>$_POST['mesy_pengerusi'],
                    //"mesy_ahli" =>$_POST['mesy_ahli'],
                    "mesy_tarikh" =>$_POST['mesy_tarikh'],
                    "mesy_status" =>$_POST['mesy_status'],
                    "bil" =>$_POST['bil']
                ));

                $result1 = $conn->prepare("UPDATE mesy_ahli SET 
                ahli_id=:ahli_id
                WHERE mesy_id=:mesy_id
                ");

                $mesy_ahli=$_POST['mesy_ahli'];
                foreach ($mesy_ahli as $mesy_ahlir) {
                    $result1 = $conn->prepare("INSERT INTO mesy_ahli(mesy_id, ahli_id)
                    VALUES(LAST_INSERT_ID(),:mesy_ahli)");
                    $result1->bindParam(":mesy_ahli", $mesy_ahlir);
                    $result1->execute();
                }

                $result2 = $conn->prepare("UPDATE mesy_agensi SET 
                agensi_id=:agensi_id 
                WHERE mesy_id=:mesy_id
                ");

                $agensi_id=$_POST['agensi_id'];
                foreach ($agensi_id as $agensi_idr) {
                    $result2 = $conn->prepare("INSERT INTO mesy_agensi(mesy_id, agensi_id)
                    VALUES(LAST_INSERT_ID(),:agensi_id)");
                    $result2->bindParam(":agensi_id", $agensi_idr);
                    $result2->execute();
                }

                //echo json_encode(array_merge($answer,$mesy_ahli,$agensi_id));
                echo json_encode($answer);
                //echo json_encode($mesy_ahli);
                //echo json_encode($agensi_id);
            break;
        default:
                $result = $conn->prepare("SELECT * 	
                FROM	mesy
                        
        ");
                $result->execute();
                
                $show= $result->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($show);
                break;
    }

?>