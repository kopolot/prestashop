<?php 

if(!defined('_PS_VERSION_')){
    exit;
}

class MyBasicModule extends Module{
    public function __construct(){
        $this->name = "mybasicmodule";
        $this->tab = "front_office_features";
        $this->version = "1.0";
        $this->author = "Adolf Hitler";
        $this->need_instance = 0;
        $this->ps_version_compliancy = [
            'min' => "1.6",
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l("My Module");
        $this->description = $this->l("This is a great testing module");
        $this->comfirmUninstall = $this->l('idi na chuj');

    }

    public function install(){
        
    }
}