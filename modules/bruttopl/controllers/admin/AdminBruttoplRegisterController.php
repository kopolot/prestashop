<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class AdminBruttoplRegisterController extends ModuleAdminController
{
    public function initToolbarTitle()
    {
        $this->toolbar_title = $this->l('Register at brutto.pl');
    }

    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();
    }

    public function init()
    {
        Configuration::updateGlobalValue('JASHBRUTTO_NEW_LABEL', 0);
        parent::init();
    }

    public function initContent()
    {
        if ($this->module->isRegistered()) {
            $this->display = "view";
            $this->confirmations[] = sprintf('<a href="%s">', Configuration::getGlobalValue('JASHBRUTTO_LOGIN_URL'))
                .$this->l('Go to brutto.pl')
                .'</a>';
        } else {
            $this->display = "add";
        }

        parent::initContent();
    }

    public function renderForm()
    {
        $register_regulations_desc = $this->context->smarty->fetch(
            $this->module->getModuleLocalPath().
            'views/templates/admin/register_regulations_desc.tpl'
        );
        $register_policy_desc = $this->context->smarty->fetch(
            $this->module->getModuleLocalPath().
            'views/templates/admin/register_policy_desc.tpl'
        );
        $register_marketing_desc = $this->context->smarty->fetch(
            $this->module->getModuleLocalPath().
            'views/templates/admin/register_marketing_desc.tpl'
        );
        $register_footer = $this->context->smarty->fetch(
            $this->module->getModuleLocalPath().
            'views/templates/admin/register_footer.tpl'
        );
        
        $fields_form = array(
            array(
                'type' => 'text',
                'label' => $this->l('NIP'),
                'col' =>2,
                'name' => 'nip',
                'required' => 'true',
                'size' => '10',
                'maxlength' => '10',
                'desc' => '',
                'is_bool' => true,
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Email address'),
                'col' =>3,
                'name' => 'email',
                'required' => 'true',
                'is_bool' => true,
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Mobile phone number'),
                'col' =>2,
                'name' => 'phone',
                'required' => 'true',
                'maxlength' => '9',
                'size' => '9',
                'desc' => '',
                'is_bool' => true,
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Acceptance of Terms and conditions'),
                'name' => 'regulations',
                'required' => 'true',
                'is_bool' => true,
                'desc' => $register_regulations_desc,
                'values' => array(
                    array(
                        'id' => 'active_on',
                        'value' => true,
                        'label' => $this->l('Enabled')
                    ),
                    array(
                        'id' => 'active_off',
                        'value' => false,
                        'label' => $this->l('Disabled')
                    )
                ),
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Acceptance of the privacy clause'),
                'required' => 'true',
                'name' => 'policy',
                'is_bool' => true,
                'desc' => $register_policy_desc,
                'values' => array(
                    array(
                        'id' => 'active_on',
                        'value' => true,
                        'label' => $this->l('Enabled')
                    ),
                    array(
                        'id' => 'active_off',
                        'value' => false,
                        'label' => $this->l('Disabled')
                    )
                ),
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Acceptance of marketing consents'),
                'name' => 'marketing',
                'is_bool' => true,
                'desc' => $register_marketing_desc,
                'values' => array(
                    array(
                        'id' => 'active_on',
                        'value' => true,
                        'label' => $this->l('Enabled')
                    ),
                    array(
                        'id' => 'active_off',
                        'value' => false,
                        'label' => $this->l('Disabled')
                    )
                ),
            ),
            array(
                'type' => 'html',
                'name' => 'form_footer',
                'class' => 'brutto-form-footer',
                'html_content' => $register_footer,
            ),
        );

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Register at brutto.pl and claim your limit'),
                'icon' => 'icon-paper-clip'
            ),
            'input' => $fields_form,
            'submit' => array(
                'title' => $this->l('Create an account')
            )
        );

        if (!Tools::isSubmit('submitAddconfiguration')) {
            $this->fields_value = array(
                'nip' => Configuration::get('JASHBRUTTO_NIP'),
                'email' => Configuration::get('JASHBRUTTO_EMAIL'),
                'phone' => Configuration::get('JASHBRUTTO_PHONE')
            );
        }


        $form = parent::renderForm();
        return $form;
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitAddconfiguration')) {
            $email =  Tools::getValue('email');
            $phone =  Tools::getValue('phone');
            $nip =  Tools::getValue('nip');
            $regulations =  Tools::getValue('regulations');
            $marketing =  Tools::getValue('marketing');
            $policy =  Tools::getValue('policy');

            if (!Validate::isEmail($email)) {
                $this->errors[] = $this->l('Invalid email');
            }

            if (empty($phone) || !Validate::isPhoneNumber($phone) || Tools::strlen($phone) != 9) {
                $this->errors[] = $this->l('Invalid phone');
            }

            if (empty($nip) || !$this->validateNIP($nip)) {
                $this->errors[] = $this->l('Invalid NIP');
            }

            if (empty($regulations)) {
                $this->errors[] = $this->l('Consent is required');
            }

            if (empty($policy)) {
                $this->errors[] = $this->l('Acceptance of the terms and conditions is required');
            }

            if (!$this->errors) {
                $this->module->recalculateTransactions();
                $sales = $this->module->getSales();

                $data = [];
                $data['company']['nip'] = $nip;
                $data['company']['email'] = $email;
                $data['company']['phone'] = $phone;
                $data['consents']['regulations'] = (bool)$regulations;
                $data['consents']['marketing'] = (bool)$marketing;
                $data['consents']['policy'] = (bool)$policy;
                $data['person'] = [];
                $data['integration']['client_id'] = $this->module->getClientId();
                $data['integration']['product'] = 'COMPANY_LOAN';
                $data['data']['sales']['currency'] = $this->module->getShopCurrencyIso();
                $data['data']['sales']['income'] = $sales['income'];
                $data['data']['sales']['transactions'] = $sales['transactions'];

                $response = $this->module->callApiRegister($data);

                if (in_array($response['info']['http_code'], [200,201])) {
                    $this->confirmations[] = $this->l('Registration was successful. ');
                    Configuration::updateGlobalValue(
                        'JASHBRUTTO_BRUTTO_ID',
                        json_decode($response ['body'], true)['brutto_id']
                    );
                    Configuration::updateGlobalValue(
                        'JASHBRUTTO_PARTNER_ID',
                        json_decode($response ['body'], true)['partner_id']
                    );
                    Configuration::updateGlobalValue(
                        'JASHBRUTTO_LOGIN_URL',
                        json_decode($response ['body'], true)['login_url']
                    );
                    Configuration::updateGlobalValue('JASHBRUTTO_NIP', $nip);
                    Configuration::updateGlobalValue('JASHBRUTTO_EMAIL', $email);
                    Configuration::updateGlobalValue('JASHBRUTTO_PHONE', $phone);
                    Configuration::updateGlobalValue('JASHBRUTTO_REGULATIONS', (int)$regulations);
                    Configuration::updateGlobalValue('JASHBRUTTO_MARKETING', (int)$marketing);
                    Configuration::updateGlobalValue('JASHBRUTTO_POLICY', (int)$policy);
                    $this->module->switchRegisterMenuItem(0);
                    /* refresh */
                    $response = $this->module->refresh(true);
                } else {
                    $this->errors[] = $this->displayError(
                        json_decode($response ['body'], true)['error']['code'],
                        json_decode($response ['body'], true)['error']['message']
                    );
                }
            }
        }
    }

    public function displayError($code, $message)
    {
        $messages = array();
        $messages[99] = $this->l('Technical break');
        $messages[409] = $this->l('There is already an account with such data in Brutto. Contact Brutto');
        $messages[422] = $this->l('There is a problem with the registration. Contact Brutto');
        $messages[500] = $this->l('A service error has occurred. Contact Brutto');

        if (isset($messages[$code])) {
            return $messages[$code];
        }

        if (!$message) {
            $message = $this->l('A service error has occurred. Contact Brutto');
        }

        return $message;
    }

    public function validateNIP($value)
    {
        $valid = false;

        $weights = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
        $nip = preg_replace('/^PL/', '', $value);

        if (Tools::strlen($nip) == 10 && is_numeric($nip)) {
            $sum = 0;

            for ($i = 0; $i < 9; $i++) {
                $sum += $nip[$i] * $weights[$i];
            }

            $valid = ($sum % 11) == $nip[9];
        }

        return $valid;
    }
}
