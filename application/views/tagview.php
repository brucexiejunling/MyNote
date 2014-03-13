<div class="pl">标签</div>
<div class="tag_row">
    <?php 
    foreach ($tags as $tag) {
        $tag_target = $this->TagTargetModel->getSpercified($target_type['id'], $target_id, $tag['id']);
        $tag_num = $this->TagshipModel->count_up($tag_target['id']);
        ?>
        <span class="label tag <?php echo $islogin && !$this->TagshipModel->voted($tag_target['id'], $userdata['id'])?"notice":"" ?>"
              alt="<?php echo $tag['id'] ?>" 
              target_type="<?php echo $target_type['id'] ?>" 
              target_id="<?php echo $target_id ?>">
            <?php echo $tag['name'] ?>(<?php echo $tag_num ?>)
        </span>
    <?php } ?>
</div>
<span class="addtag">
    <form action="<?php echo base_url("index.php/tag/add/{$target_type['id']}/$target_id") ?>">
        <input type="text" name="newtag" placeholder="new tag" />
        <input type="button" value="add new tag" class="btn" id="tagcontroller"/>
    </form>
</span><br/>


