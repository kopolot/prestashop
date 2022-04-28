<?php

if(!defined('_PS_VERSION_')){
    exit;
}

class CustomOrderRef extends Module{
    //parametry modułu 
    public function __construct(){
        $this->name = "customorderref";
        $this->tab = "administration";
        $this->version = " .dev";
        $this->author = "M2ITsolutions";
        $this->need_instance = 0;
        $this->ps_version_compliancy = [
            'min' => "1.6",
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l("Customisable orders refelantial number");
        $this->description = $this->l("This is a great modyule");
        $this->comfirmUninstall = $this->l('Do you wan\'t remove this module');
        if (!Configuration::get('CUSTOM_ORDER_REF')) {
            $this->warning = $this->l('No name provided');
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
    
       return (
            parent::install() 
            && $this->registerHook('actionObjectOrderAddAfter')
        ); 
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

    public $dupa;

    //  $params['object'] = order
    public function actionObjectOrderAddBefore($params){
       // 4 etapy do konfiguracj i tyle 
    }

    // from 3, return : string 
    public static function dateReference($order){
        $date1 = date('/Y/');
        $date2 = date("/m/Y");
        $cmo = self::monthC();
        $random = self::random3String();
        return $random . $date1 . $cmo . $date2;
    }

    // randomowe znaki 
    public static function random3String(){
        $char = "ABidsfidfjJOIPfoasfDSOVKDSPOPVMPOsopajfsadjuiuwmecruitvcxnvxczczzxWEQPOCVCXKLVBGOWSG";
        $charlen = strlen($char)-1;
        for ($i = 0;$i<=3;$i++){
            $res[$i]=substr($char,rand(0,$charlen),1);
        }
        return $res[0] . $res[1] . $res[2];
    }

    // aktualny mies
    public static function monthC(){
        $current_month = Configuration::get("CURRENT_MONTH");
        $current_month_order = Configuration::get("CURRENT_ORDER_IN_MONTH");
        if($current_month_order===null)
            $current_month_order = 1;
        if($current_month===null)
            $current_month = date("m");
        if($current_month==date("m")){
            Configuration::updateValue("CURRENT_ORDER_IN_MONTH",$current_month_order + 1);
            return Configuration::get("CURRENT_ORDER_IN_MONTH");
        }else{
            Configuration::updateValue("CURRENT_MONTH",date("m"));
            Configuration::updateValue("CURRENT_ORDER_IN_MONTH",1);
            return Configuration::get("CURRENT_ORDER_IN_MONTH");
        }
    }

    // jesli sei dubluja? 
    public function getNewUniqReference()
    {
        $query = new DbQuery();
        $query->select('MIN(id_order) as min, MAX(id_order) as max');
        $query->from('orders');
        $query->where('id_cart = ' . (int) $this->id_cart);
        $order = Db::getInstance()->getRow($query);
        if ($order['min'] == $order['max']) {
            return $this->reference;
        } else {
            return $this->reference . '#' . ($this->id + 1 - $order['min']);
        }
    }
    

    // do tego wyzej 
    public static function getNewUniqReferenceOf($id_order)
    {
        $order = new Order($id_order);
        return $order->getUniqReference();
    }
}