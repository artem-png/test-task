<?php

declare(strict_types=1);

namespace App\Infrastructure\Dto;

class BaseDto
{
    /**
     * Method is ugly, but I don't want to waste time on it.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];
        $properties = get_object_vars($this);

        foreach ($properties as $key => $propertyValue) {
            $value = $this->$key;
            if (is_array($value) && $value) {
                $element = $value[array_key_first($value)];

                if ($element instanceof BaseDto) {
                    $nestedResult = [];
                    foreach ($value as $nestedKey => $nestedDto) {
                        $nestedResult[$nestedKey] = $nestedDto->toArray();
                    }
                    $result[$key] = $nestedResult;
                } else {
                    $result[$key] = $value;
                }
            } elseif ($value instanceof BaseDto) {
                $result[$key] = $value->toArray();
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
