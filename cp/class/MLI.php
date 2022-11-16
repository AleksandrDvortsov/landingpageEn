<?php

class MLI
{
    private $_db;
    public $lang;
    public $lang_std;
    public $site_lang; /*массив с языками*/
    public $root;

    public function __construct($db)
    {
        $this->_db = $db;

        // Определяем основной язык сайта
        $db_main_lang = $this->_db
            ->where ('code', 'LANG_MAIN')
            ->getOne ("settings");

        $this->lang_std = $db_main_lang['value'];
        $default_lang = $db_main_lang['value'];

        // Определяем все возможные языки на сайте
        $this->_db->where ('code', 'LANG_SITE');
        $db_site_langs = $this->_db->getOne ("settings");
        $this->site_lang = explode( ",", $db_site_langs['value']  );

        // Определяем язык
        $ar_url = explode("/",$_SERVER["SCRIPT_NAME"]);

        if ( isset($ar_url[1]) && trim($ar_url[1])!="" && in_array($ar_url[1], $this->site_lang))
        {
            $this->lang = $ar_url[1];
            $this->root = "/".$this->lang;
        }
        else
        {
            $this->lang = $default_lang;
            $this->root = "";
        }

    }

    // catalog level
    public function catalog_level($catalog_id, $level = 1)
    {
        $catalog_info = $this->_db
            ->where("id", $catalog_id)
            ->orderBy("sort", "ASC")
            ->getOne("catalog", "id, section_id");
        if($catalog_info)
        {
            if($catalog_info['section_id'] == 0)
            {
                return $level;
            }
            else
            {
                $level++;
                return $this->catalog_level($catalog_info['section_id'], $level);
            }
        }
        else
        {
            return 0;
        }
    }


    public function display_option_catalog_children( $catalog_id, $tree, $CATALOG_TREE = 0, $all_disabled = 0)
    {

        // variabila $level este folosita doar pentru disign
        $CATALOG_LEVEL = $this->catalog_level($catalog_id);
       // show($CATALOG_LEVEL);


        foreach ($tree as $key => $value)
        {
            $disabled_option_status = "";
            if($all_disabled == 1)
            {
                $disabled_option_status = "disabled";
            }

            $info_of_curent_children = $this->_db
                ->where("id", $key)
                ->orderBy("sort", "ASC")
                ->getOne("catalog",'id, title_'.$this->lang.' as title');
            $cat_level = $this->catalog_level($info_of_curent_children['id']);

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
                    <option <?php echo $disabled_option_status;?>
                        value="<?php echo $info_of_curent_children['id']; ?>"><?php echo str_repeat('&nbsp', ($cat_level * 5)) . '&#9658;' . $info_of_curent_children['title']; ?></option>
                <?php
                }
            }

            foreach( $value as $val_children)
            {
                $disabled_option_status = "";
                if( !(isset($tree[$val_children]) && count($tree[$val_children])>0 && is_array($tree[$val_children])) )
                {
                    $info_of_curent_children = $this->_db
                        ->where("id", $val_children)
                        ->orderBy("sort", "ASC")
                        ->getOne("catalog",'id, title_'.$this->lang.' as title');
                    $cat_level = $this->catalog_level($info_of_curent_children['id']);

                    if($all_disabled == 1)
                    {
                        $disabled_option_status = "disabled";
                    }

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
                            <option <?php echo $disabled_option_status;?>
                                value="<?php echo $info_of_curent_children['id']; ?>"><?php echo str_repeat('&nbsp', ($cat_level * 5)) . '&#9658;' . $info_of_curent_children['title']; ?></option>
                        <?php
                        }
                    }

                }

            }
        }

    }

///////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getOneLevel($catalog_id)
    {
        $cat_id=array();
        $select_children = $this->_db
            ->where("section_id", $catalog_id)
            ->orderBy("sort", "ASC")
            ->get('catalog', null, 'id' );

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

    public function getChildren($parent_id, &$tree_string=array()) {
       // show($parent_id);
        $tree = array();
        // getOneLevel() returns a one-dimensional array of child ids
        $tree = $this->getOneLevel($parent_id);
        if(count($tree)>0 && is_array($tree)){
           // show($parent_id);
           // show($tree);
            $tree_string[$parent_id] = $tree;
            //$tree_string=array_merge($tree_string,$tree);
        }
        foreach ($tree as $key => $val) {
            $this->getChildren($val, $tree_string);
        }
        return $tree_string;
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////

// get parents of element
    public function get_catalog_parents($catalog_id, &$tree_string=array())
    {
        $get_parent = $this->_db
            ->where("id", $catalog_id)
            ->getOne('catalog', 'id, section_id');
        if($get_parent && count($get_parent)>0)
        {
            if($get_parent['section_id'] != 0)
            {
                $tree_string[$catalog_id] = $get_parent['section_id'];
                $this->get_catalog_parents($get_parent['section_id'], $tree_string);
            }
            else
            {
                $tree_string['main_parent'] = $catalog_id;
            }

        }
        return $tree_string;

    }

///////////////////////////////////////////////////////////////////////////////////////////////////////
    // @method getPageTitle - Получаем название из ws_pages
    public function getPageTitle($id)
    {
        $cols = Array ('title_'.$this->lang);
        $this->_db->where ('id', $id);
        $PageTitle = $this->_db->getOne ("pages", $cols );
        if($PageTitle)
        {
            return $PageTitle['title_'.$this->lang];
        }
        else
        {
            return "Wrong Id!";
        }
    }


    // @method AddressURI - Получаем аналог адреса для второго языка сайта
    public function AddressURI()
    {
        $arr = array();
        //$ar_url = explode("/",$_SERVER["REQUEST_URI"]);
        foreach ($this->site_lang as $key => $value) {
            if( $value != $this->lang_std){
                $page = str_replace("/".$this->lang."/", "/", $_SERVER["REQUEST_URI"]);
                $arr[$value] = '/'.$value.$page;
            }else{
                $page = str_replace("/".$this->lang."/", "/", $_SERVER["REQUEST_URI"]);
                $arr[$value] = $page;
            }
        }
        return $arr;
    }

    // @method GetAddress - берем адрес текущей страницы с добавлением index.php при необходимости
    public function GetAddress()
    {
        $script_url = $_SERVER["SCRIPT_NAME"];
        foreach ($this->site_lang as $key => $value) {
            if( $this->lang == $value && $value != $this->lang_std ){
                $script_url = str_replace("/".$value."/", "/", $_SERVER["SCRIPT_NAME"]);
            }
        }
        $script_url_parts = explode("/", $script_url);
        if( array_pop($script_url_parts) == '' )
            $script_url = $script_url.'index.php';
        return $script_url;
    }



    // @method GetPageData - Получение всех данных для страницы (title, description, keywords, text)
    // @param $page - адрес страницы
    // @return  В случае успеха вернется массив данных.
    public function GetPageData()
    {
        $current_page = $this->GetAddress();
        $this->_db->where ('page', $current_page);
        $page = $this->_db->getOne ("pages");
        if($page)
        {
            if($this->_db->count > 0)
            {
                $ar_page = array(
                    "title_".$this->lang => $page["title_".$this->lang],
                    "meta_k_".$this->lang => $page["meta_k_".$this->lang],
                    "meta_d_".$this->lang => $page["meta_d_".$this->lang],
                    "text_".$this->lang => $page["text_".$this->lang]
                );
                return $ar_page;
            }
            else return "Запрос вернул пустой результат";


            /*
            if( $page['assoc_table'] && $page['var_get'] )
            {
                if( isset($_GET[$page['var_get']]) && $_GET[$page['var_get']] )
                {
                    if ( is_numeric($_GET[$page['var_get']]) )
                    {
                        $id = $_GET[$page['var_get']];

                        $cols = Array ("*");
                        $this->_db->where ('id', $id);
                        $assoc_page = $this->_db->get ($page[assoc_table], null, $cols);
                        if ( $assoc_page && $this->_db->count > 0 )
                        {
                            $ar_key = array_keys( $ar_page );
                            foreach ( $ar_key as $key )
                            {
                                if ( isset($assoc_page[$key]) && $assoc_page[$key] != '' )
                                {
                                    $ar_page[$key] = $assoc_page[$key];
                                }
                            }
                            return $ar_page;
                        }
                        else
                            return "Запрос на выборку данных из базы не прошел. Напишите об этом администратору";
                    }
                    else
                        return $ar_page;
                }
                else
                    return $ar_page;
            }
            else
                return $ar_page;
            */


        }
        else
        {
            return "Запрос на выборку данных из базы не прошел. Напишите об этом администратору";
        }
    }


    // @method   GetPageIncData - Вывод данных включаемой области
    // @param    $id - id или код элемента
    // @return   В случае успеха вернется содержимое включаемой области.
   public function GetPageIncData( $inc_id )
   {
       $this->_db->where ('id', $inc_id);
       $this->_db->orWhere ('code', $inc_id);
       $page = $this->_db->getOne ("pages_inc");
       if($page)
       {
           return $page['text_'.$this->lang];
       }
       else return "Информация по запросу не может быть извлечена: в таблице нет записей";
   }



    // @method   GetDefineSettings - Получим массив описывающий настройки сайта.
    public function GetDefineSettings()
    {
       $ar_define_settings = array();
       $cols = Array ("*");
       $res_settings =  $this->_db->get ("settings", null, $cols);
       if ($this->_db->count > 0)
       {
           foreach ($res_settings as $settings)
           {
               $ar_define_settings[$settings['code']] = $settings['value'];
           }
           return $ar_define_settings;
       }
    }

    // GetDefineLangTerms - Получим массив описывающий языковые термины сайта.
    public function GetDefineLangTerms()
    {
        $ar_define_terms = array();
        $cols = Array ("*");
        $res_terms =  $this->_db->get ("dictionary", null, $cols);
        if ($this->_db->count > 0)
        {
            foreach ($res_terms as $terms)
            {
                $ar_define_terms[$terms['code']] = $terms['title_'.$this->lang];
            }
            return $ar_define_terms;
        }
    }

}

