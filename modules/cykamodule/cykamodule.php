<?php

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if(!defined('_PS_VERSION_')){
    exit;
}

class CykaModule extends Module implements WidgetInterface{
    //parametry modułu 
    public function __construct(){
        $this->name = "cykamodule";
        $this->tab = "front_office_features";
        $this->version = "0";
        $this->author = "samolot";
        $this->need_instance = 0;
        $this->ps_version_compliancy = [
            'min' => "1.6",
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l("HWDP");
        $this->description = $this->l("PDW");
        $this->comfirmUninstall = $this->l('cyka nuggets');
        if (!Configuration::get('CUSTOM_ORDER_REF')) {
            $this->warning = $this->l('No name provided');
        }
    }
    //update table
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
    
       return (
            parent::install() 
            && $this->registerHook('registerGDPRConsent')
        ); 
    }

    public function uninstall(){
        return parent::uninstall();
    }

    // public function hookDisplayFooter(){
    //     return "HWDP 100";
    // }

    public function hookDisplayHeader(){
        $this->context->smarty->assign([
            'msg' => "maluch w maluchu",
            'idcart' => $this->context->cart->id
        ]);
        return $this->display(__FILE__,"views/templates/hook/header.tpl");
    }

    public function renderWidget($hookName= null,$configuration = []){
        if($hookName=="displayTop")
        return "";
        if(!$this->isCached('module:cykamodule/views/templates/hook/header.tpl',$this->getCacheId($this->name)))
        $this->context->smarty->assign($this->getWidgetVariables($hookName,$configuration)) ;
        return $this->fetch('module:cykamodule/views/templates/hook/header.tpl', $this->getCacheId('cykamodule'));
    }

    public function getWidgetVariables($hookName = null, array $configuration = []){
        return [
            'msg' => 'dobry przekaz leci',
            'idcart' => $this->context->cart->id
        ];
    }
   
    // zakomentowane po to zeby zrobic HelperForm

    public function getContent(){
        if(Tools::getValue('nie')!=null)
            Configuration::updateValue("ALLAH_AKBAR",Tools::getValue('nie'));
        $this->context->smarty->assign([
            'tak' => Configuration::get('ALLAH_AKBAR'),
            'checkable' => Tools::getValue('nie')
        ]);
        return $this->fetch('module:cykamodule/views/templates/admin/config.tpl');
    }

    
}