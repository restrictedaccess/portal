<script type="text/javascript">
jQuery().ready(function($){
    
    $('textarea').keyup(function(e) {
        while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
            $(this).height($(this).height()+1);
        };
    });
    /*Calendar.setup({inputField : "bugdate", trigger: "bd", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });*/
    brep.submit_form('adduserform');
    
    brep.load_assignto('staff_name', 'Search...', 'userid');
    
    $('input[name=useradd]').click(function() {
        var report_id = $('input#report_id').val();
        //$('input#action').val('add');
        $('#add_tester').jqmShow();
	});
    $('input[name=userdel]').click(function() {
        var report_id = $('input#report_id').val();
        var chkd = $("input:checkbox:checked");
        /*chkd.each(function() {
            alert($(this).val());
            //$('#t').append(', '+$(this).val());
        });*/
        
        /*for(var i=0; i<chkd.length; i++) {
            var t = $('input[name=tick]');
            alert(t.attr('type'));
        }*/
        if( chkd.length > 0 && confirm('Do you want to delete this user?')) {
            $('form#userform').submit();
        }
        //$('#add_tester').jqmShow();
	});
    //$('#newrep').jqm({ajax: 'views/bugform.html', trigger: 'a.newtrigger'});
    $('#add_tester').jqm({overlay: 50, modal: true, trigger: false});
});
</script>   
    <style type='text/css'>
    div.container{float:left;width:75%;margin-left:auto;margin-right:auto;border:1px solid #7a9512;}
    </style>
    
    <div id='divresult' class='container'>
        <span id='task-status'></span>
		
			<div id="qholder" style="float:left;width:97%;padding:10px;">
                <form id='userform' action='?/tester' method='post' target='ajaxframe'>
                    <input type='hidden' name='action' value='del'/>
                <table width='100%' border='0' cellpadding="7" cellspacing="2" class="list" id="logs">
                    <tr><td height='30' class='header' colspan='4'>Q.A. People
                    <span style='float:right;width:50px;'>
                        <input type='button' class='button' value="Add" name='useradd' title="Add new user"/></span>
                    </td>
                    </tr>
                    <tr>
                        <td class='header' style='width:30px;'><!--<input type='checkbox' name='tickAll' onclick='tick_untickAll(this);'/>--></td>
                        <td class='label2' style='width:20%;'>Email</td>
                        <td class='label2' style='width:15%'>User Name</td>
                        <td class='label2' style='width:70%;'></td>
                    </tr>
                    <?php if(count($users) > 0):
                        $bgcolor = array('#d0d8e8', '#e9edf4');
                        foreach($users as $user):?>
                        
                            <tr id='row<?php echo $user['userid'];?>'>
                            <td class='item'><input type='checkbox' name='tick[]' value='<?php echo $user['userid'];?>'/></td>
                            <td class='item'><?php echo $user['email'];?></td>
                            <td class='item' style='width:20px;'><?php echo $user['name'];?></td>
                            <td class='item' style='width:20px;'></td>
                            </tr>
              
                    <?php endforeach;
                    endif;?>
                </table>
                <span style='float:left;width:50px;'>
                        <input type='button' class='button' value="Delete" name='userdel' title="Delete user"/></span>
                </form>
            </div>
        
    </div>
<br />

<div class='jqmWindow' id='add_tester' style="float:left;width:57%;padding:10px;">
	<span id='log_testname'>Add New QA User</span>
	<a href='#' class='jqmClose' style='float:right'>Close</a><hr>

    <form id='adduserform' action='?/tester' method='post' target='ajaxframe'>
        <input type='hidden' name='emailaddr' id='emailaddr'/>
        <input type='hidden' name='action' value='add'/>
        <table width="100%" cellspacing="2" class="list">
            <tr><td height="30" class="header" colspan='2'>Enter Details</td>
            </tr>
            <tr>
                <td class="label" width="100">User Name</td>
                <td class="form2 lolite">
                    <input class="inputbox2" name="staff_name" id='staff_name' style='width:79%;' />
                </td>
            </tr>
            <tr>
                <td class="label" width="100">User ID</td>
                <td class="form2 lolite">
                    <input class="inputbox2" name="userid" id="userid"/>
                </td>
            </tr>
            
        </table>
    </form>
    
                
    <div style='float:right;width:20%;right:10px;'>
	<input type='submit' class='button' value="Submit" name='submit' form="adduserform"/>
    </div>
            
</div>


<script type="text/javascript">
<!--
function createResult(err_msg) {
    if( err_msg )
    	jQuery('span#task-status').empty().append(err_msg).show().fadeOut(9000);
	else {
		//alert('The data has been saved.');
        location.href='?/tester/';
	}
}

function createUploadResult(err_msg) {
    if( err_msg )
    	jQuery('span#task-status').empty().append(err_msg).show().fadeOut(9000);
	/*else {
		alert('The data has been saved.');
		location.href='apptest.php?/testinfo/'+id;
	}*/
}
-->
</script>
