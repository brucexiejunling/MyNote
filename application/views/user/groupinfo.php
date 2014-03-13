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
        <h1>My Group List</h1><hr/>
        <h3>Groups Created By Me</h3>
        <div class="info_container" id="my_groups">
            <ul >
                <?php
                foreach ($groups_created as $group) {
                    ?>
                    <li>
                        <h3><a href="group/showgroup/<?php echo $group['id']; ?>"><?php echo $group['name']; ?></a></h3>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <hr/>
        <h3>Groups I Joined</h3>
        <div class="info_container">
            <ul>
                <?php
                foreach ($groups_joined as $group2) {
                    ?>
                    <li>
                        <h3><a href="group/showgroup/<?php echo $group2['id']; ?>"><?php echo $group2['name']; ?></a></h3>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <hr/>
        <h3>Create A Group</h3>
        <div class="info_container">
            <form action="<?php echo base_url() . "index.php/group/creat_group" ?>" id="Create_Group_Form" method="post">
                <input type="hidden" value="<?php echo $user['id'] ?>" name="creator_id"/>
                Group name：<br/>
                <input type="text"  name="groupname" class ="medium"/></br>
                Group introduction：<br/>
                <input type="texta" name="groupintro" class ="large"/></br>
                <input type="submit" value="Create"class="btn primary"/>
            </form>
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
