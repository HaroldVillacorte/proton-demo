<?php

include 'bootstrap.php';

use App\Api\AccountApi;
use App\Adapter\DoctrineAdapter;

class AccountApiTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Proton\Application
     */
    public $app;

    /**
     * @var AccountApi
     */
    public $accountApi;

    /**
     * Set up.
     */
    public function setup()
    {
        $this->app = new Proton\Application();
        $this->accountApi = new AccountApi();
    }

    /**
     * Tests login.
     */
    public function testLogin()
    {
        session_unset();
        $result = AccountApi::login('manager1@app.com', 'password');
        $this->assertTrue($result['success']);
        session_unset();
    }

    /**
     * Tests adding a User.
     */
    public function testAddUser()
    {
        $data = [
            'name' => 'userX',
            'role' => AccountApi::$roles['manager'],
            'email' => 'userX@app.com',
            'phone' => '5555555555',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        $user = AccountApi::addUser($data);
        $this->assertNotFalse($user);
        $this->assertInternalType('int', $user->getId());
        $this->assertEquals($data['name'], $user->getName());
        $this->assertEquals($data['role'], $user->getRole());
        $this->assertEquals($data['email'], $user->getEmail());
        $this->assertEquals($data['phone'], $user->getphone());
        $this->assertInstanceOf('DateTime', $user->getCreatedAt());
        $this->assertEquals($data['created_at'], $user->getCreatedAt());
        $this->assertInstanceOf('DateTime', $user->getUpdatedAt());
        $this->assertEquals($data['updated_at'], $user->getUpdatedAt());
        if ($user) {
            $em = DoctrineAdapter::getEntityManager();
            $user = $em->find('App\Entity\User', ['id' => $user->getId()]);
            $em->remove($user);
            $em->flush();
        }
    }

    /**
     * Test get user.
     */
    public function testGetUSer()
    {
        $id = 1;
        $response = $this->accountApi->getUser($id);
        $this->assertNotFalse($response['success']);
        $this->assertInternalType('array', $response['data']);
        $this->assertEquals($id, $response['data']['id']);
    }

}