<?php 

if(!defined('_PS_VERSION_')){
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class MyBasicModule extends Module implements WidgetInterface {
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

    // install | return :bool
    public function install(){
        return parent::install() && $this->registerHook('registerGDPRConsent') && $this->dbInstall();
    }

    // uninstall | return :bool
    public function uninstall(){
        return parent::uninstall();
    }

    // sql install
    public function dbInstall(){
        // sql robiacy tabele 
        return true;
    }

    //wylonczone bo chce sprawidzc widgety
    // public function hookdisplayFooter($params){

    //     // nie dziala a powinno 

    //     // $this->context->smarty->assing([
    //     //     'jebać_depresje' => 'no konrad rozpadzasz sie lekko',
    //     //     'idcart' => $this->context->cart->id
    //     // ]);
    //     return $this->display(__FILE__,'views/templates/hook/footer.tpl');
    // }

    // widgeta dzialaja wszystkie hooki ;)
    // mozna sie odnsoci do tej metody w views z innyvh modeli 
    public function renderWidget($hookName, array $configuration){
        if ($hookName==='dispalyNavFullWidth')
        return "No słabo jest";
        $this->context->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch('module:mybasicmodule/views/templates/hook/footer.tpl');
    }

    public function getWidgetVariables($hookName, array $configuration){
        return [
            'idcart' => $this->context->cart->id,
            'jebac_depresje' => 'ale dasz radę'
        ];
    }

    // strona konfiguracyjna
    public function getContent(){
        return $this->fetch('module:mybasicmodule/views/templates/admin/config.tpl');
    }

}