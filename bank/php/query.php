<?php
require_once 'config.php';

class Admin extends Database{

    public function userInfo(){

        $sql = "SELECT  FROM farmer WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username'=>$Username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    // id
    public function farmer_ID($username){
        $sql = "SELECT farmerID FROM farmer WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }

    public function sex($username){
        $sql = "SELECT sex FROM farmer WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }

    public function contact($username){
        $sql = "SELECT contact FROM farmer WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }

    public function fname($username){
        $sql = "SELECT fname FROM farmer WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }
    public function mname($username){
        $sql = "SELECT mname FROM farmer WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }
    public function lname($username){
        $sql = "SELECT lname FROM farmer WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }

    public function brgy($username){
        $sql = "SELECT br.barangay FROM farmer as f
        INNER JOIN barangay as br
        ON f.brgyID = br.brgyID
        WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }

    public function assoc($username){
        $sql = "SELECT a.associationName FROM farmer as f
        INNER JOIN association as a
        ON f.assocID = a.assocID
        WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }

    public function password($username){
        $sql = "SELECT password FROM farmer WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }

    public function changePassword($username, $hnew) {
        $sql = "UPDATE farmer SET password = :hnew WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute(['username' => $username, 'hnew' => $hnew]);
    
        return $result;
    }

    public function assoc_ID($username){
        $sql = "SELECT assocID FROM farmer WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }

    public function brgy_ID($username){
        $sql = "SELECT brgyID FROM farmer WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row;
    }

    public function updateProfile($fname, $mname, $lname, $contact, $username){
        
        $sql = "UPDATE farmer SET fname = :fname, mname = :mname, lname = :lname, contact = :contact WHERE username = :username"; 
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute(['username' => $username, 'fname' => $fname, 'mname' => $mname, 'lname' => $lname, 'contact' => $contact]);
    
        return $result;
    }
    
    public function fetchAnnouncement($assocID) {
        $farmerID = $_SESSION['farmerID'];
        $assocID = implode($asID);

        $sql = "SELECT * FROM announcement WHERE assocID = :assocID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':assocID', $assocID);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function inputHarvest($landTypeID, $seedSystemID, $seedTypeID, $harvestArea, $aveYield, $prod, $farmerID, $brgyID, $assocID, $cropTypeID){
        
        $sql = "INSERT INTO harvestedcrop(landTypeID, seedSystemID, seedTypeID, harvestArea, aveYield, prod, farmerID, brgyID, assocID, cropTypeID) VALUES (:landTypeID, :seedSystemID, :seedTypeID, :harvestArea, :aveYield, :prod, :farmerID, :brgyID, :assocID, :cropTypeID)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['landTypeID' => $landTypeID, 'seedSystemID' => $seedSystemID, 'seedTypeID' => $seedTypeID, 'harvestArea'=>$harvestArea, 'aveYield'=>$aveYield, 'prod'=>$prod, 'farmerID'=>$farmerID, 'brgyID'=>$brgyID, 'assocID'=>$assocID, 'cropTypeID'=>$cropTypeID]);
        return true;
    }

    public function fetchHarvest($farmerID){
        $ID = $_SESSION['ID'];
        $farmerID = implode($ID);
        $sql = "SELECT lt.landType, ct.cropType, ss.seedSystem, st.seedType, hc.harvestArea, hc.aveYield, hc.prod
        FROM harvestedcrop as hc
        LEFT JOIN landtype as lt
        ON hc.landTypeID = lt.landTypeID
        LEFT JOIN seedsystem as ss
        ON hc.seedSystemID = ss.seedSystemID
        LEFT JOIN seedtype as st
        ON hc.seedTypeID = st.seedTypeID
        LEFT JOIN croptype as ct
        ON hc.cropTypeID = ct.cropTypeID
        WHERE farmerID = :farmerID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':farmerID', $farmerID);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function inputInfo($agriLand, $numFarm, $aveFarm, $areaRice, $soilType, $areaOther, $otherPlant,$farmerID){
        $sql = "INSERT INTO farm_info(agriLand, numFarm, aveFarm, areaRice, soilType, areaOther, otherPlant,farmerID) VALUES (:agriLand, :numFarm, :aveFarm, :areaRice, :soilType, :areaOther, :otherPlant, :farmerID)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['agriLand' => $agriLand, 'numFarm' => $numFarm, 'aveFarm' => $aveFarm, 'areaRice'=>$areaRice, 'soilType'=>$soilType, 'areaOther'=>$areaOther, 'otherPlant'=>$otherPlant, 'farmerID'=>$farmerID]);
        return true;
    }


    public function inputFarmInfo($landSize, $landTypeID, $seedSystemID, $farmerID){
        $sql = "INSERT INTO `farminfo`(`landSize`, `landTypeID`, `seedSystemID`, `farmerID`) VALUES (:landSize,:landTypeID, :seedSystemID, :farmerID)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['landSize' => $landSize, 'landTypeID' => $landTypeID, 'seedSystemID' => $seedSystemID, 'farmerID' => $farmerID]);
        return true;
    }

    public function fetchFarmInfo() {
        $fID = $_SESSION['ID'];
        $farmerID = implode($fID);

        $sql = "SELECT fi.landSize, lt.landType, ss.seedSystem
                FROM farminfo as fi
                LEFT JOIN landtype as lt
                ON fi.landTypeID = lt.landTypeID
                LEFT JOIN seedsystem as ss
                ON fi.seedSystemID = ss.seedSystemID
                WHERE farmerID = :farmerID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':farmerID', $farmerID);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkID(){
        $fID = $_SESSION['ID'];
        $farmerID = implode($fID);
        $sql = "SELECT COUNT(*) as count FROM farminfo WHERE farmerID = :farmerID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':farmerID', $farmerID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
        // return ($result['count'] > 0);
    }

}
?>