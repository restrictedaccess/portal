<?php /* Smarty version 2.6.19, created on 2010-03-23 05:39:15
         compiled from response.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'response.tpl', 5, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>

<response>
    <status><?php echo ((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</status>
    <message><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</message>
</response>