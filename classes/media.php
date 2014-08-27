<?php

class Maxxdev_Helper_Media {

	public static function addThumbnailSize($name, $width, $height, $crop = false, $check_existing_name = false) {
		$reserved_words = array("thumb", "thumbnail", "medium", "large", "post-thumbnail");

		if (in_array($name, $reserved_words)) {
			return false;
		}

		if ($check_existing_name === true) {
			global $_wp_additional_image_sizes;

			if (array_key_exists($name, $_wp_additional_image_sizes)) {
				return false;
			}
		}

		add_image_size($name, $width, $height, $crop);

		return true;
	}

	public static function addMediaFromPath($filename, $parent_post_id = 0) {
		$filetype = wp_check_filetype(basename($filename), null);
		$wp_upload_dir = wp_upload_dir();

		$attachment = array(
			'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
			'post_content' => '',
			'post_status' => 'inherit'
		);

		$attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);

		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata($attach_id, $filename);
		wp_update_attachment_metadata($attach_id, $attach_data);

		return $attach_id;
	}

}
