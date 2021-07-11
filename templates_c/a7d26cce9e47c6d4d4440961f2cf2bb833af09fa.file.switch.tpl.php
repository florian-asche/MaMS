<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 13:16:50
         compiled from "templates/greensky/control_panels/switch.tpl" */ ?>
<?php /*%%SmartyHeaderCode:137673054556a21db2387eb7-37734750%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7d26cce9e47c6d4d4440961f2cf2bb833af09fa' => 
    array (
      0 => 'templates/greensky/control_panels/switch.tpl',
      1 => 1424524106,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '137673054556a21db2387eb7-37734750',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a21db24c1e53_35654433',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a21db24c1e53_35654433')) {function content_56a21db24c1e53_35654433($_smarty_tpl) {?></td></tr>
<tr align="center">


<td class="object_control_panel">
<form id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn2" onsubmit="FormSubmitRequest('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn2', '<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
');">
<input type="hidden" id="action_wert1" name="action_wert1" value="1">
<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
">
<input type="hidden" id="function" name="function" value="send_data">
<input type="hidden" id="function" name="priority" value="10">
<input type="button" value="ON" onClick="FormSubmitRequest('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn2', '<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
');">
</form>
</td>


<td class="object_control_panel">
<form id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn3" onsubmit="FormSubmitRequest('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn3', '<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
');">
<input type="hidden" id="action_wert1" name="action_wert1" value="0">
<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
">
<input type="hidden" id="function" name="function" value="send_data">
<input type="hidden" id="function" name="priority" value="10">
<input type="button" value="OFF" onClick="FormSubmitRequest('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn3', '<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
');">
</form>

</td></tr><?php }} ?>
