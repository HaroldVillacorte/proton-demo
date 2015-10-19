<?php

use App\Entity\Shift;

/**
 * Class ShiftTest
 */
class ShiftTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    public $shiftData = [
        'id' => 1,
        'manager_id' => 1,
        'employee_id' => 1,
        'break' => 0.50,
        'start_time' => null,
        'end_time' => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    /**
     * Set up.
     */
    public function setup() {
        $this->shiftData['start_time'] = new DateTime();
        $this->shiftData['end_time'] = new DateTime();
        $this->shiftData['created_at'] = new DateTime();
        $this->shiftData['updated_at'] = new DateTime();
    }

    /**
     * Test User getters and setters.
     */
    public function testGettersAndSetters()
    {
        // Setup.
        $data = $this->shiftData;
        $shift = new Shift();

        // Set.
        $shift->setId($data['id']);
        $shift->setManagerId($data['manager_id']);
        $shift->setEmployeeId($data['employee_id']);
        $shift->setBreak($data['break']);
        $shift->setStartTime($data['start_time']);
        $shift->setEndTime($data['end_time']);
        $shift->setCreatedAt($data['created_at']);
        $shift->setUpdatedAt($data['updated_at']);

        // Test get.
        $this->assertEquals($data['id'], $shift->getId());
        $this->assertEquals($data['manager_id'], $shift->getManagerId());
        $this->assertEquals($data['employee_id'], $shift->getEmployeeId());
        $this->assertEquals($data['break'], $shift->getBreak());
        $this->assertInstanceOf('DateTime', $shift->getStartTime());
        $this->assertEquals($data['start_time'], $shift->getStartTime());
        $this->assertInstanceOf('DateTime', $shift->getEndTime());
        $this->assertEquals($data['end_time'], $shift->getEndTime());
        $this->assertInstanceOf('DateTime', $shift->getCreatedAt());
        $this->assertEquals($data['created_at'], $shift->getCreatedAt());
        $this->assertInstanceOf('DateTime', $shift->getUpdatedAt());
        $this->assertEquals($data['updated_at'], $shift->getUpdatedAt());
    }

}