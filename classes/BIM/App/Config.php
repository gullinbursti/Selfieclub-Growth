<?php

class BIM_App_Config extends BIM_App_Base{
    /**
     * @param array $params
     */
    public static function saveBootConf( $params ){
        $type = isset($params['type']) ? $params['type'] : 'live';
        $data = isset($params['data']) ? $params['data'] : '';
        $OK = FALSE;
        $data = json_decode( $data );
        if( $data ){
            $data = json_encode($data);
            BIM_Config::saveBootConf($data, $type);
            $OK = TRUE;
        }
        return $OK;
    }
    
    public static function getBootConf( $params ){
        $type = isset($params['type']) ? $params['type'] : 'live';
        return self::prettyPrint(BIM_Config::getBootConf( $type ));
    }
    
    /*
     * Indents a flat JSON string to make it more human-readable.
     *
     * @param string $json The original JSON string to process.
     *
     * @return string Indented version of the original JSON string.
     */
    public static function prettyPrint($json) {
    
        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = '  ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;
    
        for ($i=0; $i<=$strLen; $i++) {
    
            // Grab the next character in the string.
            $char = substr($json, $i, 1);
    
            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;
    
            // If this character is the end of an element,
            // output a new line and indent the next line.
            } else if(($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos --;
                for ($j=0; $j<$pos; $j++) {
                    $result .= $indentStr;
                }
            }
    
            // Add the character to the result string.
            $result .= $char;
    
            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }
    
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
    
            $prevChar = $char;
        }
    
        return $result;
    }
    
}
