<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Model;

use Task\TodoList\Api\Data\TaskInterface;
use Task\TodoList\Api\Data\TaskSearchResultInterface;
use Task\TodoList\Api\Data\TaskSearchResultInterfaceFactory;
use Task\TodoList\Api\TaskRepositoryInterface;
use Task\TodoList\Model\ResourceModel\Task as TaskResource;
use Task\TodoList\Model\ResourceModel\Task\CollectionFactory as TaskCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

/**
 * Class TaskRepository
 */
class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @var array
     */
    private $registry = [];

    /**
     * @var TaskResource
     */
    private $taskResource;

    /**
     * @var TaskFactory
     */
    private $taskFactory;

    /**
     * @var TaskCollectionFactory
     */
    private $taskCollectionFactory;

    /**
     * @var TaskSearchResultInterfaceFactory
     */
    private $taskSearchResultFactory;

    /**
     * @param TaskResource $taskResource
     * @param TaskFactory $taskFactory
     * @param TaskCollectionFactory $taskCollectionFactory
     * @param TaskSearchResultInterfaceFactory $taskSearchResultFactory
     */
    public function __construct(
        TaskResource $taskResource,
        TaskFactory $taskFactory,
        TaskCollectionFactory $taskCollectionFactory,
        TaskSearchResultInterfaceFactory $taskSearchResultFactory
    ) {
        $this->taskResource = $taskResource;
        $this->taskFactory = $taskFactory;
        $this->taskCollectionFactory = $taskCollectionFactory;
        $this->taskSearchResultFactory = $taskSearchResultFactory;
    }

    /**
     * @param int $id
     * @return TaskInterface
     * @throws NoSuchEntityException
     */
    public function get(int $id)
    {
        if (!array_key_exists($id, $this->registry)) {
            $task = $this->taskFactory->create();
            $this->taskResource->load($task, $id);
            if (!$task->getId()) {
                throw new NoSuchEntityException(__('Requested task does not exist'));
            }
            $this->registry[$id] = $task;
        }

        return $this->registry[$id];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TaskSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->taskCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $searchResult = $this->taskSearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }

    /**
     * @param TaskInterface $task
     * @return TaskInterface
     * @throws StateException
     */
    public function save(TaskInterface $task)
    {
        try {
            /** @var Task $task */
            $this->taskResource->save($task);
            $this->registry[$task->getId()] = $this->get($task->getId());
        } catch (\Exception $exception) {
            throw new StateException(__('Unable to save task #%1', $task->getId()));
        }
        return $this->registry[$task->getId()];
    }

    /**
     * @param TaskInterface $task
     * @return bool
     * @throws StateException
     */
    public function delete(TaskInterface $task)
    {
        try {
            /** @var Task $task */
            $this->taskResource->delete($task);
            unset($this->registry[$task->getId()]);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove task #%1', $task->getId()));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws StateException|NoSuchEntityException
     */
    public function deleteById(int $id)
    {
        return $this->delete($this->get($id));
    }
}
