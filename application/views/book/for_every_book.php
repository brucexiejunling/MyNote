<div class="row">
    <div class="span-two-thirds">
        <div id = "book_part">
            <div id = "book_information">
                <h1>
                    <span id ="book_name"><?php echo $book["name"] ?></span>
                </h1>
                <div id = "book_upper">
                    <div>
                        <img id ="book_img"src="<?php echo base_url("img") . "/cover/" . $book["cover"] ?>" alt ="<?php $book["id"] ?>"/>
                    </div>
                    <div id ="book_info" >
                        <div class="pl">作者</div>
                        <div class="pl_info"><?php echo $book["author"] == "" ? "暂无信息" : $book["author"] ?></div>
                        <div class="pl">分类</div>
                        <div class="pl_info"><?php echo $classification["intro"] == "" ? "暂无信息" : $classification["intro"] ?></div>
                        <div class="pl">出版日期</div>
                        <div class="pl_info"><?php echo $book["pub_date"] == "" ? "暂无信息" : $book["pub_date"] ?></div>
                        <div class="pl">10-ISBN</div>
                        <div class="pl_info"><?php echo $book["isbn10"] == "" ? "暂无信息" : $book["isbn10"] ?></div>
                        <div class="pl">13-ISBN</div>
                        <div class="pl_info"><?php echo $book["isbn13"] == "" ? "暂无信息" : $book["isbn13"] ?></div>
                        <?php echo isset($tag_span) ? $tag_span : "" ?>
                    </div>
                </div>
                <div id ="book_related_info">
                    <span><h4>内容简介:</h4>
                        <p><?php echo $book["intro"] ?></p></span><br/>
                </div>
            </div>
        </div>


        <div id = "book_comments" >
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
                                <span class = "comment_user_name"><?php echo $comment_user["nickname"] ?></span>评论:<br/>
                                <?php echo $comment["comment"] ?><br>
                                <span class ="comment_time"><?php echo $comment["pub_time"] ?></span><br/>
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
                <input id = "book_comments_button" type = "button" name = "book_notes" value ="我想评论这本书" class="btn primary"/>
                <form id = "input_comments" enctype="multipart/form-data" action = "<?php echo base_url() . "index.php/book/addcommentsandnotes/" . $book["id"] ?>" method = "post"/>
                <fieldset id = "fieldset_input_comments">
                    <textarea  class ="input_text"name = "input_comment" placeholder="请输入您的评论"></textarea>
                    <br>
                    <label class = "input_submit"><input type = "submit" size ="20"name = "submit_button" value = "评论" class="btn success"/></label>
                </fieldset>
            </div>
            <?php
        }
        ?>

        <div id = "book_notes" >
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
                                    <img class ="user_img" src="<?php echo base_url() . "/img/avatar/" . $note_user['avatar']; ?>" alt="暂时无法显示图片"/>                    
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
            <input id = "book_notes_button" type = "button" name = "book_notes" value ="我想做笔记" class="btn primary"/>
            <div>
                <fieldset id ="fieldset_input_notes">
                    <textarea placeholder="请输入您的笔记" name="input_note" class="input_text"></textarea>
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
    <div id = "book_fond" class="span-one-third">
        <div id ="who_looks_thebook" >
            <h1 class ="right_part_h">
                谁读过这本书?<br>
            </h1>
            <?php
            if (count($peopleReadBook) > 0) {
                foreach ($peopleReadBook as $prb) {
                    ?>
                    <div class ="man_look_thebook" >
                        <div class ="read_books_user_photo">
                            <a href="<?php echo base_url("index.php/user/showuser/{$prb["id"]}") ?>" target ="_blank">
                                <img class ="user_img" src="<?php echo base_url() . "/img/avatar/" . $prb['avatar']; ?>" alt="暂时无法显示图片"/>                    
                            </a>
                        </div>
                        <div>
                            用户名：<span class = "read_books_user_info"><?php echo $prb["nickname"] ?></span><br>
                            注册时间:<span class = "read_books_user_info"><?php echo $prb["reg_time"] ?></span><br>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            } else {
                ?>
                <div class ="noOneLookBook">
                    暂时还没有人看过这本书
                </div>
                <?php
            }
            ?>               
        </div>
        <div id ="fav_books" >
            <h1 class ="right_part_h">
                其他人还看?<br>
            </h1>
            <?php
            $count = 0;
            if (count($favbooks) > 0) {
                foreach ($favbooks as $fav_book) {
                    if ($count > 7)
                        break;
                    $count++;
                    if ($book['id'] == $fav_book['id'])
                        continue;
                    ?>
                    <div class ="man_look_thebook" >
                        <div class ="read_books_user_photo">

                            <a href="<?php echo base_url("index.php/book/view/{$fav_book["id"]}") ?>" target ="_blank">
                                <img class ="user_img" src="<?php echo base_url("img") . '/cover/' . $fav_book["cover"]; ?>" alt="暂时无法显示图片"/>                    
                            </a>
                        </div>
                        <div>
                            书名<span  class = "read_books_user_info">：<?php echo $fav_book["name"] == "" ? "暂无信息" : $fav_book["name"] ?></span><br>
                            作者<span  class = "read_books_user_info">：<?php echo $fav_book["author"] == "" ? "暂无信息" : $fav_book["author"] ?></span><br>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            } else {
                ?>
                <div class ="noOneLookBook">
                    暂时没有其他人信息
                </div>
                <?php
            }
            ?>               
        </div>
    </div>
</div>