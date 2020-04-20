<div class="wrap" id="wrap_data">
    <h1>WP Test</h1>
    <span>API: https://jsonplaceholder.typicode.com/users/</span>
    <?php
    $datas =  get_data('https://jsonplaceholder.typicode.com/users/');
    ?>
    <div class="content">
        <table id="wp_test_data" class="display" style="width:100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <?php if($datas): foreach ($datas as $value): ?>
            <tr>
                <td><a onclick="get_user(<?php _e($value['id']); ?>)"><?php _e($value['id']); ?></a></td>
                <td><a onclick="get_user(<?php _e($value['id']); ?>)"><?php _e($value['name']); ?></a></td>
                <td><a onclick="get_user(<?php _e($value['id']); ?>)"><?php _e($value['username']); ?></a></td>
                <td> <a onclick="get_user(<?php _e($value['id']); ?>)"><?php _e($value['email']); ?></a> </td>
            </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="detail_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>
    </div>
</div>

