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
        // if (!Configuration::get('CYKA_MODULE')) {
        //     $this->warning = $this->l('No name provided');
        // }
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

    /**
        ha zjadł na tym filmiku bracie
     */

    // zakomentowane po to zeby zrobic HelperForm | ten z filmiku nie dziala 

    public function getContent(){
        if(Tools::getValue('nie')!=null)
            Configuration::updateValue("ALLAH_AKBAR",Tools::getValue('nie'));
        $this->context->smarty->assign([
            'tak' => Configuration::get('ALLAH_AKBAR'),
            'checkable' => Tools::getValue('nie')
        ]);
        return $this->fetch('module:cykamodule/views/templates/admin/config.tpl');
    }

    // mam nadzieje ze teraz zadziala | no i chuj nie dziala

    // public function getContent(){
    //     return $this->displayForm();
    // }

    // public function displayForm(){

    //     $defaultLang = Configuration::get('PS_LANG_DEFAULT');

    //     //inputy
    //     $form = [
    //         'legend' => [
    //             'title' => $this->trans('Ustawinia modułu')
    //         ],
    //         'input' => [
    //             [
    //                 'type' => 'text',
    //                 'label' => 'wpisz cos',
    //                 'name' => 'CYKA_MODULE',
    //                 'size' => 20,
    //                 'required' => true
    //             ]
    //         ],
    //         'submit' => [
    //             'title' => $this->trans('zapisz hwdp do policji'),
    //             'class' => 'btn btn-priamry pull-right'
    //         ],
    //     ];

    //     // HelperForm
    //     $helper = new HelperForm();
    //     $helper->table = $this->table;
    //     $helper->module = $this;
    //     $helper->name_controller = $this->name;
    //     $helper->token = Tools::getAdminTokenLite('AdminModules');
    //     $helper->currentIndex = AdminController::$currentIndex . '&' . http_build_query(['configure' => $this->name]);
    //     $helper->submit_action = 'submit' . $this->name;

    //     // Language
    //     $helper->default_form_language = $defaultLang;
    //     $helper->allow_employee_form_lang = $defaultLang;

    //     // Title and toolbar
    //     // $helper->title = $this->displayName;
    //     // $helper->show_toolbar = true;
    //     // $helper->toolbar_scroll = true;
    //     // $helper->submit_action = "submit" . $this->name;
    //     // $helper->toolbar_btn = [
    //     //     'save' => [
    //     //         'desc' => $this->l('save'),
    //     //         'href' => AdminController::$currentIndex . '&token=' . $this->name . '&save' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules')
    //     //     ],
    //     //     'back' => [
    //     //         'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
    //     //         'desc' => $this->l('Back to list') 
    //     //     ]
    //     // ];
       
    //     return $helper->generateForm([$form]);
   // }
}