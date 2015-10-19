<?php

namespace App\Entity;

/**
 * Class Shift
 * @package App\Entity
 * @Entity @Table(name="shifts")
 */
class Shift
{
    /**
     * @var int
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $manager_id;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $employee_id;

    /**
     * @var float
     * @Column(type="float")
     */
    protected $break;

    /**
     * @var \DateTime
     * @Column(type="datetime")
     */
    protected $start_time;

    /**
     * @var \DateTime
     * @Column(type="datetime")
     */
    protected $end_time;

    /**
     * @var \DateTime
     * @Column(type="datetime")
     */
    protected $created_at;

    /**
     * @var \DateTime
     * @Column(type="datetime")
     */
    protected $updated_at;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @return int
     */
    public function getManagerId()
    {
        return $this->manager_id;
    }

    /**
     * @param int $manager_id
     */
    public function setManagerId($manager_id)
    {
        $this->manager_id = (int)$manager_id;
    }

    /**
     * @return int
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * @param int $employee_id
     */
    public function setEmployeeId($employee_id)
    {
        $this->employee_id = (int)$employee_id;
    }

    /**
     * @return float
     */
    public function getBreak()
    {
        return $this->break;
    }

    /**
     * @param float $break
     */
    public function setBreak($break)
    {
        $this->break = (float)$break;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param \DateTime $start_time
     */
    public function setStartTime(\DateTime $start_time)
    {
        $this->start_time = $start_time;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param \DateTime $end_time
     */
    public function setEndTime(\DateTime $end_time)
    {
        $this->end_time = $end_time;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt(\DateTime $updated_at)
    {
        $this->updated_at = $updated_at;
    }

}
