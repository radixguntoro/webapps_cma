<?php

namespace App\Libraries;

use Input;
use DB;

class ConvertData
{
	public function ArrayToObject($Array) {
        // Create new stdClass object
        $object = new stdClass();

        foreach ($Array as $key => $value) {
            if (is_array($value)) {
                $value = ToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }
}
