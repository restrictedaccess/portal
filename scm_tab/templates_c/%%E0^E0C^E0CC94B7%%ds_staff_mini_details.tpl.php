<?php /* Smarty version 2.6.19, created on 2010-03-22 15:15:29
         compiled from ds_staff_mini_details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ds_staff_mini_details.tpl', 5, false),array('modifier', 'date_format', 'ds_staff_mini_details.tpl', 13, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>

<response>
    <status><?php echo ((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</status>
    <message><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</message>
    <staff userid="<?php echo $this->_tpl_vars['staff']['userid']; ?>
" 
            lname="<?php echo $this->_tpl_vars['staff']['lname']; ?>
"
            fname="<?php echo $this->_tpl_vars['staff']['fname']; ?>
"
            email="<?php echo $this->_tpl_vars['staff']['email']; ?>
"
            skype_id="<?php echo $this->_tpl_vars['staff']['skype_id']; ?>
"
            image="<?php echo $this->_tpl_vars['staff']['image']; ?>
"
            last_snapshot_date="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff']['last_snapshot_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"
            last_snapshot_time="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff']['last_snapshot_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%r") : smarty_modifier_date_format($_tmp, "%r")); ?>
"
            last_machine_reported_date="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff']['last_machine_reported_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"
            last_machine_reported_time="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff']['last_machine_reported_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%r") : smarty_modifier_date_format($_tmp, "%r")); ?>
"
            last_activity_note_date="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff']['last_activity_note_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"
            last_activity_note_time="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff']['last_activity_note_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%r") : smarty_modifier_date_format($_tmp, "%r")); ?>
"
            subcontractors_id="<?php echo $this->_tpl_vars['staff']['subcontractors_id']; ?>
"
            leads_id="<?php echo $this->_tpl_vars['staff']['leads_id']; ?>
"
            leads_name="<?php echo $this->_tpl_vars['staff']['leads_name']; ?>
"
            status="<?php echo $this->_tpl_vars['staff']['status']; ?>
"
        />
</response>