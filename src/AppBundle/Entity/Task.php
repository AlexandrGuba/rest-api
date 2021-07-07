<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="tasks")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskRepository")
 */
class Task
{
	
	private $priorityList = [
	  "0" => "0 status",
	  "1" => "1 status",
	  "2" => "2 status",
	];
	
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @var string
	 * @ORM\Column(name="id_task", type="string", length=100)
	 */
	private $id_task;
	
	/**
	 * @var string
	 * @ORM\Column(name="sprint_id", type="string", nullable=true)
	 */
	private $sprint_id;
	
	/**
	 * @var string
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;
	
	/**
	 * @var string
	 * @ORM\Column(name="description", type="string", length=255, nullable=true)
	 */
	private $description;
	
	/**
	 * @var boolean
	 * @ORM\Column(name="action", type="boolean", nullable=true, options={"default": false})
	 */
	private $action;
	
	/**
	 * @var int
	 * @ORM\Column(name="estimation", type="integer", nullable=true)
	 */
	private $estimation;
	
	/**
	 * @var int
	 * @ORM\Column(name="priority", type="integer", nullable=true)
	 */
	private $priority;
	
	/**
	 * Get id
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set id_task
	 * @param string $id_task
	 * @return Task
	 */
	public function setIdTask($id_task)
	{
		$this->id_task = $id_task;
		return $this;
	}
	
	/**
	 * Get id_task
	 * @return string
	 */
	public function getIdTask()
	{
		return $this->id_task;
	}
	
	/**
	 * Set sprint_id
	 * @param integer $sprint_id
	 * @return Task
	 */
	public function setSprintId($sprint_id)
	{
		$this->sprint_id = $sprint_id;
		return $this;
	}

	/**
	 * Get sprint_id
	 * @return integer
	 */
	public function getSprintId()
	{
		return $this->sprint_id;
	}
	
	/**
	 * Set title
	 * @param string $title
	 * @return Task
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}
	
	/**
	 * Get title
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * Set description
	 * @param string $description
	 * @return Task
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	
	/**
	 * Get description
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}
	
	/**
	 * Set action
	 * @param boolean $action
	 * @return Task
	 */
	public function setAction($action)
	{
		$this->action = $action;
		return $this;
	}
	
	/**
	 * Get action
	 * @return string
	 */
	public function getAction()
	{
		return $this->action;
	}
	
	/**
	 * Set estimation
	 * @param int $estimation
	 * @return Task
	 */
	public function setEstimation($estimation)
	{
		$this->estimation = $estimation;
		return $this;
	}
	
	/**
	 * Get estimation
	 * @return int
	 */
	public function getEstimation()
	{
		return $this->estimation;
	}
	
	/**
	 * Set priority
	 * @param integer $priority
	 * @return Task
	 */
	public function setPriority($priority)
	{
		$this->priority = $priority;
		return $this;
	}
	
	/**
	 * Get priority
	 * @return integer
	 */
	public function getPriority()
	{
		return $this->priority;
	}
	
	/**
	 * Get priorityList
	 * @return array
	 */
	public function getPriorityList()
	{
		return $this->priorityList;
	}
	
}
	
