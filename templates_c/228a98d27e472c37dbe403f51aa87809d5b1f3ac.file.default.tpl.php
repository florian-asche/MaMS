<?php /* Smarty version Smarty-3.1.18, created on 2016-02-04 20:40:57
         compiled from "templates/afterlife/control_panels/default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:158152936456b3a949ab8246-40783631%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '228a98d27e472c37dbe403f51aa87809d5b1f3ac' => 
    array (
      0 => 'templates/afterlife/control_panels/default.tpl',
      1 => 1444504699,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '158152936456b3a949ab8246-40783631',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56b3a949c5b188_67302516',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b3a949c5b188_67302516')) {function content_56b3a949c5b188_67302516($_smarty_tpl) {?></td></tr>
<tr align="center">


<td class="object_control_panel">
<form id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn2" onsubmit="FormSubmitRequest('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn2', '<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
');">
<input type="hidden" id="action_wert1" name="action_wert1" value="100">
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
<form onkeypress="return event.keyCode != 13;" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn1" onsubmit="FormSubmitRequest('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn1', '<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
');">
<input type="text" size="1px" id="action_wert1" name="action_wert1" value="" onkeyup="if(event.keyCode==13) FormSubmitRequest('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn1', '<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
');">
<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
">
<input type="hidden" id="function" name="function" value="send_data">
<input type="hidden" id="function" name="priority" value="10">
<input type="button" value="X" onkeyup="FormSubmitRequest('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn1', '<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
');" onClick="FormSubmitRequest('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
btn1', '<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
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
