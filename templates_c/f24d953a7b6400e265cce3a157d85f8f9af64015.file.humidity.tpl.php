<?php /* Smarty version Smarty-3.1.18, created on 2016-02-04 20:40:56
         compiled from "templates/afterlife/dashboard_objects/humidity.tpl" */ ?>
<?php /*%%SmartyHeaderCode:149054143056b3a948dccac6-71614190%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f24d953a7b6400e265cce3a157d85f8f9af64015' => 
    array (
      0 => 'templates/afterlife/dashboard_objects/humidity.tpl',
      1 => 1444504705,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149054143056b3a948dccac6-71614190',
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
  'unifunc' => 'content_56b3a949063f60_59668349',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b3a949063f60_59668349')) {function content_56b3a949063f60_59668349($_smarty_tpl) {?><table class="object" bgcolor="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['backgroundcolor'];?>
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
                <?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['temperature_c'];?>
<?php echo $_smarty_tpl->tpl_vars['default_configuration']->value['datatypes']['temperature_c']['unit'];?>
 & <?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['humidity'];?>
<?php echo $_smarty_tpl->tpl_vars['default_configuration']->value['datatypes']['humidity']['unit'];?>

            </div>
            
            <div class="object_message" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
__messageafter"></div>

            <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['selected_template']->value)."/time.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </td>
    </tr>
</table><?php }} ?>
