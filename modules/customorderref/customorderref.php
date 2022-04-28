<?php

if(!defined('_PS_VERSION_')){
    exit;
}

class CustomOrderRef extends Module{
    //parametry modułu 
    public function __construct(){
        $this->name = "customorderref";
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
        $this->displayName = $this->l("Customizable orders refelantial number");
        $this->description = $this->l("This is a great modyule");
        $this->comfirmUninstall = $this->l('Do you wan\'t remove this module');
        if (!Configuration::get('CUSTOM_ORDER_REF')) {
            $this->warning = $this->l('No name provided');
        }
    }

    public function install(){
        return parent::install();
    }

    public function uninstall(){
        return parent::uninstall();
    }

    public function getContent(){
        $msg = null;
        if(Tools::getValue('config')){
            Configuration::updateValue('ORDER_REF_METHOD',Tools::getValue('config'));
            $msg = "Sukcess";
        }
        $this->context->smarty->assign([
            'msg' => $msg,
            'value' => Configuration::get('ORDER_REF_METHOD')
        ]);
        return $this->fetch('module:customorderref/views/templates/admin/config.tpl');
    }
}