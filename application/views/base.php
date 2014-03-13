<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="shortcut icon" href="<?php echo base_url("img")."/favicon.png"?>" type="image/x-icon"></link>
        <link rel="shortcut icon" href="<?php echo base_url("img")."/favicon.gif"?>" type="image/x-icon"></link>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("css") . "/bootstrap.min.css" ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("css")."/style.css"?>"></link>
        <?php
        if (isset($css)) {
            foreach ($css as $c) {
                ?>
                <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "css/$c" ?>"/>
            <?php }
        } ?>
        <script type="text/javascript" src="<?php echo base_url("js") . "/jquery.js" ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("js")."/bootstrap-dropdown.js" ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("js")."/nav.js" ?>"></script>
        <script type="text/javascript">var base_url = "<?php echo base_url() ?>"</script>
        <?php
        if (isset($js)) {
            foreach ($js as $j) {
                ?>
                <script type="text/javascript" src="<?php echo base_url() . "js/$j" ?>"></script>
            <?php }
        } ?>
        <title><?php echo isset($title) ? $title : "" ?></title>
    </head>
    <body>
        <div class="topbar" data-dropdown="dropdown">
            <div class="topbar-inner">
                <div class="container">
                    <h3><a href="<?php echo base_url(); ?>">WashingMachine</a></h3>
                    <ul class="nav">
                        <li><a href="<?php echo base_url("index.php/explore"); ?>">Explore</a></li>
                    </ul>
                    <form class="pull-left" action="<?php echo base_url("index.php/search")?>">
                        <input type="text" placeholder="Search" name="search"/>
                    </form>
                    <ul class="nav secondary-nav">
                    </ul>
                </div>

            </div>
        </div>
        <?php echo $body_content ?>
        <div class="row">
            <div class="footer span16">
                © 2011 washingmachine
                <a href="<?php echo base_url('index.php/admin')?>">Management Panel</a>
            </div>
        </div>
    </body>
</html>
