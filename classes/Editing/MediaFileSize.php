<?php

namespace AcpCustomColumn\Editing;

use ACP;
use ACP\Editing\View\Text;
use AcpCustomColumn\Service\FileSizeRepo;
use AcpCustomColumn\Service\MetaStorage;

class MediaFileSize implements ACP\Editing\Service
{

    private $meta_storage;

    public function __construct(MetaStorage $meta_storage)
    {
        $this->meta_storage = $meta_storage;
    }

    public function get_view(string $context): ?ACP\Editing\View
    {
        return (new Text())->set_placeholder('Click update to save file size as metadata.');
    }

    public function get_value(int $id)
    {
        return $this->meta_storage->get($id);
    }

    public function update(int $id, $data): void
    {
        (new FileSizeRepo($this->meta_storage))->save_file_size($id);
    }

}