<li>
    <a href="<?php echo base_url().'index.php/book/view/'.$id ?>"
       rel="popover" title="<?php echo $name?>"
       data-content="<?php echo substr($intro, 0, 252)?>">
        <img src="<?php echo base_url("img/cover").'/'.$cover ?>"
             alt="<?php echo $name?>"/>
    </a>
</li>