<?php namespace App\Services;


class PlanManagerservice 
{
    
    protected $user;
    protected $plan;
    public $action;

    public function __construct()
    {
        $this->user = auth('api')->user();

        if(!$this->user || empty($this->user) || !isset($this->user)){

            return response()->json([
                'message' => 'Authentication Failed',
                'data'=> []
            ], 403);

        }
    }

    public function getCurrentUserPlan(){

        $this->plan = $this->user->currentPlan();

        return $this->plan ?? false;

    }

    public function can($action){
        //register actions users can perform.
        $acceptedChecks = [
            'createProperty'            
        ];


    }

    public function getAllPropertiesListedByUser(){

        return $this->user->properties()->count();

    }

    public function canUserCreateProperty(){

        //check if user can create property

        if(!$this->getCurrentUserPlan() || $this->getCurrentUserPlan() == null || empty($this->getCurrentUserPlan())){ 
            return false; 
        }

        if($this->getAllPropertiesListedByUser() >= $this->getCurrentUserPlan()->maximum_listings){
            return false;
        }            

        return true;
    }

}
