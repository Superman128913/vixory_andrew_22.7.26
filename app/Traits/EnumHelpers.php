<?php

namespace App\Traits;

trait EnumHelpers
{
    /**
     * Return a flat array of the enums values.
     */
    public static function toValueArray()
    {
        $instances = static::getInstances();

        $reformatted_data = array();
        foreach($instances as $instance)
        {
            $reformatted_data[] = $instance->value;
        }
        return $reformatted_data;   
    }

    /**
     * Return the enum as an array of objects with (key - value - description) pairs.
     */
    public static function toObjectArray()
    {
        $instances = static::getInstances();

        $reformatted_data = array();
        foreach($instances as $instance)
        {
            $reformatted_data[] = [
                'value' => $instance->value,
                'key' => $instance->key,
                'description' => $instance->description
            ];
        }
        return $reformatted_data;
    }
}