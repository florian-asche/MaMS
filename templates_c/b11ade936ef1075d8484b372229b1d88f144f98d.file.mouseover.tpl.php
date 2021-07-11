<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 13:19:15
         compiled from "templates/greensky/mouseover.tpl" */ ?>
<?php /*%%SmartyHeaderCode:77330412456a21e43f3c283-23928809%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b11ade936ef1075d8484b372229b1d88f144f98d' => 
    array (
      0 => 'templates/greensky/mouseover.tpl',
      1 => 1420113665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '77330412456a21e43f3c283-23928809',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
    'key' => 0,
    'selected_template' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a21e440ee333_02892462',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a21e440ee333_02892462')) {function content_56a21e440ee333_02892462($_smarty_tpl) {?><?php if (file_exists("templates/language/german.conf")) {?>
    <?php  $_config = new Smarty_Internal_Config("templates/language/german.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<?php } else { ?>
    Missing Languagefile: "templates/language/german.conf"
<?php }?>

<html>
<tbody>
<meta name="author" content="Florian Asche">
<link rel="shortcut icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="lib/mams.css">
<title>Measurement and Management System - Smart Home</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="pragma" content="no-cache">

<body>
<script type="text/javascript" src="lib/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="lib/mams.js"></script>
<script type="text/javascript" src="lib/wz_tooltip.js"></script>
</body>

<div class="mams_content_mouseover">
<table width="100%" border="0" class="mouseover_object" bgcolor="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['backgroundcolor'];?>
">
    <tr>
        <td class="object_header" colspan="3">
            <p class="object_header_text"><?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['x'];?>
.<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['y'];?>
 <?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['name'];?>
</p>
        </td>
    </tr>
    <tr>
        <td valign="top">
            <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['load_templates_mouseover']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                <br>
                <b><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
:</b>
                <br>
                <?php if (file_exists("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/mouseover/".((string)$_smarty_tpl->tpl_vars['value']->value))) {?>
                    <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/mouseover/".((string)$_smarty_tpl->tpl_vars['value']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                <?php } else { ?>
                    Missing template file: templates/<?php echo $_smarty_tpl->tpl_vars['selected_template']->value;?>
/mouseover/<?php echo $_smarty_tpl->tpl_vars['value']->value;?>

                <?php }?>
                <br>
            <?php } ?>
        </td>
        <td>
            <b>Grafik:</b>
            <br>
            <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/graph.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </td>
    </tr>
</table>
</div>
</html><?php }} ?>
