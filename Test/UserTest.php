<?php

require 'bootstrap.php';

use App\Entity\User;

/**
 * Class UserTest
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    public $userData = [
        'id' => 1,
        'name' => 'name',
        'role' => 'role',
        'email' => 'email',
        'phone' => 'phone',
        'created_at' => null,
        'updated_at' => null,
    ];

    /**
     * Setup.
     */
    public function setup()
    {
        $this->userData['created_at'] = new DateTime();
        $this->userData['updated_at'] = new DateTime();
    }

    /**
     * Test User getters and setters.
     */
    public function testGettersAndSetters()
    {
        // Setup.
        $data = $this->userData;
        $user = new User();

        // Set.
        $user->setId($data['id']);
        $user->setName($data['name']);
        $user->setRole($data['role']);
        $user->setEmail($data['email']);
        $user->setPhone($data['phone']);
        $user->setCreatedAt($data['created_at']);
        $user->setUpdatedAt($data['updated_at']);

        // Test get.
        $this->assertEquals($data['id'], $user->getId());
        $this->assertEquals($data['name'], $user->getName());
        $this->assertEquals($data['role'], $user->getRole());
        $this->assertEquals($data['email'], $user->getEmail());
        $this->assertEquals($data['phone'], $user->getPhone());
        $this->assertInstanceOf('DateTime', $user->getCreatedAt());
        $this->assertEquals($data['created_at'], $user->getCreatedAt());
        $this->assertInstanceOf('DateTime', $user->getUpdatedAt());
        $this->assertEquals($data['updated_at'], $user->getUpdatedAt());
    }
}