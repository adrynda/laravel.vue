<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\Get;
use App\State\ExpiredToDoProvider;

#[Get(uriTemplate: '/todo/expired', provider: ExpiredToDoProvider::class)]
class ExpiredToDo
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $title = null,
        public readonly ?string $dueDate = null,
    ) {
    }
}
