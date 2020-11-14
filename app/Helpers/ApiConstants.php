<?php


namespace App\Helpers;


class ApiConstants
{
    const SERVER_ERR_CODE = 500;
    const BAD_REQ_ERR_CODE = 400;
    const AUTH_ERR_CODE = 401;
    const NOT_FOUND_CODE = 404;
    const VALIDATION_ERR_CODE = 406;
    const GOOD_REQ_CODE = 200;
    const DEFAULT_USER_TYPE = "USER"; // represents "Student"
    const ADMIN_USER_TYPE = "ADMIN";// represents "Admin"
    const CHEF_USER_TYPE = "CHEF";// represents "Chef"
    const AUTH_TOKEN_EXP = 60; // auth otp token expiry in minutes
    const OTP_DEFAULT_LENGTH = 7;
    const MAX_PROFILE_PIC_SIZE = 2048;

    const MALE = 'Male';
    const FEMALE = 'Female';
    const OTHERS = 'Others';

    const PAGINATION_VAL = 20;


    public static function ignoreApiKeysLog()
    {
        return ['token', '_token', 'password', 'auth_token', 'verified', 'registered'];
    }
}
