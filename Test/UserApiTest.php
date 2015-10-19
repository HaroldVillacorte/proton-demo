<?php

include 'bootstrap.php';

use App\Api\UserApi;
use App\Adapter\DoctrineAdapter;

class UserApiTest
{
    /**
     * @var \App\Adapter\DoctrineAdapter
     */
    public $em;

    /**
     * @var \App\Api\UserApi
     */
    public $userApi;

    /**
     * Set up.
     */
    public function setup()
    {
        $this->userApi = new UserApi();
        $this->em = DoctrineAdapter::getEntityManager();
    }

    /**
     * Test get all.
     */
    public function testGetAllEmployees()
    {
        $allEmployees = $this->shiftApi->getAllEmployees()['data'];
        $this->assertInternalType('array', $allEmployees);
        $this->assertGreaterThan(0, count($allEmployees));
    }
}