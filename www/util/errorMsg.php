<?php

class ErrorMsg{
    // DATABASE
    public const DATABASE_CONNECT_ERROR = "There are something wrong with our side. Please try again latter";
    public const DATABASE_USERNAME_EXIST_ERROR ="Username already been taken";
    public const DATABASE_USERNAME_PASSWORD_ERROR = "username/password not match our record";

    // SESSION
    public const SESSION_EXPIRED_ERROR = "Login Expired, please login again";

    // COURSE
    public const COURSE_COURSE_NOT_FOUND_ERROR = "Course not found";
    public const COURSE_EMPTY_COURSE_WARNING = "You do not have any course to display";
    public const COURSE_AUTHENTICATE_ERROR = "You don't have permission access this course";

    //FILE
    public const FILE_AUTHENTICATE_ERROR = "You don't have permission access this file";
    public const FILE_EMPTY_FILE_WARNING = "There are no file can be download for the course";
    public const FILE_FILE_EXIST_WARNING = "This file existed, please try and upload different file";
    public const FILE_FILE_UPLOAD_ERROR = "There are something wrong, please try again later";
    public const FILE_FILE_UPLOAD_SUCCESS = "File uploaded";
}