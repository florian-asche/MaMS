<?php /* Smarty version Smarty-3.1.18, created on 2016-02-01 20:05:52
         compiled from "templates/setup/Objects_table.tpl" */ ?>
<?php /*%%SmartyHeaderCode:65411575156afac9062b117-30131698%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53b19c75a3226c7a9960010afba7f7bbe35449a3' => 
    array (
      0 => 'templates/setup/Objects_table.tpl',
      1 => 1439324668,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65411575156afac9062b117-30131698',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pages' => 0,
    'page' => 0,
    'page_objects' => 0,
    'tabledata_array' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56afac907366f2_84833497',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56afac907366f2_84833497')) {function content_56afac907366f2_84833497($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/var/www/html/mams/lib/Smarty-3.1.18/libs/plugins/function.cycle.php';
?><?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->_loop = true;
?>
    <a class="table_menu_button" href="setup.php?page=Objects&action=page_edit&selected_id=<?php echo $_smarty_tpl->tpl_vars['page']->value['ID'];?>
"><h2>[<?php echo $_smarty_tpl->tpl_vars['page']->value['ID'];?>
] <?php echo $_smarty_tpl->tpl_vars['page']->value['name'];?>
 (<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['page']->value['active'];?>
<?php $_tmp3=ob_get_clean();?><?php if ($_tmp3=="1") {?>active<?php } else {?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['page']->value['active'];?>
<?php $_tmp4=ob_get_clean();?><?php if ($_tmp4=="0") {?>inactive<?php } else { ?>error<?php }}?>)</h2></a>
    
    <table border = "0">
        <thead>
        <tr>
            <th align="left" colspan="5">
                <a class="table_menu_button" href="setup.php?page=Objects&action=object_add_start&selected_id=<?php echo $_smarty_tpl->tpl_vars['page']->value['ID'];?>
">Add a new Object...</a>
            </th>
        </tr>
            <tr>
                <th style="background-color: #d0d0d0"><font color="black">ID</font></th>
                <th style="background-color: #d0d0d0"><font color="black">X</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Y</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Name</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Object ID</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Link to Device</font></th>
                <th style="background-color: #d0d0d0"><font color="black">Status</font></th>
                <th colspan="3" style="background-color: #d0d0d0"><font color="black">Options</font></th>
            </tr>
        </thead>
        <tbody>
        <?php  $_smarty_tpl->tpl_vars['tabledata_array'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tabledata_array']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['page_objects']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tabledata_array']->key => $_smarty_tpl->tpl_vars['tabledata_array']->value) {
$_smarty_tpl->tpl_vars['tabledata_array']->_loop = true;
?>
            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['pageid'];?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['page']->value['ID'];?>
<?php $_tmp6=ob_get_clean();?><?php if ($_tmp5==$_tmp6) {?>
                <tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#eeeeee,#d0d0d0"),$_smarty_tpl);?>
">
                    <td><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['ID'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['x'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['y'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['objects']['name'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['objectid'];?>
</td>
                    <td>
                    <?php if (isset($_smarty_tpl->tpl_vars['tabledata_array']->value['station_protocols']['info'])) {?>
                        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['station_protocols']['info'];?>
<?php $_tmp7=ob_get_clean();?><?php if ($_tmp7) {?>
                            <?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['station_protocols']['info'];?>

                            ID=<?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['station_protocols']['ID'];?>
 CLASS=<?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['station_protocols']['class'];?>

                        <?php }?>
                    <?php }?>
                    </td>
                    <td>
                        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['active'];?>
<?php $_tmp8=ob_get_clean();?><?php if ($_tmp8=="0") {?>
                            inactive
                        <?php } else {?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['active'];?>
<?php $_tmp9=ob_get_clean();?><?php if ($_tmp9=="1") {?>
                            active
                        <?php } else { ?>
                            error
                        <?php }}?>
                    </td>
                        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['active'];?>
<?php $_tmp10=ob_get_clean();?><?php if ($_tmp10=="0") {?>
                            <td><a class="table_menu_button" href="setup.php?page=Objects&action=object_activate&selected_id=<?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['ID'];?>
">activate</a></td>
                        <?php } else {?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['active'];?>
<?php $_tmp11=ob_get_clean();?><?php if ($_tmp11=="1") {?>
                            <td><a class="table_menu_button" href="setup.php?page=Objects&action=object_deactivate&selected_id=<?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['ID'];?>
">deactivate</a></td>
                        <?php }}?>
                    <td><a class="table_menu_button" href="setup.php?page=Objects&action=object_edit&selected_id=<?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['ID'];?>
">edit</a></td>
                    <td><a onclick='return confirmSubmit();' class="table_menu_button" href="setup.php?page=Objects&action=object_delete&selected_id=<?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['page_objects']['ID'];?>
">delete</a></td>
                </tr>
            <?php }?>
        <?php } ?>
        </tbody>
    </table>
<?php } ?><?php }} ?>
