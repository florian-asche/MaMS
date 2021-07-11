<?php /* Smarty version Smarty-3.1.18, created on 2016-02-04 20:40:57
         compiled from "templates/afterlife/control_panels/switch.tpl" */ ?>
<?php /*%%SmartyHeaderCode:51134068856b3a949612bf6-12305804%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b7b42858998665a45fa71fbcd9cfe906e8a45ee' => 
    array (
      0 => 'templates/afterlife/control_panels/switch.tpl',
      1 => 1444504700,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '51134068856b3a949612bf6-12305804',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56b3a949678890_71968285',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b3a949678890_71968285')) {function content_56b3a949678890_71968285($_smarty_tpl) {?></td></tr>
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
