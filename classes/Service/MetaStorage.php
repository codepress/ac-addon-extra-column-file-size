<?php

declare(strict_types=1);

namespace AcpCustomColumn\Service;

class MetaStorage
{

    private $meta_key;

    public function __construct(string $meta_key)
    {
        $this->meta_key = $meta_key;
    }

    public function save(int $id, $value): void
    {
        update_post_meta($id, $this->meta_key, $value);
    }

    public function delete(int $id): void
    {
        delete_post_meta($id, $this->meta_key);
    }

    public function get(int $id)
    {
        return get_post_meta($id, $this->meta_key, true);
    }
}