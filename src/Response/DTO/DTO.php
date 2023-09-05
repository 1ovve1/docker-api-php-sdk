<?php declare(strict_types=1);

namespace Lowel\Docker\Response\DTO;

use function ucfirst;

abstract class DTO
{
    /** @var array<string, mixed> */
    protected readonly array $rawData;

    /**
     * @param mixed[] $rawData
     */
    public function __construct(array $rawData)
    {
        $this->rawData = $rawData;
    }


    /**
     * lowerCamelCase name of the param that we store in $rawData
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        $dataName = ucfirst($name);

        return $this->rawData[$dataName];
    }


}