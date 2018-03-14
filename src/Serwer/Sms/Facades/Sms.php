<?php namespace Serwer\Sms\Facades;

use Illuminate\Support\Facades\Facade;

class Sms extends Facade {

    public $config  = null;
    
    public function __construct()
    {
        $app = \Config::get('app');
        if(isset($app['sms'])){
            $this->config = json_decode(json_encode($app['sms']), FALSE);
        }

    }
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'SerwerSMS'; }

}