<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 13:16:49
         compiled from "templates/greensky/dashboard_object.tpl" */ ?>
<?php /*%%SmartyHeaderCode:117945689556a21db15ec942-56578055%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '94a7454bae64e6d23e70456443b98ca4cf7188d8' => 
    array (
      0 => 'templates/greensky/dashboard_object.tpl',
      1 => 1425141698,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '117945689556a21db15ec942-56578055',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'selected_template' => 0,
    'objekt' => 0,
    'objektdata' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a21db190bee7_79999515',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a21db190bee7_79999515')) {function content_56a21db190bee7_79999515($_smarty_tpl) {?><?php if (file_exists("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/dashboard_objects/".((string)$_smarty_tpl->tpl_vars['objekt']->value['objects']['template']).".tpl")) {?>
    <?php if (isset($_smarty_tpl->tpl_vars['objektdata']->value['timestampdiff'])) {?>
        <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/dashboard_objects/".((string)$_smarty_tpl->tpl_vars['objekt']->value['objects']['template']).".tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php } else {?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['template'];?>
<?php $_tmp1=ob_get_clean();?><?php if (preg_match("/special-(.*)/",$_tmp1)) {?>
        <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/dashboard_objects/".((string)$_smarty_tpl->tpl_vars['objekt']->value['objects']['template']).".tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php } else { ?>
        <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/dashboard_objects/no_data.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php }}?>
<?php } else { ?>
    <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/dashboard_objects/no_tpl.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php }} ?>
