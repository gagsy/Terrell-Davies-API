<?php

namespace App\Traits;

trait Constants
{

    //Http Statuses

    /**
     * Success
     * @return int 200
     */
    public $successResponse = 200;

    /**
     * Created
     * @return int 201
     */
    public $createdResponse = 201;

    /**
     * Unauthorized
     * @return int 401
     */
    public $unauthorizedResponse = 401;

    /**
     * Bad Request
     * @return int 400
     */
    public $badRequestResponse = 400;

    /**
     * Not Found
     * @return int 404
     */
    public $notFoundErrorResponse = 404;

    /**
     * Validation error
     * @return int 422
     */
    public $validationErrorResponse = 422;

    /**
     * Server error
     * @return int 500
     */
    public $serverErrorResponse = 500;



    // App Statuses

    /**
     * Pending Status
     * @return  0
     */
    public $pendingStatus = 0;

    /**
     * Active Status
     * @return  1
     */
    public $activeStatus = 1;

    /**
     * Declined Status
     * @return int 2
     */
    public $declinedStatus = 2;

    /**
     * Inactive Status
     * @return int 3
     */
    public $inactiveStatus = 3;


    /**
     * Processing Status
     * @return int 4
     */
    public $processingStatus = 4;


    /**
     * Compeleted Status
     * @return int 5
     */
    public $completedStatus = 5;

    /**
     * Cancelled Status
     * @return int 6
     */
    public $cancelledStatus = 6;


    /**Returns image path for chef application selfies */
    public $chefApplicationSelfieImagePath = 'images/applications/chef/selfies';


    /**Returns file path region cover images */
    public $regionCoverImagesPath = 'images/regions/cover';



    /**Returns file path for chef application ids */
    public $chefApplicationIdFilePath = 'files/applications/chef/ids';


    /**Returns food categories cover image path */
    public $foodCategoryCoverImagesPath = 'images/food/categories/cover';


     /**Returns food cover image path */
     public $foodCoverImagesPath = 'images/food/cover';


     /**Returns user avatar image path */
     public $userAvatarImagePath = 'images/users/avatar';




    /**Get status of model */
    public function getModelStatus($status){
        switch($status){
            case $this->pendingStatus:
                return 'Pending';
            case $this->activeStatus:
                return 'Active';
            case $this->declinedStatus:
                return 'Declined';
            case $this->disabledStatus:
                return 'Disabled';
            case $this->processingStatus:
                return 'Processing';
            case $this->completedStatus:
                return 'Completed';
            case $this->cancelledStatus:
                return 'Cancelled';
            default:
                return null;
        }
    }

    public function getStatusList($index = null){
        return [
            $this->pendingStatus ,
            $this->activeStatus ,
            $this->declinedStatus ,
            $this->disabledStatus ,
            $this->processingStatus ,
            $this->completedStatus ,
            $this->cancelledStatus ,
        ];
    }

    public function getInvestmentStatus($status){
        switch($status){
            case $this->pendingStatus:
                return 'Pending';
            case $this->activeStatus:
                return 'Active';
            case $this->completedStatus:
                return 'Completed';
            case $this->cancelledStatus:
                return 'Cancelled';
        }
    }


}
