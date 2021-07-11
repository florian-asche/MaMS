<?php /* Smarty version Smarty-3.1.18, created on 2016-02-04 20:40:57
         compiled from "templates/afterlife/dashboard_objects/wind_direction.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22430149756b3a94a00d440-83363836%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0983ad7a99e34e77e7a31d4e4381321931c1993' => 
    array (
      0 => 'templates/afterlife/dashboard_objects/wind_direction.tpl',
      1 => 1444504707,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22430149756b3a94a00d440-83363836',
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
  'unifunc' => 'content_56b3a94a30d083_71654696',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b3a94a30d083_71654696')) {function content_56b3a94a30d083_71654696($_smarty_tpl) {?><table class="object" bgcolor="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['backgroundcolor'];?>
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
                <?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['wind_direction'];?>
<?php echo $_smarty_tpl->tpl_vars['default_configuration']->value['datatypes']['wind_direction']['unit'];?>
 (<?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['percentage'];?>
<?php echo $_smarty_tpl->tpl_vars['default_configuration']->value['datatypes']['percentage']['unit'];?>
)
            </div>
            
            
            
            <div class="object_message" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
__messageafter"></div>

            <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/time.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </td>
    </tr>
</table><?php }} ?>
