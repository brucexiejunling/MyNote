<div class="span13">
    <table class="bordered-table">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>isbn13</th>
            <th>isbn10</th>
            <th>author</th>
            <th>classification</th>
            <th>cover</th>
            <th>operation</th>
        </tr>
        <?php foreach ($books as $book) { ?>
            <tr>
                <td><?php echo $book['id'] ?></td>
                <td><?php echo $book['name'] ?></td>
                <td><?php echo $book['isbn13'] ?></td>
                <td><?php echo $book['isbn10'] ?></td>
                <td><?php echo $book['author'] ?></td>
                <td>
                    <?php $classification = $this->ClassificationModel->getClassificationById($book['classification']) ?>
                    <?php echo $classification['classification'] ?>
                </td>
                <td><img src='<?php echo base_url("img/cover/{$book['cover']}") ?>' alt="cover"/></td>
                <td>
                    <!--button class="btn primary">Edit</button-->
                    <button class="btn danger delete" alt="<?php echo $book['id']?>">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="pagination">
        <ul>
            <li class="prev <?php echo $cur_page==1?'disabled':''?>"><a href="<?php echo base_url('index.php/admin/book/'.($cur_page==1?1:$cur_page-1))?>">&larr; Previous</a></li>
            <?php for($i=$cur_page-1; $i>0 && $i>=$cur_page-3; $i--){ ?>
            <li><a href="<?php echo base_url("index.php/admin/book/$i")?>"><?php echo $i ?></a></li>
            <?php } ?>
            <li class="active"><a href="<?php echo base_url("index.php/admin/book/$cur_page")?>"><?php echo $cur_page ?></a></li>
            <?php for($i=$cur_page+1; $i<=$total_page && $i<=$cur_page+3; $i++){ ?>
            <li><a href="<?php echo base_url("index.php/admin/book/$i")?>"><?php echo $i ?></a></li>
            <?php } ?>
            <li class="next <?php echo $cur_page==$total_page?'disabled':''?>"><a href="<?php echo base_url('index.php/admin/book/'.($cur_page==$total_page?$total_page:$cur_page+1))?>">Next &rarr;</a></li>
        </ul>
    </div>
</div>
</div>