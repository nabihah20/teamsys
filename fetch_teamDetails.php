<?php

if (isset($_GET['id'])) {
    try{
        include('connection_pdo.php');
        $ID = $_GET['id'];
        $sql = "SELECT * FROM teams
        WHERE id='$ID'";
        $statement = $conn->prepare($sql);
        $statement->execute(array(":id"=>$ID));
        $teamRow=$statement->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM users
        WHERE team_id='$ID'";
        $statement = $conn->prepare($sql);
        $statement->execute(array(":team_id"=>$ID));
        $memberRow=$statement->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
  echo "Cannot get data from database";
  exit;
}
?>
    <div class="row">
        <div class="form-group col-md-5">
            <label>Team Name</label>
        </div>
        <div class="form-group col-md-1">
            <label>:</label>
        </div>
        <div class="form-group col-md-5">
            <?php echo $teamRow['tname'];?>
        </div>                    
    </div>
    <div class="row">
        <div class="form-group col-md-5">
            <label>Team Lead</label>
        </div>
        <div class="form-group col-md-1">
            <label>:</label>
        </div>
        <div class="form-group col-md-5">
            <?php echo $teamRow['lead_tname'];?>
        </div>                    
    </div>
    <div class="row">
        <div class="form-group col-md-5">
            <label>Team Members</label>
        </div>
        <div class="form-group col-md-1">
            <label>:</label>
        </div>
        <div class="form-group col-md-5">
            <table>
                <?php
                if ($memberRow && $statement->rowCount() > 0) { 
                    $counter = 1; 
                    foreach ($memberRow as $row) {
                    $member_name = $row['uname'];

                ?>
                    <tr>
                        <td><?php echo $counter; ?>. <?php echo $member_name; ?></td>
                    </tr>
                    <?php $counter++;
                    }
                } else {
                    ?> 
                <tr>
                    <td>No team member yet</td>
                </tr>
                <?php
                    }?>
            </table>
        </div>
