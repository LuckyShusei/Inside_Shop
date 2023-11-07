<?php
namespace App\Services;

class Mopi {

    protected $setting;

    public function __construct()
    {
        $setting_string = file_get_contents(resource_path('/setting/setting.json'));
        $this->setting = json_decode($setting_string);
    }

    public function site ()
    {
        return $this->setting->site;
    }

    public function collections ()
    {
        return $this->setting->collection;
    }

    public function pages () {
        if (isset($this->setting->site->pages)) {
            return $this->setting->site->pages;
        } else {
            return [];
        }
    }

    public function getResource ($key)
    {
        return $this->setting->resources->$key;
    }

    public function getResources ()
    {
        return $this->setting->resources;
    }

}
