<?php
/**
 * Created by PhpStorm.
 * User: almir
 * Date: 17/01/16
 * Time: 22:34
 */
namespace app\components;

class ABStringFilter
{
    /**
     * @inheritdoc
     */
    public static function iniciaisMaiusculas($string)
    {
        // Converte strings para Iniciais maiúsculas
        // Não converte "da,do,dos,das,de ..." nomes no meio iniciando do D com 2 ou 3 letras
        if ($string == "")
            return $string;
        $string= mb_strtolower(trim($string), 'UTF-8');
        $string[0]=strtoupper($string[0]);
        for($atual=0;$atual<=strlen($string)-1;$atual++)
        {
            if($string[$atual]==" ")
                if($string[$atual+1]!="d")
                    $string[$atual+1]=strtoupper($string[$atual+1]);
                else
                    if(!($string[$atual+3]==" " || $string[$atual+4]==" "))
                        $string[$atual+1]=strtoupper($string[$atual+1]);
        }
        return $string;
    }

    public static function removeAcentuacao($string)
    {
        $array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
        , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
        $array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
        , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );

        return str_replace( $array1, $array2, $string);
    }
}
