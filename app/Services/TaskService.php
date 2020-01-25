<?php


namespace App\Services;


use App\Models\Task;
use App\Repositories\TaskRepository;
use Particle\Validator\Rule\Email;
use Particle\Validator\Rule\InArray;
use Particle\Validator\Rule\LengthBetween;
use Particle\Validator\Rule\NotEmpty;
use Particle\Validator\Validator;

class TaskService
{
    /**
     * @var Task
     */
    private $task;
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct()
    {
        $this->task = new Task();
        $this->taskRepository = new TaskRepository();
    }

    /**
     * Return right data for order
     *
     * @return array|bool
     */
    public function getRightOrderFromRequest()
    {
        $orderBy = $_GET['orderBy'] ?? "";
        if ($orderBy == "") {
            $direction = "";
        } else {
            $direction = strtolower($_GET['direction'] ?? "");
        }

        $orderBy = $orderBy ?: 'performed';
        $direction = $direction ?: 'asc';

        $order = [
            'orderBy'   => $orderBy,
            'direction' => $direction,
        ];

        $allowed = $this->task->getAllowedForOrder();

        $isAllowedOrderBy = !in_array($order['orderBy'], $allowed) && $order['orderBy'] != "";
        $isAllowedDirection = !in_array($order['direction'], ['asc', 'desc']) && $order['direction'] != "";
        if ($isAllowedOrderBy && $isAllowedDirection)
            return false;

        return $order;
    }

    /**
     * Get Page from Request
     *
     * @return bool|int
     */
    public function getPageFromRequest()
    {
        $isNotHavePage = !isset($_GET['page']) ||
            (isset($_GET['page']) && $_GET['page'] == "");

        if ($isNotHavePage)
            return 1;

        $page = (int)$_GET['page'];

        if (strval($page) != $_GET['page'])
            return false;

        return $page;
    }

    /**
     * Get Order data for Paginate
     *
     * @param array $inputOrder
     * @return array|bool
     */
    public function getOrderForPaginate($inputOrder = [])
    {
        $order = $inputOrder ?: $this->getRightOrderFromRequest();

        $order['orderBy'] = $order['orderBy'] != 'performed' ? $order['orderBy'] : "";
        $order['direction'] = $order['direction'] != 'asc' ? $order['direction'] : "";

        return $order;
    }

    /**
     * Returns list orders for select
     *
     * @return array
     */
    public function getListOrdersForSelect()
    {
        return [
            'name'   => 'По имени',
            'email'  => 'По email',
            'status' => 'По статусу'
        ];
    }


    /**
     * Return validation result for new task
     *
     * @param $input
     * @return \Particle\Validator\ValidationResult
     */
    public function checkInputForNewTask($input)
    {
        $validator = new Validator;

        $validator->required('name')->lengthBetween(4, 100);
        $validator->required('email')->email();
        $validator->required('task')->lengthBetween(6, 500);

        $validator->overwriteMessages([
            'name'  => [
                LengthBetween::TOO_LONG  => 'Слишком длинное имя!',
                LengthBetween::TOO_SHORT => 'Слишком короткое имя!',
                NotEmpty::EMPTY_VALUE    => 'Поле с именем не должно быть пустым!'
            ],
            'email' => [
                Email::INVALID_FORMAT => 'Email неверен!',
                NotEmpty::EMPTY_VALUE => 'Поле с email не должно быть пустым!'

            ],
            'task'  => [
                LengthBetween::TOO_LONG  => 'Слишком длинная задача!',
                LengthBetween::TOO_SHORT => 'Слишком короткая задача!',
                NotEmpty::EMPTY_VALUE    => 'Задача не может быть пустой!'
            ],
        ]);

        $result = $validator->validate($input);

        return $result;
    }


    /**
     * Return validation result for edit task
     *
     * @param $input
     * @return \Particle\Validator\ValidationResult
     */
    public function checkInputForEditTask($input)
    {
        $validator = new Validator;

        $validator->required('name')->lengthBetween(4, 100);
        $validator->required('email')->email();
        $validator->required('task')->lengthBetween(6, 500);
        $validator->required('status')->inArray(["0", "1"]);

        $validator->overwriteMessages([
            'name'   => [
                LengthBetween::TOO_LONG  => 'Слишком длинное имя!',
                LengthBetween::TOO_SHORT => 'Слишком короткое имя!',
                NotEmpty::EMPTY_VALUE    => 'Поле с именем не должно быть пустым!'
            ],
            'email'  => [
                Email::INVALID_FORMAT => 'Email неверен!',
                NotEmpty::EMPTY_VALUE => 'Поле с email не должно быть пустым!'

            ],
            'task'   => [
                LengthBetween::TOO_LONG  => 'Слишком длинная задача!',
                LengthBetween::TOO_SHORT => 'Слишком короткая задача!',
                NotEmpty::EMPTY_VALUE    => 'Задача не может быть пустой!'
            ],
            'status' => [
                InArray::NOT_IN_ARRAY => 'Не допустимое значение статуса'
            ],
        ]);

        $result = $validator->validate($input);

        return $result;
    }

    /**
     * Get one task by Id
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getTask(int $id)
    {
        $task = $this->taskRepository->find($id);
        return $task;
    }

    /**
     * Update task
     *
     * @param $task
     * @param array $validInput
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function updateTask($task, array $validInput)
    {
        if ($this->isDirtyTask($task, $validInput))
            $validInput['performed'] = true;
        $validInput['status'] = (int)$validInput['status'];
        $model = $this->taskRepository->update($task->id, $validInput);
        return $model;
    }

    /**
     * Returns true if data is different
     *
     * @param Task $task
     * @param array $validInput
     * @return bool
     */
    private function isDirtyTask(Task $task, array $validInput)
    {
        if ($task->name != $validInput['name'] ||
            $task->email != $validInput['email'] ||
            $task->task != $validInput['task']
        ) return true;
        return false;
    }

    /**
     * Get array with paginate data or false
     *
     * @param $perPage
     * @param $currentPage
     * @return array|bool
     */
    public function getPaginate(int $perPage, int $currentPage)
    {
        $countItems = $this->taskRepository->countAll();
        $countPages = intdiv($countItems, $perPage);
        $countPages = $countPages * $perPage < $countItems ? $countPages + 1 : $countPages;

        if ($countPages < $currentPage && $countItems > 0)
            return false;

        $back = $currentPage > 1 && $countPages > 1 ? $currentPage - 1 : false;
        $next = $currentPage + 1 <= $countPages ? $currentPage + 1 : false;

        $paginate = [
            'isPaginated' => $countPages > 1,
            'countItems'  => $countItems,
            'countPages'  => $countPages,
            'current'     => $currentPage,
            'back'        => $back,
            'next'        => $next,
        ];

        return $paginate;
    }

    /**
     * Get all tasks with order
     *
     * @param int $perPage
     * @param int $currentPage
     * @param array $order
     * @return \Illuminate\Support\Collection
     */
    public function getAllWithOrder(int $perPage, int $currentPage, array $order)
    {
        $tasks = $this->taskRepository->getAllWithOrder($perPage, $currentPage, $order);
        return $tasks;
    }

    /**
     * Create task
     *
     * @param $data
     */
    public function createTask($data)
    {
        $this->taskRepository->create($data);
    }

}