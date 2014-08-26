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

}
