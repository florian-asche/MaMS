<?php /* Smarty version Smarty-3.1.18, created on 2016-04-16 21:50:28
         compiled from "templates/greensky/dashboard_objects/no_tpl.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1791087678571297844943a1-43027538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '968bcd8e4a78909e3f470a40b92e50ae4d0f648f' => 
    array (
      0 => 'templates/greensky/dashboard_objects/no_tpl.tpl',
      1 => 1424007958,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1791087678571297844943a1-43027538',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5712978452a609_69414130',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5712978452a609_69414130')) {function content_5712978452a609_69414130($_smarty_tpl) {?><table class="object" bgcolor="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['backgroundcolor'];?>
">
    <tr>
        <td class="object_header" colspan="3">
            <?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['x'];?>
.<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['y'];?>
 <?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['name'];?>

        </td>
    </tr>
    <tr>
        <td colspan="3" class="object_content">
            <div class="object_message" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
__messagebefore"></div>
            
            <div class="object_data">
                NO TPL
            </div>
            
            <div class="object_message" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
__messageafter"></div>

            
        </td>
    </tr>
</table><?php }} ?>
