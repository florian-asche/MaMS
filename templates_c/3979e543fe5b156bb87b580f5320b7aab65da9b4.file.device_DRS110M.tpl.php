<?php /* Smarty version Smarty-3.1.18, created on 2016-02-04 20:40:56
         compiled from "templates/afterlife/dashboard_objects/device_DRS110M.tpl" */ ?>
<?php /*%%SmartyHeaderCode:178584677956b3a948a8e654-23178666%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3979e543fe5b156bb87b580f5320b7aab65da9b4' => 
    array (
      0 => 'templates/afterlife/dashboard_objects/device_DRS110M.tpl',
      1 => 1444504703,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '178584677956b3a948a8e654-23178666',
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
  'unifunc' => 'content_56b3a948af0eb3_29580142',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b3a948af0eb3_29580142')) {function content_56b3a948af0eb3_29580142($_smarty_tpl) {?><table class="object" bgcolor="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['backgroundcolor'];?>
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
            
            <div class="object_data">
                <?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['power'];?>
<?php echo $_smarty_tpl->tpl_vars['default_configuration']->value['datatypes']['power']['unit'];?>

                <br>
                <?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['active_power'];?>
<?php echo $_smarty_tpl->tpl_vars['default_configuration']->value['datatypes']['active_power']['unit'];?>

            </div>
            
            <div class="object_message" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
__messageafter"></div>

            <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/time.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </td>
    </tr>
</table><?php }} ?>
