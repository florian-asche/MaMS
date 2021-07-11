<?php /* Smarty version Smarty-3.1.18, created on 2016-02-04 20:40:56
         compiled from "templates/afterlife/dashboard_object.tpl" */ ?>
<?php /*%%SmartyHeaderCode:153198856856b3a9489b5af9-63028677%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0589c264de3c196ab25b09a92bef40fc3de58d08' => 
    array (
      0 => 'templates/afterlife/dashboard_object.tpl',
      1 => 1444504709,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '153198856856b3a9489b5af9-63028677',
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
  'unifunc' => 'content_56b3a948a868e7_03647114',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b3a948a868e7_03647114')) {function content_56b3a948a868e7_03647114($_smarty_tpl) {?><?php if (file_exists("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/dashboard_objects/".((string)$_smarty_tpl->tpl_vars['objekt']->value['objects']['template']).".tpl")) {?>
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
