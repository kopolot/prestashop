<?php

if(!defined('_PS_VERSION_')){
    exit;
}

class CustomOrderId extends Module{
    //parametry modułu 
    public function __construct(){
        $this->name = "customorderid";
        $this->tab = "administration";
        $this->version = "1. 0";
        $this->author = "M2ITsolutions";
        $this->need_instance = 0;
        $this->ps_version_compliancy = [
            'min' => "1.6",
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l("Customizable Orders ID");
        $this->description = $this->l("This is a great modyule");
        $this->comfirmUninstall = $this->l('Do you wan\'t remove this module');

    }

    // install | return :bool
    public function install(){
        return parent::install();
    }

    // uninstall | return :bool
    public function uninstall(){
        return parent::uninstall();
    }

    public function getConfig(){
        $message = null ;
        // getValue zbiera posty i get 
        if(Tools::getValue('')){
            Configuration::updateValue('OCENA_AKADEMIKA',Tools::getValue('ocena_akademika'));
            $message = "no i chuj";
        }
        // input ocena_akademika
        $ocena_akademika = Configuration::get('OCENA_AKADEMIKA');
        $this->context->smarty->assign([
            'ocena_akademika' => $ocena_akademika,
            'message' => $message
        ]);
        return $this->fetch('module:customorderid/views/templates/admin/config.tpl');
    }
}