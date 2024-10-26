<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public $menu = '';

    public static function createMenu()
    {
        $jsonMenu = file_get_contents(resource_path('views/menu/menu.json'));
        $jsonMenuArr = json_decode($jsonMenu,true);
        // dd($jsonMenuArr);
        $li = '<ul class="nav sidebar-inner" id="sidebar-menu">';
        foreach($jsonMenuArr as $menuArr)
        {
            $mark = $menuArr['sub']!=null?'<b class="caret"></b>':"";
            $li .= '<li class="has-sub"><a class="sidenav-item-link" href="'.$menuArr["slug"].'"><span class="nav-text">'.$menuArr["name"].'</span>'.$mark.'</a>';
            if($menuArr['sub']!=null)
            {
            $li .= self::createSubMenu($menuArr['sub']);
            }
            $li .= '</li>';
        }
        $li .= '</ul>';
        return $li;
    }

    public static function createSubMenu($subMenu)
    {
        $li = '<div class="collapse"><ul class="sub-menu" data-parent="#sidebar-menu">';
        foreach($subMenu as $menuArr)
        {
            $mark = $menuArr['sub']!=null?'<b class="caret"></b>':"";
            $li .= '<li class=""><a class="sidenav-item-link" href="'.$menuArr["slug"].'"><span class="nav-text">'.$menuArr["name"].'</span>'.$mark .'</a>';
            if($menuArr['sub']!=null)
            {
               $li .= self::createSubMenu($menuArr['sub']);
            }
            $li .='</li>';
        }
        $li .= '</ul></div>';
        return $li;
    }

    public function dashboard()
    {
        return view('index');
    }
}
