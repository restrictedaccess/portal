<?php /* Smarty version 2.6.19, created on 2010-03-22 15:15:36
         compiled from ds_get_staff_time_sheet.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ds_get_staff_time_sheet.tpl', 11, false),array('modifier', 'date_format', 'ds_get_staff_time_sheet.tpl', 18, false),array('modifier', 'replace', 'ds_get_staff_time_sheet.tpl', 34, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>

<response>
    <status><?php echo ((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</status>
    <message><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</message>
    <admin_status adjust_time_sheet="<?php echo $this->_tpl_vars['adjust_time_sheet']; ?>
" force_logout="<?php echo $this->_tpl_vars['force_logout']; ?>
"/>
    <time_records>
        <?php $_from = $this->_tpl_vars['time_records_final']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['time_record']):
?>
            <time_record 
                record_id="<?php echo $this->_tpl_vars['time_record']['id']; ?>
"
                day_of_week="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['day_of_week'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%a %d/%y") : smarty_modifier_date_format($_tmp, "%a %d/%y")); ?>
" 
                day="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['day_of_week'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%a") : smarty_modifier_date_format($_tmp, "%a")); ?>
" 
                of_week="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['day_of_week'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d")); ?>
" 
                date="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['day_of_week'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
" 
                <?php if (( ( ((is_array($_tmp=$this->_tpl_vars['time_record']['day_of_week'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%a") : smarty_modifier_date_format($_tmp, "%a")) == 'Sat' ) || ( ((is_array($_tmp=$this->_tpl_vars['time_record']['day_of_week'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%a") : smarty_modifier_date_format($_tmp, "%a")) == 'Sun' ) )): ?>
                    bullet_color="#8D8D8D"
                <?php endif; ?>
                start="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['time_in'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" 
                end="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['time_out'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" 
                client="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['fname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['lname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['company_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
                total_lunch_hrs="<?php echo $this->_tpl_vars['time_record']['total_lunch_hrs']; ?>
"
                computed_total_hrs="<?php echo $this->_tpl_vars['time_record']['computed_total_hrs']; ?>
"
                adjusted_total_hrs="<?php echo $this->_tpl_vars['time_record']['adjusted_total_hrs']; ?>
"
                start_lunch="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['time_in_lunch'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" 
                end_lunch="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['time_out_lunch'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" 
                regular_hrs="<?php echo $this->_tpl_vars['time_record']['regular_hrs']; ?>
" 
                notes="<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['time_record']['notes'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, "\n", ' ') : smarty_modifier_replace($_tmp, "\n", ' ')))) ? $this->_run_mod_handler('replace', true, $_tmp, "\r", ' ') : smarty_modifier_replace($_tmp, "\r", ' ')); ?>
" 
                />
        <?php endforeach; endif; unset($_from); ?>
    </time_records>
</response>