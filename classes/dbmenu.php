<?php
namespace DbMenu;

/**
 * FuelPHP DbMenu Package
 *
 * @author     Phil Foulston
 * @version    1.0
 * @package    Fuel
 * @subpackage DbMenu
 */

class DbMenu {

    /**
	* @var table name
	*/
	public static $table = null;

    public static function _init()
	{
	   	\Config::load('dbmenu', true);
		static::$table  = \Config::get('dbmenu.db.table', 'dbmenu');
	}

    public static function build($menu_name = 'main')
    {
        $menu_data = static::populate_menu($menu_name);
        $html = static::build_menu($menu_data);
        return substr($html, 0, strlen($html)-5); // strip the last </ul> from the string
    }

    private static function populate_menu($menu_name)
    {
        $menu_data = array('parents' => array(), 'items' => array());

        $result = \DB::select('*')
				->from(static::$table)
                ->where('menu_name', $menu_name)
				->order_by('parent')
				->order_by('position')
                ->order_by('title')
                ->execute()
                ->as_array();

        foreach ($result as $menu_item)
        {
            $menu_data['items'][$menu_item['id']] = $menu_item;
            $menu_data['parents'][$menu_item['parent']][] = $menu_item['id'];
        }

        return $menu_data;
    }

    private static function build_menu($menu_data, $parent = 0, $sub = false)
    {
       $html = "";
       if (isset($menu_data['parents'][$parent]))
       {
          //$html .= "<ul>\n";
           foreach ($menu_data['parents'][$parent] as $itemId)
           {
              if(!isset($menu_data['parents'][$itemId]))
              {
                if(!$sub && $parent != 0)
                {
                    $html .= '<li>'.$menu_data['items'][$itemId]['title']."\n";
                }
                else
                {
                    $html .= "<li><a href='/".$menu_data['items'][$itemId]['link']."'>".$menu_data['items'][$itemId]['title']."</a></li>\n";
                }
              }
              else
              {
                 $html .= "<li><a href='/".$menu_data['items'][$itemId]['link']."'>".$menu_data['items'][$itemId]['title']."</a>\n";
                 if ($parent === 0)
                 {
                    $html .= "<ul>\n";
                 }
                 $html .= static::build_menu($menu_data, $itemId, true);
                 $html .= "</li>\n";
              }
           }
           $html .= "</ul>";
       }
       return $html;
    }

}