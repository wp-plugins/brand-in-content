<?php
/**
 * @package brand-in-content
 * @version 1.1.1
 */
/*
Plugin Name: Brand In Content
Plugin URI: http://wordpress.org/plugins/brand-in-content
Description: Replace your Brand name with Image Logo or custom style in WordPress Content.
Version: 1.1.1
Author: AboZain, Mohammed J. AlBanna
Author URI: https://profiles.wordpress.org/abozain
*/

add_action( 'admin_menu', 'bic_reg_menu' );

function bic_reg_menu(){
	add_options_page( __('Brand In Content', 'BrandInContent'), __('Brand In Content', 'BrandInContent'), 'administrator', 'brand-in-content', 'bic_BrandInContent'); 
}

//////////////////////////
# Load plugin text domain
add_action( 'init', 'bic_plugin_textdomain' );
# Text domain for translations
function bic_plugin_textdomain() {
    $domain = 'BrandInContent';
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
    load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
    load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}
//////////////////////////

function bic_BrandInContent(){

	//echo 'my test';
	//print_r($_POST);
	if(isset($_POST['brand_name']) && ($_POST['brand_name']) ){
		//print_r($_POST);
				$data['brand_name'] = sanitize_text_field( $_POST['brand_name'] );
                $data['image_url'] = sanitize_text_field( $_POST['image_url'] );
                $data['height'] = sanitize_text_field( $_POST['height'] );
                $data['width'] = sanitize_text_field( $_POST['width'] );
				$data['alt'] = sanitize_text_field( $_POST['alt'] );
				$data['title'] = sanitize_text_field( $_POST['title'] );
				$data['position_from_top'] = sanitize_text_field( $_POST['position_from_top'] );

                update_option('brand_in_content', $data);		
		echo '<br /> <br /> <h2 style="
  color: green;
  background-color: white;
  height: 15px;
  width: 95%;
  padding: 20px;">'.__('Saved Successfully', 'BrandInContent').'</h2>';
	}else{
		$data =  get_option('brand_in_content'); 
		//print_r($data);
	}
	$brand_name = (isset($data['brand_name']))? esc_html($data['brand_name']) : '';
	$image_url = (isset($data['image_url']))? esc_html($data['image_url']) : '';
	$height = (isset($data['height']))? esc_html($data['height']) : '';
	$width = (isset($data['width']))? esc_html($data['width']) : '';
	$alt = (isset($data['alt']))? esc_html($data['alt']) : '';
	$title = (isset($data['title']))? esc_html($data['title']) : '';
	$position_from_top = (isset($data['position_from_top']))? esc_html($data['position_from_top']) : '2px';
	?>
        <div class="wrap">
            <?php screen_icon('edit-pages'); ?>
			<h2><?php _e('Brand In Content', 'BrandInContent') ?></h2>
            <h4><?php _e('Replace your Brand name with Image Logo or custom style in WordPress Content', 'BrandInContent') ?></h4>
            <form method="post" action="">
				<?php settings_fields( 'disable-settings-group' ); ?>
            	<?php do_settings_sections( 'disable-settings-group' ); ?>
			<br/>
			<table>	
			<tr>
				<td><label> <?php _e('Find Text', 'BrandInContent') ?> </label></td>
				<td><input id="brand_name" type="text" size="30" name="brand_name" value="<?php echo $brand_name ?>" /></td>
				<td> </td>
			</tr>
			<tr>
				<td><label> <?php _e('Upload Image', 'BrandInContent') ?> </label></td>
				<td>
					<input id="image_url" type="text" size="30" name="image_url" value="<?php echo $image_url ?>" /><br/>
					<input id="image_url_button" class="button" type="button" value="Upload Image" />	
				</td>
				<td> </td>
			</tr>
			<tr>
				<td><label> <?php _e('Height', 'BrandInContent') ?> </label></td>
				<td><input id="height" type="text" size="30" name="height" value="<?php echo $height ?>" maxlength="5" /> </td>
				<td> </td>
			</tr>
			<tr>
				<td><label> <?php _e('Width', 'BrandInContent') ?> </label></td>
				<td><input id="width" type="text" size="30" name="width" value="<?php echo $width ?>" maxlength="5" /> </td>
				<td> </td>
			</tr>
			<tr>
				<td><label> <?php _e('Title', 'BrandInContent') ?> </label></td>
				<td><input id="title" type="text" size="30" name="title" value="<?php echo $title ?>" maxlength="100" /> </td>
				<td> </td>
			</tr>
			<tr>
				<td><label> <?php _e('Alt', 'BrandInContent') ?> </label></td>
				<td><input id="alt" type="text" size="30" name="alt" value="<?php echo $alt ?>" maxlength="100" /> </td>
				<td> </td>
			</tr>
			<tr>
				<td><label> <?php _e('Position from top', 'BrandInContent') ?> </label></td>
				<td><input id="position_from_top" type="text" size="30" name="position_from_top" value="<?php echo $position_from_top ?>" maxlength="5" /> </td>
				<td> </td>
			</tr>
			<table>
                <?php submit_button(); ?>
            </form>
        </div>	
		
		<br/>
		<h3><?php _e('Preview Image', 'BrandInContent') ?></h3>
		<?php _e('This is preview', 'BrandInContent') ?> <img src="<?php echo $image_url ?>" width="<?php echo $width ?>" height="<?php echo $height ?>" alt="<?php echo $alt ?>" title="<?php echo $title ?>" style="display: inline-block;position: relative;top: <?php echo $position_from_top ?>;}"   > <?php _e('how the image will apear in your site', 'BrandInContent') ?>
		

		
<script>
 var image_custom_uploader;
 jQuery('#image_url_button').click(function(e) {
 e.preventDefault();

 //If the uploader object has already been created, reopen the dialog
 if (image_custom_uploader) {
 image_custom_uploader.open();
 return;
 }

 //Extend the wp.media object
 image_custom_uploader = wp.media.frames.file_frame = wp.media({
 title: 'Choose Image',
 button: {
 text: 'Choose Image'
 },
 multiple: false
 });

 //When a file is selected, grab the URL and set it as the text field's value
 image_custom_uploader.on('select', function() {
 attachment = image_custom_uploader.state().get('selection').first().toJSON();
 var url = '';
 url = attachment['url'];
 jQuery('#image_url').val(url);
 });

 //Open the uploader dialog
 image_custom_uploader.open();
 });
</script>
		
		<?php
}

//////////////////////////
function bic_replace_text_wps($text){

		$data =  get_option('brand_in_content'); 
			
			$brand_name = (isset($data['brand_name']))? esc_html($data['brand_name']) : '';
			$image_url = (isset($data['image_url']))? esc_html($data['image_url']) : '';
			$height = (isset($data['height']))? esc_html($data['height']) : '';
			$width = (isset($data['width']))? esc_html($data['width']) : '';
			$alt = (isset($data['alt']))? esc_html($data['alt']) : '';
			$title = (isset($data['title']))? esc_html($data['title']) : '';
			$position_from_top = (isset($data['position_from_top']))? esc_html($data['position_from_top']) : '';

        $replace = array(
                // 'WORD TO REPLACE' => 'REPLACE WORD WITH THIS'
                $brand_name => '<img src="'.$image_url.'" width="'. $width.'" height="'.$height.'"  alt="'.$alt.'" title="'.$title.'"  style="display: inline-block;position: relative;top: '.$position_from_top.'}"  >',
        );
        $text = str_replace(array_keys($replace), $replace, $text);
        return $text;
}

add_filter('the_content', 'bic_replace_text_wps');


///////////////
function bic_load_wp_media_files() {
  wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'bic_load_wp_media_files' );

?>
