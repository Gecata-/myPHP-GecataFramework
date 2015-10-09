<?php

/**
 * Description of Common
 *
 * @author gdimitrov
 */

namespace GF;

class Common {

    public static function normalize($data, $types) {
        $allTypes = explode('|', $types);
        if (is_array($allTypes)) {
            foreach ($allTypes as $v) {
                switch ($v) {
                    case'int':
                        return $data = (int) $data;
                        break;
                    case'float': 
                        return $data = (float) $data;
                        break;
                    case'double':
                        return $data = (double) $data;
                        break;
                    case'bool':
                        return $data = (bool) $data;
                        break;
                    case'string':
                        return $data = (string) $data;
                        break;
                    case'trim':
                        return $data = trim($data);
                        break;
                    case'xss':
                        //TODO
                        return;
                        break;
                }
            }
        }
        return $data;
    }

}
