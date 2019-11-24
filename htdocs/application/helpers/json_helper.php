<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//If you are on a version of PHP before 5.2, this might help:
if (!function_exists('json_encode')) {

    function json_encode($data)
    {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);

                    if ($output_index_count !== null && $output_index_count++ !== $key) {
                        $output_index_count = null;
                    }
                }

                if ($output_index_count !== null) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported

        }
    }
}
