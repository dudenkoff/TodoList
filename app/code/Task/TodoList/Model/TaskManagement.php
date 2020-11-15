<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Model;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Webapi\Rest\Request;
use Task\TodoList\Api\TaskManagementInterface;
use Task\TodoList\Api\TaskRepositoryInterface;

/**
 * Class TaskManagement
 */
class TaskManagement implements TaskManagementInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var TaskFactory
     */
    protected $taskFactory;

    /**
     * @var TaskRepositoryInterface
     */
    protected $taskRepository;

    /**
     * @var Json
     */
    protected $json;

    /**
     * @param Request $request
     * @param TaskFactory $taskFactory
     * @param TaskRepositoryInterface $taskRepository
     * @param Json $json
     */
    public function __construct(
        Request $request,
        TaskFactory $taskFactory,
        TaskRepositoryInterface $taskRepository,
        Json $json
    ) {
        $this->request = $request;
        $this->taskFactory = $taskFactory;
        $this->taskRepository = $taskRepository;
        $this->json = $json;
    }

    /**
     * @param CustomerInterface $customer
     * @param string $taskText
     * @return string
     */
    public function set(CustomerInterface $customer, $taskText = '')
    {
        $task = $this->taskFactory->create();

        $task->setTask($taskText);
        $task->setCustomerId($customer->getId());

        $task = $this->taskRepository->save($task);

        $response = [
            'id' => $task->getId(),
            'text' => $task->getTask()
        ];

        return $this->json->serialize($response);
    }

    /**
     * @param CustomerInterface $customer
     * @param int $taskId
     * @return bool
     */
    public function remove(CustomerInterface $customer, $taskId)
    {
        $this->taskRepository->deleteById($taskId);

        return true;
    }
}
