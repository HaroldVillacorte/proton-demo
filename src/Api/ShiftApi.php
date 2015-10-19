<?php

namespace App\Api;

use App\Adapter\DoctrineAdapter;
use App\Entity\StandardResponse;
use Doctrine\ORM\Query;
use App\Entity\Shift;

class ShiftApi
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->em = DoctrineAdapter::getEntityManager();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $response = new StandardResponse();
        $queryString = 'SELECT shift.id, shift.manager_id, manager.name AS manager_name, ' .
            'shift.employee_id, employee.name AS employee_name, shift.break, ' .
            'shift.start_time, shift.end_time, shift.created_at, shift.updated_at ' .
            'FROM \App\Entity\Shift shift ' .
            'JOIN \App\Entity\User employee WHERE employee.id = shift.employee_id ' .
            'JOIN \App\Entity\User manager WHERE manager.id = shift.manager_id';
        $shifts = $this->em->createQuery($queryString)->getArrayResult();
        if ($shifts) {
            $shifts = $this->processShifts($shifts);
            $response->setSuccess(true);
            $response->setMessage('Here are the shifts.');
            $response->setData($shifts);
        }
        return $response->getObjectVars();
    }

    /**
     * @param $id
     * @return StandardResponse
     */
    public function getMyShifts($id)
    {
        $response = new StandardResponse();
        $queryString = 'SELECT shift.id, shift.manager_id, manager.name AS manager_name, ' .
            'shift.employee_id, employee.name AS employee_name, shift.break, ' .
            'shift.start_time, shift.end_time, shift.created_at, shift.updated_at ' .
            'FROM \App\Entity\Shift shift ' .
            'JOIN \App\Entity\User employee WHERE employee.id = shift.employee_id ' .
            'JOIN \App\Entity\User manager WHERE manager.id = shift.manager_id ' .
            'WHERE shift.employee_id = :id';
        $shifts = $this->em->createQuery($queryString)->setParameter('id', $id)->getArrayResult();
        if ($shifts) {
            $shifts = $this->processShifts($shifts);
            $response->setSuccess(true);
            $response->setMessage('Here are the shifts.');
            $response->setData($shifts);
        }
        return $response->getObjectVars();
    }

    /**
     * @param $userId
     * @return array
     */
    public function getWeeklySummary($userId) {
        $response = new StandardResponse();
        $db = new \PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', 'root');
        $stmt = $db->prepare('SELECT id, WEEKOFYEAR(start_time) as week, SUM(TIMEDIFF(end_time, start_time))/10000 as hours ' .
            'FROM shifts WHERE employee_id = :id ' .
            'GROUP BY WEEK(start_time)');
        $stmt->bindValue(':id', (int)$userId, \PDO::PARAM_INT);
        $stmt->execute();
        $shifts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if ($shifts) {
            $response->setSuccess(true);
            $response->setMessage('Here is the summary.');
            $response->setData($shifts);
        }
        return $response->getObjectVars();
    }

    /**
     * @param $start
     * @param $end
     * @return array
     */
    public function getByDateRange(\DateTime $start, \DateTime $end)
    {
        $response = new StandardResponse();
        $queryString = 'SELECT shift.id, shift.manager_id, manager.name AS manager_name, ' .
            'shift.employee_id, employee.name AS employee_name, shift.break, ' .
            'shift.start_time, shift.end_time, shift.created_at, shift.updated_at ' .
            'FROM \App\Entity\Shift shift ' .
            'JOIN \App\Entity\User employee WHERE employee.id = shift.employee_id ' .
            'JOIN \App\Entity\User manager WHERE manager.id = shift.manager_id ' .
            'WHERE shift.start_time BETWEEN :start AND :end OR shift.end_time BETWEEN :start AND :end ' .
            'OR :start BETWEEN shift.start_time AND shift.end_time OR :end BETWEEN shift.start_time AND shift.end_time';
        $shifts = $this->em->createQuery($queryString)->setParameter('start', $start)
            ->setParameter('end', $end)->getArrayResult();
        if ($shifts) {
            $shifts = $this->processShifts($shifts);
            $response->setSuccess(true);
            $response->setMessage('Here are the shifts.');
            $response->setData($shifts);
        }
        return $response->getObjectVars();
    }

    /**
     * @param array $shifts
     * @return array
     */
    public function processShifts(array $shifts)
    {
        $newShifts = [];
        foreach ($shifts as $shift) {
            $shift['start_time'] = $shift['start_time']->getTimestamp();
            $shift['end_time'] = $shift['end_time']->getTimestamp();
            $shift['created_at'] = $shift['created_at']->getTimestamp();
            $shift['updated_at'] = $shift['updated_at']->getTimestamp();
            $newShifts[] = $shift;
        }
        return $newShifts;
    }

    /**
     * @param int $id
     * @return null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function get($id)
    {
        $response = new StandardResponse();
        $queryString = 'SELECT shift.id, shift.manager_id, shift.employee_id, shift.break, ' .
            'shift.start_time, shift.end_time, shift.created_at, shift.updated_at FROM \App\Entity\Shift shift ' .
            'WHERE shift.id = :id';
        $shift = $this->em->createQuery($queryString)->setParameter('id', (int)$id)->getArrayResult();
        if ($shift) {
            if (isset($shift[0])) {
                $shift[0]['start_time'] = $shift[0]['start_time']->getTimestamp();
                $shift[0]['end_time'] = $shift[0]['end_time']->getTimestamp();
            }
            $response->setSuccess(true);
            $response->setMessage('Here is the shift.');
            $response->setData(isset($shift[0]) ? $shift[0] : []);
        }
        return $response->getObjectVars();
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function save(array $data)
    {
        $response = new StandardResponse();
        if (isset($data['id'])) {
            $shift = $this->em->find('App\Entity\Shift', (int)$data['id']);
        } else {
            $shift = new Shift();
            $shift->setCreatedAt(new \DateTime());
        }
        $shift->setManagerId($data['manager_id']);
        $shift->setEmployeeId($data['employee_id']);
        $shift->setBreak($data['break']);
        $shift->setStartTime($data['start_time']);
        $shift->setEndTime($data['end_time']);
        $shift->setUpdatedAt(new \DateTime());
        $this->em->persist($shift);
        try {
            $response->setSuccess(true);
            $response->setMessage('You have successfully saved the shift.');
            $this->flush();
        } catch (\Exception $e) {}
        return $response->getObjectVars();
    }

    /**
     * @param $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function delete($id)
    {
        $shift = $this->em->find('App\Entity\Shift', (int)$id);
        $this->em->remove($shift);
        return $this->flush();
    }

    /**
     * @return bool
     */
    public function flush()
    {
        try {
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}