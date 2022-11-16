<?php
class CPU
{
    private $_db;
    private $_cpu_lang;
    public $lang;
    public $langList;

    public function __construct()
    {
        global $db, $list_of_site_langs;
        $this->_db = $db;
        $this->langList = $list_of_site_langs;
    }

    private function LastSlash($string)
    {
        $string = strval($string);
        if(!$string || $string==''){
            return "";
        }else{
            $lastSymbol = $string[strlen($string)-1];
            return $lastSymbol;
        }
    }

    public function FirstSlash($string)
    {
        $string = strval($string);
        if(!$string || $string==''){
            return "";
        }else{
            $lastSymbol = $string[0];
            return $lastSymbol;
        }
    }

    public function getCPU()
    {
        $url = $_SERVER['REQUEST_URI'];
        //очистка
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = preg_replace("/[^\x20-\xFF]/","",strval($url));
        $url = str_replace("%22", "", $url);
        $urlR = explode("?", $url);
        $url = $this->_db->escape($urlR[0]);
        $exploded_url = array_filter( explode("/", $url), 'strlen' );
        if(count($exploded_url)>0)
        {
            $cpu_last_part = end($exploded_url);
        }
        else
        {
            $cpu_last_part = '';
        }

        $cpu = $this->_db
            ->where('cpu', $cpu_last_part)
            ->getOne('cpu');

        if(!empty($cpu))
        {
            $page_data = $this->_db
                ->where('id',$cpu['page_id'])
                ->getOne('pages', 'page');

            if(!empty($page_data))
            {
                $this->_cpu_lang = $cpu['lang'];
                //Будет использоваться код состояния 301 для изменения URL страницы так, как она показана в результатах поиска.
                //С точки зрения SEO, именно 301 редирект сообщает поисковым роботам, что нужно объединить два разных адреса в один,
                //где основным будет тот, на который и происходит перенаправление.
                //return $this->LastSlash($url);

                if($this->LastSlash($url)!=="/" )
                {
                    return 301;
                }
                else
                {
                    // show( $this->getURL($cpu['page_id'],$cpu['elem_id']) );
                    // проверим валидность полной ссылки
                    if( $url == ($this->getURL($cpu['page_id'],$cpu['elem_id'])) )
                    {
                        return array("lang"=>$cpu['lang'], "page"=>$page_data['page'], "page_id"=>$cpu['page_id'], "cpu"=>$url, "elem_id"=>$cpu['elem_id']);
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;
        }


    }


    public function GetPageData($pageData)
    {
        $pageId = $this->_db->escape( intval($pageData['page_id']) );
        $lang = $this->_db->escape( $pageData['lang'] );
        if(!$pageId || $pageId==0){
            return false;
        }

        $page = $this->_db
            ->where('id', $pageId)
            ->getOne('pages', "id, id as cat_id, type, db_table, page, cpu_parrent,  title_".$lang." AS title , page_title_".$lang." AS page_title, meta_d_".$lang." AS meta_d, meta_k_".$lang." AS meta_k, assoc_table, text_".$lang." AS `text`");
         //show($page);

        if(!empty($page))
        {
            if(trim($page['assoc_table'])!='')
            {

                $assc_table_data = $this->_db
                    ->where('id',$pageData['elem_id'])
                    ->getOne($page['assoc_table'], "id, id as elem_id, title_".$lang." AS title , page_title_".$lang." AS page_title, meta_d_".$lang." AS meta_d, meta_k_".$lang." AS meta_k,  text_".$lang." AS `text`");

                if(!empty($assc_table_data))
                {
                    $assc_table_data = array('cat_id' => $page['id'], 'parrent' => $page['cpu_parrent'], 'type' => $page['type'], 'db_table' => $page['assoc_table']) + $assc_table_data;
                    return $assc_table_data;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                //id of table -> detail page of elements
                $sp_found_detail_page_of_current_catalog = dirname($page['page']).'/detail.php';
                $detail_page_id = $this->_db
                    ->where('cpu_parrent', $page['id'])
                    ->where('page', $sp_found_detail_page_of_current_catalog )
                    ->getOne('pages','id, type');
                //show($sp_found_detail_page_of_current_catalog);
                if($detail_page_id)
                {
                    $page = array('type' => $detail_page_id['type'], 'detail_page_id' => $detail_page_id['id'], 'elem_id' => 0 ) + $page;
                }
                return $page;
            }
        }
        else
        {
            return false;
        }
    }

    public function page404()
    {
        header('HTTP/1.0 404 Not Found');
        include($_SERVER['DOCUMENT_ROOT']."/404.php");
        exit;
    }

    //список адресов текущей страницы для всех языков
    public function getURL($page_id,$elem_id = 0)
    {
        //-------------- pentru pagina 404 ----------------//
        if(!isset($this->_cpu_lang) || trim($this->_cpu_lang) == '')
        {
            if( isset($_SESSION['last_lang']) && trim($_SESSION['last_lang']) != '')
            {
                $this->_cpu_lang = $_SESSION['last_lang'];
            }
        }
        //-------------- pentru pagina 404 ----------------//

        $CpuUrl = $this->_db
            ->where ('page_id', $page_id)
            ->where ('elem_id', $elem_id)
            ->where('lang', $this->_cpu_lang)
            ->getOne('cpu', 'cpu');

        //show(array($page_id, $elem_id, $this->_cpu_lang));

        if(!empty($CpuUrl))
        {
            // проверим если есть чпу родитель для данного элемента (для склеивание частей чпу-урл если это необходимо)
            $have_parent = true;
            $cp_pages_id = $page_id;
            if(trim($CpuUrl['cpu'])=='')
            {
                $creadted_cpu_thread = '/';
            }
            else
            {
                $creadted_cpu_thread = '/'.$CpuUrl['cpu'].'/';
            }

            while($have_parent!=false)
            {
                $cpu_parent_info = $this->_db
                    ->where ("id", $cp_pages_id)
                    ->getOne("pages", "id, cpu_parrent, assoc_table");


                if($cpu_parent_info['assoc_table'] == 'catalog')
                {
                    $CpuParentUrl = $this->_db
                        ->where ('page_id', $cp_pages_id)
                        ->where ('elem_id', $elem_id)
                        ->where('lang', $this->_cpu_lang)
                        ->getOne('cpu');

                    $get_parent_of_curent_catalog =  $this->_db
                        ->where('id',$CpuParentUrl['elem_id'])
                        ->getOne('catalog', 'id, section_id');

                    $catalog_path = array();
                    $catalog_path[] = $get_parent_of_curent_catalog['id'];

                    if($get_parent_of_curent_catalog['section_id']!=0)
                    {
                        $section_id_of_current_parent = $get_parent_of_curent_catalog['section_id'];
                        $curent_parent_id = $get_parent_of_curent_catalog['id'];

                        while($section_id_of_current_parent!=0)
                        {

                            $get_all_parents_of_curent_catalog =  $this->_db
                                ->where('id', $section_id_of_current_parent)
                                ->getOne('catalog', 'id, section_id');

                            $section_id_of_current_parent = $get_all_parents_of_curent_catalog['section_id'];
                            $curent_parent_id = $get_all_parents_of_curent_catalog['id'];
                            $catalog_path[] = $curent_parent_id;
                        }
                    }

                    $reversed_catalog_path = array_reverse($catalog_path);

                    if($this->_cpu_lang == $GLOBALS['ar_define_settings']['LANG_MAIN'])
                    {
                        $creadted_cpu_thread = '';
                    }
                    else
                    {
                        $creadted_cpu_thread = '/'.$this->_cpu_lang;
                    }


                    foreach ( $reversed_catalog_path as $catalog_path_info )
                    {
                        $CpuParentUrl = $this->_db
                            ->where ('page_id', 94)
                            ->where ('elem_id', $catalog_path_info)
                            ->where('lang', $this->_cpu_lang)
                            ->getOne('cpu', 'cpu');

                        //show($catalog_path_info['id']);
                        if($CpuParentUrl)
                        {
                            $creadted_cpu_thread .= '/'.$CpuParentUrl['cpu'];
                        }
                    }

                    return $creadted_cpu_thread.'/';

                }

                else
                    if($cpu_parent_info['assoc_table'] == 'catalog_elements')
                    {
                        if( !empty($cpu_parent_info) && $cpu_parent_info['cpu_parrent']>0)
                        {
                            //alfam in ce catalog se afla produsul
                            $get_section_id_of_element = $this->_db
                                ->where('id',$elem_id)
                                ->getOne('catalog_elements', 'section_id');
                            if($get_section_id_of_element)
                            {
                                $cpu_catalog_of_curent_element = $this->getURL(94,$get_section_id_of_element['section_id']); // 94 - id of catalog page
                                return $cpu_catalog_of_curent_element.$CpuUrl['cpu'].'/';
                            }
                        }
                    }

                    else
                        if($cpu_parent_info['assoc_table'] == 'blog_elements')
                        {
                            if( !empty($cpu_parent_info) && $cpu_parent_info['cpu_parrent']>0)
                            {
                                //alfam in ce catalog se afla produsul
                                $get_section_id_of_element = $this->_db
                                    ->where('id',$elem_id)
                                    ->getOne('blog_elements', 'section_id');
                                if($get_section_id_of_element)
                                {
                                    $cpu_catalog_of_curent_element = $this->getURL(525,$get_section_id_of_element['section_id']); // 525 - id of blog catalog page
                                    return $cpu_catalog_of_curent_element.$CpuUrl['cpu'].'/';
                                }
                            }
                        }

                        else
                            if($cpu_parent_info['assoc_table'] == 'special_offers_elements')
                            {

                                if( !empty($cpu_parent_info) && $cpu_parent_info['cpu_parrent']>0)
                                {
                                    //alfam in ce catalog se afla produsul
                                    $get_section_id_of_element = $this->_db
                                        ->where('id',$elem_id)
                                        ->getOne('special_offers_elements', 'section_id');
                                    if($get_section_id_of_element)
                                    {
                                        $cpu_catalog_of_curent_element = $this->getURL(728,$get_section_id_of_element['section_id']); // 728 - id of offers catalog page
                                        return $cpu_catalog_of_curent_element.$CpuUrl['cpu'].'/';
                                    }
                                }
                            }


                    else
                    {

                        if( !empty($cpu_parent_info) && $cpu_parent_info['cpu_parrent']>0)
                        {
                            $CpuParentUrl = $this->_db
                                ->where ('page_id', $cpu_parent_info['cpu_parrent'])
                                ->where ('elem_id', 0)
                                ->where('lang', $this->_cpu_lang)
                                ->getOne('cpu', 'cpu');

                            if(!empty($CpuParentUrl))
                            {
                                if(trim($CpuParentUrl['cpu'])=='')
                                {
                                    $creadted_cpu_thread = $CpuParentUrl['cpu'].$creadted_cpu_thread;
                                }
                                else
                                {
                                    $creadted_cpu_thread = '/'.$CpuParentUrl['cpu'].$creadted_cpu_thread;
                                }
                                $cp_pages_id = $cpu_parent_info['cpu_parrent'];
                            }
                        }
                        else
                        {
                            $have_parent = false;
                        }
                    }
            }

            return $creadted_cpu_thread;
        }
        else
        {
            return false;
        }
    }

    public function translitURL($str)
    {
        $str = str_replace('/',"",$str);
        $str = str_replace('\\',"",$str);
        $tr = array(
            "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
            "Д"=>"d","Е"=>"e","Ё"=>"yo","Ж"=>"zh","З"=>"z","И"=>"i",
            "Й"=>"j","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
            "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
            "У"=>"u","Ф"=>"f","Х"=>"H","Ц"=>"c","Ч"=>"ch",
            "Ш"=>"sh","Щ"=>"sch","Ъ"=>"j","Ы"=>"y","Ь"=>"i",
            "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo","ж"=>"zh",
            "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"j",
            "ы"=>"y","ь"=>"i","э"=>"e","ю"=>"yu","я"=>"ya",
            " "=> "-", "."=> "", "І"=> "i", "'"=>"",
            "і"=> "i", "&#1186;"=> "n", "&#1187;"=> "n",
            "&#1198;"=> "u", "&#1199;"=> "u", "&#1178;"=> "q", '""'=>'', '//'=>'', '/'=>'',
            "&#1179;"=> "q", "&#1200;"=> "u",
            "&#1201;"=> "u", "&#1170;"=> "g", "&#1171;"=> "g",
            "&#1256;"=> "o", "&#1257;"=> "o", "&#1240;"=> "a", 'ă'=>'a','ț'=>'t','ș'=>'s',
            "&#1241;"=> "a" , 'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
        );

        // Убираю тире, дефисы внутри строки
        $urlstr = str_replace('–'," ",$str);
        $urlstr = str_replace('-'," ",$urlstr);
        $urlstr = str_replace('—'," ",$urlstr);

        // Убираю лишние пробелы внутри строки
        $urlstr=preg_replace('/\s+/',' ',$urlstr);
        if (preg_match('/[^A-Za-z0-9_\-]/', $urlstr)) {
            $urlstr = strtr($urlstr,$tr);
            $urlstr = preg_replace('/[^A-Za-z0-9_\-\/]/', '', $urlstr);
            $urlstr = trim($urlstr,'-');
            $urlstr = strtolower($urlstr);
            return $urlstr;
        } else {
            $str = trim($str,'-');
            return strtolower($str);
        }
    }

    // проверяем, чтобы адреса в массиве имели нужный формат
    public function checkCpu($urlArr)
    {
        foreach ($urlArr as $key => $value)
        {
            $value = $this->translitURL($value);
            $urlArr[$key] = $value;
        }
        return $urlArr;
    }


    // проверяем чпу на уникальность
    public function CheckForUniqCpu($url,$lang,$pageId)
    {
        // уточним ид поле для текущего ЧПУ, чтобы исключить его из поиска совпадение
        $current_cpu_info = $this->_db
            ->where ("cpu", $url)
            ->getOne("cpu", "*");

        if($current_cpu_info)
        {
            if($pageId == $current_cpu_info['page_id'] && $lang == $current_cpu_info['lang'])
            {
                return $url;
            }
            else
            {
                $url = $url.'-'.$GLOBALS['ar_define_settings']['CPU_KEYWORD'];
                if($url===$this->CheckForUniqCpu($url,$lang,$pageId))
                {
                    return $url;
                }
                else
                {
                    return $this->CheckForUniqCpu($url,$lang,$pageId);
                }
            }
        }
        else
        {
            return $url;
        }
    }

    public function updateCpu($arr,$pageId)
    {
        $status_info = true;
        if(!$pageId || !is_numeric($pageId) || $pageId==0)
        {
            echo "Не указана страница для редактирования";
            $status_info = false;
        }

        foreach ($this->langList as $lang)
        {
            // проверим уникальность
            $arr[$lang] = $this->CheckForUniqCpu($arr[$lang],$lang,$pageId);
            //show($arr[$lang]);
            $CpuFieldId = $this->_db
                ->where ("page_id", $pageId)
                ->where ("lang", $lang)
                ->where ("elem_id", 0)
                ->getOne("cpu", "id");
            if($CpuFieldId)
            {
                $data = Array (
                    'cpu' => $arr[$lang]
                );

                $this->_db->where ('page_id', $pageId);
                $this->_db->where ('lang', $lang);
                $this->_db->where ('elem_id', 0);
                if ($this->_db->update ('cpu', $data))
                {
                    // echo 1;
                }
                else
                {
                    $status_info = false;
                }
            }
            else
            {
                // это на случай если кто-то случайно удалит поле с ЧПУ для странице, то при редактирование странице ЧПУ восстановится
                $data = Array (
                    "page_id" => $pageId,
                    "cpu" => $arr[$lang],
                    "lang" => $lang
                );
                $id = $this->_db->insert ('cpu', $data);
                if(!$id)
                {
                    $status_info = false;
                }
            }

        }
        return $status_info;
    }


    public function top_block_info($cutpageinfo)
    {
        // $children_of - se va folosi pentru afisarea corecta a 'breadcrumb' a subcategoriilor
        // Cind intram in add_element sau edit_element, apelam la tabelul parinte pentru afisarea corecta a 'breadcrumb'

        if(isset(parse_url($_SERVER['REQUEST_URI'])['query']))
        {
            $exploded_url_query = parse_url($_SERVER['REQUEST_URI'])['query'];
            parse_str($exploded_url_query, $url_query);
        }
        $children_of = 0; // no children
        if(isset($url_query['section_id']) && is_numeric($url_query['section_id']) && $url_query['section_id'] > 0 )
        {
            $children_of = (int)$url_query['section_id']; // children with section_id = $url_query['id']
        }


        $explode_cpu = array_filter( explode("/", $cutpageinfo['cpu']), 'strlen' );
        // проверим если текущий язык не совпадает с главным языком по умолчанию
        $site_lang_by_default = $this->_db
            ->where('code', 'LANG_MAIN')
            ->getOne('settings', "value");

        if($site_lang_by_default && $site_lang_by_default['value'] == $cutpageinfo['lang'])
        {
            // если языки совпадают, то добавлением чпу для главного языка
            // это делается потому что cpu для языка по умолчанию является пустота, и когда мы делаем explode array_filter это значение теряется
            array_unshift($explode_cpu,"");
        }

        $lengOfExmplodeArray = count($explode_cpu);
        $explode_cpu = array_values($explode_cpu); // reset key of array
        ?>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <?php
                if($lengOfExmplodeArray > 1)
                {
                    if($children_of == 0)
                    {
                        $breadcrumb_for_return_back = $this->_db
                            ->where ("cpu", $explode_cpu[$lengOfExmplodeArray-2])
                            ->getOne("cpu", "page_id");
                        $bredcrumb_one_step_back_cpu = $this->getURL($breadcrumb_for_return_back['page_id']);
                        ?>

                        <a href="<?php echo $bredcrumb_one_step_back_cpu;?>">
                            <span class="label label-info label-danger"><?php echo $GLOBALS['ar_define_langterms']['RETURN_BACK']?></span>
                        </a>
                        <?php
                    }
                    else
                    {
                        $get_last_cpu_info = $this->_db
                            ->where ("cpu", $explode_cpu[$lengOfExmplodeArray-1])
                            ->getOne("cpu", "page_id");

                        if($get_last_cpu_info)
                        {
                            $get_table_of_last_cpu = $this->_db
                                ->where ("id", $get_last_cpu_info['page_id'])
                                ->getOne("pages", "db_table,cpu_parrent");

                            if( isset($get_table_of_last_cpu['db_table']) && !empty($get_table_of_last_cpu['db_table']) )
                            {
                                $get_info_of_table_of_last_cpu = $this->_db
                                    ->where('id', $children_of)
                                    ->getOne($get_table_of_last_cpu['db_table']);
                                if(isset($get_info_of_table_of_last_cpu['section_id']))
                                {
                                    ?>
                                    <a href="<?php echo $this->getURL($get_last_cpu_info['page_id']);?>?section_id=<?php echo $get_info_of_table_of_last_cpu['section_id'];?>">
                                        <span class="label label-info label-danger"><?php echo $GLOBALS['ar_define_langterms']['RETURN_BACK']?></span>
                                    </a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="<?php echo $this->getURL($get_table_of_last_cpu['cpu_parrent']);?>?section_id=<?php echo $get_info_of_table_of_last_cpu['id'];?>">
                                        <span class="label label-info label-danger"><?php echo $GLOBALS['ar_define_langterms']['RETURN_BACK']?></span>
                                    </a>
                                    <?php
                                }
                            }
                            else
                            {
                                if(isset($get_table_of_last_cpu['cpu_parrent']) && is_numeric($get_table_of_last_cpu['cpu_parrent']) )
                                {
                                    $get_info_of_parent_cpu = $this->_db
                                        ->where ("id", $get_table_of_last_cpu['cpu_parrent'])
                                        ->getOne("pages", "db_table");

                                    if(isset($get_info_of_parent_cpu['db_table']) && !empty($get_info_of_parent_cpu['db_table']) )
                                    {
                                        $get_info_of_table_of_last_cpu = $this->_db
                                            ->where('id', $children_of)
                                            ->getOne($get_info_of_parent_cpu['db_table']);

                                        if( isset($get_info_of_table_of_last_cpu['section_id']))
                                        {
                                            ?>
                                            <a href="<?php echo $this->getURL($get_table_of_last_cpu['cpu_parrent']);?>?3section_id=<?php echo $get_info_of_table_of_last_cpu['section_id'];?>">
                                                <span class="label label-info label-danger"><?php echo $GLOBALS['ar_define_langterms']['RETURN_BACK']?></span>
                                            </a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a href="<?php echo $this->getURL($get_table_of_last_cpu['cpu_parrent']);?>?section_id=<?php echo $get_info_of_table_of_last_cpu['id'];?>">
                                                <span class="label label-info label-danger"><?php echo $GLOBALS['ar_define_langterms']['RETURN_BACK']?></span>
                                            </a>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>


                    <?php
                    /*
                    <span onclick="history.go(-1);" style='cursor:pointer;' class="label label-info label-danger"><?php echo $GLOBALS['ar_define_langterms']['RETURN_BACK']?></span>
                    */
                    ?>

                    <div style="clear: both; height: 25px;"></div>
                    <?php
                }
                ?>
                <h4 class="page-title"><?php echo $cutpageinfo['title'];?></h4>
            </div>

            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <?php
                    $cpu_counter = 0;
                    if($lengOfExmplodeArray > 1)
                    {
                        if($children_of == 0)
                        {
                            foreach ($explode_cpu as $breadcrumb_cpu)
                            {
                                $breadcrumb_Info = $this->_db
                                    ->where ("cpu", $breadcrumb_cpu)
                                    ->getOne("cpu", "page_id");
                                $bredcrumb_step_cpu = $this->getURL($breadcrumb_Info['page_id']);

                                $breadcrumb_title = $this->_db
                                    ->where ("type", 0)
                                    ->where('id', $breadcrumb_Info['page_id'])
                                    ->getOne('pages'," title_".$cutpageinfo['lang']." as title ");


                                if(trim($breadcrumb_title['title'])!="")
                                {
                                    if ($cpu_counter == $lengOfExmplodeArray - 1)
                                    {
                                        ?>
                                        <li class="active"><?php echo mb_strtolower($breadcrumb_title['title']);?></li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li>
                                            <a href="<?php echo $bredcrumb_step_cpu;?>"><?php echo mb_strtolower($breadcrumb_title['title'])?></a>
                                        </li>
                                        <?php
                                    }
                                }
                                $cpu_counter++;
                            }
                        }
                        else
                        {

                            foreach ($explode_cpu as $breadcrumb_cpu)
                            {
                                $breadcrumb_Info = $this->_db
                                    ->where ("cpu", $breadcrumb_cpu)
                                    ->getOne("cpu", "page_id");

                                $bredcrumb_step_cpu = $this->getURL($breadcrumb_Info['page_id']);

                                $breadcrumb_title = $this->_db
                                    ->where ("type", 0)
                                    ->where('id', $breadcrumb_Info['page_id'])
                                    ->getOne('pages'," title_".$cutpageinfo['lang']." as title ");

                                if(trim($breadcrumb_title['title'])!="")
                                {
                                    if($get_last_cpu_info['page_id'] == 87 || $get_last_cpu_info['page_id'] == 88 || $get_last_cpu_info['page_id'] == 89)
                                    {
                                       // este facuta o exceptie pentru filitru, din cauza structurii nestandarte a bazei de date
                                        //show($get_last_cpu_info['page_id']);
                                        if ($cpu_counter == $lengOfExmplodeArray - 1)
                                        {

                                        $filter_parent_info = $this->_db
                                            ->where ("id", $children_of)
                                            ->getOne("filter_options", 'title_'.$this->_cpu_lang.' as title');
                                            ?>
                                            <li class="active"><?php echo mb_strtolower($filter_parent_info['title']);?></li>
                                            <?php
                                        }
                                        else
                                        {
                                           if($breadcrumb_Info['page_id'] == 83 ) // daca in sectiunea principala, atunci nu folosim section_id
                                           {
                                               $filter_bredcrumb_step_cpu = $this->getURL($breadcrumb_Info['page_id']);
                                           }
                                           else
                                           {
                                               $filter_bredcrumb_step_cpu = $this->getURL($breadcrumb_Info['page_id']).'?section_id='.$children_of;
                                           }
                                            ?>
                                            <li>
                                                <a href="<?php echo $filter_bredcrumb_step_cpu;?>"><?php echo mb_strtolower($breadcrumb_title['title'])?></a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        if ($cpu_counter == $lengOfExmplodeArray - 1)
                                        {
                                            $get_table_of_last_cpu = $this->_db
                                                ->where ("id", $get_last_cpu_info['page_id'])
                                                ->getOne("pages", "db_table,cpu_parrent");

                                            if(isset($get_table_of_last_cpu['db_table']) && !empty($get_table_of_last_cpu['db_table']) )
                                            {

                                                $get_info_of_table_of_last_cpu = $this->_db
                                                    ->where('id', $children_of)
                                                    ->getOne($get_table_of_last_cpu['db_table']);

                                                ?>
                                                <li>
                                                    <a href="<?php echo $bredcrumb_step_cpu;?>"><?php echo mb_strtolower($breadcrumb_title['title'])?></a>
                                                </li>
                                                <?php

                                                $cpu_sdb = $this->getURL($get_last_cpu_info['page_id']).'?section_id='.$get_info_of_table_of_last_cpu['id'];
                                                $cpu_sdb_title = $get_info_of_table_of_last_cpu['title_'.$this->_cpu_lang];
                                                //show($cpu_sdb);

                                                if( isset($get_info_of_table_of_last_cpu['section_id']) && $get_info_of_table_of_last_cpu['section_id'] != 0)
                                                {
                                                    $this->breadcrumb_section_cicle($get_last_cpu_info['page_id'],$get_info_of_table_of_last_cpu['section_id'],$get_table_of_last_cpu['db_table']);
                                                }

                                                ?>
                                                <li class="active"><?php echo mb_strtolower($cpu_sdb_title);?></li>
                                                <?php


                                            }
                                            else
                                            {
                                                if(isset($get_table_of_last_cpu['cpu_parrent']) && is_numeric($get_table_of_last_cpu['cpu_parrent']) )
                                                {
                                                    $get_info_of_parent_cpu = $this->_db
                                                        ->where ("id", $get_table_of_last_cpu['cpu_parrent'])
                                                        ->getOne("pages", "db_table");

                                                    if(isset($get_info_of_parent_cpu['db_table']) && !empty($get_info_of_parent_cpu['db_table']) )
                                                    {
                                                        $get_info_of_table_of_last_cpu = $this->_db
                                                            ->where('id', $children_of)
                                                            ->getOne($get_info_of_parent_cpu['db_table']);

                                                        $cpu_sdb = $this->getURL($get_table_of_last_cpu['cpu_parrent']).'?section_id='.$get_info_of_table_of_last_cpu['id'];
                                                        $cpu_sdb_title = $get_info_of_table_of_last_cpu['title_'.$this->_cpu_lang];

                                                        if( isset($get_info_of_table_of_last_cpu['section_id']) && $get_info_of_table_of_last_cpu['section_id'] != 0)
                                                        {
                                                            $this->breadcrumb_section_cicle($get_table_of_last_cpu['cpu_parrent'],$get_info_of_table_of_last_cpu['section_id'],$get_info_of_parent_cpu['db_table']);
                                                        }

                                                        ?>
                                                        <li>
                                                            <a href="<?php echo $cpu_sdb;?>"><?php echo mb_strtolower($cpu_sdb_title)?></a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <li class="active"><?php echo mb_strtolower($breadcrumb_title['title']);?></li>
                                                <?php

                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <li>
                                                <a href="<?php echo $bredcrumb_step_cpu;?>"><?php echo mb_strtolower($breadcrumb_title['title'])?></a>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                $cpu_counter++;
                            }
                        }
                    }
                    ?>
                </ol>
            </div>
        </div>
        <?php
    }


    public function exception_tur_compartment_top_block_info($cutpageinfo, $tur_id)
    {
        // $children_of - se va folosi pentru afisarea corecta a 'breadcrumb' a subcategoriilor
        // Cind intram in add_element sau edit_element, apelam la tabelul parinte pentru afisarea corecta a 'breadcrumb'

        if(isset(parse_url($_SERVER['REQUEST_URI'])['query']))
        {
            $exploded_url_query = parse_url($_SERVER['REQUEST_URI'])['query'];
            parse_str($exploded_url_query, $url_query);
        }
        $children_of = 0; // no children
        if(isset($url_query['section_id']) && is_numeric($url_query['section_id']) && $url_query['section_id'] > 0 )
        {
            $children_of = (int)$url_query['section_id']; // children with section_id = $url_query['id']
        }


        $explode_cpu = array_filter( explode("/", $cutpageinfo['cpu']), 'strlen' );
        // проверим если текущий язык не совпадает с главным языком по умолчанию
        $site_lang_by_default = $this->_db
            ->where('code', 'LANG_MAIN')
            ->getOne('settings', "value");

        if($site_lang_by_default && $site_lang_by_default['value'] == $cutpageinfo['lang'])
        {
            // если языки совпадают, то добавлением чпу для главного языка
            // это делается потому что cpu для языка по умолчанию является пустота, и когда мы делаем explode array_filter это значение теряется
            array_unshift($explode_cpu,"");
        }

        $lengOfExmplodeArray = count($explode_cpu);
        $explode_cpu = array_values($explode_cpu); // reset key of array
        ?>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <?php
                if($lengOfExmplodeArray > 1)
                {
                    if($children_of == 0)
                    {
                        $breadcrumb_for_return_back = $this->_db
                            ->where ("cpu", $explode_cpu[$lengOfExmplodeArray-2])
                            ->getOne("cpu", "page_id");
                        $bredcrumb_one_step_back_cpu = $this->getURL($breadcrumb_for_return_back['page_id']).'?tur_id='.$tur_id;
                        ?>

                        <a href="<?php echo $bredcrumb_one_step_back_cpu;?>">
                            <span class="label label-info label-danger"><?php echo $GLOBALS['ar_define_langterms']['RETURN_BACK']?></span>
                        </a>
                        <?php
                    }
                    ?>


                    <?php
                    /*
                    <span onclick="history.go(-1);" style='cursor:pointer;' class="label label-info label-danger"><?php echo $GLOBALS['ar_define_langterms']['RETURN_BACK']?></span>
                    */
                    ?>

                    <div style="clear: both; height: 25px;"></div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

    public function breadcrumb_section_cicle($page_id,$section_id,$db_table, $crumb_array = array() )
    {
        $get_special_info_of_table_of_last_cpu = $this->_db
            ->where('id', $section_id)
            ->getOne($db_table);

        $cpu_sdb = $this->getURL($page_id).'?section_id='.$get_special_info_of_table_of_last_cpu['id'];
        $cpu_sdb_title = $get_special_info_of_table_of_last_cpu['title_'.$this->_cpu_lang];
        $crumb_array[$get_special_info_of_table_of_last_cpu['id']]['cpu'] = $cpu_sdb;
        $crumb_array[$get_special_info_of_table_of_last_cpu['id']]['title'] = $cpu_sdb_title;

        if($get_special_info_of_table_of_last_cpu['section_id'] != 0)
        {
            $this->breadcrumb_section_cicle( $page_id, $get_special_info_of_table_of_last_cpu['section_id'], $db_table, $crumb_array);
        }
        else
        {
            $reversed_crumb_array = array_reverse($crumb_array);
            foreach ( $reversed_crumb_array as $crumb_info )
            {
                ?>
                <li>
                    <a href="<?php echo $crumb_info['cpu'];?>"><?php echo mb_strtolower($crumb_info['title'])?></a>
                </li>
                <?php
            }
        }
    }


    public function getURLbyLang($page_id, $elem_id = 0, $lang)
    {
        $CpuUrl = $this->_db
            ->where ('page_id', $page_id)
            ->where ('elem_id', $elem_id)
            ->where('lang', $lang)
            ->getOne('cpu', 'cpu');

        if(!empty($CpuUrl))
        {
            // проверим если есть чпу родитель для данного элемента (для склеивание частей чпу-урл если это необходимо)
            $have_parent = true;
            $cp_pages_id = $page_id;
            if(trim($CpuUrl['cpu'])=='')
            {
                $creadted_cpu_thread = '/';
            }
            else
            {
                $creadted_cpu_thread = '/'.$CpuUrl['cpu'].'/';
            }

            while($have_parent!=false)
            {
                $cpu_parent_info = $this->_db
                    ->where ("id", $cp_pages_id)
                    ->getOne("pages", "id, cpu_parrent, assoc_table");

                if($cpu_parent_info['assoc_table'] == 'catalog')
                {
                    $CpuParentUrl = $this->_db
                        ->where ('page_id', $cp_pages_id)
                        ->where ('elem_id', $elem_id)
                        ->where('lang', $lang)
                        ->getOne('cpu');

                    if($CpuParentUrl)
                    {
                        $get_parent_of_curent_catalog =  $this->_db
                            ->where('id',$CpuParentUrl['elem_id'])
                            ->getOne('catalog', 'id, section_id');

                        if($get_parent_of_curent_catalog)
                        {
                            $catalog_path = array();
                            $catalog_path[] = $get_parent_of_curent_catalog['id'];

                            if($get_parent_of_curent_catalog['section_id'] != 0)
                            {
                                $section_id_of_current_parent = $get_parent_of_curent_catalog['section_id'];
                                $curent_parent_id = $get_parent_of_curent_catalog['id'];

                                while($section_id_of_current_parent!=0)
                                {
                                    $get_all_parents_of_curent_catalog =  $this->_db
                                        ->where('id', $section_id_of_current_parent)
                                        ->getOne('catalog', 'id, section_id');

                                    $section_id_of_current_parent = $get_all_parents_of_curent_catalog['section_id'];
                                    $curent_parent_id = $get_all_parents_of_curent_catalog['id'];
                                    $catalog_path[] = $curent_parent_id;
                                }
                            }

                            $reversed_catalog_path = array_reverse($catalog_path);

                            if($lang == $GLOBALS['ar_define_settings']['LANG_MAIN'])
                            {
                                $creadted_cpu_thread = '';
                            }
                            else
                            {
                                $creadted_cpu_thread = '/'.$lang;
                            }


                            foreach ( $reversed_catalog_path as $catalog_path_info )
                            {
                                $CpuParentUrl = $this->_db
                                    ->where ('page_id', 94)
                                    ->where ('elem_id', $catalog_path_info)
                                    ->where('lang', $lang)
                                    ->getOne('cpu', 'cpu');

                                //show($catalog_path_info['id']);
                                if($CpuParentUrl)
                                {
                                    $creadted_cpu_thread .= '/'.$CpuParentUrl['cpu'];
                                }
                            }

                            return $creadted_cpu_thread.'/';
                        }
                        else
                        {
                            return false;
                        }
                    }
                    else
                    {
                        return false;
                    }
                }

                else
                    if($cpu_parent_info['assoc_table'] == 'catalog_elements')
                    {
                        if( !empty($cpu_parent_info) && $cpu_parent_info['cpu_parrent']>0)
                        {
                            //alfam in ce catalog se afla produsul
                            $get_section_id_of_element = $this->_db
                                ->where('id',$elem_id)
                                ->getOne('catalog_elements', 'section_id');
                            if($get_section_id_of_element)
                            {
                                $cpu_catalog_of_curent_element = $this->getURLbyLang(94,$get_section_id_of_element['section_id'], $lang); // 94 - id of catalog page
                                return $cpu_catalog_of_curent_element.$CpuUrl['cpu'].'/';
                            }
                        }
                    }

                    else
                        if($cpu_parent_info['assoc_table'] == 'blog_elements')
                        {
                            if( !empty($cpu_parent_info) && $cpu_parent_info['cpu_parrent']>0)
                            {
                                //alfam in ce catalog se afla elementul
                                $get_section_id_of_element = $this->_db
                                    ->where('id',$elem_id)
                                    ->getOne('blog_elements', 'section_id');
                                if($get_section_id_of_element)
                                {
                                    $cpu_catalog_of_curent_element = $this->getURLbyLang(525,$get_section_id_of_element['section_id'], $lang); // 525 - id of catalog page
                                    return $cpu_catalog_of_curent_element.$CpuUrl['cpu'].'/';
                                }
                            }

                        }

                        else
                            if($cpu_parent_info['assoc_table'] == 'special_offers_elements')
                            {
                                if( !empty($cpu_parent_info) && $cpu_parent_info['cpu_parrent']>0)
                                {
                                    //alfam in ce catalog se afla elementul
                                    $get_section_id_of_element = $this->_db
                                        ->where('id',$elem_id)
                                        ->getOne('special_offers_elements', 'section_id');
                                    if($get_section_id_of_element)
                                    {
                                        $cpu_catalog_of_curent_element = $this->getURLbyLang(728,$get_section_id_of_element['section_id'], $lang); // 728 - id of offer catalog page
                                        return $cpu_catalog_of_curent_element.$CpuUrl['cpu'].'/';
                                    }
                                }

                            }

                    else
                    {
                        if( !empty($cpu_parent_info) && $cpu_parent_info['cpu_parrent']>0)
                        {
                            $CpuParentUrl = $this->_db
                                ->where ('page_id', $cpu_parent_info['cpu_parrent'])
                                ->where('lang', $lang)
                                ->getOne('cpu', 'cpu');
                            if(!empty($CpuParentUrl))
                            {
                                if(trim($CpuParentUrl['cpu'])=='')
                                {
                                    $creadted_cpu_thread = $CpuParentUrl['cpu'].$creadted_cpu_thread;
                                }
                                else
                                {
                                    $creadted_cpu_thread = '/'.$CpuParentUrl['cpu'].$creadted_cpu_thread;
                                }
                                $cp_pages_id = $cpu_parent_info['cpu_parrent'];
                            }
                        }
                        else
                        {
                            $have_parent = false;
                        }
                    }

            }
            return $creadted_cpu_thread;
        }
        else
        {
            return false;
        }
    }

    // проверям на уникальность ЧПУ при добавлении
    public function unicURL($url)
    {
        // уточним ид поле для текущего ЧПУ, чтобы исключить его из поиска совпадение
        $current_cpu_info = $this->_db
            ->where ("cpu", $url)
            ->getOne("cpu", "*");
        if($current_cpu_info)
        {
            $url = $url.'-'.$GLOBALS['ar_define_settings']['CPU_KEYWORD'];
            if($url===$this->unicURL($url))
            {
                return $url;
            }
            else
            {
                return $this->unicURL($url);
            }
        }
        else
        {
            return $url;
        }
    }


    public function uniqFrontPageElementURL($url, $lang, $pageId, $elem_id)
    {
        $params = Array($url, $pageId, $lang, $elem_id );
        $current_cpu_info =  $this->_db->rawQueryOne('
                                                      SELECT 
                                                              id 
                                                      FROM 
                                                            d_cpu 
                                                            
                                                      WHERE 
                                                              `cpu` = ?
                                                              AND (
                                                                        `page_id` <> ? 
                                                                    OR  lang <> ? 
                                                                    OR elem_id <> ?
                                                                    )
                                                ',$params);

        if($current_cpu_info)
        {
            $url = $url.'-'.$GLOBALS['ar_define_settings']['CPU_KEYWORD'];
            if($url===$this->uniqFrontPageElementURL($url, $lang, $pageId, $elem_id))
            {
                return $url;
            }
            else
            {
                return $this->uniqFrontPageElementURL($url, $lang, $pageId, $elem_id);
            }
        }
        else
        {
            return $url;
        }

    }


    public function insertCpu($arr,$pageId,$elem_id = 0)
    {
        $status_info = true;
        if(!$pageId || !is_numeric($pageId) || $pageId==0)
        {
            echo "Не указана страница для редактирования";
            $status_info = false;
        }

        foreach ($this->langList as $key => $lang)
        {
            $arr[$lang] = $this->unicURL($arr[$lang]);

            $data = Array(
                "cpu" => $arr[$lang],
                "page_id" => $pageId,
                "lang" => $lang,
                "elem_id" => $elem_id
            );

            $id = $this->_db->insert('cpu', $data);
            if (!$id)
            {
                $status_info = false;
            }
        }
        return $status_info;
    }

    public function updateElementCpu($arr,$pageId,$elem_id)
    {
        $status_info = true;
        if(!$pageId || !is_numeric($pageId) || $pageId==0)
        {
            echo "Не указана страница для редактирования";
            $status_info = false;
        }

        foreach ($this->langList as $key => $lang)
        {
            // проверим уникальность
            $arr[$lang] = $this->uniqFrontPageElementURL($arr[$lang], $lang, $pageId, $elem_id);

            $data_update_cpu = Array (
                'cpu' => $arr[$lang]
            );

            //show($arr[$lang]);

            $this->_db->where ('page_id', $pageId);
            $this->_db->where ('lang', $lang);
            $this->_db->where ('elem_id', $elem_id);
            $this->_db->update ('cpu', $data_update_cpu, 1);


            $getElem = $this->_db
                ->where ("page_id", $pageId)
                ->where ("lang", $lang)
                ->where ("elem_id", $elem_id)
                ->getOne ("cpu", "id");

            //show($getElem);
            if(empty($getElem))
            {
                $arr[$lang] = $this->unicURL($arr[$lang]);
                $data_insert = Array (
                    "page_id" => $pageId,
                    "cpu" => $arr[$lang],
                    "lang" => $lang,
                    "elem_id" => $elem_id
                );
                //show($data_insert);
                $last_inserted_id =  $this->_db->insert ('cpu', $data_insert);
                if(!$last_inserted_id)
                {
                    $status_info = false;
                }
            }

        }
        return $status_info;
    }


    public function breadcrump_onfront($cutpageinfo)
    {
        $explode_cpu = array_filter( explode("/", $cutpageinfo['cpu']), 'strlen' );
        // проверим если текущий язык не совпадает с главным языком по умолчанию
        $site_lang_by_default = $this->_db
            ->where('code', 'LANG_MAIN')
            ->getOne('settings', "value");

        if($site_lang_by_default && $site_lang_by_default['value'] == $cutpageinfo['lang'])
        {
            // если языки совпадают, то добавлением чпу для главного языка
            // это делается потому что cpu для языка по умолчанию является пустота, и когда мы делаем explode array_filter это значение теряется
            array_unshift($explode_cpu,"");
        }

        $lengOfExmplodeArray = count($explode_cpu);
        $explode_cpu = array_values($explode_cpu); // reset key of array
        //show($explode_cpu);
        ?>
        <div class="breadcrumbs">
            <?php

            $cpu_counter = 0;
            if($lengOfExmplodeArray > 1)
            {
                foreach ($explode_cpu as $breadcrumb_cpu)
                {
                    $breadcrumb_Info = $this->_db
                        ->where ("cpu", $breadcrumb_cpu)
                        ->getOne("cpu");

                    if($breadcrumb_Info['page_id'] == 94 ) // 94 - pentru catalog (facem exceptie)
                    {
                        //show($breadcrumb_Info);
                        $bredcrumb_step_cpu = $this->getURL(94,$breadcrumb_Info['elem_id']);
                        //show($bredcrumb_step_cpu);
                        $breadcrumb_title = $this->_db
                            ->where('id', $breadcrumb_Info['elem_id'])
                            ->getOne('catalog'," title_".$cutpageinfo['lang']." as title ");
                        // show($breadcrumb_title);

                        if ($cpu_counter == $lengOfExmplodeArray - 1)
                        {
                            ?>
                            <li class="active"><a href="<?php echo $bredcrumb_step_cpu;?>"><?php echo $breadcrumb_title['title'];?></a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>

                            <?php
                        }
                        else
                        {

                            ?>
                            <li class="active"><a href="<?php echo $bredcrumb_step_cpu;?>"><?php echo $breadcrumb_title['title'];?></a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>

                            <?php
                        }

                    }
                    else
                    {
                        $bredcrumb_step_cpu = $this->getURL($breadcrumb_Info['page_id']);
                        $breadcrumb_title = $this->_db
                            ->where('id', $breadcrumb_Info['page_id'])
                            ->getOne('pages'," title_".$cutpageinfo['lang']." as title, assoc_table");

                        if(empty($breadcrumb_title['assoc_table'])) {

                            if ($cpu_counter == $lengOfExmplodeArray - 1)
                            {
                                ?>
                                <li class="active">
                                        <?php echo $breadcrumb_title['title'];?>
                                </li>
                                <li>
                                    <i class="fa" aria-hidden="true"></i>
                                </li>
                                <?php
                            }
                            else
                            {

                                ?>
                                <li class="active"><a href="<?php echo $bredcrumb_step_cpu;?>"><?php echo $breadcrumb_title['title'];?></a></li>
                                <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>

                                <?php

                            }

                        }else {

                            $breadcrumb_title_last_part = $this->_db
                                ->where('id', $breadcrumb_Info['elem_id'])
                                ->getOne($breadcrumb_title['assoc_table']," title_".$cutpageinfo['lang']." as title");

                            ?>
                            <span class="active"><?php echo mb_strtolower($breadcrumb_title_last_part['title']);?></span>

                            <?php
                        }

                    }

                    $cpu_counter++;
                }
            }

            ?>
        </div>

        <?php
    }


}
