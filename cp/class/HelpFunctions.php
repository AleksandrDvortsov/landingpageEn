<?php
class HelpFunctions
{
    private $_db;
    private $_errors;

    public function __construct()
    {
        global $db;
        $this->_db = $db;
        $this->_errors = array();
    }


    // copierea directoriului cu tot continutul din el
    public function recurse_copy($src,$dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) )
        {
            if (( $file != '.' ) && ( $file != '..' ))
            {
                if ( is_dir($src . '/' . $file) )
                {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else
                {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    // stergerea directoriului ( fisiere + subdirectorii )
    public function deleteDir($dirPath)
    {
        if (! is_dir($dirPath))
        {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/')
        {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file)
        {
            if (is_dir($file))
            {
                $this->deleteDir($file);
            }
            else
            {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    // catalog level
    public function catalog_level($catalog_id, $db_table, $level = 1)
    {
        $catalog_info = $this->_db
            ->where("id", $catalog_id)
            ->getOne($db_table, "id, section_id");
        if($catalog_info)
        {
            if($catalog_info['section_id'] == 0)
            {
                return $level;
            }
            else
            {
                $level++;
                return $this->catalog_level($catalog_info['section_id'], $db_table, $level);
            }
        }
        else
        {
            return 0;
        }
    }

    public function display_catalog_children( $catalog_id, $tree, $lang,  $db_table)
    {
        // variabila $level este folosita doar pentru disign
        $CATALOG_LEVEL = $this->catalog_level($catalog_id, $db_table);
        //show($CATALOG_LEVEL);
        //show($tree);
        foreach ($tree as $key => $value)
        {
           // show($value);
            $info_of_curent_children = $this->_db
                ->where("id", $key)
                ->getOne($db_table,'id, title_'.$lang.' as title');
            $cat_level = $this->catalog_level($info_of_curent_children['id'], $db_table);
            //show($cat_level);
            if($info_of_curent_children && is_array($info_of_curent_children) && count($info_of_curent_children)> 0 )
            {
                if($catalog_id == $key)
                {
                    ?>
                    <option selected
                            value="<?php echo $info_of_curent_children['id']; ?>"><?php echo str_repeat('&nbsp', ($cat_level * 5)) . '&#9658;' . $info_of_curent_children['title']; ?></option>
                    <?php
                }
                else
                {
                    ?>
                    <option
                        value="<?php echo $info_of_curent_children['id']; ?>"><?php echo str_repeat('&nbsp', ($cat_level * 5)) . '&#9658;' . $info_of_curent_children['title']; ?></option>
                    <?php
                }
            }

            if(is_array($value))
            {
                foreach( $value as $val_children)
                {
                    if( !(isset($tree[$val_children]) && count($tree[$val_children])>0 && is_array($tree[$val_children])) )
                    {
                        $info_of_curent_children = $this->_db
                            ->where("id", $val_children)
                            ->getOne($db_table,'id, title_'.$lang.' as title');
                        $cat_level = $this->catalog_level($info_of_curent_children['id'], $db_table);


                        if($info_of_curent_children && is_array($info_of_curent_children) && count($info_of_curent_children)> 0)
                        {
                            if($catalog_id == $info_of_curent_children['id'])
                            {
                                ?>
                                <option selected
                                        value="<?php echo $info_of_curent_children['id']; ?>"><?php echo str_repeat('&nbsp', ($cat_level * 5)) . '&#9658;' . $info_of_curent_children['title']; ?></option>
                                <?php
                            }
                            else
                            {
                                ?>
                                <option
                                    value="<?php echo $info_of_curent_children['id']; ?>"><?php echo str_repeat('&nbsp', ($cat_level * 5)) . '&#9658;' . $info_of_curent_children['title']; ?></option>
                                <?php
                            }
                        }

                    }

                }
            }

        }

    }

    public function getOneLevelDirectory($catalog_id, $db_table)
    {
        $cat_id=array();
        $select_children = $this->_db
            ->where("section_id", $catalog_id)
            ->get($db_table, null, 'id' );

        if($select_children)
        {
            // show($select_children);
            foreach( $select_children as $children)
            {
                $cat_id[] = $children['id'];
            }
        }

        return $cat_id;
    }

    public function getDirectoryChildren($parent_id, $db_table, &$tree_string=array()) {
        // show($parent_id);
        $tree = array();
        // getOneLevel() returns a one-dimensional array of child ids
        $tree = $this->getOneLevelDirectory($parent_id, $db_table);
        if(count($tree)>0 && is_array($tree)){
            $tree_string=array_merge($tree_string,$tree);
        }
        foreach ($tree as $key => $val) {
            $this->getDirectoryChildren($val, $db_table, $tree_string);
        }
        return $tree_string;
    }

    public function getDirectoryChildren_for_options($parent_id, $db_table, &$tree_string=array()) {
        // show($parent_id);
        $tree = array();
        // getOneLevelDirectory() returns a one-dimensional array of child ids
        $tree = $this->getOneLevelDirectory($parent_id, $db_table);
        if(count($tree)>0 && is_array($tree)){
            // show($parent_id);
            // show($tree);
            $tree_string[$parent_id] = $tree;
            //$tree_string=array_merge($tree_string,$tree);
        }
        foreach ($tree as $key => $val) {
            $this->getDirectoryChildren_for_options($val, $db_table, $tree_string);
        }

        return $tree_string;
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////

//========================================================================================================================================================================================
    /*
     * @param DateTime $date Date that is to be checked if it falls between $startDate and $endDate
     * @param DateTime $startDate Date should be after this date to return true
     * @param DateTime $endDate Date should be before this date to return true
     * return bool
     */
    public function isDateBetweenDates(DateTime $date, DateTime $startDate, DateTime $endDate)
    {
        return $date > $startDate && $date < $endDate;
    }

    /* EXAMPLE
    $fromUser = new DateTime("now");
    $startDate = new DateTime("2016-02-12 10:33:05");
    $endDate = new DateTime("2016-03-25 10:33:10");

    echo "= ".isDateBetweenDates($fromUser, $startDate, $endDate);
    */
//========================================================================================================================================================================================

//========================================================================================================================================================================================
    /*
     * @param DateTime $date Date that is to be checked if it falls between $startDate and $endDate
     * @param DateTime $startDate Date should be after this date to return true
     * @param DateTime $endDate Date should be before this date to return true
     * return bool
     */
    public function isDateBetweenOrEquelDates(DateTime $date, DateTime $startDate, DateTime $endDate)
    {
        return $date >= $startDate && $date <= $endDate;
    }

    /* EXAMPLE
    $fromUser = new DateTime("now");
    $startDate = new DateTime("2016-02-12 10:33:05");
    $endDate = new DateTime("2016-03-25 10:33:10");

    echo "= ".isDateBetweenDates($fromUser, $startDate, $endDate);
    */
//========================================================================================================================================================================================
 // Diferentsa dintre 2 date
    public function diff_dates($date1,$date2)
    {
        $diff = abs(strtotime($date2) - strtotime($date1));

        $years   = floor($diff / (365*60*60*24));
        $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
        $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
        $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));

        if($seconds > 0 && $minuts == 0 && $hours == 0 && $days == 0 && $months == 0 && $years == 0)
        {
            return $seconds." seconds";
        }
        else
        if($seconds > 0 && $minuts > 0 && $hours == 0 && $days == 0 && $months == 0 && $years == 0)
        {
            return $minuts." minuts, ".$seconds." seconds";
        }
        else
        if($seconds > 0 && $minuts > 0 && $hours > 0 && $days == 0 && $months == 0 && $years == 0)
        {
            return $hours." hours, ".$minuts." minuts, ".$seconds." seconds";
        }
        else
        if($seconds > 0 && $minuts > 0 && $hours > 0 && $days > 0 && $months == 0 && $years == 0)
        {
            return $days." days, ".$hours." hours, ".$minuts." minuts, ".$seconds." seconds";
        }
        else
        if($seconds > 0 && $minuts > 0 && $hours > 0 && $days > 0 && $months > 0 && $years == 0)
        {
            return $months." months, ".$days." days, ".$hours." hours, ".$minuts." minuts, ".$seconds." seconds";
        }
        else
        {
            return $years." years, ".$months." months, ".$days." days, ".$hours." hours, ".$minuts." minuts, ".$seconds." seconds";
        }
    }

    // get title page
    public function page_title($id)
    {
        global $lang;
        $title_info = $this->_db
            ->where("id", $id)
            ->getOne("pages", "title_".$lang." as title" );

        if($title_info)
        {
            return $title_info['title'];
        }
    }

    // partition_array. Imaprte un array in părți
    function partition_array(Array $list, $p)
    {
        $listlen = count($list);
        $partlen = floor($listlen / $p);
        $partrem = $listlen % $p;
        $partition = array();
        $mark = 0;
        for($px = 0; $px < $p; $px ++) {
            $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice($list, $mark, $incr);
            $mark += $incr;
        }
        return $partition;
    }

    // Intoarce titlu a oricarui tabel, dupa id
    public function get_table_element_title($db_table, $id)
    {
        global $lang;
        $title_info = $this->_db
            ->where("id", $id)
            ->getOne($db_table, "title_".$lang." as title" );

        if($title_info)
        {
            return $title_info['title'];
        }
    }


    // ============== Sufixe pentru cpu la adaugarea unei noi pagini ============== //
    public function cpu_sufixe_cp_add_element($lang_index, $type = 0)
    {
        // $type = 0 (default or unknown) -> for cpu; $type = 1 -> for title;
        if($type == 1)
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = ' - добавить элемент';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = ' - adaugarea elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = ' - add element';
                    }
                    else
                    {
                        $word = uniqid(" - add element_".$lang_index);
                    }
        }
        else
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = '_добавить_элемент';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = '_adaugarea_elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = '_add_element';
                    }
                    else
                    {
                        $word = uniqid("_add_element_".$lang_index);
                    }
        }

        return $word;
    }

    public function cpu_sufixe_cp_edit_element($lang_index, $type = 0)
    {
        // $type = 0 (default or unknown) -> for cpu; $type = 1 -> for title;
        if($type == 1)
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = ' - редактировать элемент';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = ' - editarea elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = ' - edit element';
                    }
                    else
                    {
                        $word = uniqid(" - edit element ".$lang_index);
                    }
        }
        else
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = '_редактировать_элемент';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = '_editarea_elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = '_edit_element';
                    }
                    else
                    {
                        $word = uniqid("_edit_element_".$lang_index);
                    }
        }

        return $word;
    }

    public function cpu_sufixe_cp_delete_element($lang_index, $type = 0)
    {
        // $type = 0 (default or unknown) -> for cpu; $type = 1 -> for title;
        if($type == 1)
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = ' - удаление элемента';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = ' - stergerea elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = ' - delete element';
                    }
                    else
                    {
                        $word = uniqid(" - delete element ".$lang_index);
                    }
        }
        else
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = '_удаление_элемента';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = '_stergerea_elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = '_delete_element';
                    }
                    else
                    {
                        $word = uniqid("_delete_element_".$lang_index);
                    }
        }

        return $word;
    }

    public function cpu_sufixe_front_add_element($lang_index, $type = 0)
    {
        // $type = 0 (default or unknown) -> for cpu; $type = 1 -> for title;
        if($type == 1)
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = ' - добавить элемент';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = ' - adaugarea elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = ' - add element';
                    }
                    else
                    {
                        $word = uniqid(" - add element ".$lang_index);
                    }
        }
        else
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = '-добавить-элемент';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = '-adaugarea-elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = '-add-element';
                    }
                    else
                    {
                        $word = uniqid("-add-element-".$lang_index);
                    }
        }

        return $word;
    }

    public function cpu_sufixe_front_edit_element($lang_index, $type = 0)
    {
        // $type = 0 (default or unknown) -> for cpu; $type = 1 -> for title;
        if($type == 1)
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = ' - редактировать элемент';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = ' - editarea elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = ' - edit element';
                    }
                    else
                    {
                        $word = uniqid(" - edit element ".$lang_index);
                    }
        }
        else
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = '-редактировать-элемент';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = '-editarea-elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = '-edit-element';
                    }
                    else
                    {
                        $word = uniqid("-edit-element-".$lang_index);
                    }
        }

        return $word;
    }

    public function cpu_sufixe_front_delete_element($lang_index, $type = 0)
    {
        // $type = 0 (default or unknown) -> for cpu; $type = 1 -> for title;
        if($type == 1)
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = ' - удаление элемента';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = ' - stergerea elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = ' - delete element';
                    }
                    else
                    {
                        $word = uniqid(" - delete element ".$lang_index);
                    }
        }
        else
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = '-удаление-элемента';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = '-stergerea-elementului';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = '-delete-element';
                    }
                    else
                    {
                        $word = uniqid("-delete-element-".$lang_index);
                    }
        }

        return $word;
    }

    public function cpu_sufixe_front_detail_page($lang_index, $type = 0)
    {
        // $type = 0 (default or unknown) -> for cpu; $type = 1 -> for title;
        if($type == 1)
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = ' - детальная страница';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = ' - pagina detaliata';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = ' - detail page';
                    }
                    else
                    {
                        $word = uniqid(" - detail page ".$lang_index);
                    }
        }
        else
        {
            if(!strcmp($lang_index, 'ru'))
            {
                $word = '-детальная-страница';
            }
            else
                if(!strcmp($lang_index, 'ro'))
                {
                    $word = '-pagina-detaliata';
                }
                else
                    if(!strcmp($lang_index, 'en'))
                    {
                        $word = '-detail-page';
                    }
                    else
                    {
                        $word = uniqid("-detail-page-".$lang_index);
                    }
        }

        return $word;
    }
    // ============ END=> Sufixe pentru cpu la adaugarea unei noi pagini ============ //


    // get_dictionary - bloc cu posibilitatea de a redacta unele cuvinte din dictionar
    public function dictionary_editor_table($dictionary_ids_array)
    {
        global $list_of_site_langs;
        if (is_array($dictionary_ids_array))
        {
            $get_settings_code = $this->_db
                ->orderBy('id', 'asc')
                ->where("id", $dictionary_ids_array, 'IN')
                ->get("dictionary");

            if($get_settings_code && count($get_settings_code)>0)
            {
                ?>
                <table class="table-bordered table sp_top_dictionary_table">
                <thead>
                <tr>
                    <th><?php echo dictionary('LANG'); ?></th>
                    <th><?php echo dictionary('DESCRIPTION'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($get_settings_code as $setting_code)
                {
                    ?>
                    <tr>
                        <td>
                            <?php
                            foreach ($list_of_site_langs as $site_langs)
                            {
                                echo mb_ucfirst($site_langs) . ': <br>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($list_of_site_langs as $site_langs)
                            {
                                ?>
                                <input class="input_focusof" type="text"
                                       data-language="<?php echo $site_langs; ?>"
                                       value="<?php echo $setting_code['title_' . $site_langs]; ?>"
                                       onchange="change_dictionary_input_value('<?php echo $setting_code['id']; ?>',$(this).data('language'),$(this).val());"
                                       onpaste="this.onchange();">
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
                    <tfoot>
                    </thead>
                </table>
                <?php
            }
        }
    }
    //================================================================================================================//
    private function _rfgets($handle) {
        $line = null;
        $n = 0;

        if ($handle) {
            $line = '';

            $started = false;
            $gotline = false;

            while (!$gotline) {
                if (ftell($handle) == 0) {
                    fseek($handle, -1, SEEK_END);
                } else {
                    fseek($handle, -2, SEEK_CUR);
                }

                $readres = ($char = fgetc($handle));

                if (false === $readres) {
                    $gotline = true;
                } elseif ($char == "\n" || $char == "\r") {
                    if ($started)
                        $gotline = true;
                    else
                        $started = true;
                } elseif ($started) {
                    $line .= $char;
                }
            }
        }

        fseek($handle, 1, SEEK_CUR);

        return strrev($line);
    }

    public function file_line_counter($file)
    {
        $f = fopen($file, 'rb');
        $lines = 0;

        while (!feof($f)) {
            $lines += substr_count(fread($f, 8192), "\n");
        }

        fclose($f);

        return $lines;
    }

    public function read_logo_file($file, $numRows = 0)
    {
        // $numRows stops after this number of rows
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if($ext === 'log')
        {
            $linecount = $this->file_line_counter($file);
            //show($linecount);
            $handle = fopen($file, "r");
            if ($handle)
            {
                if($numRows == 0)
                {
                    $linecount = $this->file_line_counter($file);
                }
                else
                {
                    $linecount = $numRows;
                }

                for ($i = 0; $i < $linecount; $i++)
                {
                    $buffer = $this->_rfgets($handle);
                    echo $buffer . PHP_EOL.'<br>';
                }

                fclose($handle);
            }
            else
            {
                echo 'error opening the file';
            }


        }
        else
        {
            echo 'only .log format is allowed';
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function image_thumb($image_name = 'no-image.jpg', $db_table = 'default', $image_width=0, $image_height=0, $version=0, $zc=0 )
    {
        $image_path = $_SERVER['DOCUMENT_ROOT'].'/uploads/' . $db_table . '/'.$image_name;
        if(isset($image_name) && $image_name!="" && is_file($image_path))
        {
            $image_thumb = newthumbs( $image_name , $db_table, $image_width, $image_height, $version, $zc);
        }
        else
        {
            $image_thumb = '';
        }

        echo "<script>console.log('Debug Objects: " . $image_thumb . "' );</script>";
        return $image_thumb;
    }



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function youtube_link($link)
    {
        $youtube_link = '';

        if ( trim($link) != '')
        {
            if (strpos($link, 'www.youtube.com/watch?v=') !== false)
            {
                $parts = parse_url($link);
                parse_str($parts['query'], $query);
                $youtube_link =  $query['v'];
            }
            else
            {
                $youtube_link =  $link;
            }
        }

        if( trim($youtube_link) != '' )
        {
            return "//www.youtube.com/embed/".$youtube_link;
        }
        else
        {
            return false;
        }

    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*
    	Exemplu de folosire
	 $youbute_link_preview_image = $Functions->youtube_link_preview_image($catalog_info['youtube_link']);
                                            if($youbute_link_preview_image)
                                            {
                                                $imagethumb = $youbute_link_preview_image;
                                            }
    */
    public function youtube_link_preview_image($link)
    {
        $youtube_link = '';

        if ( trim($link) != '')
        {
            if (strpos($link, 'www.youtube.com/watch?v=') !== false)
            {
                $parts = parse_url($link);
                parse_str($parts['query'], $query);
                $youtube_link =  $query['v'];
            }
            else
            {
                $youtube_link =  $link;
            }
        }

        if( trim($youtube_link) != '' )
        {
            $youtube_link_preview_image = "https://img.youtube.com/vi/".$youtube_link."/maxresdefault.jpg";
            return $youtube_link_preview_image;
        }
        else
        {
            return false;
        }

    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





}




