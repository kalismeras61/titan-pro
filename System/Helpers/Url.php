<?php
/**
 * URL Helper
 *
 * Turan Karatuğ - <tkaratug@hotmail.com.tr>
 */

/**
 * Converting urls to clickable hyperlink in text
 * @param 	string $text
 * @return 	string
 */
if ( ! function_exists('make_link')) {
    function make_link($text)
    {
        $pattern 	= '/(((http[s]?:\/\/(.+(:.+)?@)?)|(www\.))[a-z0-9](([-a-z0-9]+\.)*\.[a-z]{2,})?\/?[a-z0-9.,_\/~#&=:;%+!?-]+)/is';
        $text 		= preg_replace($pattern, ' <a href="$1">$1</a>', $text);
        $text 		= preg_replace('/href="www/', 'href="http://www', $text);
        return $text;
    }
}

/**
 * Converting email adressess to clickable mailto in text
 * @param 	string $text
 * @return 	string
 */
if ( ! function_exists('make_mailto')) {
    function make_mailto($text)
    {
        $regex 		= '/(\S+@\S+\.\S+)/';
        $replace 	= '<a href="mailto:$1">$1</a>';
        return preg_replace($regex, $replace, $text);
    }
}

/**
 * Safe mail
 * @param 	string $email
 * @return 	string
 */
if ( ! function_exists('safe_mail')) {
    function safe_mail($email)
    {
        $character_set 	= '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
        $key 			= str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);

        for($i=0;$i<strlen($email);$i+=1) {
            $cipher_text.= $key[strpos($character_set,$email[$i])];
        }

        $script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
        $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
        $script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';

        $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")";
        $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';

        return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
    }
}