<?php

declare(strict_types=1);

namespace AcpCustomColumn\Service;

use SplFileInfo;

class FileSizeRepo
{

    private $storage;

    public function __construct(MetaStorage $storage)
    {
        $this->storage = $storage;
    }

    public function save_file_size(int $file_id): void
    {
        $file_path = get_attached_file($file_id);

        if ( ! $file_path) {
            return;
        }

        $file = new SplFileInfo($file_path);

        if ( ! $file->isFile() || ! $file->isReadable() || ! $file->getSize()) {
            $this->storage->delete($file_id);

            return;
        }

        $this->storage->save($file_id, $file->getSize());
    }

}