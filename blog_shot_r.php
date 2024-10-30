<?php
/*
 * Plugin Name: BlogShotR
 * Plugin URI: http://basicblogger.de/2008/11/16/wp-plugin-blogshotr/
 * Description: Show the Commentators Blog Shot
 * Version: 0.2
 * Author: Ahmet Topal
 * Author URI: http://basicblogger.de
 */
$bs_option_w = get_option('bs_option_w');

if ('insert' == $HTTP_POST_VARS['action'])
{
    update_option("bs_option_w",$HTTP_POST_VARS['bs_option_w']);
}


// Innerhalb von the_loop reicht das
function bs_description_w() {
  global $id, $post_meta_cache, $bs_option_w; // globale Variablen

  if ( $keys = get_post_custom_keys() ) {
    foreach ( $keys as $key ) {
      $values = array_map('trim', get_post_custom_values($key));
      $value = implode($values,', ');
      if ( $key == bs_option_w ) {
        echo "$value";
      }
    }
  }
} // Ende Funktion bs_description_w()

$bs_option_h = get_option('bs_option_h');

if ('insert' == $HTTP_POST_VARS['action'])
{
    update_option("bs_option_h",$HTTP_POST_VARS['bs_option_h']);
}

// Innerhalb von the_loop reicht das
function bs_description_h() {
  global $id, $post_meta_cache, $bs_option_h; // globale Variablen

  if ( $keys = get_post_custom_keys() ) {
    foreach ( $keys as $key ) {
      $values = array_map('trim', get_post_custom_values($key));
      $value = implode($values,', ');
      if ( $key == bs_option_h ) {
        echo "$value";
      }
    }
  }
} // Ende Funktion bs_description_h()

function bs_option_page() {
?>

<!-- Start Optionen im Admin -->
  <div class="wrap">
    <h2>BlogShotR Options</h2>
<form name="form1" method="post" action="<?=$location ?>">
	<label for="width" class="width">Image Width:</label>
      <input name="bs_option_w" value="<?=get_option("bs_option_w");?>" type="text" /><br />
	<label for="height" class="height">Image Heilght:</label>
      <input name="bs_option_h" value="<?=get_option("bs_option_h");?>" type="text" />
      <input type="submit" value="Save" />
      <input name="action" value="insert" type="hidden" />
    </form>
  </div>
<?php
} // Ende Funktion bs_option_page()

// Adminmenu Optionen erweitert
function bs_add_menu() {
  add_option("bs_option_w","90"); // optionsfield in Tabelle TABLEPRÄFIX_options
  add_option("bs_option_h","70"); // optionsfield in Tabelle TABLEPRÄFIX_options
  add_options_page('BlogShotR-Plugin', 'BlogShotR', 9, __FILE__, 'bs_option_page'); //optionenseite hinzufügen
}


function bs_image($text) {
	global $comment;
$bs_url = $comment->comment_author_url;
$bs_name = $comment->comment_author;
$bs_option_h = get_option('bs_option_h');
$bs_option_w = get_option('bs_option_w');
$bs_img = "<img src='http://images.websnapr.com/?url=$bs_url&size=t' alt='Die Homepage von $bs_name' class='' width='$bs_option_w' height='$bs_option_h'/>";
$text = "<span class='bs-image' style='float:right;'>$bs_img</span><br />" . $text;
return $text;
}

add_filter('comment_text', 'bs_image');
add_action('admin_menu', 'bs_add_menu');
?>