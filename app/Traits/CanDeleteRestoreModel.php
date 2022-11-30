<?php

declare(strict_types=1);

namespace App\Traits;


trait CanDeleteRestoreModel
{
    public function deleteOrRestore(): string
    {
        if ($this->trashed()) {
            $this->restore();
            return 'restored';
        } else {
            $this->delete();
            return 'deleted';
        }
    }
}