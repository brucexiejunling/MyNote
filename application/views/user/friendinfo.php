<?php
if (isset($islogin) && $islogin) {
    ?>
    <div class="container_user">
        <div id="links">
            <ul class="pills">
                <li><a href="<?php echo base_url() . "index.php/user/index" ?>">Profile</a></li>
                <li class ="active"><a href="<?php echo base_url() . "index.php/friend" ?>">Friends</a></li>
                <li><a href="<?php echo base_url() . "index.php/group" ?>">Groups</a></li>
                <li><a href="<?php echo base_url() . "index.php/comment" ?>">My Comments</a></li>
                <li><a href="<?php echo base_url() . "index.php/note" ?>">My Notes</a></li>
            </ul>
        </div>
        <h1>My Friends</h1><hr/>
        <h3>Friends' List</h3>
        
        <div class="info_container">
            <div class="row">
                <?php
                //var_dump($friendinfo);
                foreach ($friendinfo as $friend) {
                    ?>
                    <div class="span">
                        <a href="user/showuser/<?php echo $friend['id']; ?>">
                            <img class="thumbnail" src ="<?php echo base_url("img/avatar/") . "/" . $friend['avatar']; ?>" alt="<?php echo $friend['avatar']; ?>"/><br/>
                        </a>
                        <a href="user/showuser/<?php echo $friend['id']; ?>"><?php echo $friend['nickname']; ?></a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <hr/>
        <h3>What's New</h3>
        <div class="info_container">
            <div class="row">
                <h3>Notes</h3>
                <ul>
                    <?php 
                    foreach ($notes as $note) {
                        foreach( $friendinfo as $friend )
                            if( $friend['id'] == $note['user_id']){
                        if ($note['target_type'] == 1)
                            foreach ($note_books as $item)
                                if ($item['id'] == $note['target_id']) {
                                    ?>
                                    <li>
                                        <div class="user_name">
                                            <a href="user/showuser/<?php echo $friend['id']; ?>">By: <?php echo $friend['nickname']?></a>
                                        </div>
                                        <div class="co">
                                            <a href="<?php echo base_url() . "index.php/book/view/" . $item['id'] ?>">
                                            <?php echo $item['name'] ?></a>
                                            Note recorded by at:<?php echo $note['pub_time'] ?>
                                            <br/>
                                            <?php echo $note['note'] ?>
                                        </co>
                                    </li>
                                    <?php
                                    break;
                                }
                        if ($note['target_type'] == 2)
                            foreach ($note_papers as $item)
                                if ($item['id'] == $note['target_id']) {
                                    ?>
                                    <li>
                                        <div class="user_name">
                                            <a href="user/showuser/<?php echo $friend['id']; ?>">By: <?php echo $friend['nickname']?></a>
                                        </div>
                                        <div class="co"><a href="<?php echo base_url() . "index.php/paper/view/" . $item['id'] ?>">
                                            <?php echo $item['title'] ?></a>
                                            Note recorded at:<?php echo $note['pub_time'] ?>
                                            <br/>
                                            <?php echo $note['note'] ?>
                                        </div>
                                    </li>
                                    <?php
                                    break;
                                }
                            }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <hr/>
        <div class="info_container">
        <h3>Comments</h3>
            <ul>
                <?php
                foreach ($comments as $comment) {
                    foreach( $friendinfo as $friend )
                            if( $friend['id'] == $comment['user_id']){
                    if ($comment['target_type'] == 1)
                        foreach ($books as $item)
                            if ($item['id'] == $comment['target_id']) {
                                ?>
                                <li>
                                    <div class="user_name">
                                        <a href="user/showuser/<?php echo $friend['id']; ?>">By: <?php echo $friend['nickname']?></a>
                                    </div>
                                    <div class="co"><a href="<?php echo base_url() . "index.php/book/view/" . $item['id'] ?>">
                                        <?php echo $item['name'] ?></a>
                                    comment recorded at:<?php echo $comment['pub_time'] ?>
                                    <br/>
                                    <?php echo $comment['comment'] ?>
                                    </div>
                                </li>
                                <?php
                                break;
                            }
                    if ($comment['target_type'] == 2)
                        foreach ($papers as $item)
                            if ($item['id'] == $comment['target_id']) {
                                ?>
                                <li>
                                    <div class="user_name">
                                            <a href="user/showuser/<?php echo $friend['id']; ?>">By: <?php echo $friend['nickname']?></a>
                                    </div>
                                    <div class="co"><a href="<?php echo base_url() . "index.php/paper/view/" . $item['id'] ?>">
                                        <?php echo $item['title'] ?></a>
                                    comment recorded at:<?php echo $comment['pub_time'] ?>
                                    <br/>
                                    <?php echo $comment['comment'] ?>
                                    </div>
                                </li>
                                <?php
                                break;
                            }
                    if ($comment['target_type'] == 3)
                        foreach ($webpages as $item)
                            if ($item['id'] == $comment['target_id']) {
                                ?>
                                <li>
                                    <div class="user_name">
                                            <a href="user/showuser/<?php echo $friend['id']; ?>">By: <?php echo $friend['nickname']?></a>
                                    </div>
                                    <div class="co"><a href="<?php echo base_url() . "index.php/webpage/view/" . $item['id'] ?>">
                                        <?php echo $item['title'] ?></a>
                                    comment recorded at:<?php echo $comment['pub_time'] ?>
                                    <br/>
                                    <?php echo $comment['comment'] ?>
                                    </div>
                                </li>
                                <?php
                                break;
                            }
                            }
                }
                ?>
            </ul>
        </div>

    </div>


    <?php
} else {
    ?>
    Please log in
<?php } ?>
