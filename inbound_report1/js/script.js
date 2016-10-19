
function Stop()
{
var usr=document.getElementById('uname').value;

if (usr=="")
  {
 
  return;
  } 
	else
	{
			window.location.href = "sess.php?aa=logout";
	}



}
function validate()
	{
		var user = document.getElementById('fname').value;
		var password = document.getElementById('password').value;
	
        if((user ==null) || (user == ""))
		{
		
		alert ("Username should not be empty");
			//loginForm.passwd.focus();
			return false;
		
		}
		else if((password ==null) || (password == "")){
		alert("Password should not be empty");
		return false;
		}
		
	
		return true;
	}
function Validation(){	
	var channel_value = document.getElementById('selectchannel').value;
	var list_value = document.getElementById('selectlist').value;
	if(list_value == '1' || list_value == '2'){
	if((channel_value == '' ) || (channel_value == null)){
		alert("Select Channel Field");
		return false;
		}
	}else{
		return true;
	}
}