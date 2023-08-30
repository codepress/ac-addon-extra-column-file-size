<?php

namespace AcpCustomColumn\Column;

use AC\Column;
use AC\MetaType;
use ACP;
use ACP\Sorting\Type\DataType;
use AcpCustomColumn;
use AcpCustomColumn\Service\MetaStorage;

class MediaFileSize extends Column
    implements ACP\Editing\Editable, ACP\Sorting\Sortable, ACP\Export\Exportable, ACP\Search\Searchable
{

    public function __construct()
    {
        $this->set_type('column-media-file-size');
        $this->set_label(__('Media File Size', 'ac-media-file-size'));
    }

    protected function get_meta_key(): string
    {
        return AC_META_KEY_FILE_SIZE;
    }

    public function get_value($id)
    {
        $file_size = (int)get_post_meta($id, $this->get_meta_key(), true);

        return $file_size > 0
            ? ac_helper()->file->get_readable_filesize($file_size)
            : $this->get_empty_char();
    }

    public function editing()
    {
        return new AcpCustomColumn\Editing\MediaFileSize(new MetaStorage($this->get_meta_key()));
    }

    public function sorting()
    {
        return new ACP\Sorting\Model\Post\Meta($this->get_meta_key(), new DataType(DataType::NUMERIC));
    }

    public function export()
    {
        return new ACP\Export\Model\Post\Meta($this->get_meta_key());
    }

    public function search()
    {
        return new ACP\Search\Comparison\Meta\Number($this->get_meta_key(), new MetaType(MetaType::POST));
    }

}