<?php
if (isset($islogin) && $islogin) {
    ?>
    <div class="container_user">
        <div id="links">
            <ul class="pills">
                <li ><a href="<?php echo base_url() . "index.php/user/index" ?>">Profile</a></li>
                <li class ="active"><a href="<?php echo base_url() . "index.php/friend" ?>">Friends</a></li>
                <li ><a href="<?php echo base_url() . "index.php/group" ?>">Groups</a></li>
                <li><a href="<?php echo base_url() . "index.php/comment" ?>">My Comments</a></li>
                <li><a href="<?php echo base_url() . "index.php/note" ?>">My Notes</a></li>
            </ul>
        </div>

        <h1><?php echo $user['nickname']; ?>'s Profile</h1><hr/>
        <h3>Profile</h3>
        <div class="info_container">
            <img class="thumbnail" src="<?php echo base_url("img/avatar/") . "/" . $user['avatar']; ?>" alt="">
            <br/>
            <?php echo $user['nickname']; ?>

            <div class="friend_control">
                <?php
                if ($is_me)
                    ;
                else if ($is_friend) {
                    ?>We are friends
                    <form  action="<?php echo base_url() . "index.php/user/delete_friend" ?>" id="Delete_Friend_Form" method="post">
                        <input type="hidden" name="friend_id" value="<?php echo $user['id'] ?>"></input>
                        <input type="submit" value="Delete" class="btn danger"></input>
                    </form>
                        <br/>
                    <?php
                } else {
                    if ($is_group_friend) {
                        echo "We are group friends";
                    }else echo "We are NOT friends";
                    ?>

                    <form  action="<?php echo base_url() . "index.php/user/add_friend" ?>" id="Add_Friend_Form" method="post">
                        <input type="hidden" name="add_friend_id" value="<?php echo $user['id'] ?>"></input>
                        <input type="submit" value="Add Friend" class="btn success"></input>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        if ($is_me || $is_friend || $is_group_friend) {
            ?>
            <hr/>
            <h3>Notes</h3>
            <div class="info_container">
                <ul>
                    <?php
                    foreach ($notes as $note) {
                        if ($note['target_type'] == 1)
                            foreach ($note_books as $item)
                                if ($item['id'] == $note['target_id']) {
                                    ?>
                                    <li>
                                        <a href="<?php echo base_url() . "index.php/book/view/" . $item['id'] ?>">
                                            <?php echo $item['name'] ?></a>
                                        Note recorded at:<?php echo $note['pub_time'] ?>
                                        <br/>
                                        <?php echo $note['note'] ?>
                                    </li>
                                    <?php
                                    break;
                                }
                        if ($note['target_type'] == 2)
                            foreach ($note_papers as $item)
                                if ($item['id'] == $note['target_id']) {
                                    ?>
                                    <li>
                                        <a href="<?php echo base_url() . "index.php/paper/view/" . $item['id'] ?>">
                                            <?php echo $item['title'] ?></a>
                                        Note recorded at:<?php echo $note['pub_time'] ?>
                                        <br/>
                                        <?php echo $note['note'] ?>
                                    </li>
                                    <?php
                                    break;
                                }
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
        ?>
        <hr/>
        <h3>Comments</h3>
        <div class="info_container">
            <ul>
                <?php
                foreach ($comments as $comment) {
                    if ($comment['target_type'] == 1)
                        foreach ($books as $item)
                            if ($item['id'] == $comment['target_id']) {
                                ?>
                                <li>
                                    <a href="<?php echo base_url() . "index.php/book/view/" . $item['id'] ?>">
                                        <?php echo $item['name'] ?></a>
                                    comment recorded at:<?php echo $comment['pub_time'] ?>
                                    <br/>
                                    <?php echo $comment['comment'] ?>
                                </li>
                                <?php
                                break;
                            }
                    if ($comment['target_type'] == 2)
                        foreach ($papers as $item)
                            if ($item['id'] == $comment['target_id']) {
                                ?>
                                <li>
                                    <a href="<?php echo base_url() . "index.php/paper/view/" . $item['id'] ?>">
                                        <?php echo $item['title'] ?></a>
                                    comment recorded at:<?php echo $comment['pub_time'] ?>
                                    <br/>
                                    <?php echo $comment['comment'] ?>
                                </li>
                                <?php
                                break;
                            }
                    if ($comment['target_type'] == 3)
                        foreach ($webpages as $item)
                            if ($item['id'] == $comment['target_id']) {
                                ?>
                                <li>
                                    <a href="<?php echo base_url() . "index.php/webpage/view/" . $item['id'] ?>">
                                        <?php echo $item['title'] ?></a>
                                    comment recorded at:<?php echo $comment['pub_time'] ?>
                                    <br/>
                                    <?php echo $comment['comment'] ?>
                                </li>
                                <?php
                                break;
                            }
                }
                ?>
            </ul>
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
