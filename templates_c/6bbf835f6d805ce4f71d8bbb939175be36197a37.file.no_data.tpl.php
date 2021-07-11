<?php /* Smarty version Smarty-3.1.18, created on 2016-02-04 20:40:57
         compiled from "templates/afterlife/dashboard_objects/no_data.tpl" */ ?>
<?php /*%%SmartyHeaderCode:183015259356b3a9491e1631-71334368%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6bbf835f6d805ce4f71d8bbb939175be36197a37' => 
    array (
      0 => 'templates/afterlife/dashboard_objects/no_data.tpl',
      1 => 1444504706,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183015259356b3a9491e1631-71334368',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56b3a949487879_16838358',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b3a949487879_16838358')) {function content_56b3a949487879_16838358($_smarty_tpl) {?><table class="object" bgcolor="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['backgroundcolor'];?>
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
                NO DATA
                <br>
                ID=<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['ID'];?>

            </div>
            
            <div class="object_message" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
__messageafter"></div>

            
        </td>
    </tr>
</table><?php }} ?>
