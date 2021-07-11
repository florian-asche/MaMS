<?php /* Smarty version Smarty-3.1.18, created on 2016-02-04 20:40:56
         compiled from "templates/afterlife/dashboard_objects/special-clock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:151045183456b3a948d3a115-64965117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '145a8b3d7f8db24fcddb00b7138eeed78150eb1c' => 
    array (
      0 => 'templates/afterlife/dashboard_objects/special-clock.tpl',
      1 => 1444504706,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '151045183456b3a948d3a115-64965117',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56b3a948f2b6e2_85021604',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b3a948f2b6e2_85021604')) {function content_56b3a948f2b6e2_85021604($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/html/mams/lib/Smarty-3.1.18/libs/plugins/modifier.date_format.php';
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
