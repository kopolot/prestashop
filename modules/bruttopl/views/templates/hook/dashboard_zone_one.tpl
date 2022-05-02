{*
* 2007-2021 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2022 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}


<section id="bruttopl-widget-zone-one" class="panel widget">
	<div class="panel-heading"> <i class="icon-money"></i> {$panelTitle|escape:'html':'UTF-8'} </div>
        
    {if isset($registered) && $registered}
    
        <div class="row">
            <div class="col-md-6">
                <h4 class="text-center">{l s='Granted' mod='bruttopl' }</h4>
                 
                <h4 class="text-center">
                    <strong>{if isset($grantedLimit)}{$grantedLimit|number_format:0:".":" "|escape:'html':'UTF-8'} {else}  ? {/if} {$currencySign|escape:'html':'UTF-8'}</strong>
                </h4>
             
            </div>
            <div class="col-md-6">
            
                <h4 class="text-center">{l s='Available' mod='bruttopl' }</p>
                 
                <h4 class="text-center">
                    <strong class="text-primary">{if isset($availableLimit)}{$availableLimit|number_format:0:".":" "|escape:'html':'UTF-8'} {else}  ? {/if} {$currencySign|escape:'html':'UTF-8'} </strong>
                </h4>
            </div>
        </div>
        
        <hr />

        <div class="row">
        
            <div class="col-md-6">  
                <p class="pull-left">
                    <a href="{$link->getAdminLink('AdminModules', true)|escape:'html':'UTF-8'}&configure=bruttopl"> {l s='Configuration' mod='bruttopl'}</a>
                </p>    
            </div>
            
            <div class="col-md-6">  
                <p class="pull-right">
                    <a class="btn btn-info btn-lg" href="https://www.brutto.pl/o/w/">{l s='Get funding' mod='bruttopl' }</a>
                </p>
            </div>
        </div>
       
    {else}    
        
          <div class="row"> 
            <div class="col-md-6">
                <h4 class="text-center">{l s='Total turnover' mod='bruttopl' }<br />{l s='for the last year' mod='bruttopl' }</h4>
                 
                <h4 class="text-center">
                    <strong>{if isset($incomeTotal)}{$incomeTotal|number_format:0:".":" "|escape:'html':'UTF-8'} {else}  ? {/if} {$currencySign|escape:'html':'UTF-8'}</strong>
                </h4>
             
            </div>
            
            <div class="col-md-6">
                <h4 class="text-center">{l s='Initial ' mod='bruttopl' }<br />{l s='funding limit' mod='bruttopl' }</h4>
                 
                <h4 class="text-center ">
                    <strong class="text-primary">{if isset($prelimit)}{$prelimit|number_format:0:".":" "|escape:'html':'UTF-8'} {else}  ? {/if} {$currencySign|escape:'html':'UTF-8'} </strong>
                </h4>
             
            </div>
             <div class="col-md-12">
             <hr />
             
             <h5>{l s='Limit check date' mod='bruttopl' }:  <span class="" title="{$prelimitDate|escape:'html':'UTF-8'}">{if isset($prelimitDate)} {$prelimitDate|date_format:"%Y-%m-%d"|escape:'html':'UTF-8'} {else} ? {/if}</span></h5>
             
             <hr />
             
             </div>
        </div>
    
        <p class="text-center">
            <a href="{$link->getAdminLink('AdminBruttoplStatus', true)|escape:'html':'UTF-8'}&recalculate">{l s='Recalculate' mod='bruttopl' }</a>
        </p>
        
        <p class="text-center">
            <a class="btn btn-info btn-lg" href="{$link->getAdminLink('AdminBruttoplRegister', true)|escape:'html':'UTF-8'}">{l s='Get funding' mod='bruttopl' }</a>
        </p>
        
        <p class="text-center">
            {l s='Find out' mod='bruttopl'} <a href="https://www.brutto.pl/produkt/pozyczki/">{l s='more' mod='bruttopl'}</a><br />{l s='or call  22 699 97 32' mod='bruttopl'}
        </p>
    {/if}
        
	
</section>    