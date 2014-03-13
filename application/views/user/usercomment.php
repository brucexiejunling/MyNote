<?php
if (isset($islogin) && $islogin) {
    ?>
    <div class="container_user">
        <div id="links">
            <ul class="pills">
                <li ><a href="<?php echo base_url() . "index.php/user/index" ?>">Profile</a></li>
                <li><a href="<?php echo base_url() . "index.php/friend" ?>">Friends</a></li>
                <li><a href="<?php echo base_url() . "index.php/group" ?>">Groups</a></li>
                <li class ="active"><a href="<?php echo base_url() . "index.php/comment" ?>">My Comments</a></li>
                <li><a href="<?php echo base_url() . "index.php/note" ?>">My Notes</a></li>
            </ul>
        </div>

        <div class="info_container">
            <div class="row">
                <?php
                foreach ($comments as $comment) {
                    if ($comment['target_type'] == 1)
                        foreach ($books as $item)
                            if ($item['id'] == $comment['target_id']) {
                                ?>
                                <div class="span16">
                                    <div class="cover">
                                        <a href="<?php echo base_url() . "index.php/book/view/" . $item['id'] ?>">
                                            <img src="<?php echo base_url("img/cover/") . "/" . $item['cover'] ?>" alt=" <?php echo $item['name'] ?>"></img></a>
                                    </div>
                                    <div class="book_main">
                                        <div class="book_name">
                                            <a href="<?php echo base_url() . "index.php/book/view/" . $item['id'] ?>">
                                                <?php echo $item['name'] ?></a>
                                        </div>
                                        <div class="time_info">
                                            <?php echo $comment['pub_time'] ?>
                                        </div>
                                        <div class="book_comment"><?php echo $comment['comment'] ?></div>
                                        <div class="comment_foot">
                                            <a href ="<?php echo base_url() . "index.php/comment/delete/" . $comment['id'] ?>" class="btn danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                            }
                    if ($comment['target_type'] == 2)
                        foreach ($papers as $item)
                            if ($item['id'] == $comment['target_id']) {
                                ?>
                                <div class="span16">
                                    <div class="cover">
                                        <a href="<?php echo base_url() . "index.php/book/view/" . $item['id'] ?>">
                                            <img src="<?php echo base_url("img/paper/") . "/paper_default.png" ?>" alt=" <?php echo $item['title'] ?>"></img></a>
                                    </div>
                                    <div class="book_main">
                                        <div class="book_name">
                                            <a href="<?php echo base_url() . "index.php/paper/view/" . $item['id'] ?>">
                                                <?php echo $item['title'] ?></a>
                                        </div>
                                        <div class="time_info">
                                            <?php echo $comment['pub_time'] ?>
                                        </div>
                                        <div class="book_comment"><?php echo $comment['comment'] ?></div>
                                        <div class="comment_foot">
                                            <a href ="<?php echo base_url() . "index.php/comment/delete/" . $comment['id'] ?>"class="btn danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                            }
                    if ($comment['target_type'] == 3)
                        foreach ($webpages as $item)
                            if ($item['id'] == $comment['target_id']) {
                                ?>
                                <div class="span16">
                                    <div class="cover">
                                        <a href="<?php echo base_url() . "index.php/webpage/view/" . $item['id'] ?>">
                                            <img src="<?php echo base_url("img/site/") . "/".$item['image']?>" alt=" <?php echo $item['title'] ?>"></img></a>
                                    </div>
                                    <div class="book_main">
                                        <div class="book_name">
                                            <a href="<?php echo base_url() . "index.php/webpage/view/" . $item['id'] ?>">
                                                <?php echo $item['title'] ?></a>
                                        </div>
                                        <div class="time_info">
                                            <?php echo $comment['pub_time'] ?>
                                        </div>
                                        <div class="book_comment"><?php echo $comment['comment'] ?></div>
                                        <div class="comment_foot">
                                            <a href ="<?php echo base_url() . "index.php/comment/delete/" . $comment['id'] ?>" class="btn danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                            }
                }
                ?>
            </div>
        </div>
    </div>


    <?php
} else {
    ?>
    Please log in
<?php } ?>
