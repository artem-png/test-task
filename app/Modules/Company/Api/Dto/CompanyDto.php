<?php

declare(strict_types=1);

namespace App\Modules\Company\Api\Dto;

use App\Infrastructure\Dto\BaseDto;

class CompanyDto extends BaseDto
{
    /**
     * @param string $id
     * @param string $name
     * @param string $street
     * @param string $city
     * @param string $zip
     * @param string $phone
     * @param string $email
     */
    public function __construct(
        protected string $id,
        protected string $name,
        protected string $street,
        protected string $city,
        protected string $zip,
        protected string $phone,
        protected string $email,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
