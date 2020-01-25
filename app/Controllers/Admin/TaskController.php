<?php


namespace App\Controllers\Admin;


use App\Controllers\CoreController;
use App\Services\TaskService;

class TaskController extends CoreController
{
    /**
     * @var TaskService
     */
    private $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    /**
     * Edit task form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View|\Jenssegers\Blade\Blade
     */
    public function edit($id)
    {
        $task = $this->taskService->getTask($id);
        if (!$task) {
            back(false, ['Задача не найдена!']);
        }

        $pageTitle = "Редактирование задачи №".$id;
        return view('admin.tasks.edit', compact('task', 'pageTitle'));
    }

    /**
     * Updating exists task data
     *
     * @param $id
     */
    public function update($id)
    {
        $validateResult = $this->taskService->checkInputForEditTask($_POST);
        if ($validateResult->isNotValid()) {
            return back(true, $validateResult->getMessages());
        }

        $task = $this->taskService->getTask($id);
        if (!$task) {
            return back(true, ['Задача не найдена!']);
        }

        $this->taskService->updateTask($task, $validateResult->getValues());

        set_success('Данные задачи обновлены');
        return back();
    }
}