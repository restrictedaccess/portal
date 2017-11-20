function makeObj()
{
	var x ; 
	var browser = navigator.appName ;
	if(browser == 'Microsoft Internet Explorer')
	{
		x = new ActiveXObject('Microsoft.XMLHTTP')
	}
	else
	{
		x = new XMLHttpRequest()
	}
	return x ;
}

var request = makeObj()

function editSubCat(name,id,classification)
{
	var temp = "<table width='0' border='0' cellspacing='2' cellpadding='2'>"
		temp +="<tr>"
			temp +="<td valign='top'><strong>UPDATE SUB CATEGORIES</strong></td>"
			temp +="<td valign='top'>:</td>"
			temp +="<td valign='top'><input type='text' id='sub_name' value="+name+" /></td>"
			temp +='<td valign="top"><select id="sub_classification" name="classification">';
			if(classification == 'it'){
				temp += '<option value="it" selected="selected">I.T.</option>';
				temp += '<option value="non it">Non I.T.</option>';
			} else{
				temp += '<option value="it">I.T.</option>';
				temp += '<option value="non it" selected="selected">Non I.T.</option>';
			}
			temp += '</select></td>';
			
			temp +='<td><input type="button" value="Update" onClick="javascript: UpdateSubcategoryName(document.getElementById(\'sub_name\').value,'+id + ',document.getElementById(\'sub_classification\').value);" /></td>'
		temp +="</tr>"
	temp +="</table>"
	document.getElementById('EditSubCat').innerHTML=temp;
}

function UpdateSubcategoryName(name,id,classification)
{
	request.open('get', 'category/updateSubCategory.php?name='+name+'&id='+id + '&classification=' + classification);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	//request.onreadystatechange = active_listings 
	request.send(1)
	
	alert("Changes has been applied.");
	document.getElementById('EditSubCat').innerHTML = "";
	getAllCategory();
}

function check_val()
{
	var ins = document.getElementsByName('users')
	var i;
	var x;
	var j=0;
	var vals= new Array();
	var vals2 =new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true)
		{
			if(ins[i].value!="" || ins[i].value!="undefined")
			{
				vals[j]=ins[i].value;
				//vals2[j]=id;
				j++;
			}		
		}
	}
document.getElementById("emails").value =(vals);
}

function check_val2()
{

userval =new Array();
var userlen = document.form.userss.length;
for(i=0; i<userlen; i++)
{
	if(document.form.userss[i].checked==true)
	{	
	//	document.getElementById("applicants").value+=(id);
		//push.userval=(id);
		userval.push(document.form.userss[i].value);
	}
}
document.getElementById("applicants").value=(userval);
}

getAllCategory();

