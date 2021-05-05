<?php

class User
{
    protected int $id;
    protected string $email;
    protected string $first_name;
    protected string $given_name;
    protected string $street_name;
    protected string $street_number;
    protected string $post_code;
    protected string $city;
    protected string $phone_number;
    protected string $password;
    protected bool $active;
    protected string $vkey;
    protected int $rights;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->given_name;
    }

    /**
     * @param string $given_name
     */
    public function setGivenName(string $given_name): void
    {
        $this->given_name = $given_name;
    }

    /**
     * @return string
     */
    public function getStreetName(): string
    {
        return $this->street_name;
    }

    /**
     * @param string $street_name
     */
    public function setStreetName(string $street_name): void
    {
        $this->street_name = $street_name;
    }

    /**
     * @return string
     */
    public function getStreetNumber(): string
    {
        return $this->street_number;
    }

    /**
     * @param string $street_number
     */
    public function setStreetNumber(string $street_number): void
    {
        $this->street_number = $street_number;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->post_code;
    }

    /**
     * @param string $post_code
     */
    public function setPostCode(string $post_code): void
    {
        $this->post_code = $post_code;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber(string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getVkey(): string
    {
        return $this->vkey;
    }

    /**
     * @param string $vkey
     */
    public function setVkey(string $vkey): void
    {
        $this->vkey = $vkey;
    }

    /**
     * @return int
     */
    public function getRights(): int
    {
        return $this->rights;
    }

    /**
     * @param int $rights
     */
    public function setRights(int $rights): void
    {
        $this->rights = $rights;
    }

}