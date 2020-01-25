<?php


namespace App\Services;


use App\Models\Task;
use Particle\Validator\Rule\Email;
use Particle\Validator\Rule\LengthBetween;
use Particle\Validator\Rule\NotEmpty;
use Particle\Validator\Validator;

class TaskService
{
    /**
     * @var Task
     */
    private $task;

    public function __construct()
    {
        $this->task = new Task();
    }

    public function getOrderFromRequest()
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

        $allowed = $this->task->getAllowedOrders();

        $isAllowedOrderBy = !in_array($order['orderBy'], $allowed) && $order['orderBy'] != "";
        $isAllowedDirection = !in_array($order['direction'], ['asc', 'desc']) && $order['direction'] != "";
        if ($isAllowedOrderBy && $isAllowedDirection)
            return false;

        return $order;
    }

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

    public function getOrderForPaginate($inputOrder = [])
    {
        $order = $inputOrder ?: $this->getOrderFromRequest();

        $order['orderBy'] = $order['orderBy'] != 'performed' ? $order['orderBy'] : "";
        $order['direction'] = $order['direction'] != 'asc' ? $order['direction'] : "";

        return $order;
    }

    public function getOrdersForSelect()
    {
        return [
            'name'      => 'По имени',
            'email'     => 'По email',
            'performed' => 'По статусу'
        ];
    }


    /**
     * Return validation result
     *
     * @return \Particle\Validator\ValidationResult
     */
    public function checkInputForNewTask()
    {
        $validator = $this->getValidatorForNew();
        $result = $validator->validate($_POST);

        return $result;
    }

    /**
     * Get Validator for a new task
     *
     * @return Validator
     */
    private function getValidatorForNew() {
        $validator = new Validator;

        $validator->required('name')->lengthBetween(4, 100);
        $validator->required('email')->email();
        $validator->required('task')->lengthBetween(6, 500);

        $validator->overwriteMessages([
            'name' => [
                LengthBetween::TOO_LONG => 'Слишком длинное имя!',
                LengthBetween::TOO_SHORT => 'Слишком короткое имя!',
                NotEmpty::EMPTY_VALUE => 'Поле с именем не должно быть пустым!'
            ],
            'email' => [
                Email::INVALID_FORMAT => 'Email неверен!',
                NotEmpty::EMPTY_VALUE => 'Поле с email не должно быть пустым!'

            ],
            'task' => [
                LengthBetween::TOO_LONG => 'Слишком длинная задача!',
                LengthBetween::TOO_SHORT => 'Слишком короткая задача!',
                NotEmpty::EMPTY_VALUE => 'Задача не может быть пустой!'
            ],
        ]);

        return $validator;
    }

}