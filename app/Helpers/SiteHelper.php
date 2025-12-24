<?php

namespace App\Helpers;

use App\Models\Menu;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Session;

class SiteHelper
{
    public static function checkIfvalueEmpty($str)
    {
        if (empty($str) || $str == 'undefined' || $str == 'null' || $str == null || $str == false) {
            return true;
        }

        return false;
    }

    public static function replaceEmptyValue($str)
    {
        if (empty($str) || $str == 'undefined' || $str == 'null' || $str == null || $str == false) {
            echo '-';
        } else {
            echo $str;
        }
    }

    public static function allowChange()
    {
        $role = Session::get('role');
        $role_code = $role->code;
        if ($role_code == 'admin' || $role_code == 'office' || $role_code == 'local_coordinator') {
            return true;
        }

        return false;
    }

    public static function checkMenuPermission($menu_id = '', $mode = "view")
    {
        $role = Session::get('role');
        $RolePermission = RolePermission::where([
            'role_id' => $role->id,
            'menu_id' => $menu_id,
            'can_' . $mode => true
        ])->first();

        if (!empty($RolePermission)) {
            return true;
        }

        return false;
    }

    public static function getMenuId($code = "students")
    {
        $Menu = Menu::where([
            'code' => $code,
        ])->first();

        if (!empty($Menu)) {
            return $Menu->id;
        }

        return false;
    }

    public static function getLoginUserId()
    {
        if (Session::has('user')) {
            return Session::get('user')->id;
        }
        return false;
    }

    public static function isSelected($firstValue, $secondValue)
    {
        return $firstValue == $secondValue ? 'selected' : '';
    }
}
