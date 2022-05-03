<?php 

if (!defined('_PS_VERSION_')) {
    exit;
}

class Tutorial extends Module{

    public function __construct(){
        $this->name = 'tutorial';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'tutorial';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('tutorial');
        $this->description = $this->l('słabo jest co?');

        $this->confirmUninstall = $this->l('wszystko smuci i wkurwia');

        if (!Configuration::get('TUTORIAL')) {
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
            && $this->registerHook('registerGDPRConsent')
            && $this->registerHook('actionFrontControllerSetMedia')
            && Configuration::updateValue('TUTORIAL', 'my friend')
        ); 
    }

    public function uninstall()
    {
        return (
            parent::uninstall() 
            && Configuration::deleteByName('TUTORIAL')
        );
    }

    public function getContent()
    {
        $output = '';

        // this part is executed only when the form is submitted
        if (Tools::isSubmit('submit' . $this->name)) {
            // retrieve the value set by the user
            $configValue = (string) Tools::getValue('TUTORIAL_CONFIG');

            // check that the value is valid
            if (empty($configValue) || !Validate::isGenericName($configValue)) {
                // invalid value, show an error
                $output = $this->displayError($this->l('Invalid Configuration value'));
            } else {
                // value is ok, update it and display a confirmation message
                Configuration::updateValue('TUTORIAL_CONFIG', $configValue);
                $output = $this->displayConfirmation($this->l('Settings updated'));
            }
        }

        // display any message, then the form
        return $output . $this->displayForm();
    }

    public function displayForm()
    {
        // Init Fields form array
        $form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Configuration value'),
                        'name' => 'TUTORIAL_CONFIG',
                        'size' => 20,
                        'required' => true,
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                ],
            ],
        ];

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->table = $this->table;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&' . http_build_query(['configure' => $this->name]);
        $helper->submit_action = 'submit' . $this->name;

        // Default language
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');

        // Load current value into the form
        $helper->fields_value['TUTORIAL_CONFIG'] = Tools::getValue('TUTORIAL_CONFIG', Configuration::get('TUTORIAL_CONFIG'));
        Configuration::deleteByName("TUTORIAL_CONFIG");
        
        return $helper->generateForm([$form]);
    }

    public function hookDisplayLeftColumn($params)
    {
        $this->context->smarty->assign([
            'tutorial_name' => Configuration::get('TUTORIAL'),
            'tutorial_link' => $this->context->link->getModuleLink('tutorial', 'display')
        ]);

        return $this->display(__FILE__, 'views/templates/hook/tutorial.tpl');
    }

    public function hookDisplayRightColumn($params)
    {
        return $this->hookDisplayLeftColumn($params);
    }

    public function hookDisplayTop($params)
    {
        return $this->hookDisplayLeftColumn($params);
    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->registerStylesheet(
            'tutorial-style',
            $this->_path.'views/css/tutorial.css',
            [
                'media' => 'all',
                'priority' => 1000,
            ]
        );

        $this->context->controller->registerJavascript(
            'tutorial-javascript',
            $this->_path.'views/js/tutorial.js',
            [
                'position' => 'bottom',
                'priority' => 1000,
            ]
        );
    }

}