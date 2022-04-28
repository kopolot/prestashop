<?php
/* Smarty version 3.1.43, created on 2022-04-28 13:04:50
  from 'C:\xampp7.4.28\htdocs\presta\themes\classic\templates\page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_626a74d2225c28_02204012',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6cbf7d5667230f42947975f812af54fe161f80d2' => 
    array (
      0 => 'C:\\xampp7.4.28\\htdocs\\presta\\themes\\classic\\templates\\page.tpl',
      1 => 1647359402,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_626a74d2225c28_02204012 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_679643495626a74d2206827_30976563', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['layout']->value);
}
/* {block 'page_title'} */
class Block_1565321985626a74d220e520_55639236 extends Smarty_Internal_Block
{
public $callsChild = 'true';
public $hide = 'true';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <header class="page-header">
          <h1><?php 
$_smarty_tpl->inheritance->callChild($_smarty_tpl, $this);
?>
</h1>
        </header>
      <?php
}
}
/* {/block 'page_title'} */
/* {block 'page_header_container'} */
class Block_2090385613626a74d220a6a1_55630092 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1565321985626a74d220e520_55639236', 'page_title', $this->tplIndex);
?>

    <?php
}
}
/* {/block 'page_header_container'} */
/* {block 'page_content_top'} */
class Block_602250318626a74d2216222_86802255 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'page_content'} */
class Block_733712720626a74d221a0a5_47728753 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Page content -->
        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_618629828626a74d22123a8_35506354 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <div id="content" class="page-content card card-block">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_602250318626a74d2216222_86802255', 'page_content_top', $this->tplIndex);
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_733712720626a74d221a0a5_47728753', 'page_content', $this->tplIndex);
?>

      </div>
    <?php
}
}
/* {/block 'page_content_container'} */
/* {block 'page_footer'} */
class Block_2125209366626a74d2221da9_98207878 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Footer content -->
        <?php
}
}
/* {/block 'page_footer'} */
/* {block 'page_footer_container'} */
class Block_1782584110626a74d221df26_86519165 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <footer class="page-footer">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2125209366626a74d2221da9_98207878', 'page_footer', $this->tplIndex);
?>

      </footer>
    <?php
}
}
/* {/block 'page_footer_container'} */
/* {block 'content'} */
class Block_679643495626a74d2206827_30976563 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_679643495626a74d2206827_30976563',
  ),
  'page_header_container' => 
  array (
    0 => 'Block_2090385613626a74d220a6a1_55630092',
  ),
  'page_title' => 
  array (
    0 => 'Block_1565321985626a74d220e520_55639236',
  ),
  'page_content_container' => 
  array (
    0 => 'Block_618629828626a74d22123a8_35506354',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_602250318626a74d2216222_86802255',
  ),
  'page_content' => 
  array (
    0 => 'Block_733712720626a74d221a0a5_47728753',
  ),
  'page_footer_container' => 
  array (
    0 => 'Block_1782584110626a74d221df26_86519165',
  ),
  'page_footer' => 
  array (
    0 => 'Block_2125209366626a74d2221da9_98207878',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


  <section id="main">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2090385613626a74d220a6a1_55630092', 'page_header_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_618629828626a74d22123a8_35506354', 'page_content_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1782584110626a74d221df26_86519165', 'page_footer_container', $this->tplIndex);
?>


  </section>

<?php
}
}
/* {/block 'content'} */
}
