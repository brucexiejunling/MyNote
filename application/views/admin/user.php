<div class="span13">
    <table class="bordered-table">
        <tr>
            <th>id</th>
            <th>email</th>
            <th>nickname</th>
            <th>privilege</th>
            <th>avatar</th>
            <th>operation</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['id'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['nickname'] ?></td>
                <td><?php echo $user['privilege']==1?"admin":"user" ?></td>
                <td><img src='<?php echo base_url("img/avatar/{$user['avatar']}") ?>' alt="avatar"/></td>
                <td>
                    <!--button class="btn primary">Edit</button-->
                    <button class="btn danger delete" alt="<?php echo $user['id']?>">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="pagination">
        <ul>
            <li class="prev <?php echo $cur_page==1?'disabled':''?>"><a href="<?php echo base_url('index.php/admin/user/'.($cur_page==1?1:$cur_page-1))?>">&larr; Previous</a></li>
            <?php for($i=$cur_page-1; $i>0 && $i>=$cur_page-3; $i--){ ?>
            <li><a href="<?php echo base_url("index.php/admin/user/$i")?>"><?php echo $i ?></a></li>
            <?php } ?>
            <li class="active"><a href="<?php echo base_url("index.php/admin/user/$cur_page")?>"><?php echo $cur_page ?></a></li>
            <?php for($i=$cur_page+1; $i<=$total_page && $i<=$cur_page+3; $i++){ ?>
            <li><a href="<?php echo base_url("index.php/admin/user/$i")?>"><?php echo $i ?></a></li>
            <?php } ?>
            <li class="next <?php echo $cur_page==$total_page?'disabled':''?>"><a href="<?php echo base_url('index.php/admin/user/'.($cur_page==$total_page?$total_page:$cur_page+1))?>">Next &rarr;</a></li>
        </ul>
    </div>
</div>
</div>