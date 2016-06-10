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

    /**
     * Adds a thumbnail for a post by a form field (type=file)
     *
     * @param int $postID which POST should get the thumb?
     * @param string $formField what is the name of the field in the form (e.g. "file")
     * @param string $uploadDirPath in which folder (in wp-content/uploads) shall the file be saved
     * @param bool $deleteOldFiles shall old files in this folder be deleted? (default: false)
     * @return boolean
     */
    public static function addPostThumbnailByUpload($postID, $formField, $uploadDirPath, $deleteOldFiles = false) {
        $upload_file_name = $formField["name"];
        $upload_file_src = $formField["tmp_name"];

        $image_attributes = getimagesize($upload_file_src);

        if ($image_attributes != false) {
            $upload_file_type = $image_attributes["mime"];
            $upload_file_extension = pathinfo($upload_file_name, PATHINFO_EXTENSION);
            $new_filename = $postID . "_" . md5($formField["tmp_name"]) . "." . $upload_file_extension;
            $wp_upload_dir = wp_upload_dir();
            $upload_path_user = $wp_upload_dir["basedir"] . "/" . $uploadDirPath;
            $new_file_path = $upload_path_user . $new_filename;

            $attachment = array(
                "guid" => $wp_upload_dir["baseurl"] . "/" . $uploadDirPath . "/" . $new_filename,
                "post_mime_type" => $upload_file_type,
                "post_title" => $new_filename,
                "post_content" => "",
                "post_status" => "inherit"
            );

            $folders = explode("/", $uploadDirPath);

            if (count($folders) > 0) {
                $dir = $wp_upload_dir["basedir"];
                foreach ($folders as $folder) {
                    $dir .= "/" . $folder;

                    if (!file_exists($dir)) {
                        @mkdir($dir);
                    }
                }
            }

            // delete old files
            if ($deleteOldFiles == true) {
                if ($dh = opendir($upload_path_user)) {
                    while (($file = readdir($dh)) !== false) {
                        if ($file != "." AND $file != "..") {
                            unlink($upload_path_user . $file);
                        }
                    }
                }
            }

            if (file_exists($upload_file_src)) {
                if (file_exists($upload_path_user)) {
                    // move file to right destination
                    $moved = move_uploaded_file($upload_file_src, $new_file_path);

                    if ($moved == false) {
                        $moved = exec("mv $upload_file_src $new_file_path");
                    }

                    // get attachment id
                    $attachment_id = wp_insert_attachment($attachment, $new_file_path, $postID);

                    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );

                    // generate thumbs
                    $attach_data = wp_generate_attachment_metadata($attachment_id, $new_file_path);
                    wp_update_attachment_metadata($attachment_id, $attach_data);

                    // default wordpress image entry for posts
                    update_post_meta($postID, "_thumbnail_id", $attachment_id);

                    return $attachment_id;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function deletePostThumbnailAndFile($postID) {
        $thumbnailID = get_post_thumbnail_id($postID);

        if (strlen($thumbnailID) > 0) {
            $attachmentData = wp_get_attachment_metadata($thumbnailID);
            $uploadDir = wp_upload_dir();
            $uploadDirAttachment = $uploadDir["basedir"];
            $files = array($uploadDirAttachment . "/" . $attachmentData["file"]);

            foreach ($attachmentData["sizes"] as $size) {
                $files[] = substr($files[0], 0, strrpos($files[0], "/")) . "/" . $size["file"];
            }

            foreach ($files as $file) {
                @unlink($file);
            }

            // remove the thumbnail from the post
            delete_post_thumbnail($postID);

            // delete the media
            wp_delete_attachment($thumbnailID);
        }
    }

}
