<?php
/*
Plugin Name: WP Test
Description: Test plugin
Author: Ken
Version: 1.0
Plugin Slug: wp-test
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp_test
*/

require 'vendor/autoload.php';
use Michelf\Markdown;
function markdown_text($text){
    $html = Markdown::defaultTransform($text);
    return $html;
}
function wptest_register_my_custom_menu_page() {
    add_menu_page(
        __( 'WP Test', 'wp_test' ),
        'WP Test',
        'manage_options',
        'admin-seting',
        'f_admin_seting',
        'dashicons-chart-pie',
        90
    );
}
add_action( 'admin_menu', 'wptest_register_my_custom_menu_page' );

function f_admin_seting(){
    global $wpdb;
    do_action('data_enqueue_scripts');
    include_once ('admin-seting.php');
}

function my_scripts_method() {
  //  wp_enqueue_style('datatables-style', plugin_dir_url(__FILE__) . '/assets/css/datatables.min.css', array(), '1.0.0', 'all' );
  //  CDN
    wp_enqueue_style('datatables-style',  'https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css', array(), '1.0.0', 'all' );
    wp_enqueue_style('bootstrap.min.css',   plugin_dir_url(__FILE__).'/assets/css/bootstrap.min.css', array(), '1.0.0', 'all' );
    wp_enqueue_style('data-style',   plugin_dir_url(__FILE__).'/assets/css/data-style.css', array(), '1.0.0', 'all' );
  ///  wp_enqueue_script('datatables-js', plugin_dir_url(__FILE__) . '/assets/js/datatables.min.js', array(), '1.0.0', 'true' );
  /// CDN
    wp_enqueue_script('jquery-3.3.1-js',  'https://code.jquery.com/jquery-3.3.1.js', array(), '1.0.0', 'true' );
    wp_enqueue_script('datatables-js',  'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js', array(), '1.0.0', 'true' );
    wp_enqueue_script('bootstrap.min.js', plugin_dir_url(__FILE__) . '/assets/js/bootstrap.min.js', array(), '1.0.0', 'true' );
    wp_enqueue_script('function-js', plugin_dir_url(__FILE__) . '/assets/js/function.js', array(), '1.0.0', 'true' );
}
add_action( 'data_enqueue_scripts', 'my_scripts_method' );


function get_data($url){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    if($result === false)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Curl error: ' . curl_error($curl).'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
        return false;
    }
   return  json_decode($result,ARRAY_A);
}
add_action( 'wp_ajax_get_detail_user', 'f_get_detail_user' );
function f_get_detail_user(){
  $user = $_POST['user'];
  $data = get_data('https://jsonplaceholder.typicode.com/users/'.$user);
  if(is_array($data)):
    ?>
      <div class="modal-header">
          <div class="modal-title" id="exampleModalLabel"><?php _e( markdown_text('##### '.$data['name'] )); ?></div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <table>
              <!--   Loop 1 users -->
              <?php foreach ($data as $key=> $item): ?>
                  <tr>
                      <td class="label"><?php _e($key); ?></td>
                      <td>
                          <?php if(!is_array($item)):  ?>
                              <?php _e($item); ?>
                          <?php else: ?>
                              <!--   Loop 2 users -->
                              <?php foreach ($item as $t=>$list): if(!is_array($list)): ?>

                                  <label class="label"><?php _e($t); ?>: </label>
                                  <span><?php _e($list); ?></span><br/>

                              <?php endif; endforeach;  ?>
                              <!--  end Loop 2 users -->
                          <?php endif; ?>
                      </td>

                  </tr>
              <?php endforeach; ?>
              <!--  end Loop 1 users -->
          </table>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

<?php
  else:
     echo  $data;
  endif;
    die();
}