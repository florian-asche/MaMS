<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 13:16:50
         compiled from "templates/greensky/dashboard_objects/ethersex_door_stateonly.tpl" */ ?>
<?php /*%%SmartyHeaderCode:39811210156a21db2d4be80-14513263%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2343d3a54d475043ae3cbffe85db06d7f3fa91f8' => 
    array (
      0 => 'templates/greensky/dashboard_objects/ethersex_door_stateonly.tpl',
      1 => 1424478030,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '39811210156a21db2d4be80-14513263',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
    'objektdata' => 0,
    'default_configuration' => 0,
    'selected_template' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a21db2eb4966_43718283',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a21db2eb4966_43718283')) {function content_56a21db2eb4966_43718283($_smarty_tpl) {?><table class="object" bgcolor="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['backgroundcolor'];?>
">
    <tr>
        <td class="object_header" colspan="3">
            <a class="object_header_text" href='api.php?action=get_mouseover&pageobjectid=<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
' onmouseover="Tip(TooltipTxt('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
'))" onmouseout="UnTip()"><?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['x'];?>
.<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['y'];?>
 <?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['name'];?>
</a>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="object_content">
            <div class="object_message" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
__messagebefore"></div>
            <div class="object_data"><?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['door_state'];?>
<?php echo $_smarty_tpl->tpl_vars['default_configuration']->value['datatypes']['door_state']['unit'];?>
</div>
            <div class="object_message" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
__messageafter"></div>
           
            <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/time.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
         
        </td>
    </tr>
</table><?php }} ?>
