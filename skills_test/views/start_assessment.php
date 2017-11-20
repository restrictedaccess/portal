	<style type='text/css'>
    div.container{float:left;width:100%;margin-left:auto;margin-right:auto;border:1px solid #7a9512;}
    </style>
    
    <div id='divresult' class='container'>
		<span id='loading' style='display:block'>Loading, please wait...</span>
        <span id='task-status'></span>
		
			<div id="holder" style="float:left;width:100%;padding:10px;">

                <span id='task-status'>status</span>
		<iframe id='ifw' name='ifw' frameborder='0' src='<?php echo $kasAssessURL;?>' scrolling="no" style='width:99%;height:1800px;padding:1px;margin:1px;float:left;overflow:hidden;'>
			
		</iframe>
        </div>
        
    </div>
	
	<script type="text/javascript">
	jQuery().ready(function(){
		$('#ifw').load(function(){
			$(window).scrollTop(0);
			$('#loading').hide();
			jQuery(this).css("height", jQuery(this).outerHeight());
		});
	});
	
	
</script>