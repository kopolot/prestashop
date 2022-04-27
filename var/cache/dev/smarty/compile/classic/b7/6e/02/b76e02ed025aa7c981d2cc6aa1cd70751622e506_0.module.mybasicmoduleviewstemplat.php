<?php
/* Smarty version 3.1.43, created on 2022-04-27 22:21:35
  from 'module:mybasicmoduleviewstemplat' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_6269a5cfa0ace4_19141155',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b76e02ed025aa7c981d2cc6aa1cd70751622e506' => 
    array (
      0 => 'module:mybasicmoduleviewstemplat',
      1 => 1651090853,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6269a5cfa0ace4_19141155 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- begin C:\xampp7.4.28\htdocs\presta/modules/mybasicmodule/views/templates/admin/config.tpl --><form action="" method="POST">
    <div class="form-group">
        <label class="form-control-label" for="input1">My module text</label>
        <input type="text" required class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['ocena_akademika']->value;?>
" id="input1" />
        
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form><!-- end C:\xampp7.4.28\htdocs\presta/modules/mybasicmodule/views/templates/admin/config.tpl --><?php }
}
