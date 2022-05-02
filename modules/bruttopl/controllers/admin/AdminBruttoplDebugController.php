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

class AdminBruttoplDebugController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();
    }

    public function init()
    {
        // No cache for auto-refresh uploaded logo
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

       
        parent::init();
    }

    public function initContent()
    {
        $this->display = "view";
        
        parent::initContent();
    }
    
    
    protected function getConfiguratation($prefix = 'JASHBRUTTO_')
    {
        return Db::getInstance()->executeS(
            "SELECT * FROM "._DB_PREFIX_."configuration WHERE name LIKE '".$prefix."%' "
        );
    }
    
    public function renderView()
    {
        $prelimitData = ['sales'=>[
            'currency' => $this->module->getShopCurrencyIso(),
            'income'=>$this->module->getSales()['income'],
            'transactions'=>$this->module->getSales()['transactions']
        ]] ;
        
        $this->context->smarty->assign(
            array(
                'sales'=> $this->module->getSales(),
                'incomeTotal' =>$this->module->getIncomeTotal(),
                'configuration' =>$this->getConfiguratation(),
                "callPrelimit" => $this->module->callApiPrelimit($prelimitData),
                "callLimit" => $this->module->callApiLimit()
            )
        );
        $output = $this->context->smarty->fetch($this->module->getModuleLocalPath().'views/templates/admin/debug.tpl');
        return $output;
    }
}
