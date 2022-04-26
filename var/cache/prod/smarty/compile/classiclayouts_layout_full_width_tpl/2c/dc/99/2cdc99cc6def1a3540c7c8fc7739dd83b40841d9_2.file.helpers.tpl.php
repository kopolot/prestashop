<?php
/* Smarty version 3.1.43, created on 2022-04-26 14:06:31
  from 'C:\xampp7.4.28\htdocs\presta\themes\classic\templates\_partials\helpers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_6267e0478a31b3_63007716',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2cdc99cc6def1a3540c7c8fc7739dd83b40841d9' => 
    array (
      0 => 'C:\\xampp7.4.28\\htdocs\\presta\\themes\\classic\\templates\\_partials\\helpers.tpl',
      1 => 1647359402,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6267e0478a31b3_63007716 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'renderLogo' => 
  array (
    'compiled_filepath' => 'C:\\xampp7.4.28\\htdocs\\presta\\var\\cache\\prod\\smarty\\compile\\classiclayouts_layout_full_width_tpl\\2c\\dc\\99\\2cdc99cc6def1a3540c7c8fc7739dd83b40841d9_2.file.helpers.tpl.php',
    'uid' => '2cdc99cc6def1a3540c7c8fc7739dd83b40841d9',
    'call_name' => 'smarty_template_function_renderLogo_11484925006267e04789b4b3_39152452',
  ),
));
?> 

<?php }
/* smarty_template_function_renderLogo_11484925006267e04789b4b3_39152452 */
if (!function_exists('smarty_template_function_renderLogo_11484925006267e04789b4b3_39152452')) {
function smarty_template_function_renderLogo_11484925006267e04789b4b3_39152452(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

  <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['pages']['index'], ENT_QUOTES, 'UTF-8');?>
">
    <img
      class="logo img-fluid"
      src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['src'], ENT_QUOTES, 'UTF-8');?>
"
      alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
      width="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['width'], ENT_QUOTES, 'UTF-8');?>
"
      height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['height'], ENT_QUOTES, 'UTF-8');?>
">
  </a>
<?php
}}
/*/ smarty_template_function_renderLogo_11484925006267e04789b4b3_39152452 */
}
