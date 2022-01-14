<?php

if (!function_exists('stringSlug')) {
    function stringSlug($string, $separator = '-')
    {
        $string = strtolower($string); // Replaces all spaces with hyphens.
        $string = str_replace(' ', $separator, $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string = preg_replace('/-+/', $separator, $string); // Replaces multiple hyphens with single one.
        return $string;
    }
}

if (!function_exists('getRoleName')) {
    function getRoleName($data)
    {
        $info = null;
        switch($data){
            case 'name':
                $info = Auth::user()->roles->pluck('name');
                break;
            case 'display_name':
                $info = Auth::user()->roles->pluck('display_name');
                break;
        }
        $info =  substr($info, 2);
        $info =  substr($info, 0, -2);
        return $info;
    }
}

if (!function_exists('getRoleNameByID')) {
    function getRoleNameByID($id, $type)
    {
        $data = User::find($id);
        $info = null;
        switch($type){
            case 'name':
                $info = $data->roles->pluck('name');
                break;
            case 'display_name':
                $info = $data->roles->pluck('display_name');
                break;
        }
        $info =  substr($info, 2);
        $info =  substr($info, 0, -2);
        return $info;
    }
}

if (!function_exists('permissionTable')) {
    function permissionTable($tableName)
    {
        $data = Permission::where('table_name', $tableName)->get();

        return $data;
    }
}

if (!function_exists('authProfilePic')) {
    function authProfilePic($id)
    {
        $data = '/img/blank-profile.jpg';

        $profile = Profile::where('user_id', $id)->first();

        if(!empty($profile)){
            if($profile->image !== null){
                $data = $profile->image;
            }
        }


        return $data;
    }
}


if (!function_exists('computeAmortization')) {
    function computeAmortization($amount, $terms, $interest, $decimal = 2)
    {
        $interest = $amount * ($interest/100);
        $amount = $amount + $interest;
        $amor = $amount / $terms;
        $amor = preg_replace('/,/', '',number_format($amor, 2));
        $amor = floatval($amor);
        return $amor;
    }
}

if (!function_exists('computeTotalLoan')) {
    function computeTotalLoan($amount, $terms, $interest, $decimal = 2)
    {
        $interest = $amount * ($interest/100);
        $amount = $amount + $interest;
        $amount = preg_replace('/,/', '',number_format($amount, 2));
        $amount = floatval($amount);
        return $amount;
    }
}

if (!function_exists('currency_format')) {
    function currency_format($amount, $decimal = 2)
    {
        $amount = floatval($amount);
        return number_format($amount, $decimal);
    }
}

if (!function_exists('cleanNum')) {
    function cleanNum($number)
    {
        return floatval(preg_replace('/,/',',', $number));
    }
}

if (!function_exists('settings')) {
    function settings($setting)
    {
        $settingQuery =  \Illuminate\Support\Facades\DB::table('settings')->where('name', $setting)->first();
        if($settingQuery){
            return $settingQuery->value;
        }
    }
}


