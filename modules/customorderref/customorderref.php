<?php

if(!defined('_PS_VERSION_')){
    exit;
}

/**
    zostalo zrobic view do koca,
    dodac wszystkie metody,
    view configow opary na flexie zeby sie ładnie dodawaly nowe czesci
 */


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
//update table
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
    
       return (
            parent::install() 
            && $this->registerHook('actionValidateOrder')
        ); 
    }

    public function uninstall(){
        return parent::uninstall();
    }


    public function getContent(){
        $msg = null; 
        if(Tools::getValue("config")){
            $msg = "Sukcess";
            Configuration::updateValue("ORDER_REF",Tools::getValue("config"));
        }
        $this->context->smarty->assign([
            'msg' => $msg,
        ]);
        return $this->fetch('module:customorderref/views/templates/admin/config.tpl');
    }


    //  $params['order'] = order
    public function hookActionValidateOrder($params){
        $order = $params['order'];
        $config = Configuration::get("ORDER_REF");
        $config=str_replace("/YY/",date("Y"),$config);
        $config=str_replace("/MM/",date("m"),$config);
        $config=str_replace("/NEXTOM/",self::monthC(),$config);
        $config=str_replace("/NEXTO/",self::increment(),$config);
        Configuration::updateValue("ORDER_REF",$config);
        $order->reference = Configuration::get("ORDER_REF");
    }

    // zwieksza sie liczba 
    public static function increment(){
        if(Configuration::get("CURRENT_ORDER")===null){
            Configuration::updateValue("CURRENT_ORDER",1);
        }
        Configuration::updateValue("CURRENT_ORDER",Configuration::get("CURRENT_ORDER")+1);
        return Configuration::get("CURRENT_ORDER");
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


    //CHYAB SIE NIE MG ZDUBLOWAC
    // // jesli sei dubluja? 
    // public function getNewUniqReference()
    // {
    //     $query = new DbQuery();
    //     $query->select('MIN(id_order) as min, MAX(id_order) as max');
    //     $query->from('orders');
    //     $query->where('id_cart = ' . (int) $this->id_cart);
    //     $order = Db::getInstance()->getRow($query);
    //     if ($order['min'] == $order['max']) {
    //         return $this->reference;
    //     } else {
    //         return $this->reference . '#' . ($this->id + 1 - $order['min']);
    //     }
    // }
    

    // // do tego wyzej 
    // public static function getNewUniqReferenceOf($id_order)
    // {
    //     $order = new Order($id_order);
    //     return $order->getUniqReference();
    // }
}