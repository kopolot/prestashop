<?php
/**
* 2007-2020 PrestaShop
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
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Bruttopl extends Module
{
    protected $config_form = false;
    protected $months = 12;
    protected $config = [];


    public function __construct()
    {
        $this->name = 'bruttopl';
        $this->tab = 'administration';
        $this->version = '1.2.9';
        $this->author = 'Jash Technologie jash.pl';
        $this->need_instance = 0;
        $this->module_key = '465106f7d2d16db766d7f2102a659e7f';

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Brutto');
        $this->description = $this->l('A company loan from Brutto gives you more 
            opportunities for your store. Gain access to additional funds for 
            the purchase of goods, marketing, salaries and payment of company taxes 
            and social security contributions.');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        
        $this->config = require dirname(__FILE__).'/config.inc.php';
    }

    public function install()
    {
        Configuration::updateGlobalValue('JASHBRUTTO_NEW_LABEL', 1);
        Configuration::updateGlobalValue('JASHBRUTTO_SHOPS', Configuration::get('PS_SHOP_DEFAULT'));
        
        $return =  parent::install()
            &&  $this->registerHook('backOfficeHeader')
            &&  $this->registerHook('dashboardZoneOne');
        
        $menuIdParent = $this->addTab(['name'=> 'Brutto.pl', 'className' => 'AdminBruttoplStatus']);
        $this->addTab(['name'=> $this->l('Status'), 'className' => 'AdminBruttoplStatus'], $menuIdParent);
        $this->addTab(['name'=> $this->l('Register'), 'className' => 'AdminBruttoplRegister'], $menuIdParent);
        $this->addTab(['name'=> $this->l('Debug'), 'className' => 'AdminBruttoplDebug'], -1);
   
        $this->updatePosition(Hook::getIdByName('dashboardZoneOne'), 0, 1);
        
        $sql = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."bruttopl_transactions` (
                `id_bruttopl_transaction` INT(11) NOT NULL AUTO_INCREMENT,
                `month` DATE NOT NULL,
                `income` DECIMAL(10,2) NOT NULL,
                `transactions` INT(11) NOT NULL DEFAULT '0',
                `date_add` DATETIME NULL DEFAULT NULL,
                `date_upd` DATETIME NULL DEFAULT NULL,
                PRIMARY KEY (`id_bruttopl_transaction`) USING BTREE,
                UNIQUE INDEX `month` (`month`) USING BTREE
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8;";
        
        $return = $return && Db::getInstance()->execute($sql);
        
        $this->refresh();
        
        return $return;
    }

    public function uninstall()
    {
        Configuration::deleteByName('JASHBRUTTO_NEW_LABEL');
        Configuration::deleteByName('JASHBRUTTO_SHOPS');
        Configuration::deleteByName('JASHBRUTTO_BRUTTO_ID');
        Configuration::deleteByName('JASHBRUTTO_PRELIMIT');
        Configuration::deleteByName('JASHBRUTTO_PRELIMIT_DATE');
        Configuration::deleteByName('JASHBRUTTO_NIP');
        Configuration::deleteByName('JASHBRUTTO_EMAIL');
        Configuration::deleteByName('JASHBRUTTO_PHONE');
        Configuration::deleteByName('JASHBRUTTO_REGULATIONS');
        Configuration::deleteByName('JASHBRUTTO_POLICY');
        Configuration::deleteByName('JASHBRUTTO_MARKETING');
        Configuration::deleteByName('JASHBRUTTO_PARTNER_ID');
        Configuration::deleteByName('JASHBRUTTO_LOGIN_URL');
        Configuration::deleteByName('JASHBRUTTO_LIMIT_DATE');
        Configuration::deleteByName('JASHBRUTTO_COMPANY_LOAN_UPDATED_AT');
        Configuration::deleteByName('JASHBRUTTO_COMPANY_LOAN_AVAILABLE');
        Configuration::deleteByName('JASHBRUTTO_COMPANY_LOAN_USED');
        Configuration::deleteByName('JASHBRUTTO_COMPANY_LOAN_GRANTED');
        
        $this->removeTabs();

        Db::getInstance()->execute("DROP TABLE IF EXISTS "._DB_PREFIX_."bruttopl_transactions");
        return parent::uninstall();
    }
    
    public function getModuleLocalPath()
    {
        return $this->local_path;
    }
    
    public function getContent()
    {
        if (Shop::isFeatureActive() && Shop::getContext() != Shop::CONTEXT_ALL) {
            return $this->displayError($this->l('Only All Shop context allowed'));
        }
         
        

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = '';
        
        if (((bool)Tools::isSubmit('submitBruttoplModule')) == true) {
            $this->postProcess();
            $output .= $this->displayConfirmation(
                $this->l('Settings have been saved')
            );
        }
        
        if (!Configuration::get('JASHBRUTTO_SHOPS')) {
            $output .= $this->displayError(
                $this->l('No shop has been selected. The module will not function properly.')
            );
        }
        
        
        $output .= $this->displayWarning(
            $this->l('NOTE - select stores that sell only under the VAT number registered in Brutto')
        );
        
       
        return $output.$this->renderForm();
    }


    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBruttoplModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }


    protected function getConfigForm()
    {
        $shops = Shop::getShops(false);
       
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'checkbox',
                        'multiple' => true,
                        'label' => $this->l('stores included in the turnover'),
                        'name' => 'JASHBRUTTO_SHOPS',
                        'values' => array(
                            'query' => $shops,
                            'id' => 'id_shop',
                            'name' => 'name'
                        )
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }
    
    
    protected function getConfigFormValues()
    {
        $values =  array();
        
        $JASHBRUTTO_SHOPS = explode(",", Configuration::get('JASHBRUTTO_SHOPS'));
        foreach (Shop::getShops(false) as $shop) {
            if (in_array($shop['id_shop'], $JASHBRUTTO_SHOPS)) {
                $values['JASHBRUTTO_SHOPS_'.$shop['id_shop']] = 1;
            }
        }
        
        return $values;
    }
    
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            if (!preg_match('#^JASHBRUTTO_(SHOPS)#', $key)) {
                Configuration::updateGlobalValue($key, Tools::getValue($key));
            }
        }
        
        $shops = [];
        foreach (Shop::getShops(false) as $shop) {
            $key = 'JASHBRUTTO_SHOPS_' . $shop['id_shop'];
            if (Tools::getValue($key)) {
                $shops[] = $shop['id_shop'];
            }
        }

        Configuration::updateValue('JASHBRUTTO_SHOPS', implode(",", (array)$shops));
        $this->recalculateTransactions();
    }

    public function addTab($tab, $id_parent = 0)
    {
        $tabModel = new Tab();
        $tabModel->module = $this->name;
        $tabModel->active = isset($tab['active']) ? (bool)$tab['active'] : 1;
        $tabModel->class_name = $tab['className'];
        $tabModel->id_parent = $id_parent;

        foreach (Language::getLanguages(false) as $lang) {
            $tabModel->name[$lang['id_lang']] = $tab['name'];
        }
        $tabModel->add();
           
        return $tabModel->id;
    }

    public function removeTabs()
    {
        $ids = Db::getInstance()->getValue('SELECT GROUP_CONCAT(id_Tab) as ids  
            FROM '._DB_PREFIX_.'tab 
            WHERE module = "'.$this->name.'"');
        if ($ids) {
            Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'tab where id_tab IN ('.$ids.')');
            Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'tab_lang where id_tab IN ('.$ids.')');
            Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'tab_advice where id_tab IN ('.$ids.')');
            if (version_compare(_PS_VERSION_, '1.7', '<=') === true) {
                Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'access where id_tab IN ('.$ids.')');
            }
        }
    }
    
    public function hookBackOfficeHeader($params)
    {
        $page = $this->context->controller->controller_name;
        $allowed = ['AdminDashboard', 'AdminBruttoplStatus', 'AdminBruttoplRegister'];
        
        if (in_array($page, $allowed) || Configuration::get('JASHBRUTTO_NEW_LABEL')) {
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
            $this->context->smarty->assign('is_new', Configuration::get('JASHBRUTTO_NEW_LABEL'));
            return $this->context->smarty->fetch($this->local_path.'views/templates/hook/head.tpl');
        }
        
        return null;
    }
    
    public function hookDashboardZoneOne($params)
    {
        if ($this->isRegistered()) {
            $this->context->smarty->assign(
                array(
                   'registered' => true,
                   'panelTitle' => $this->l('Your funding limit'),
                   'grantedLimit' => $this->getGrantedLimit(),
                   'availableLimit' => $this->getAvailableLimit(),
                )
            );
        } else {
            $this->context->smarty->assign(
                array(
                    'registered' => false,
                    'incomeTotal' => $this->getIncomeTotal(),
                    'panelTitle' => $this->l('Company loan'),
                    'prelimitDate' => $this->getPrelimitDate(),
                    'prelimit' => $this->getPrelimit(),
                )
            );
        }
        
        $this->context->smarty->assign(
            array(
                'currencyIso' => $this->getShopCurrencyIso(),
                'currencySign' => $this->getShopCurrencySign(),
            )
        );

        return $this->context->smarty->fetch($this->local_path.'views/templates/hook/dashboard_zone_one.tpl');
    }
    
    public function recalculateTransactions()
    {
        $shops = explode(",", Configuration::getGlobalValue('JASHBRUTTO_SHOPS'));
        $shops = array_map("intval", $shops);
        $shops = array_filter($shops);
        
        Db::getInstance()->execute('TRUNCATE TABLE '._DB_PREFIX_.'bruttopl_transactions');
        
        if (!$shops) {
            return [];
        }
        
        $sql = 'INSERT INTO '._DB_PREFIX_.'bruttopl_transactions (month, income, transactions, date_add)
                SELECT 
                    DATE_FORMAT(`invoice_date`, "%Y-%m-00") AS month, 
                    ROUND(SUM(total_paid * conversion_rate),2) AS income,   
                    COUNT(id_order) AS transactions, 
                    NOW() as date_add
                FROM '._DB_PREFIX_.'orders o
                WHERE 
                    o.valid = 1 
                    AND o.id_shop IN ('.implode(',', $shops).')
                    AND o.invoice_date >= DATE_FORMAT(LAST_DAY(now() - INTERVAL 13 MONTH) 
                        + INTERVAL 1 DAY, "%Y-%m-%d 00:00:00")
                    AND o.invoice_date <= DATE_FORMAT(LAST_DAY(NOW() - INTERVAL 1 MONTH), "%Y-%m-%d 23:59:59")
                    GROUP BY month
                ON DUPLICATE KEY UPDATE  income=income, transactions=transactions, date_upd=NOW()
                ';
            
        PrestaShopLogger::addLog($this->l("Brutto.pl recalculate Transactions SUCCESS"), 1);
        return Db::getInstance()->execute($sql);
    }
    
    public function getSales()
    {
        $months = $this->months;
        $sales = [];
        for ($i=1; $i<=$months; $i++) {
            $date = date('Y-m', strtotime("-$i month"));
            $sales['income'][$date] = 0;
            $sales['transactions'][$date] = 0;
        }
        
        $transactions = Db::getInstance()->executeS(
            'SELECT DATE_FORMAT(month, "%Y-%m") as month, income, transactions 
            FROM '._DB_PREFIX_.'bruttopl_transactions'
        );
        foreach ($transactions as $trans) {
            if (array_key_exists($trans['month'], $sales['income'])) {
                $sales['income'][$trans['month']] = (float)$trans['income'];
                $sales['transactions'][$trans['month']] = (int)$trans['transactions'];
            }
        }
        
        return $sales;
    }
    
    public function getIncomeTotal()
    {
        $transactions = $this->getSales();
        return array_sum($transactions['income']);
    }
    
    public function callApi($endpoint, $data = [], $headers = [], $method = "post")
    {
        $postfields = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);

        $requestURI = $this->config['apiBase'].$endpoint;
        
        $guid = $this->getGuid();
        $timestamp = time();
        $signature = $this->hmac($this->config['PartnerSecret'], $guid.$timestamp.$endpoint);
        
        $baseHeaders = [];
        
        $baseHeaders[] = 'Content-Type: application/json';
        $baseHeaders[] = 'Authorization: Apikey '.$this->config['PartnerId'].':'.$this->config['PartnerApiKey'];
        $baseHeaders[] = "X-BruttoApi-Request-Id: $guid";
        $baseHeaders[] = "X-BruttoApi-Request-Timestamp: $timestamp";
        $baseHeaders[] = "X-BruttoApi-Request-Signature: $signature";

        $ch = curl_init($requestURI);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($baseHeaders, $headers));

        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        if ($method == "post") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_HTTP200ALIASES, array(400));
        
        $return = curl_exec($ch);
        
        $info = curl_getinfo($ch);
        
        $header = Tools::substr($return, 0, (int)$info['header_size']);
        $body = trim(Tools::substr($return, (int)$info['header_size']));
        
        curl_close($ch);
        
        return ['return'=>$return, 'info'=>$info, 'body'=>$body, 'postfields'=>$postfields, 'header' => $header];
    }
    
    public function callApiPrelimit($data)
    {
        return $this->callApi('/api/v3/companyloan/prelimit', $data);
    }
    
    public function callApiLimit()
    {
        $brutto_id = Configuration::getGlobalValue('JASHBRUTTO_BRUTTO_ID');
        if ($brutto_id) {
            $return = $this->callApi('/api/v3/company/'.$brutto_id.'/limits', [], [], "get");
            return $return;
        } else {
            return false;
        }
    }
    
    public function callApiResendSales($data)
    {
        $brutto_id = Configuration::getGlobalValue('JASHBRUTTO_BRUTTO_ID');
        if ($brutto_id) {
            $return = $this->callApi('/api/v3/company/'.$brutto_id.'/input/sales', $data);
            return $return;
        } else {
            return false;
        }
    }
    
    public function callApiRegister($data)
    {
        return $this->callApi('/api/v3/company/register', $data);
    }
    
    public function isRegistered()
    {
        return (bool)Configuration::getGlobalValue('JASHBRUTTO_BRUTTO_ID');
    }
    
    public function getPrelimit()
    {
        return Configuration::getGlobalValue('JASHBRUTTO_PRELIMIT');
    }
    
    public function getPrelimitDate()
    {
        return Configuration::getGlobalValue('JASHBRUTTO_PRELIMIT_DATE');
    }
    
    public function getLimitDate()
    {
        return Configuration::getGlobalValue('JASHBRUTTO_LIMIT_DATE');
    }
    
    public function getShopCurrency()
    {
        return Currency::getDefaultCurrency();
    }
    
    public function getShopCurrencyIso()
    {
        $currency = $this->getShopCurrency();
        if ($currency) {
            return $currency->iso_code;
        }
    }
    
    public function getShopCurrencySign()
    {
        $currency = $this->getShopCurrency();
        if ($currency) {
            return $currency->sign;
        }
    }
    
    public function getGrantedLimit()
    {
        return Configuration::getGlobalValue('JASHBRUTTO_COMPANY_LOAN_GRANTED');
    }
    
    public function getAvailableLimit()
    {
        return Configuration::getGlobalValue('JASHBRUTTO_COMPANY_LOAN_AVAILABLE');
    }
    
    public function displayWarning($warning)
    {
        if (is_callable('parent::displayWarning')) {
            return parent::displayWarning($warning);
        } elseif (is_callable('parent::adminDisplayWarning')) {
            return parent::adminDisplayWarning($warning);
        }
        
        return $warning;
    }

    public function refreshPrelimit()
    {
        $this->recalculateTransactions();
        $sales =  $this->getSales();
        $data = ['sales'=>[
            'currency' => $this->getShopCurrencyIso(),
            'income'=>$sales['income'],
            'transactions'=>$sales['transactions']
        ]] ;
        
        $response = $this->callApiPrelimit($data);
        
        if ($response['info']['http_code'] == 201) {
            $prelimit = json_decode($response ['body'], true)['prelimit']['COMPANY_LOAN'];
            if (is_null($prelimit)) {
                return false;
            }
            Configuration::updateGlobalValue('JASHBRUTTO_PRELIMIT', $prelimit);
            Configuration::updateGlobalValue('JASHBRUTTO_PRELIMIT_DATE', date('Y-m-d H:i:s'));
            
            PrestaShopLogger::addLog($this->l("Brutto.pl refreshPrelimit SUCCESS"), 1, $response['info']['http_code']);
            return true;
        } else {
            PrestaShopLogger::addLog(
                sprintf(
                    $this->l("Brutto.pl refreshPrelimit %d %s"),
                    $response ['body']['error']['code'],
                    $response ['body']['error']['message']
                ),
                3,
                $response ['body']['error']['code']
            );
            return false;
        }
        return true;
    }
    
    public function resendSales()
    {
        $this->recalculateTransactions();
        $sales =  $this->getSales();
        $data = array();
        $data['input']['product'] = 'COMPANY_LOAN';
        $data['input']['sales']['currency'] = $this->getShopCurrencyIso();
        $data['input']['sales']['income'] = $sales['income'];
        $data['input']['sales']['transactions'] = $sales['transactions'];
        
        $response = $this->callApiResendSales($data);

        $body = json_decode($response ['body'], true);
        
        if ($response['info']['http_code'] == 204) {
            PrestaShopLogger::addLog($this->l("Brutto.pl resendSales SUCCESS"), 1, $response['info']['http_code']);
            return true;
        } else {
            PrestaShopLogger::addLog(
                sprintf(
                    $this->l("Brutto.pl resendSales %d %s"),
                    $body ['error']['code'],
                    $body ['error']['message']
                ),
                3,
                $body ['error']['code']
            );
            return false;
        }
    }
    
    public function refreshLimit()
    {
        $this->resendSales();
        $response = $this->callApiLimit();

        
        if ($response['info']['http_code'] == 200) {
            $limits = json_decode($response ['body'], true)['limits'];
            
            if (isset($limits['company_loan'])) {
                Configuration::updateGlobalValue(
                    'JASHBRUTTO_COMPANY_LOAN_GRANTED',
                    (string)$limits['company_loan']['granted']
                );
                Configuration::updateGlobalValue(
                    'JASHBRUTTO_COMPANY_LOAN_USED',
                    (string)$limits['company_loan']['used']
                );
                Configuration::updateGlobalValue(
                    'JASHBRUTTO_COMPANY_LOAN_AVAILABLE',
                    (string)$limits['company_loan']['available']
                );
                Configuration::updateGlobalValue(
                    'JASHBRUTTO_COMPANY_LOAN_UPDATED_AT',
                    $limits['company_loan']['updated_at']
                );
                Configuration::updateGlobalValue('JASHBRUTTO_LIMIT_DATE', date('Y-m-d H:i:s'));
                
                PrestaShopLogger::addLog($this->l("Brutto.pl refreshLimit SUCCESS"), 1, $response['info']['http_code']);
            }
        } else {
            PrestaShopLogger::addLog(
                sprintf(
                    $this->l("Brutto.pl refreshLimit %d %s"),
                    $response['body']['error']['code'],
                    $response['body']['error']['message']
                ),
                3,
                $response['body']['error']['code']
            );
            return false;
        }
    }
    
    public function getGuid()
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    
    public function hmac($key, $data)
    {
        return $this->customHmac('sha256', $data, $key, false);
    }
    
    public function customHmac($algo, $data, $key, $raw_output = false)
    {
        $algo = Tools::strtolower($algo);
        $pack = 'H'.Tools::strlen(hash($algo, ('test')));
        $size = 64;
        $opad = str_repeat(chr(0x5C), $size);
        $ipad = str_repeat(chr(0x36), $size);

        if (Tools::strlen($key) > $size) {
            $key = str_pad(pack($pack, $algo($key)), $size, chr(0x00));
        } else {
            $key = str_pad($key, $size, chr(0x00));
        }

        for ($i = 0; $i < Tools::strlen($key) - 1; $i++) {
            $opad[$i] = $opad[$i] ^ $key[$i];
            $ipad[$i] = $ipad[$i] ^ $key[$i];
        }

        $output = hash($algo, ($opad.pack($pack, hash($algo, ($ipad.$data)))));

        return ($raw_output) ? pack($pack, $output) : $output;
    }
    
    public function switchRegisterMenuItem($active)
    {
        $tab = Tab::getInstanceFromClassName('AdminBruttoplRegister');
        $tab->active = $active;
        $tab->update();
    }
    
    public function getClientId()
    {
        return sha1($_SERVER['SERVER_NAME']._COOKIE_KEY_);
    }
    
    public function refresh($force = false)
    {
        $this->switchRegisterMenuItem(!$this->isRegistered());

        if ($this->isRegistered()) {
            $limitDate = $this->getLimitDate();
            
            if ($force || $this->getGrantedLimit() === false
                || !$limitDate || (int)date('m') != (int)date('m', strtotime($limitDate))) {
                return $this->refreshLimit();
            }
        } else {
            $prelimitDate = $this->getPrelimitDate();
 
            if ($force || $this->getPrelimit() === false || !$prelimitDate
                || (int)date('m') != (int)date('m', strtotime($prelimitDate))) {
                if (!$this->refreshPrelimit()) {
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminBruttoplStatus', true).'&error=1');
                } else {
                    return true;
                }
            }
        }
    }
}
