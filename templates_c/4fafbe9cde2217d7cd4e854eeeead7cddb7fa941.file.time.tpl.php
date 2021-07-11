<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 13:16:49
         compiled from "templates/greensky/time.tpl" */ ?>
<?php /*%%SmartyHeaderCode:173069980056a21db19183f2-95697446%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4fafbe9cde2217d7cd4e854eeeead7cddb7fa941' => 
    array (
      0 => 'templates/greensky/time.tpl',
      1 => 1449603094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173069980056a21db19183f2-95697446',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objektdata' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a21db1999ce9_91798746',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a21db1999ce9_91798746')) {function content_56a21db1999ce9_91798746($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/html/mams/lib/Smarty-3.1.18/libs/plugins/modifier.date_format.php';
?></td></tr>
<tr>

<td class="object_time" colspan="3">
    <p align="center" >
        <font size="2">
        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['objektdata']->value['timestampdiff'];?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp2<"90") {?>
            vor <?php echo $_smarty_tpl->tpl_vars['objektdata']->value['timestampdifftext'];?>

        <?php } else { ?>
            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['objektdata']->value['timestamp'],"%d.%m.%Y");?>
 um <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['objektdata']->value['timestamp'],"%H:%M:%S");?>
 Uhr
        <?php }?>
        </font>
    </p>
</td>
<?php }} ?>
