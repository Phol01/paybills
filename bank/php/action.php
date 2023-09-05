<?php
session_start();
require_once 'query.php';
$admin = new Admin();


if(isset($_POST['action']) && $_POST['action'] == 'farmerLogin'){
    $username = $admin->test_input($_POST['username']);
    $password = $admin->test_input($_POST['password']);

    $hpassword = sha1($password);

    $loggedInAdmin = $admin->farmer_login($username,$hpassword);

    $info = $admin->farmer_info($username);
    $ID = $admin->farmer_ID($username);
    $assocID = $admin->assoc_ID($username);
    $contact = $admin->contact($username);
    $sex = $admin->sex($username);
    $brgy = $admin->brgy($username);
    $brID = $admin->brgy_ID($username);
    $assoc = $admin->assoc($username);
    $fname = $admin->fname($username);
    $mname = $admin->mname($username);
    $lname = $admin->lname($username);
    $pass = $admin->password($username);

    if($loggedInAdmin != null){
        echo 'farmerLogin';
        $_SESSION['farmer_user'] = $username;
        $_SESSION['farmer_info'] = $info;
        $_SESSION['assoc_ID'] = $assocID;
        $_SESSION['contact'] = $contact;
        $_SESSION['sex'] = $sex;
        $_SESSION['brgy'] = $brgy;
        $_SESSION['brgyID'] = $brID;
        $_SESSION['assoc'] = $assoc;
        $_SESSION['fname'] = $fname;
        $_SESSION['mname'] = $mname;
        $_SESSION['lname'] = $lname;
        $_SESSION['password'] = $pass;
        $_SESSION['ID'] = $ID;
    }
    else{
        echo $admin->showMessage('Username or Password is Incorrect');
    }
}

//adding farmer account 
if(isset($_POST['action']) && $_POST['action'] == 'registerFarmer'){
    $fname = $admin->test_input($_POST['fname']);
    $mname = $admin->test_input($_POST['mname']);
    $lname = $admin->test_input($_POST['lname']);
    $sex = $admin->test_input($_POST['sex']);
    $username = $admin->test_input($_POST['username']);
    $pass = $admin->test_input($_POST['password']);
    $contact = $admin->test_input($_POST['contact']);
    $brgyID = $admin->test_input($_POST['brgy']);
    $assocID = $admin->test_input($_POST['assoc']);
    $hpass = sha1($pass);

    if($admin->farmer_exist($username)){
        echo $admin->showMessage('This username is already exist!!!');
    }
    else{
        if($admin->registerFarmer($fname,$mname,$lname,$sex,$username,$hpass,$contact,$brgyID,$assocID)){
            echo 'registerFarmer';
        }
        else{
            echo $admin->showMessage('Something went wrong! Try again later');
        }
    }

}


?>