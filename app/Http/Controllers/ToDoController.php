<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use DatetimeImmutable;

class ToDoController extends Controller
{
    public function __construct(
        private readonly Request $request,
    ) {
    }

    public function index()
    {
        return Inertia::render('ToDo/Index', [
            'user' => 'asd',
        ]);
    }

    public function list()
    {
        // $this->mockList();
        return response()->json($this->request->getSession()->get('todo.list', []));
    }

    public function create()
    {
        $id = $this->request->getSession()->get('todo.id', 0);
        $list = $this->request->getSession()->get('todo.list', []);
        $item = $this->request->getPayload()->all();
        $item['id'] = ++$id;
        $item['createdAt'] = (new DatetimeImmutable())->format('Y-m-d H:i:s');
        $list[] = $item;
        $this->request->getSession()->set('todo.list', $list);
        $this->request->getSession()->set('todo.id', $id);
        return $this->json($item);
    }

    private function mockList(): void
    {
        $this->request->getSession()->set('todo.id', 2);
        $this->request->getSession()->set('todo.list', [
            [
                "id" => 1,
                "title" => "Kupić mleko",
                "completed" => false,
                "createdAt" => "2025-08-21 10:30:00",
                "dueDate" => "2025-08-22 18:00:00",
                "priority" => "high",
                "category" => "zakupy",
                "notes" => "Kupić jajka"
            ],
            [
                "id" => 2,
                "title" => "Kupić mleko",
                "completed" => false,
                "createdAt" => "2025-08-21 10:30:00",
                "dueDate" => "2025-08-22 18:00:00",
                "priority" => "high",
                "category" => "zakupy",
                "notes" => "Kupić też jajka"
            ]
        ]);
    }
}
