<?php /* Smarty version 2.6.19, created on 2010-03-22 15:15:32
         compiled from ds_previous_month_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ds_previous_month_list.tpl', 5, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>

<response>
    <status><?php echo ((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</status>
    <message><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</message>
    <months>
        <?php $_from = $this->_tpl_vars['available_months']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['month']):
?>
            <month desc="<?php echo $this->_tpl_vars['month']; ?>
" value="<?php echo $this->_tpl_vars['k']; ?>
"/>
        <?php endforeach; endif; unset($_from); ?>
    </months>
</response>