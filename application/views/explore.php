<div class="row">
    <div class="leftcol">
        <ul class="media-grid" id="show-ground">
        </ul>
    </div>
    <div class="rightcol">
        <div class="filter">
            <div class="checkbox-set">
                <h3>Item Type:</h3>
                <input type="checkbox" id="checkbox_book" name="type" value="book"/><label for="checkbox_book">book</label>
                <input type="checkbox" id="checkbox_paper" name="type" value="paper"/><label for="checkbox_paper">paper</label>
                <input type="checkbox" id="checkbox_webpage" name="type" value="webpage"/><label for="checkbox_webpage">webpage</label>
            </div>
            <div class="checkbox-set">
                <h3>Classification:</h3>
                <?php foreach ($classifications as $classification) { ?>
                    <input type="checkbox" id="checkbox_<?php echo $classification['classification'] ?>" name="classification" value="<?php echo $classification['classification'] ?>"/>
                    <label for="checkbox_<?php echo $classification['classification'] ?>"><?php echo $classification['classification'] ?></label>
                <?php } ?>
            </div>
            <div>
                <h3>Group Explore:</h3>
                <ul class="group_list">
                <?php foreach($groups as $group){ ?>
                    <li>
                        <h5>
                            <a href="<?php echo base_url("index.php/group/showgroup/{$group['id']}")?>">
                            <?php echo $group['name']?>
                            </a>
                        </h5>
                        <p><?php echo $group['intro']?></p>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="leftcol">
        <button id="getmore" class="btn">more</button>
    </div>
</div>