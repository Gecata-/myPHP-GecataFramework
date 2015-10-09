<?php

/**
 * Description of Common
 *
 * @author gdimitrov
 */
namespace GF;
class Common {
    public static function normalize($data,$types){
        $types=  explode('|', $types);
        if(is_array($types)){
            foreach ($types as $v){
                if($v == 'int'){
                    $data = (int)$data;
                }
                
            }
        }
        return $data;
    }
}
