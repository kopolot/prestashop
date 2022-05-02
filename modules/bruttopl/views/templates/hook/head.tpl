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

{if $is_new}
<script>
        $( document ).ready(function() {
             $('#maintab-AdminBruttoplStatus').addClass("new");
             $('#tab-AdminBruttoplStatus').addClass("new");
             $('#maintab-AdminBruttoplStatus a span:first').attr('data-newlabel', '{l s='New' mod='bruttopl'}');
             $('#tab-AdminBruttoplStatus span:first').attr('data-newlabel', '{l s='New' mod='bruttopl'}');
             
        })
</script>
{/if}

<script>
    $( document ).ready(function() {
    
        $('form.AdminBruttoplRegister #nip, form.AdminBruttoplRegister #phone').on('input', function(){
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $('#brutto-marketing-expand').toggle();
        $('[href=#brutto-marketing-expand]').on('click', function(){
                $(this).text($(this).text() == $(this).attr('data-collapse-label') ? $(this).attr('data-expand-label') : $(this).attr('data-collapse-label') );
                $($(this).attr('href')).toggle();
        }); 
    });
</script>