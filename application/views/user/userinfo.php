<?php
if (isset($islogin) && $islogin) {

?>
   
    <div class="container_user">
        <div id="links">
            <ul class="pills">
                <li class ="active"><a href="<?php echo base_url() . "index.php/user/userinfo.php" ?>">Profile</a></li>
                <li><a href="<?php echo base_url() . "index.php/friend" ?>">Friends</a></li>
                <li><a href="<?php echo base_url() . "index.php/group" ?>">Groups</a></li>
                <li><a href="<?php echo base_url() . "index.php/comment" ?>">My Comments</a></li>
                <li><a href="<?php echo base_url() . "index.php/note" ?>">My Notes</a></li>
            </ul>
        </div>
        <h1>My Profile</h1><hr/>
        <div class="info_container">
            <img id="avatar" class="thumbnail" src="<?php echo base_url("img/avatar/") . "/" . $user['avatar']; ?>" alt=""/>
            <form action="<?php echo base_url() . "index.php/user/modify_nickname" ?>" id="Modify_Nickname_Form" method="post">
                <input type="hidden" value="<?php echo $user['email'] ?>" name="email"/>
                Nickname： <input type="text" value="<?php echo $user['nickname'] ?>" name="nickname" class ="small"/></br>
                <input type="submit" value="Modify"class="btn primary"/>
            </form>
            <form action="<?php echo base_url() . "index.php/user/modify_password" ?>" id="Modify_Password_Form" method="post">
                <input type="hidden" value="<?php echo $user['email'] ?>" name="email"/>
                Old Password： <input type="password" placeholder="password" name="pre_password"/></br>
                New Password：<input type="password" placeholder="password" name="new_password"/></br>
                New Password： <input type="password" placeholder="password" name="new_password_again"/></br>
                <input type="submit" value="Modify" class="btn primary"/>
            </form>
            <?php echo form_open_multipart("user/upload_avatar");?>
            <?php echo form_input(array("name"=>"upload_avatar", "id"=>"upload_avatar", "type"=>"file")); ?>
            <?php echo form_close(); ?>
        </div>
    </div>


    <?php
} else {
    ?>
    <div class="row">
        <div class="span16">
            <div class="alert-message block-message error">
                <p>Please log in</p>
            </div>
        </div>
    </div>
<?php } ?>
