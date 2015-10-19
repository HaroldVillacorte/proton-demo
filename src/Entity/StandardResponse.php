<?php

namespace App\Entity;

/**
 * Class StandardResponse
 * @package App\Entity
 */
class StandardResponse
{
    /**
     * @var bool
     */
    protected $success = false;

    /**
     * @var string
     */
    protected $message = 'Unable to precess your request.';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = (bool)$success;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = (string)$message;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getObjectVars() {
        return get_object_vars($this);
    }

}