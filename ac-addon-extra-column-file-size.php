<?php
/*
Plugin Name:    Admin Columns - Media File Size
Description:    Stores the file size of attachments as metadata. Add the column "Media File Size" to the media list table to display each file size. It's also sortable and filterable. Use bulk edit to update all file sizes.
Version:        1.0
Author:         Codepress
Author URI:     https://www.admincolumns.com
License:        GPLv2 or later
License URI:    http://www.gnu.org/licenses/gpl-2.0.html
*/

use AC\ListScreen;
use AcpCustomColumn\Column;
use AcpCustomColumn\Service\FileSizeRepo;
use AcpCustomColumn\Service\MetaStorage;
use AcpCustomColumn\Service\UpdateFileSizeOnUpload;

if ( ! defined('AC_META_KEY_FILE_SIZE')) {
    define('AC_META_KEY_FILE_SIZE', 'media_file_size');
}

require_once(__DIR__ . '/classes/Service/MetaStorage.php');
require_once(__DIR__ . '/classes/Service/FileSizeRepo.php');
require_once(__DIR__ . '/classes/Service/UpdateFileSizeOnUpload.php');

// Register file size service
add_action('ac/ready', static function () {
    new UpdateFileSizeOnUpload(
        new FileSizeRepo(
            new MetaStorage(AC_META_KEY_FILE_SIZE)
        )
    );
});

// Register the column
add_action('acp/column_types', static function (ListScreen $list_screen) {
    if ( ! $list_screen instanceof ACP\ListScreen\Media) {
        return;
    }

    require_once(__DIR__ . '/classes/Column/MediaFileSize.php');
    require_once(__DIR__ . '/classes/Editing/MediaFileSize.php');
    require_once(__DIR__ . '/classes/Sorting/MediaFileSize.php');

    $list_screen->register_column_type(new Column\MediaFileSize());
});