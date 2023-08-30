<?php

declare(strict_types=1);

namespace AcpCustomColumn\Service;

class UpdateFileSizeOnUpload
{

    private $repo;

    public function __construct(FileSizeRepo $repo)
    {
        $this->repo = $repo;

        add_action('add_attachment', [$this, 'update_file_size']);
        add_action('attachment_updated', [$this, 'update_file_size']);
    }

    public function update_file_size(int $file_id): void
    {
        $this->repo->save_file_size($file_id);
    }
}