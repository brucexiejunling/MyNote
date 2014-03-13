<div class="span13">
    <table class="bordered-table">
        <tr>
            <th>id</th>
            <th>title</th>
            <th>authors</th>
            <th>classification</th>
            <th>image</th>
            <th>operation</th>
        </tr>
        <?php foreach ($papers as $paper) { ?>
            <tr>
                <td><?php echo $paper['id'] ?></td>
                <td><?php echo $paper['title'] ?></td>
                <td><?php echo $paper['authors'] ?></td>
                <td>
                    <?php $classification = $this->ClassificationModel->getClassificationById($paper['classification']) ?>
                    <?php echo $classification['classification'] ?>
                </td>
                <td><img src='<?php echo base_url("img/paper/{$paper['image']}") ?>' alt="cover"/></td>
                <td>
                    <!--button class="btn primary">Edit</button-->
                    <button class="btn danger delete" alt="<?php echo $paper['id']?>">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="pagination">
        <ul>
            <li class="prev <?php echo $cur_page==1?'disabled':''?>"><a href="<?php echo base_url('index.php/admin/paper/'.($cur_page==1?1:$cur_page-1))?>">&larr; Previous</a></li>
            <?php for($i=$cur_page-1; $i>0 && $i>=$cur_page-3; $i--){ ?>
            <li><a href="<?php echo base_url("index.php/admin/paper/$i")?>"><?php echo $i ?></a></li>
            <?php } ?>
            <li class="active"><a href="<?php echo base_url("index.php/admin/paper/$cur_page")?>"><?php echo $cur_page ?></a></li>
            <?php for($i=$cur_page+1; $i<=$total_page && $i<=$cur_page+3; $i++){ ?>
            <li><a href="<?php echo base_url("index.php/admin/paper/$i")?>"><?php echo $i ?></a></li>
            <?php } ?>
            <li class="next <?php echo $cur_page==$total_page?'disabled':''?>"><a href="<?php echo base_url('index.php/admin/paper/'.($cur_page==$total_page?$total_page:$cur_page+1))?>">Next &rarr;</a></li>
        </ul>
    </div>
</div>
</div>