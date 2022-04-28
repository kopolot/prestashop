<?php
/* Smarty version 3.1.43, created on 2022-04-28 12:56:14
  from 'module:customorderrefviewstempla' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_626a72ce47d593_73875095',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '21ec467d28750050e96b6caa9e05baf690e7e463' => 
    array (
      0 => 'module:customorderrefviewstempla',
      1 => 1651137768,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_626a72ce47d593_73875095 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- begin C:\xampp7.4.28\htdocs\presta/modules/customorderref/views/templates/admin/config.tpl --><?php if ($_smarty_tpl->tpl_vars['msg']->value != null) {?>
    <div class="alert alert-success" role="alert">
        <p class="alert-text">
            <?php echo $_smarty_tpl->tpl_vars['msg']->value;?>

        </p>
    </div>
<?php }?>
<div>
    <form method="POST" action="">
        <div class="form-select" style="margin-top:0.5rem; width:30%;">
            <h3>Domyślmie tworzy id od 1 rosnąco</h3>
            <select class="form-control custom-select" name="config" required>
                <option disabled selected>Wybierz sposób towrzenia id zamówienia</option>
                                <option value="1" <?php if ($_smarty_tpl->tpl_vars['value']->value == 1) {?>selected<?php }?>>liczby rosnące od 1</option>
                <option value="2" <?php if ($_smarty_tpl->tpl_vars['value']->value == 2) {?>selected<?php }?>>np. 0000-1111-2222-3333</option>
                <option value="3" <?php if ($_smarty_tpl->tpl_vars['value']->value == 3) {?>selected<?php }?>>na podstawie daty np. PL20220427103040</option>
            </select>
        </div>
        <div style="margin-top:1rem;">
            <button type="submit" class="btn btn-primary">Potwierdź</button>
        </div>
    </form>
</div><!-- end C:\xampp7.4.28\htdocs\presta/modules/customorderref/views/templates/admin/config.tpl --><?php }
}
