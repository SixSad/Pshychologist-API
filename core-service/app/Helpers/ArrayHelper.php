<?php

namespace App\Helpers;

use Exception;

class ArrayHelper
{
    public static function arrayFilter(array $array, array $filterKeys, string $message = null): array
    {
        $filterKeys[] = 'id';
        foreach ($array as $key => $value) {
            if (!in_array($key, $filterKeys)) {
                throw new Exception($message ?? "Invalid attribute $key", 405);
            }
        }
        return $array;
    }

    public static function arrayFind($array, $callback): mixed
    {
        foreach ($array as $key => $value) {
            $result = $callback($value);
            if ($result) {
                return $array[$key];
            }
        }
        return false;
    }

    public static function arrayGroup(string $property, array $data)
    {
        $groupedArray = array();

        foreach ($data as $value) {
            $value = (array)$value;
            if (array_key_exists($property, $value)) {
                $groupedArray[$value[$property]][] = $value;
            } else {
                $groupedArray[""][] = $value;
            }
        }

        return $groupedArray;
    }
}
