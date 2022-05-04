<?php 

class CustomMargin extends Module{

    public function __construct(){
        $this->name = 'custommargin';
        $this->tab = 'administration';
        $this->version = ' .dev';
        $this->author = 'M2IT solutions';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->trans('Modyfikowalna marża',[],'Modules.Custommargin.Custommargin');
        $this->description = $this->trans('Pozwala dowolnie modyfikowac marze i obliczać cene produktu po z marżą',[],'Modules.Custommargin.Custommargin');

        $this->confirmUninstall = $this->trans('Napewno chcesz usunąć?',[],'Modules.Custommargin.Custommargin');
    }

    public function install()
    {   
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }


        return (
            parent::install()
            && $this->registerHook('displayAdminProductsPriceStepBottom')
            && Configuration::updateValue('MARGIN','5')
        ); 
    }

    public function uninstall()
    {
        return (
            parent::uninstall()
            && Configuration::deleteByName('MARGIN')
        );
    }

    public function getContent(){
        $msg="";
        if(Tools::getValue('value')!==null){
            $margin = Tools::getValue('value') /100;
            Configuration::updateValue('MARGIN',$margin);
            $msg = "Sukcess";
        }
        $this->context->smarty->assign([
            'value' => Configuration::get('MARGIN') * 100,
            'msg' => $msg,
        ]);
        return $this->fetch('module:custommargin/views/templates/admin/config.tpl');
    }
    
    public function hookDisplayAdminProductsPriceStepBottom(){
        $this->context->smarty->assign([
            'value' =>  Configuration::get('MARGIN')
        ]);
        return $this->fetch('module:custommargin/views/templates/hook/product.tpl');
    }
}