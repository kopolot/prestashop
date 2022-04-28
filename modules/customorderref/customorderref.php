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

    // ilosc pol wyboru 
    public $parts = 2;

    // opcje do wyboru 
    public function varNames(){
        return [
            ['name' => "Zostaw puste jeśli chcesz pominąć", 'value' => 0],
            ['name' => "aktualne zamówienie w tym miesiącu", 'value' => 1],
            ['name' => "rosnąca liczba od podanej wartość", "value" => 2],
            ['name' => "aktualny rok i miesiąc (ROK-MIES)", "value" => 3],
            ['name' => "kraj dostawy", 'value' => 4],
            // ['name' =>'aktualny rok']
        ];
    }

    
    public function getContent(){
        $msg = null;
        for ($i = 0;$i<=$this->parts;$i++){
            if(Configuration::get("ORDER_REF_METHOD$i")===null)
                Configuration::updateValue("ORDER_REF_METHOD$i",0);
            if(Tools::getValue('config0')==0){
                $msg = "buu dyskwalifikacja";
            }
            elseif(Tools::getValue("config$i")){
                $msg = "Sukcess";
                Configuration::updateValue("ORDER_REF_METHOD$i",Tools::getValue("config$i"));
            }
        }  
        $value = [
            Configuration::get("ORDER_REF_METHOD0"),
            Configuration::get("ORDER_REF_METHOD1"),
            Configuration::get("ORDER_REF_METHOD2")
        ];
        $this->context->smarty->assign([
            'msg' => $msg,
            'names' => $this->varNames(),
            'value' => $value,
            'parts' => $this->parts,
            'jp' => Configuration::get("HWDP_JP")
        ]);
        return $this->fetch('module:customorderref/views/templates/admin/config.tpl');
    }


    //  $params['object'] = order
    public function hookActionValidateOrder($params){
        $order = $params['order'];
        $config= $this->createConfig();
        for($i=0;$i<=$this->parts;$i++){
            if($config[$i]==0)
            $tab[$i]=null;
            if($config[$i]==1)
            $tab[$i]=$this->monthC();
            if($config[$i]==2)
            $tab[$i]=$this->incrementVal();
            if($config[$i]==3)
            $tab[$i]=$this->dateReference();
            if($config[$i]==4)
            $tab[$i]=$this->orderCountry($order);
        }
        $order->reference = implode("",$tab);
    }

    // tworzy config do hooka
    public function createConfig(){
        for($i=0;$i<=$this->parts;$i++){
            $tab[$i]=Configuration::get("ORDER_REF_METHOD$i");
        }
        return $tab;
    }

    // rosnaca liczba od podanej wartosci
    public function incrementVal(){
        
    }

    // ISO code kraju zamowienaia
    public function orderCountry($order){

    }

    // from 3, return : string 
    public static function dateReference(){
        return date("Y-m");
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