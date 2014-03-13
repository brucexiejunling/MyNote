<?php
if(isset($islogin) && $islogin){
?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle">Add New Item</a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url("index.php/book/addbook")?>">New Book</a></li>
            <li><a href="<?php echo base_url("index.php/paper/addpaper")?>">New Paper</a></li>
            <li><a href="<?php echo base_url("index.php/webpage/addwebpage")?>">New Webpage</a></li>
        </ul>
    </li>
    <li><a href="<?php echo base_url()."index.php/user/index"?>">Welcome, <?php echo $user['nickname'] ?></a></li>
    <li><a href="<?php echo base_url()."index.php/usermanager/logout"?>" class="logout">logout</a></li>
<?php
}else{    
?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle">Login</a>
        <ul class="dropdown-menu">
            <form action="<?php echo base_url()."index.php/usermanager/login"?>" id="loginForm" method="post">
                <li><input type="text" placeholder="email" name="email"/></li>
                <li><input type="password" placeholder="password" name="password"/></li>
                <li><input type="submit" value="submit"/></li>
            </form>
        </ul>
    </li>
    <li class="dropdown">
    <a href="#" class="dropdown-toggle">Sign Up</a>
    <ul class="dropdown-menu">
            <form action="<?php echo base_url()."index.php/usermanager/signup"?>" id="signupForm" method="post">
                <li><input type="text" placeholder="email" name="newemail"/></li>
                <li><input type="text" placeholder="nickname" name="newnickname"/></li>
                <li><input type="password" placeholder="password" name="newpassword"/></li>
                <li><input type="password" placeholder="password again" name="newpassword_again"/></li>
                <li><input type="submit" value="Sign up"/></li>
            </form>
        </ul>
        </li>
<?php } ?>
