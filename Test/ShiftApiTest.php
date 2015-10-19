<?php

include 'bootstrap.php';

use App\Api\ShiftApi;
use App\Adapter\DoctrineAdapter;

class ShiftApiTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \App\Adapter\DoctrineAdapter
     */
    public $em;

    /**
     * @var \App\Api\ShiftApi
     */
    public $shiftApi;

    /**
     * Set up.
     */
    public function setup()
    {
        $this->shiftApi = new ShiftApi();
        $this->em = DoctrineAdapter::getEntityManager();
    }

    /**
     * Test get all.
     */
    public function testGetAll()
    {
        $allShifts = $this->shiftApi->getAll()['data'];
        $this->assertInternalType('array', $allShifts);
        $this->assertGreaterThan(0, count($allShifts));
    }

    /**
     * Test save : post and put.
     */
    public function testSaveGetDelete()
    {
        $startTime = new DateTime();
        $endTime = new DateTime();
        $endTime->modify('+8 hours');
        $data = [
            'manager_id' => 1000000,
            'employee_id' => 1,
            'break' => 0.50,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'created_at' => $startTime,
            'updated_at' => $startTime,
        ];

        // Post
        $result = $this->shiftApi->save($data);
        $this->assertNotFalse($result);
        $shift = $this->em->getRepository('App\Entity\Shift')->findOneBy(['manager_id' => 1000000]);
        $this->assertInstanceOf('App\Entity\Shift', $shift);

        // Put
        $data['id'] = $shift->getId();
        $data['manager_id'] = 2000000;
        $data['updated_at'] = new DateTime();
        $result = $this->shiftApi->save($data);
        $this->assertNotFalse($result);

        // Get
        $shift = $this->shiftApi->get(12345678912345);
        $this->assertEmpty($shift['data']);
        $result = $this->shiftApi->get($data['id']);
        $this->assertInternalType('array', $result['data']);

        // Delete.
        $result = $this->shiftApi->delete($result['data']['id']);
        $this->assertNotFalse($result);
    }

    /**
     * Test get shifts by date range.
     */
    public function testGetByDateRange()
    {
        $result = $this->shiftApi->getByDateRange(
            new \DateTime('Sun Oct 18 2015 23:00:00 GMT-0600 (MDT)'),
            new \DateTime('Sat Oct 31 2015 23:55:00 GMT-0600 (MST)')
        );
        $this->assertInternalType('array', $result['data']);
        $this->assertGreaterThanOrEqual(0, count($result['data']));
    }

    /**
     * Test get my shifts.
     */
    public function testGetMyShifts()
    {
        $result = $this->shiftApi->getMyShifts(5);
        $this->assertInternalType('array', $result['data']);
        $this->assertGreaterThanOrEqual(0, count($result['data']));
    }

    /**
     * Test get weekly summary.
     */
    public function testGetWeeklySummary() {
        $result = $this->shiftApi->getWeeklySummary(3);
        $this->assertInternalType('array', $result['data']);
        $this->assertGreaterThan(0, count($result['data']));

    }
}