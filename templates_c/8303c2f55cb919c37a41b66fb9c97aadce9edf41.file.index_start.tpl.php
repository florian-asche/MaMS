<?php /* Smarty version Smarty-3.1.18, created on 2016-02-01 20:04:20
         compiled from "templates/setup/index_start.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31611877056afac3497ee11-23737463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8303c2f55cb919c37a41b66fb9c97aadce9edf41' => 
    array (
      0 => 'templates/setup/index_start.tpl',
      1 => 1406824636,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31611877056afac3497ee11-23737463',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'username' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56afac34985a58_67710587',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56afac34985a58_67710587')) {function content_56afac34985a58_67710587($_smarty_tpl) {?><h2>Hello <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
! You are now logged in...</h2>
You are on the Frontpage of the MaMS Setup.
<br>
You can choose from the menu what you want to do.
<?php }} ?>
