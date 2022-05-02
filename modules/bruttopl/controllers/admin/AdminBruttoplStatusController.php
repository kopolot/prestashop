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

class AdminBruttoplStatusController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->show_toolbar = false;
        parent::__construct();
    }
    
    public function initToolbarTitle()
    {
        $this->toolbar_title = $this->l('Your company\'s funding limit');
    }

    public function init()
    {
        Configuration::updateGlobalValue('JASHBRUTTO_NEW_LABEL', 0);

        $this->module->refresh((bool)Tools::isSubmit('recalculate'));
        
        if (Tools::isSubmit('recalculate')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminBruttoplStatus', true).'&updated');
        }
        
        parent::init();
    }

    public function initContent()
    {
        $this->display = "view";
        
       
        if (Tools::isSubmit('updated')) {
            $this->confirmations[] = $this->l('The limit has been recalculated');
        }
        
        if (!Configuration::get('JASHBRUTTO_SHOPS')) {
            $this->errors[] = $this->l('No shop has been selected. 
                The module will not function properly.');
        }
        
        if (Tools::getValue('error') == "1") {
            $this->errors[] = $this->l('Try again');
        }
        
        parent::initContent();
    }
    
    public function renderView()
    {
        if ($this->module->isRegistered()) {
            $this->context->smarty->assign(
                array(
                   'registered' => true,
                   'panelTitle' => $this->l('Your funding limit'),
                   'grantedLimit' => $this->module->getGrantedLimit(),
                   'availableLimit' => $this->module->getAvailableLimit(),
                )
            );
        } else {
            $this->context->smarty->assign(
                array(
                    'registered' => false,
                    'incomeTotal' => $this->module->getIncomeTotal(),
                    'panelTitle' => $this->l('Initial funding limit calculation'),
                    'prelimitDate' => $this->module->getPrelimitDate(),
                    'prelimit' => $this->module->getPrelimit(),
                )
            );
        }
        
        $this->context->smarty->assign(
            array(
                'currencyIso' => $this->module->getShopCurrencyIso(),
                'currencySign' => $this->module->getShopCurrencySign(),
            )
        );
        
        $output = $this->context->smarty->fetch($this->module->getModuleLocalPath().'views/templates/admin/status.tpl');
        return $output;
    }
}
