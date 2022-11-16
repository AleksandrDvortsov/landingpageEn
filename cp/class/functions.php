<?php

if ( ! function_exists('is_mobile'))
{
    function is_mobile()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|WPDesktop|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}

if ( ! function_exists('limiter'))
{
    function limiter($text,$limit){
        if(strlen($text)>$limit)
            return strrev(strstr(strrev(mb_substr($text,0,$limit,'UTF-8'))," "))."...";
        else return $text;
    }
}


if ( ! function_exists('dictionary'))
{
    function dictionary($word, $editor = true)
    {
        global $User,$page_data;

        if($User->check_cp_authorization() && ( $page_data['type'] == 1 || $page_data['type'] == 7 ) && $editor)
        {
            return html_entity_decode($GLOBALS['ar_define_langterms'][$word], ENT_QUOTES, 'UTF-8')."<img data-word_change_code=".$word." class='editor_access_block' width='24' height='24' src='/css/images/admin_editor.png'>";
          //  return html_entity_decode($GLOBALS['ar_define_langterms'][$word], ENT_QUOTES, 'UTF-8');

        }
        else
        {
            return html_entity_decode($GLOBALS['ar_define_langterms'][$word], ENT_QUOTES, 'UTF-8');
        }

    }
}




if ( ! function_exists('element_editor'))
{
    function element_editor($cpu_id, $element_id = 0)
    {
        global $User,$Cpu;
        if($User->check_cp_authorization())
        {
            if($element_id == 0)
            {
                ?>
                <span class="editor_access_block">
                <a target="_blank" href="<?php echo $Cpu->getURL( $cpu_id );?>">
                    <img width="24" height="24" src="/css/images/element_editor.png" />
                </a>
            </span>
                <?php
            }
            else
            {
                ?>
                <span class="editor_access_block">
                <a target="_blank" href="<?php echo $Cpu->getURL( $cpu_id )."?id=".$element_id;?>">
                    <img width="24" height="24" src="/css/images/element_editor.png" />
                </a>
                </span>
                <?php
            }


        }
    }
}


if ( ! function_exists('catalog_editor'))
{
    function catalog_editor($cpu_id, $section_id = 0)
    {
        global $User,$Cpu;
        if($User->check_cp_authorization())
        {
            if($section_id == 0)
            {
                ?>
                <span class="editor_access_block">
                <a target="_blank" href="<?php echo $Cpu->getURL( $cpu_id );?>">
                    <img width="24" height="24" src="/css/images/element_editor.png" />
                </a>
            </span>
                <?php
            }
            else
            {
                ?>
                <span class="editor_access_block">
                <a target="_blank" href="<?php echo $Cpu->getURL( $cpu_id )."?section_id=".$section_id;?>">
                    <img width="24" height="24" src="/css/images/element_editor.png" />
                </a>
                </span>
                <?php
            }
        }
    }
}



if ( ! function_exists('page_editor'))
{
    function page_editor($page_id)
    {
        global $User,$Cpu;
        if($User->check_cp_authorization())
        {
            ?>
            <span class="page_editor_access_block">
                 <a target="_blank" href="<?php echo $Cpu->getURL( 11 )."?id=".$page_id;?>">
                    <img width="24" height="24" src="/css/images/element_editor.png" />
                </a>
            </span>
            <?php
        }
    }
}


if ( ! function_exists('db_text'))
{
    function db_text($text)
    {
        return html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    }
}

if ( ! function_exists('preview_text'))
{
    function preview_text($word)
    {
        $striped_text = strip_tags(html_entity_decode($word, ENT_QUOTES, 'UTF-8'));
        $text = str_replace("&nbsp;",' ',$striped_text);
        return $text;
    }
}


// вывод информации - например при добавление/редактирование элемента
if ( ! function_exists('show_status_info'))
{
    function show_status_info($status_info)
    {
        // ----- curatim valorile nule din array ( sunt unile cazuri cind se returneaza null ) ------ //
        if(isset($status_info['error']) && count($status_info['error'])>0)
        {
            foreach ($status_info['error'] as $key => $value)
            {
                if (empty($value))
                {
                    unset($status_info['error'][$key]);
                }
            }
        }
        if(isset($status_info['success']) && count($status_info['success'])>0)
        {
            foreach ($status_info['success'] as $key => $value)
            {
                if (empty($value))
                {
                    unset($status_info['success'][$key]);
                }
            }
        }
        // END: --- curatim valorile nule din array ( sunt unile cazuri cind se returneaza null ) ---- //

        if(isset($status_info['error']) && count($status_info['error'])>0)
        {
            foreach ($status_info['error'] as $info)
            {
                echo "<div style='font-size: 16px;clear:both; margin-bottom: 5px;' class='label label-rouded label-danger pull-left'>$info</div>";
            }
        }

        else

        if(isset($status_info['success']) && count($status_info['success'])>0)
        {
            foreach ($status_info['success'] as $info)
            {
                echo "<div style='font-size: 16px;clear:both; margin-bottom: 5px;' class='label label-rouded label-info pull-left'>$info</div>";
            }
        }
        echo "<div style='clear:both; margin-bottom:25px;'></div>";

    }
}


if ( ! function_exists('show'))
{
    function show($Elem)
    {
        ?>
        <pre
            style="font-family: Consolas,Courier;font-size: 12px;background: #ddd;border: 1px solid #bbb;padding: 4px 6px;color: #444;display: inline-block;border-radius: 3px;text-align: left;margin: 3px;line-height: 1.0;">
            <?php print_r($Elem);?>
        </pre>
        <?php
    }
}

if ( ! function_exists('dump'))
{
    function dump($Elem)
    {
        ?>
        <pre
            style="font-family: Consolas,Courier;font-size: 12px;background: #ddd;border: 1px solid #bbb;padding: 4px 6px;color: #444;display: inline-block;border-radius: 3px;text-align: left;margin: 3px;line-height: 1.0;">
            <?php var_dump($Elem);?>
        </pre>
        <?php
    }
}


if ( ! function_exists('slugify'))
{
    function slugify ($text)
    {
        $replace = array(
            '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
            '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä'=> 'Ae',
            '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
            'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
            'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
            'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
            'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
            'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
            'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
            'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
            'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
            'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
            'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
            'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
            '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
            'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
            'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
            'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
            'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
            'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
            'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
            'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
            'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
            'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
            'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
            'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
            'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
            '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
            'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
            'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u',
            'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
            'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
            'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
            'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
            'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
            'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
            'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
            'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
            'ю' => 'yu', 'я' => 'ya'
        );

        // make a human readable string
        $text = strtr($text, $replace);
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d.]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // remove unwanted characters
        $text = preg_replace('~[^-\w.]+~', '', $text);
        $text = strtolower($text);
        return $text;
    }
}



if ( ! function_exists('slugify_special'))
{
    function slugify_special ($text) // abc def = ABC_DEF
    {
        $replace = array(
            '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
            '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä'=> 'Ae',
            '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
            'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
            'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
            'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
            'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
            'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
            'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
            'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
            'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
            'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
            'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
            'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
            '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
            'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
            'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
            'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
            'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
            'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
            'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
            'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
            'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
            'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
            'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
            'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
            'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
            '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
            'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
            'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u',
            'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
            'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
            'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
            'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
            'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
            'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
            'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
            'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
            'ю' => 'yu', 'я' => 'ya'
        );

        // make a human readable string
        $text = strtr($text, $replace);
        // replace non letter or digits by _
        $text = preg_replace('~[^\\pL\d.]+~u', '_', $text);
        // trim
        $text = trim($text, '_');
        // remove unwanted characters
        $text = preg_replace('~[^-\w.]+~', '', $text);
        $text = strtoupper($text);
        return $text;
    }
}


if (!function_exists('mb_ucfirst'))
{   // переводит первый символ строки в верхний регистр
    function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = true) {
        $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
        $str_end = "";
        if ($lower_str_end) {
            $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
        }
        else {
            $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
        }
        $str = $first_letter . $str_end;
        return $str;
    }
}



if (!function_exists('newthumbs')) {
    function newthumbs($image = '', $dir = '', $width = 0, $height = 0, $version = 0, $zc = 0)
    {
        require_once $_SERVER['DOCUMENT_ROOT'].'/libraries/imres/phpthumb.class.php';
        $path_target = $_SERVER['DOCUMENT_ROOT'].'/uploads/';

        $img = '';

        $result = is_dir($path_target . $dir . '/thumbs');
        if ($result) {
            $prevdir = $dir . '/thumbs';
        } else {
            if (mkdir( $path_target . $dir . '/thumbs')) {
                $prevdir = $dir . '/thumbs';
            } else {
                return 'error 1';
            }
        }


        if (!empty($version))
        {
            $result = is_dir( $path_target . $dir . '/thumbs/version_' . $version );
            if ($result) {
                $prevdir = $dir . '/thumbs/version_' . $version;
            } else {
                if ( mkdir( $path_target . $dir . '/thumbs/version_' . $version)) {
                    $prevdir = $dir . '/thumbs/version_' . $version;
                } else {
                    return 'error 1';
                }
            }
        }


        $temp_ext = explode('.', $image);
        $ext = end($temp_ext);

        $timg = $path_target . $dir . '/' . $image;
        $catimg = $path_target . $prevdir . '/' . $image;



        $explodeCurentFile = explode('.', $image);
        $end_file = end($explodeCurentFile);

        if($end_file == 'svg')
        {
            $img = '/uploads/'.$dir.'/'.$image;
        }
        else
        {
            if (is_file($timg) && !is_file($catimg)) {
                $opath1 = $path_target . $dir . '/';
                $opath2 = $path_target . $prevdir . '/';
                $dest = $opath2 . $image;
                $source = $opath1 . $image;
                $phpThumb = new phpThumb();
                $phpThumb->setSourceFilename($source);
                if (!empty($width) && $width>0) $phpThumb->setParameter('w', $width);
                if (!empty($height) && $height>0) $phpThumb->setParameter('h', $height);
                if ($ext == 'png') $phpThumb->setParameter('f', 'png');
                if (!empty($zc)) {
                    $phpThumb->setParameter('zc', '1');
                }
                $phpThumb->setParameter('q', 100);
                if ($phpThumb->GenerateThumbnail()) {
                    if ($phpThumb->RenderToFile($dest)) {
                        $img = '/uploads/' . $prevdir . '/' . $image;
                    } else {
                        return 'error 3';
                    }
                }

            } elseif (is_file($catimg)) {
                $img = '/uploads/' . $prevdir . '/' . $image;
            } else {
                return 'error 2';
            }

        }
        return $img;
    }
}

if (!function_exists('getDirContents')) {
    function getDirContents($dir, $filter, &$results = array())
    {
        if(trim($filter) == '')
        {
            return false;
        }

        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

            if (!is_dir($path)) {
                if (empty($filter) || preg_match($filter, $path)) $results[] = $path;
            } elseif ($value != "." && $value != "..") {
                getDirContents($path, $filter, $results);
            }
        }
        return $results;
    }
}

//remove images from directories
if (!function_exists('remove_image'))
{
    function remove_image($dir, $image)
    {
        $return_value = true;
        $path_target = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $result = is_dir($path_target . $dir );
        if ($result)
        {
            $FileDirecotry = $path_target . $dir;
        }
        else
        {
            return false;
        }

        if($image!="" && is_file($FileDirecotry. "/" . $image)) // очень важное условие, если им пренебречь то при пустом значение файла удалиться все изображения из текущей директории
        {
            $find_all_files_for_detele = getDirContents($FileDirecotry, "/" . $image . "$/");
            if (count($find_all_files_for_detele) > 0) {
                foreach ($find_all_files_for_detele as $fined_file_to_delete) {
                    if (unlink($fined_file_to_delete)) {
                        // echo 'deleted';
                    } else {
                        $return_value = false;
                    }
                }
            } else {
                return false;
            }
        }

        return $return_value;
    }
}


// stergerea directoriului ( fisiere + subdirectorii )
if (!function_exists('deleteDir')) {
    function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}

// is_dir_empty
if (!function_exists('is_dir_empty'))
{
    function is_dir_empty($dir)
    {
        if (!is_readable($dir)) return NULL;
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                return FALSE;
            }
        }
        return TRUE;
    }
}

//remove images from directories
if (!function_exists('access_remote_url'))
{
    function access_remote_url($request_url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}

// converteaza secunde in ore
if (!function_exists('dtLength'))
{
    function dtLength($sec)
    {
        $t = new DateTime("@" . $sec);
        $r = new DateTime("@0");
        $i = $t->diff($r);
        $h = intval($i->format("%a")) * 24 + intval($i->format("%H"));
        return $h . ":" . $i->format("%I:%S");
    }
}



// Last element of array
if(!function_exists('last_element_of_array'))
{
    //// Last element of array without affecting the internal array pointer
    // This works because the parameter to the function is being sent as a copy, not as a reference to the original variable.
    function last_element_of_array( $array ) { return end( $array ); }
}


// ================= only for curent project =============

if ( ! function_exists('department_data'))
{
    function department_data($id)
    {
        global $db,$lang;
        $department_data_info = $db
            ->where('id', (int)$id )
            ->where('active', 1)
            ->getOne('departaments', 'id, title_'.$lang.' as title');
        if($department_data_info)
        {
            return $department_data_info;
        }
        else
        {
            return null;
        }
    }
}

if ( ! function_exists('doctor_data'))
{
    function doctor_data($id)
    {
        global $db,$lang;
        $doctor_data_info = $db
            ->where('id', (int)$id )
            ->where('active', 1)
            ->getOne('doctors', 'id, title_'.$lang.' as title');
        if($doctor_data_info)
        {
            return $doctor_data_info;
        }
        else
        {
            return null;
        }
    }
}