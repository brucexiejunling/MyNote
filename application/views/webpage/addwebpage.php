<div class="container_user">
    <div id ="info_container">
        <form id = "form_style" enctype="multipart/form-data" action = "<?php echo base_url()."index.php/book/formresult" ?>" method = "post"/>
        <fieldset id = "signup_part">
            <legend>
                <ul class="pills">
                    <li><a href="<?php echo base_url() . "index.php/book/addbook" ?>">Add Book</a></li>
                    <li ><a href="<?php echo base_url() . "index.php/paper/addpaper" ?>">Add Paper</a></li>
                    <li class ="active"><a href="<?php echo base_url() . "index.php/webpage/addwebpage" ?>">Add Webpage</a></li>
                </ul>
            </legend>
            <div class="clearfix">
                <label for="xlInput">Webpage Title：</label>
                <div class="input">
                    <input id="xlInput" class="xlarge" type="text" size="30" name="webpagetitle">
                    <span class="help-block">No more than 30 letters</span>
                </div>
            </div>

            <div class="clearfix">
                <label for="xlInput">Web Url：</label>
                <div class="input">
                    <input id="xlInput" class="xlarge" type="text" size="30" name="webpageurl">
                    <span class="help-block">For example:Martin Lurther King</span>
                </div>
            </div>

            <div class="clearfix">
                <label for="textarea">Introduction：</label>
                <div class="input">
                    <textarea id="textarea2" class="xxlarge" rows="3" name="webpageintro"></textarea>
                    <span class="help-block"> Brief and neccessary infomation acquired</span>
                </div>
            </div>

            <div class="clearfix">
                <label for="textarea">Classification：</label>
                <div class="input">
                    <select id="stackedSelect" name=" Classification">
                        <option value="1" seleted="selected">奇幻</option>
                        <option value="2">侦探</option>
                        <option value="3">武侠</option>
                        <option value="4">文学</option>
                        <option value="5">技术</option>
                    </select>
                </div>
            </div>
            <div class="clearfix">
                <div class="input">
                <input type="submit" value="Add webpage" class =" btn success"></input>
                </div>
            </div>
        </fieldset>
        </form> 
    </div>

</div>
</div>