<?php
 global $wpdb, $table_prefix;
 $tbl_emp = $table_prefix.'emp';
 if(isset($_GET['my-search-term'])){
    $getData = "SELECT * FROM `$tbl_emp` WHERE `name` LIKE '%".$_GET['my-search-term']."%';";
 }else{
    $getData = "SELECT * FROM `$tbl_emp`;";
 }
 $results = $wpdb->get_results($getData);
 ob_start(); ?>
    <html>
        <div class="wrap">
        <h1 class="wp-heading-inline">Manage employee</h1>
        <div class="tablenav top">
            <div class="my-form">
            <form action="<?php echo admin_url('admin.php'); ?>" id="my-search-form">
                <p class="search-box">
                <input type="hidden" name="page" value="my-plugin-page">
                <input type="text" id="my-search-term" name="my-search-term">
                <input type="submit" id="search-submit" class="button" value="Search employee">
                </p>
            </form>
             </div>
        </div>
        <table class="wp-list-table widefat fixed striped table-view-list posts">
             <thead>
                 <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>status</th>
                 </tr>
             </thead>
         <tbody id="my-tbl-result">
             <?php foreach($results as $row): ?>
             <tr>
                 <td><?php echo $row->ID;?></td>
                 <td><?php echo $row->name;?></td>
                 <td><?php echo $row->email;?></td>
                 <td><?php if($row->status == 1){ echo 'Active';} else{ echo 'Deactive';} ?></td>
             </tr>
             <?php endforeach; ?>
         </tbody>
         </table>
         </div>
    </html>
 <?php
echo ob_get_clean();
