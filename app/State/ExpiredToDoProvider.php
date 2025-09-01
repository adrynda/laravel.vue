<?php

namespace App\State;


use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Models\ToDo;
use App\ApiResource\ExpiredToDo;

class ExpiredToDoProvider implements ProviderInterface
{
    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): object|array|null {
        $todo = ToDo::where('due_date', '<', now())
            ->orderBy('due_date', 'desc')
            ->first();
        return new ExpiredToDo(id: $todo->id, title: $todo->title, dueDate: $todo->due_date);
    }
}
