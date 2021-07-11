<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 13:16:49
         compiled from "templates/greensky/dashboard_objects/special-clock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:173626960956a21db1e12883-38789045%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d9509ec36fba94fa623166629b743a4d20cde8d' => 
    array (
      0 => 'templates/greensky/dashboard_objects/special-clock.tpl',
      1 => 1425069378,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173626960956a21db1e12883-38789045',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a21db20d78c1_14219189',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a21db20d78c1_14219189')) {function content_56a21db20d78c1_14219189($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/html/mams/lib/Smarty-3.1.18/libs/plugins/modifier.date_format.php';
?><table class="object" bgcolor="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['backgroundcolor'];?>
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
                Uhrzeit:
                <b>
                    <?php echo smarty_modifier_date_format(time(),"%H:%M:%S");?>

                </b>
                <br>
                Datum: 
                <b>
                    <?php echo smarty_modifier_date_format(time(),"%d.%m.%Y");?>

                </b>
            </div>
            <div class="object_message" id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
__messageafter"></div>
        </td>
    </tr>
</table><?php }} ?>
