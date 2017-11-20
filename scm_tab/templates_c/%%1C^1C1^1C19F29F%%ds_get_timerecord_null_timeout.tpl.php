<?php /* Smarty version 2.6.19, created on 2010-03-23 09:53:07
         compiled from ds_get_timerecord_null_timeout.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ds_get_timerecord_null_timeout.tpl', 5, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>

<response>
    <status><?php echo ((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</status>
    <message><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</message>
    <null_timeout_records>
        <?php $_from = $this->_tpl_vars['null_timeout_records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['time_record']):
?>
            <time_record
                timerecord_id="<?php echo $this->_tpl_vars['time_record']['id']; ?>
"
                userid="<?php echo $this->_tpl_vars['time_record']['userid']; ?>
" 
                time_in="<?php echo $this->_tpl_vars['time_record']['time_in']; ?>
"
                mode="<?php echo $this->_tpl_vars['time_record']['mode']; ?>
"
                />
        <?php endforeach; endif; unset($_from); ?>
    </null_timeout_records>
</response>