<div class="row" id="search_result">
    <div class="span-two-thirds item_result">
        <ul class="unstyled ">
        <?php foreach($book_result as $book){ ?>
            <li>
                <div class="row">
                    <div class="span2">
                        <a href="<?php echo base_url("index.php/book/view/{$book['id']}")?>">
                            <img src="<?php echo base_url("img/cover/{$book['cover']}")?>" class="item_img"/>
                        </a>
                    </div>
                    <div class="span8">
                        <h4>
                            <a href="<?php echo base_url("index.php/book/view/{$book['id']}")?>">
                            <?php echo $book['name']?>
                            </a>
                            [<?php echo $book['type']?>]
                        </h4>
                        <p><?php echo substr($book['intro'], 0, 252)?></p>
                    </div>
                </div>
            </li>
        <?php } ?>
        <?php foreach($paper_result as $paper){ ?>
            <li>
                <div class="row">
                    <div class="span2">
                        <a href="<?php echo base_url("index.php/paper/view/{$paper['id']}")?>">
                            <img src="<?php echo base_url("img/paper/paper_default.png")?>" class="item_img"/>
                        </a>
                    </div>
                    <div class="span8">
                        <h4>
                            <a href="<?php echo base_url("index.php/paper/view/{$paper['id']}")?>">
                            <?php echo $paper['title']?>
                            </a>
                            [<?php echo $paper['type']?>]
                        </h4>
                        <p><?php echo substr($paper['intro'], 0, 252)?></p>
                    </div>
                </div>
            </li>
        <?php } ?>
        <?php foreach($webpage_result as $webpage){ ?>
            <li>
                <div class="row">
                    <div class="span2">
                        <a href="<?php echo base_url("index.php/webpage/view/{$webpage['id']}")?>">
                            <img src="<?php echo base_url("img/site/{$webpage['image']}")?>" class="item_img"/>
                        </a>
                    </div>
                    <div class="span8">
                        <h4>
                            <a href="<?php echo base_url("index.php/webpage/view/{$webpage['id']}")?>">
                            <?php echo $webpage['title']?>
                            </a>
                            [<?php echo $webpage['type']?>]
                        </h4>
                        <p><?php echo substr($webpage['intro'], 0, 252)?></p>
                    </div>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
    <div class="span-one-third user_group_result">
        <ul class="unstyled">
        <?php foreach($user_result as $user){ ?>
            <li>
                <div class="row">
                    <div class="span1">
                        <a href="<?php echo base_url("index.php/user/showuser/{$user['id']}")?>">
                            <img src="<?php echo base_url("img/avatar/{$user['avatar']}")?>" class="user_img"/>
                        </a>
                    </div>
                    <div class="span4">
                        <h4>
                            <a href="<?php echo base_url("index.php/user/showuser/{$user['id']}")?>">
                            <?php echo $user['nickname']?>
                            </a>
                            [user]
                        </h4>
                    </div>
                </div>
            </li>
        <?php } ?>
            <?php foreach($group_result as $group){ ?>
            <li>
                <div class="row">
                    <div class="span2">
                        <a href="<?php echo base_url("index.php/group/showgroup/{$group['id']}")?>">
                        </a>
                    </div>
                    <div class="span5">
                        <h4>
                            <a href="<?php echo base_url("index.php/group/showgroup/{$group['id']}")?>">
                            <?php echo $group['name']?>
                            </a>
                            [group]
                        </h4>
                    </div>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
</div>