<?php

//---------------------------------------------------------------------------------
//	Optimize WP Output of tags and Content
//---------------------------------------------------------------------------------
	if(current_theme_supports( 'cleaner-image-output' )){
		add_filter( 'img_caption_shortcode', 'stella_cleaner_caption', 10, 3 );
		function stella_cleaner_caption( $output, $attr, $content ) {

			if ( is_feed() )
				return $output;

			/* Set up the default arguments. */
			$defaults = array(
				'id' => '',
				'align' => 'alignnone',
				'width' => '',
				'caption' => ''
			);

			/* Merge the defaults with user input. */
			$attr = shortcode_atts( $defaults, $attr );

			/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
			if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
				return $content;

			$attributes = ' class="figure ' . esc_attr( $attr['align'] ) . '"';
			$output = '<figure' . $attributes .'>';
			$output .= do_shortcode( $content );
			$output .= '<figcaption>' . $attr['caption'] . '</figcaption>';
			$output .= '</figure>';
				return $output;
		}

		function stella_image_tag_class($class, $id, $align, $size) {
			$align = 'align' . esc_attr($align);
			return $align;
		}
		add_filter('get_image_tag_class', 'stella_image_tag_class', 0, 4);

		function stella_image_tag($html, $id, $alt, $title) {
			return preg_replace(array(
					'/\s+width="\d+"/i',
					'/\s+height="\d+"/i',
					'/alt=""/i'
				),
				array(
					'',
					'',
					'',
					'alt="' . $title . '"'
				),
				$html);
		}
		add_filter('get_image_tag', 'stella_image_tag', 0, 4);

		function stella_img_unautop($pee) {
		    $pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee);
		    return $pee;
		}
		add_filter( 'the_content', 'stella_img_unautop', 30 );
	}


	// Santize filenames
	function stella_theme_filename_lowercase($filename) {
	    $info = pathinfo($filename);
	    $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
	    $name = basename($filename, $ext);

	    //Sanitize Swedish Characters
	    $separator = "_";

		mb_internal_encoding("UTF-8");
		mb_regex_encoding('UTF-8');
		$clean = mb_ereg_replace('å', 'a', mb_strtolower($name));
		$clean = mb_ereg_replace('ä', 'a', $clean);
		$clean = mb_ereg_replace('ö', 'o', $clean);
		$clean = mb_ereg_replace('é', 'e', $clean);
		$clean = mb_ereg_replace('è', 'e', $clean);
		$clean = mb_ereg_replace('ü', 'u', $clean);
		$clean = preg_replace('/[^a-z0-9\s-]+/', '', $clean);
		//$clean = mb_ereg_replace('-', '', $clean);
		$clean = mb_ereg_replace('\s{2,}', ' ', $clean);
		$clean = mb_ereg_replace(' ', $separator, $clean);
		$clean = mb_ereg_replace($separator.'{2,}', $separator, $clean);
		$clean = rtrim($clean, "-");
		return $clean . $ext;
	}
	add_filter('sanitize_file_name', 'stella_theme_filename_lowercase', 10);

//---------------------------------------------------------------------------------
//	Sharpen, and interlace images
//---------------------------------------------------------------------------------
function modify_image_before_saving( $image, $post_id ){
	if ( 'attachment' == get_post_type( $post_id ) ){
		return $image;
	}
	//add interlace image option
	imageinterlace( $image, true );

	// sharpen image
	imageconvolution( $image, array(-1,-1,-1,-1,16,-1,-1,-1,-1) , 8, 0 );

	return $image;
}
add_filter( 'image_save_pre','modify_image_before_saving', 15, 2 );


//---------------------------------------------------------------------------------
//	Simple IMG-wrapper
//---------------------------------------------------------------------------------

/*
* Resize images dynamically using wp built in functions
* Victor Teixeira
*
* php 5.2+
*
* Exemplo de uso:
*
* <?php
* $thumb = get_post_thumbnail_id();
* $image = vt_resize($thumb, '', 140, 110, true);
* ?>
* <img src="<?php echo $image[url] ?>" width="<?php echo $image[width] ?>" height="<?php echo $image[height] ?>" />
*
* @param int $attach_id
* @param string $img_url
* @param int $width
* @param int $height
* @param bool $crop
* @return array
*/
function make_image($src, $width, $height, $crop = false, $return_array = false, $filter = false){

    $attach_id = $src;
    $img_url = $src;

    if(is_array($src)) {
        $attach_id = $src['id'];
        $image_src = wp_get_attachment_image_src($attach_id, 'full');
        $file_path = get_attached_file($attach_id);
        $image_meta = wp_get_attachment_metadata($attach_id);
        $image_meta = array(
            "title" => get_the_title($attach_id),
            "alt" => get_post_meta($attach_id, '_wp_attachment_image_alt', true),
            "description" => get_the_content($attach_id)
        );

    } elseif(!filter_var($src, FILTER_VALIDATE_URL)){
        // if its not an URL assume its an ID
        // this is an attachment, so we have the ID
        $image_src = wp_get_attachment_image_src($attach_id, 'full');
        $file_path = get_attached_file($attach_id);
        $image_meta = array(
            "title" => get_the_title($attach_id),
            "alt" => get_post_meta($attach_id, '_wp_attachment_image_alt', true),
            "description" => get_the_content($attach_id)
        );
    } else {

        // this is not an attachment, let's use the image url
        $file_path = parse_url($img_url);
        $file_path = $_SERVER['DOCUMENT_ROOT'].$file_path['path'];
        $image_meta = array();

        // Look for Multisite Path
        if(file_exists($file_path) === false){
            global $blog_id;
            $file_path = parse_url($img_url);
            if(preg_match('/files/', $file_path['path'])){
                $path = explode('/', $file_path['path']);
                foreach($path as $k => $v){
                    if($v == 'files'){
                        $path[$k-1] = 'wp-content/blogs.dir/'.$blog_id;
                    }
                }
                $path = implode('/', $path);
            }
            $file_path = $_SERVER['DOCUMENT_ROOT'].$path;
        }
        //$file_path = ltrim( $file_path['path'], '/' );
        //$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
        $orig_size = getimagesize($file_path);
        $image_src[0] = $img_url;
        $image_src[1] = $orig_size[0];
        $image_src[2] = $orig_size[1];
    }


    if($filter){

        list($orig_w, $orig_h, $orig_type) = @getimagesize($file_path);
        $image = wp_load_image($file_path);
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        imagealphablending($image, false);
        imagesavealpha($image, true);
        //imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
        switch ($orig_type) {
            case IMAGETYPE_GIF:
                $file = str_replace(".gif", "-bw.gif", $file_path);
                imagegif( $image, $file );
                break;
            case IMAGETYPE_PNG:
                $file = str_replace(".png", "-bw.png", $file_path);
                imagepng( $image, $file );
                break;
            case IMAGETYPE_JPEG:
                $file = str_replace(".jpg", "-bw.jpg", $file_path);
                imagejpeg( $image, $file );
                break;
        }
        $file_path = $file;
    }

    $file_info = pathinfo($file_path);

    // check if file exists
    $base_file = $file_info['dirname'].'/'.$file_info['filename'].'.'.$file_info['extension'];
    if(!file_exists($base_file)) {
        return;
    }

    $extension = '.'. $file_info['extension'];
    // the image path without the extension
    $no_ext_path = $file_info['dirname'].'/thumbnails/'.$file_info['filename'];

    if (!is_numeric($attach_id)) {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$attach_id'";
        $attach_id = $wpdb->get_var($query);
    }

//    $attach_id = apply_filters('sanitize_filename',$attach_id);

    //echo $attach_id;

    $cropped_img_path = $no_ext_path. '-' . $attach_id .'-'.$width.'x'.$height.$extension;
    // checking if the file size is larger than the target size
    // if it is smaller or the same size, stop right here and return



    if($image_src[1] >= $width){

        // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
        if(file_exists($cropped_img_path)){
            $cropped_img_url = str_replace(basename($image_src[0]), 'thumbnails/'.basename($cropped_img_path), $image_src[0]);

            $vt_image = array(
                'url'   => $cropped_img_url,
                'width' => $width,
                'height'    => $height,
                'meta'	=> $image_meta
            );
            return (!$return_array) ? $vt_image['url'] : $vt_image;
        }
        // $crop = false or no height set
        if($crop == false OR !$height){
            // calculate the size proportionaly
            $proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
            $resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;
            // checking if the file already exists
            if(file_exists($resized_img_path)){
                $resized_img_url = str_replace(basename($image_src[0]), 'thumbnails/'.basename($resized_img_path), $image_src[0]);
                $vt_image = array(
                    'url'   => $resized_img_url,
                    'width' => $proportional_size[0],
                    'height'    => $proportional_size[1],
                    'meta'	=> $image_meta
                );
                return (!$return_array) ? $vt_image['url'] : $vt_image;
            }
        }
        // check if image width is smaller than set width
        $img_size = getimagesize($file_path);
        if($img_size[0] <= $width) $width = $img_size[0];
        // Check if GD Library installed
        if(!function_exists('imagecreatetruecolor')){
            echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library';
            return;
        }
        // no cache files - let's finally resize it


        $image = wp_get_image_editor($file_path);
        if ( ! is_wp_error( $image ) ) {
	        $image->resize( $width, $height, $crop );
            $final_image = $image->save( $cropped_img_path );
        }

        //$new_img_path = image_resize($file_path, $width, $height, $crop);
        //$new_img_size = getimagesize($new_img_path);

	    list($orig_w, $orig_h, $orig_type) = @getimagesize($final_image['path']);
	    switch ($orig_type) {
		    case IMAGETYPE_GIF:
			    break;
		    case IMAGETYPE_PNG:
			    break;
		    case IMAGETYPE_JPEG:
			    $image = imagecreatefromstring( file_get_contents( $final_image['path'] ) );
			    imageinterlace($image, true);
			    imagejpeg($image, $final_image['path'], 75);
			    imagedestroy($image);
			    break;
	    }

        $new_img = str_replace(basename($image_src[0]), 'thumbnails/'.basename($final_image['path']), $image_src[0]);


        // resized output
        $vt_image = array(
            'url'   => $new_img,
            'width' => $final_image['width'],
            'height'    => $final_image['height'],
            'meta'	=> $image_meta
        );
        return (!$return_array) ? $vt_image['url'] : $vt_image;
    }
    // default output - without resizing
    $vt_image = array(
        'url'   => $image_src[0],
        'width' => $width,
        'height'    => $height,
        'meta'	=> $image_meta
    );
    return (!$return_array) ? $vt_image['url'] : $vt_image;
}

function stella_resize($src, $width, $height, $crop = false, $return_array = false, $filter = false){
    return make_image($src, $width, $height, $crop, $return_array, $filter);
}
//  Legacy
function houston_resize($src, $width, $height, $crop = false, $return_array = false, $filter = false){
    return make_image($src, $width, $height, $crop, $return_array, $filter);
}