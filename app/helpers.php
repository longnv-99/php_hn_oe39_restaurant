<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getAuthUserId')) {
    function getAuthUserId()
    {
        return Auth::user()->id;
    }
}

if (!function_exists('checkValidUser')) {
    function checkValidUser($id)
    {
        if (getAuthUserId() == $id) {
            return true;
        }

        return false;
    }
}
