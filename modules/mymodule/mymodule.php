<?php

if (!defined('_PS_VERSION_'))
	exit;

class MyModule extends Module{
    public function __construct(){
        $this->name = 'mymodule';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Albert Diller';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Eufoja Module');
        $this->description = $this->l('Description of my module.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('MYMODULE_NAME')) {
            $this->warning = $this->l('No name provided');
        }
    }

    public function install(){
        //sparawdza te duperlele jesli nie istnieja to daje false
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

    return (
            parent::install() 
            && $this->registerHook('leftColumn')
            && $this->registerHook('header')
            && Configuration::updateValue('MYMODULE_NAME', 'my friend')
        ); 
    }

    public function uninstall(){
        // zmienia w db 
        // Configuration::getMultiple(array('chuj','dupa','cycki'))
        // Configuration::updateValue(array('chuj'))
        // Configuration::delete(array('chuj','dupa','cycki'))

        // usuwa db i inne powiazane rzweczy jeslli  nie usunie to false
        return (
            parent::uninstall() 
            && Configuration::deleteByName('MYMODULE_NAME')
        );
    }

    public function hookHeader(){
        return "Hello from Amadeo";
    }
}