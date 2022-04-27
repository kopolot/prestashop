<?php
/* Smarty version 3.1.43, created on 2022-04-27 19:57:36
  from 'C:\xampp7.4.28\htdocs\presta\themes\classic\templates\_partials\helpers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_6269841051c246_50034922',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2cdc99cc6def1a3540c7c8fc7739dd83b40841d9' => 
    array (
      0 => 'C:\\xampp7.4.28\\htdocs\\presta\\themes\\classic\\templates\\_partials\\helpers.tpl',
      1 => 1650982621,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6269841051c246_50034922 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'renderLogo' => 
  array (
    'compiled_filepath' => 'C:\\xampp7.4.28\\htdocs\\presta\\var\\cache\\dev\\smarty\\compile\\classiclayouts_layout_full_width_tpl\\2c\\dc\\99\\2cdc99cc6def1a3540c7c8fc7739dd83b40841d9_2.file.helpers.tpl.php',
    'uid' => '2cdc99cc6def1a3540c7c8fc7739dd83b40841d9',
    'call_name' => 'smarty_template_function_renderLogo_1795971323626984105170e5_86454293',
  ),
));
?> 

<?php }
/* smarty_template_function_renderLogo_1795971323626984105170e5_86454293 */
if (!function_exists('smarty_template_function_renderLogo_1795971323626984105170e5_86454293')) {
function smarty_template_function_renderLogo_1795971323626984105170e5_86454293(Smarty_Internal_Template $_smarty_tpl,$params) {
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
/*/ smarty_template_function_renderLogo_1795971323626984105170e5_86454293 */
}
