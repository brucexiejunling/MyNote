<div class="row">
    <div class="span-two-thirds">
        <div id = "paper_part">
            <div id = "paper_information">
                <h1>
                    <span id ="paper_name"><?php echo $paper["title"] ?></span>
                </h1>
                <div id = "paper_upper">
                    <div>
                        <img id ="paper_img"src="<?php echo base_url("img") . "/paper/" . $paper["image"] ?>" alt ="<?php $paper["id"] ?>"/>
                    </div>
                    <div id ="paper_info" >
                        <div class="pl">作者</div>
                        <div class="pl_info">
                            <?php echo $paper["authors"] == "" ? "暂无信息" : $paper["authors"] ?>
                        </div>
                        <div class="pl">分类</div>
                        <div class="pl_info">
                            <?php echo $classification["intro"] == "" ? "暂无信息" : $classification["intro"] ?>
                        </div> 
                        <div class="pl">出版日期</div>
                        <div class="pl_info">
                            <?php echo $paper["pub_date"] == "" ? "暂无信息" : $paper["pub_date"] ?></div>
                        <?php echo isset($tag_span) ? $tag_span : "" ?>
                    </div>
                </div>
                <div id ="paper_related_info">
                    <span><h4>内容简介:</h4>
                        <p><?php echo $paper["intro"] ?></span></p><br>
                </div>
            </div>
        </div>


        <div id = "paper_comments" >
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
                            <a href="<?php echo base_url("index.php/user/showuser/{$comment_user["id"]}") ?>" target ="_blank">
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
                <input id = "paper_comments_button" type = "button" name = "paper_notes" value ="我想评论这篇论文" class="btn primary"/>
                <form id = "input_comments" enctype="multipart/form-data" action = "<?php echo base_url() . "index.php/paper/addcommentsandnotes/" . $paper["id"] ?>" method = "post"/>
                <fieldset id = "fieldset_input_comments">
                    <textarea  class ="input_text"name = "input_comment" placeholder="请输入您的评论"></textarea>
                    <br>
                    <label class = "input_submit"><input type = "submit" size ="20"name = "submit_button" value = "评论" class="btn success"/></label>
                </fieldset>
            </div>
            <?php
        }
        ?>

        <div id = "paper_notes" >
            <h4 class ="notes_title">
                <?php
                if (isset($userdata['islogin']) && $userdata['islogin']) {
                    ?>
                    读书笔记
                </h4>
                <?php
                if (count($notes) > 0) {
                    foreach ($notes as $note) {
                        $note_user = $this->UserModel->getUserById($note["user_id"]);
                        ?>
                        <div class = "notes_user_part">
                            <div class = "notes_user_photo">
                                <a href="<?php echo base_url("index.php/user/showuser/{$note_user["id"]}") ?>" target ="_blank">
                                    <img class ="user_img" src="<?php echo base_url() . "img/avatar/" . $note_user['avatar']; ?>" alt="暂时无法显示图片"/>                    
                                </a>                               </div>
                            <div class = "notes_word">
                                <span class = "note_user_name"><?php echo $note_user["nickname"] ?></span>在第
                                <span class = "note_user_name"><?php echo $note["page_num"] ?></span>页说道:<br>
                                <?php echo $note["note"] ?><br>
                                <span class ="note_time"><?php echo $note["pub_time"] ?></span><br>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div id = "notes_user_part">
                        暂无好友读书笔记
                    </div>
                    <?php
                }
            }
            ?>

        </div>
        <?php
        if (isset($userdata['islogin']) && $userdata['islogin']) {
            ?>
            <input id = "paper_notes_button" type = "button" name = "paper_notes" value ="我想做笔记" class="btn primary"/>
            <div>
                <fieldset id ="fieldset_input_notes">
                    <textarea  class ="input_text"name = "input_note" placeholder="请输入您的笔记"></textarea>
                    <br>
                    <div id ="note_page" >
                        <input type = "checkbox" name = "for_group" value = "ffo" checked = "checked"/>
                        <span id ="for_group">对小组可见</span>
                        我想对第
                        <input type = "text" size = "3" name = "note_page" placeholder="0" />
                        页做
                        <input type = "submit" size ="20"name = "submit_button" value = "笔记" class="btn success"/>
                    </div>
                </fieldset>
            </div>
            <?php
        }
        ?>
    </div>
    <div id = "paper_fond" class="span-one-third">
        <div id ="who_looks_thepaper" >
            <h1 class ="right_part_h">
                谁读过这篇论文?<br>
            </h1>
            <?php
            if (count($peopleReadPaper) > 0) {
                foreach ($peopleReadPaper as $prb) {
                    ?>
                    <div class ="man_look_thepaper" >
                        <div class ="read_papers_user_photo">
                            <a href="<?php echo base_url("index.php/user/showuser/{$prb["id"]}") ?>" target ="_blank">
                                <img class ="user_img" src="<?php echo base_url() . "/img/avatar/" . $prb['avatar']; ?>" alt="暂时无法显示图片"/>                    
                            </a>
                        </div>
                        <div>
                            用户名：<span class = "read_papers_user_info"><?php echo $prb["nickname"] ?></span><br>
                            注册时间:<span class = "read_papers_user_info"><?php echo $prb["reg_time"] ?></span><br>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            } else {
                ?>
                <div class ="noOneLookPaper">
                    暂时还没有人看过这篇论文
                </div>
                <?php
            }
            ?>               
        </div>
        <div id ="fav_papers" >
            <h1 class ="right_part_h">
                其他人还看?<br>
            </h1>
            <?php
            if (count($favpapers) > 0) {
                foreach ($favpapers as $fav_paper) {
                    if ($paper['id'] == $fav_paper['id'])
                        continue;
                    ?>
                    <div class ="man_look_thepaper" >
                        <div class ="read_papers_user_photo">

                            <a href="<?php echo base_url("index.php/paper/view/{$fav_paper["id"]}") ?>" target ="_blank">
                                <img class ="user_img" src="<?php echo base_url("img") . "/paper/" . $paper["image"]; ?>" alt="暂时无法显示图片"/>                    
                            </a>
                        </div>
                        <div>
                            书名<span  class = "read_papers_user_info">：<?php echo $fav_paper["title"] == "" ? "暂无信息" : $fav_paper["title"] ?></span><br>
                            作者<span  class = "read_papers_user_info">：<?php echo $fav_paper["authors"] == "" ? "暂无信息" : $fav_paper["authors"] ?></span><br>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            } else {
                ?>
                <div class ="noOneLookPaper">
                    暂时没有其他人信息
                </div>
                <?php
            }
            ?>               
        </div>
    </div>
</div>