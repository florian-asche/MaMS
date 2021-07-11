<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 13:16:49
         compiled from "templates/greensky/dashboard_objects/no_data.tpl" */ ?>
<?php /*%%SmartyHeaderCode:207309945856a21db1cd9be2-91482274%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '16ebf0fa8f2712e3da8797abd48ba5a5ac57a76b' => 
    array (
      0 => 'templates/greensky/dashboard_objects/no_data.tpl',
      1 => 1424536017,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '207309945856a21db1cd9be2-91482274',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a21db200cb57_90822129',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a21db200cb57_90822129')) {function content_56a21db200cb57_90822129($_smarty_tpl) {?><table class="object" bgcolor="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['backgroundcolor'];?>
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
