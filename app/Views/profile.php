<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <?php include('header.php'); include('menu.php'); ?>
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                
                <span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("Error")) echo session()->getFlashData("Error"); ?></span>
                <span class="login100-form-title p-b-32"> User Profile </span><br>
                <div style="float: center">
                    <img src="<?=session()->get("LoggedUserData")['profile_img'];  ?>" alt="Profile Image" width="40%" style="margin-left: 90px;">
                    <br>  <br>
                    <h4>Name: <?=session()->get("LoggedUserData")['name']?session()->get("LoggedUserData")['name']:"";  ?></h4><br>
                    <h4>Email: <?=session()->get("LoggedUserData")['email']?session()->get("LoggedUserData")['email']:"";  ?></h4><br>
                </div>
            </div>
        </div>
    <?php include('footer.php'); ?>