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

    public function getContent(){
        return $this->displayForm();
    }

    // public function displayForm(){
    //     $defaultLang = (int) Configuration::get('PS_LANG_DEFAULT');
        
    //     //inputy 
    //     $form = [
    //         //  duperele
    //         'legend' => [
    //             'title' => $this->trans('Rating setting')
    //         ],
    //         //  tu sie wrzuca inputy 
    //         'input' => [
    //             [
    //                 'type' => 'text',
    //                 'label' => $this->l('do configa'),
    //                 'name' => 'nie',
    //                 'required' => true
    //             ],
    //             [
    //                 'type' => 'password',
    //                 'label' => $this->l('tetstowo'),
    //                 'name' => 'chuj',
    //                 'required' => true
    //             ]
    //         ],
    //         'submit' => [
    //             'title' => $this->trans('submit'),
    //             'class' => 'btn btn-primary pull-right'
    //         ]
    //     ];
    //     $helper = new HelperForm();
    //     // Module, token and currentIndex
    //     $helper->module = $this;
    //     $helper->name_controller = $this->name;
    //     $helper->token = Tools::getAdminTokenLite('AdminModules');
    //     $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
    //     $helper->submit_action = 'submit' . $this->name;

    //     // Default language
    //     $helper->default_form_language = $defaultLang;
    //     $helper->allow_employee_form_lang = $defaultLang;

    //     // Load current value into the form
    //     $helper->fields_value['MYMODULE_CONFIG'] = Tools::getValue('MYMODULE_CONFIG', Configuration::get('MYMODULE_CONFIG'));

    //     //title and toolbar
    //     $helper->title = $this->displayName;
    //     $helper->show_toolbar = true;
    //     $helper->toolbar_scroll = true;
    //     $helper->submit_action = 'submit' . $this->name;

    //     return $helper->generateForm([$form]);

    //  }
}