<?php /* Smarty version 2.6.19, created on 2010-03-22 17:26:27
         compiled from timeSheetForClient.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'timeSheetForClient.tpl', 31, false),array('modifier', 'escape', 'timeSheetForClient.tpl', 45, false),array('modifier', 'number_format', 'timeSheetForClient.tpl', 48, false),array('function', 'cycle', 'timeSheetForClient.tpl', 34, false),)), $this); ?>
<?php if ($this->_tpl_vars['show_month_list']): ?>
<div id="time_sheet">
    <div id="available_months">Select Month : 
        <select id="month_list">
            <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['month_options']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
            <option value="<?php echo $this->_tpl_vars['month_options'][$this->_sections['j']['index']]['date']; ?>
"><?php echo $this->_tpl_vars['month_options'][$this->_sections['j']['index']]['desc']; ?>
</option>
            <?php endfor; endif; ?>
        </select>
    </div>
    <div id="dtr_time_sheet_client">
<?php endif; ?>
        <div id="time_sheet_headers_client">
            <div class="time_sheet_headers_client">
                <div class="dtr_col_day_of_week">Day of Week</div>
                <div class="dtr_col_time">Time In</div>
                <div class="dtr_col_time">Time Out</div>
                <div class="dtr_col_client">Client</div>
                <div class="dtr_col_timezone">Timezone</div>
                <div class="dtr_col_spacer"></div>
                <div class="dtr_col_total_hours_header">Total Hrs</div>
                <div class="dtr_col_total_hours_header">Lunch Hrs</div>
                <div class="dtr_col_time">Start Lunch</div>
                <div class="dtr_col_time">Fin Lunch</div>
                <div class="dtr_col_regular_hours_header">Regular Hrs</div>
                <div class="dtr_col_notes">Notes</div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['time_records']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
            <?php echo '<div class="dtr_rows_client '; ?><?php if (((is_array($_tmp=$this->_tpl_vars['time_records'][$this->_sections['j']['index']]['day_of'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3, "") : smarty_modifier_truncate($_tmp, 3, "")) == 'Sat' || ((is_array($_tmp=$this->_tpl_vars['time_records'][$this->_sections['j']['index']]['day_of'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3, "") : smarty_modifier_truncate($_tmp, 3, "")) == 'Sun'): ?><?php echo 'bg_color_weekends'; ?><?php else: ?><?php echo ''; ?><?php echo smarty_function_cycle(array('values' => "bg_color_row_1, bg_color_row_2"), $this);?><?php echo ''; ?><?php endif; ?><?php echo '"><div class="dtr_col_day_of_week">'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['day_of']; ?><?php echo '</div><div class="dtr_col_time">'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['time_in_default']; ?><?php echo '</div><div class="dtr_col_time">'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['time_out_default']; ?><?php echo '</div><div class="dtr_col_client" title="'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['time_records'][$this->_sections['j']['index']]['client'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['time_records'][$this->_sections['j']['index']]['client'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?><?php echo '</div><div class="dtr_col_timezone">'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['client_timezone']; ?><?php echo '</div><div class="dtr_col_spacer"></div><div class="dtr_col_total_hours">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['time_records'][$this->_sections['j']['index']]['total_hours'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?><?php echo '</div><div class="dtr_col_total_hours">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['time_records'][$this->_sections['j']['index']]['total_lunch_hours'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?><?php echo '</div><div class="dtr_col_time">'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['start_lunch_default']; ?><?php echo '</div><div class="dtr_col_time">'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['finish_lunch_default']; ?><?php echo '</div><div class="dtr_col_regular_hours">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['time_records'][$this->_sections['j']['index']]['working_hours'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?><?php echo '</div><div class="dtr_notes"><span blank="'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['blank']; ?><?php echo '" record_id="'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['record_id']; ?><?php echo '" day_of="'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['day_of_notes']; ?><?php echo '" class="span_add_notes" id="span_add_notes_'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['record_id']; ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['time_records'][$this->_sections['j']['index']]['timerecord_notes'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?><?php echo '</span></div><div class="clear"></div></div><div class="invisible div_notes" id="notes_'; ?><?php echo $this->_tpl_vars['time_records'][$this->_sections['j']['index']]['record_id']; ?><?php echo '">Loading....</div><div class="clear"></div>'; ?>

            <?php endfor; endif; ?>
        </div>
<?php if ($this->_tpl_vars['show_month_list']): ?>
    </div>
</div>
<?php endif; ?>