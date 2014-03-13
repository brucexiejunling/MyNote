<div class="row">
    <div class="span-two-thirds">
        <div id = "webpage_part">
            <div id = "webpage_information">
                <h1>
                    <a href="<?php echo "http://" . $webpage["url"] ?>" target ="_blank">
                        <span id ="webpage_name"><?php echo $webpage["title"] ?></span>
                    </a>
                </h1>
                <div id = "webpage_upper">
                    <div>
                        <a href="<?php echo "http://" . $webpage["url"] ?>" target ="_blank">
                            <img id ="webpage_img"src="<?php echo base_url("img") . "/site/" . "site_default.jpg" ?>" alt ="暂时无法显示图片"/>
                        </a>
                    </div>
                    <div id ="webpage_info" >
                        <div class="pl">网站地址</div>
                        <div class="pl_info"><a href= "<?php echo "http://" . $webpage["url"] ?>" target ="_blank">
                                <?php echo $webpage["url"] == "" ? "暂无信息" : $webpage["url"] ?>
                            </a>
                        </div>
                        <div class="pl">分类</div>
                        <div class="pl_info">
                            <?php echo $classification["intro"] == "" ? "暂无信息" : $classification["intro"] ?>
                        </div>
                        <?php echo isset($tag_span) ? $tag_span : "" ?>
                    </div>
                </div>
                <div id ="webpage_related_info">
                    <span><h4>内容简介</h4><br>
                        <p><?php echo $webpage["intro"] ?></span>
                    </p><br>
                </div>
            </div>
        </div>


        <div id = "webpage_comments" >
            <h4 class ="comment_title">
                评论
            </h4>
            <?php
            if (count($comments) > 0) {
                foreach ($comments as $comment) {
                    $comment_user = $this->UserModel->getUserById($comment["user_id"]);
                    ?>
                    <div class = "comment_user_part">
                        <div class = "comment_user_photo">
                            <a href= "<?php echo base_url("index.php/user/showuser/{$comment_user["id"]}") ?>" target ="_blank">
                                <img class ="user_img" src="<?php echo base_url() . "/img/avatar/" . $comment_user['avatar']; ?>" alt="暂时无法显示图片"/>                    
                            </a>
                        </div>
                        <div>
                            <div class = "comment_word">
                                <span class = "comment_user_name"><?php echo $comment_user["nickname"] ?></span>评论:<br>
                                <?php echo $comment["comment"] ?><br>
                                <span class ="comment_time"><?php echo $comment["pub_time"] ?></span><br>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class = "comment_user_part">
                    暂无评论信息
                </div>
                <?php
            }
            ?>
        </div>

        <?php
        if (isset($userdata['islogin']) && $userdata['islogin']) {
            ?>
            <div>
                <input id = "webpage_comments_button" type = "button" name = "webpage_notes" value ="我想评论这个网站" class="btn primary"/>
                <form id = "input_comments" enctype="multipart/form-data" action = "<?php echo base_url() . "index.php/webpage/addcommentsandnotes/" . $webpage["id"] ?>" method = "post"/>
                <fieldset id = "fieldset_input_comments">
                    <textarea  class ="input_text"name = "input_comment" placeholder="请输入您的评论"></textarea>
                    <br>
                    <label class = "input_submit"><input type = "submit" size ="20"name = "submit_button" value = "评论" class="btn success"/></label>
                </fieldset>
            </div>
            <?php
        }
        ?>
    </div>
    <div id = "webpage_fond" class="span-one-third">
        <div id ="who_looks_thewebpage" >
            <h4 class ="right_part_h">
                谁看过这个网站?<br>
            </h4>
            <?php
            if (count($peopleReadWebpage) > 0) {
                foreach ($peopleReadWebpage as $prb) {
                    ?>
                    <div class ="man_look_thewebpage" >
                        <div class ="read_webpages_user_photo">
                            <a href="<?php echo base_url("index.php/user/showuser/{$prb["id"]}") ?>" target ="_blank">
                                <img class ="user_img" src="<?php echo base_url() . "/img/avatar/" . $prb['avatar']; ?>" alt="暂时无法显示图片"/>                    
                            </a>
                        </div>
                        <div>
                            用户名：<span class = "read_webpages_user_info"><?php echo $prb["nickname"] ?></span><br>
                            注册时间:<span class = "read_webpages_user_info"><?php echo $prb["reg_time"] ?></span><br>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            } else {
                ?>
                <div class ="noOneLookWebpage">
                    暂时还没有人看过这个网站
                </div>
                <?php
            }
            ?>               
        </div>
        <div id ="fav_webpages" >
            <h1 class ="right_part_h">
                其他人还看?<br>
            </h1>
            <?php
            if (count($favwebpages) > 0) {
                foreach ($favwebpages as $fav_webpage) {
                    if ($webpage['id'] == $fav_webpage['id'])
                        continue;
                    ?>
                    <div class ="man_look_thewebpage" >
                        <div class ="read_webpages_user_photo">

                            <a href="<?php echo base_url("index.php/webpage/view/{$fav_webpage["id"]}") ?>" target ="_blank">
                                <img class ="user_img" src="<?php echo base_url("img") . "/site/" . "site_default.jpg"; ?>" alt="暂时无法显示图片"/>                    
                            </a>
                        </div>
                        <div>
                            网站:<span  class = "read_webpages_user_info">：<?php echo $fav_webpage["title"] == "" ? "暂无信息" : $fav_webpage["title"] ?></span><br>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            } else {
                ?>
                <div class ="noOneLookWebpage">
                    暂时没有其他人信息
                </div>
                <?php
            }
            ?>               
        </div>
    </div>
</div>