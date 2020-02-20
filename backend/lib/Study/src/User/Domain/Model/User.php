<?php

namespace Study\User\Domain\Model;

class User
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $email;

    /** @var string The hashed password*/
    protected $password;



    public function __construct(string $id, string $email, ?string $password=null)
    {
        $this->setId($id);
        $this->setEmail($email);
        if ($password) {
            $this->setPassword($password);
        }
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }

    /**
     * @param string $id
     */
    private function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}