<?php
if (isset($islogin) && $islogin) {
    ?>
    <div class="container_user">
        <div id="links">
            <ul class="pills">
                <li ><a href="<?php echo base_url() . "index.php/user/index" ?>">Profile</a></li>
                <li><a href="<?php echo base_url() . "index.php/friend" ?>">Friends</a></li>
                <li class ="active"><a href="<?php echo base_url() . "index.php/group" ?>">Groups</a></li>
                <li><a href="<?php echo base_url() . "index.php/comment" ?>">My Comments</a></li>
                <li><a href="<?php echo base_url() . "index.php/note" ?>">My Notes</a></li>
            </ul>
        </div>
        <h1><?php echo $group['name']; ?></h1>
        <?php
        if(!$is_in_group){
        ?>
        <a href ="<?php echo base_url() . "index.php/group/joingroup/". $group['id']?>" class="btn primary">Join This Group</a>
        <?php
        }else if(!$is_admin){
        ?>
        <a href ="<?php echo base_url() . "index.php/group/quitgroup/". $group['id']?>" class="btn danger">Quit This Group</a>
        <?php
        }else{
        ?>
        This group is created by me
        <?php
        }
        ?>
        <hr/>
        <h3>Member</h3>

        <div class="info_container">
            <div class="row">
                <?php
                foreach ($group_members as $member) {
                    ?>
                    <div class="span"> 
                        <img class="thumbnail" src ="<?php echo base_url("img/avatar/") . "/" . $member['avatar']; ?>" alt="<?php echo $member['avatar']; ?>"/><br/>          
                        <a href="<?php echo base_url(); ?>index.php/user/showuser/<?php echo $member['id']; ?>"><?php echo $member['nickname']; ?></a>
                        <?php if ($is_admin && $member['id']!=$session['id']) { ?>
                        <br/>
                        <form action="<?php echo base_url("index.php/group/deletemember/{$group['id']}")?>">
                            <button class="btn danger deletemember" alt="<?php echo $member['id'] ?>">DELETE</button>
                        </form>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <hr/>
        <h3>Administrator</h3>

        <div class="info_container">
            <div class="row">
                <div class="span"> 
                    <img class="thumbnail" src ="<?php echo base_url("img/avatar/") . "/" . $admin['avatar']; ?>" alt="<?php echo $admin['avatar']; ?>"/><br/>          
                    <a href="<?php echo base_url(); ?>index.php/user/showuser/<?php echo $admin['id']; ?>">
                        <?php echo $admin['nickname']; ?></a>
                </div>
            </div>
        </div>
        <hr/>

        <h3>Introduction</h3>

        <div class="info_container">
            <h4><?php echo $group['intro']; ?></h4>
            <hr/>
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
