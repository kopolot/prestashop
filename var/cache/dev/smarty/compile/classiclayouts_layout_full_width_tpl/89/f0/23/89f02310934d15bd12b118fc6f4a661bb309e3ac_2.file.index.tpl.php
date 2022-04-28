<?php
/* Smarty version 3.1.43, created on 2022-04-28 13:04:50
  from 'C:\xampp7.4.28\htdocs\presta\themes\classic\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_626a74d21ef119_98484618',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '89f02310934d15bd12b118fc6f4a661bb309e3ac' => 
    array (
      0 => 'C:\\xampp7.4.28\\htdocs\\presta\\themes\\classic\\templates\\index.tpl',
      1 => 1647359402,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_626a74d21ef119_98484618 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1733201658626a74d21df714_81658029', 'page_content_container');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'page.tpl');
}
/* {block 'page_content_top'} */
class Block_1666480649626a74d21e3599_53595859 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'hook_home'} */
class Block_1424752505626a74d21eb290_72115838 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>

          <?php
}
}
/* {/block 'hook_home'} */
/* {block 'page_content'} */
class Block_447939766626a74d21e7419_44378116 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1424752505626a74d21eb290_72115838', 'hook_home', $this->tplIndex);
?>

        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_1733201658626a74d21df714_81658029 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page_content_container' => 
  array (
    0 => 'Block_1733201658626a74d21df714_81658029',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_1666480649626a74d21e3599_53595859',
  ),
  'page_content' => 
  array (
    0 => 'Block_447939766626a74d21e7419_44378116',
  ),
  'hook_home' => 
  array (
    0 => 'Block_1424752505626a74d21eb290_72115838',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-home">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1666480649626a74d21e3599_53595859', 'page_content_top', $this->tplIndex);
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_447939766626a74d21e7419_44378116', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
}
