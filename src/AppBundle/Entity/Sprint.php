<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sprint
 *
 * @ORM\Table(name="sprints")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SprintRepository")
 */
class Sprint
{
	private $statusList = [
	  "0" => "0 status",
	  "1" => "В работе",
	  "2" => "Отработан",
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
     *
     * @ORM\Column(name="id_sprint", type="string", length=50, unique=true)
     */
    private $idSprint;

    /**
     * @var int
     *
     * @ORM\Column(name="status", nullable=true, type="integer")
     */
    private $status;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idSprint
     *
     * @param string $idSprint
     *
     * @return Sprint
     */
    public function setIdSprint($idSprint)
    {
        $this->idSprint = $idSprint;

        return $this;
    }

    /**
     * Get idSprint
     *
     * @return string
     */
    public function getIdSprint()
    {
        return $this->idSprint;
    }

    /**
     * Set status
     *
     * @param int $status
     *
     * @return Sprint
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
	
	/**
	 * Get statusList
	 * @return array
	 */
	public function getStatusList()
	{
		return $this->statusList;
	}
}

