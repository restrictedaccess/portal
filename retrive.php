<?php
	// defining constatnts
	define("NotReg","NOTREGISTRED\nnull");
	//defining log filename
	define("NotUpload","The file is not uploaded");
	$errfile = "retrive.log";
	//checkong for VoiceServerFolder POST variable. Defining VoiceLocal variable
	if(isset($_POST["VoiceServerFolder"])) 
		$VoiceLocal = $_POST["VoiceServerFolder"];
  	else 
		$VoiceLocal="/../voicefiles/";
	//Defining $VoiceFolder variable - a folder where voicefiles will be stored
	$VoiceFolder = getcwd().$VoiceLocal;
	//setting full path name to log file
	$errfile=$VoiceFolder.$errfile;
	//Processing User defined POST variables (like session ID, etc.)	  
	//TODO: process your POST variables here
	//NOTE: don't forget to check variables names and values in record_app.php
	//They should be similar to variables, processed here!
	while(list($key,$val)=each($_POST))
	{
		AddLogs($errfile,"POST variable received >".$key." = ".$val);
	}
	//truning off PHP error reporting
	error_reporting (0);
	//Finding out Action POST variable. if it equals "CREATE" - creating file, 
	//if it equals "APPEND" - finding file on disk and appending data to it
	if(!empty($_POST["ACTION"]))
	{
	  	//getting Action variable
		$ACTION = $_POST["ACTION"];
		if ($ACTION == "CREATE" || $ACTION == "APPEND") 
		{
			//getting userdir variable - user personal directory inside $VoiceFolder directory
			//where voicefile will be stored
			if (!empty($_POST["USERDIR"]) ) 
			{
				$UserDir = $VoiceFolder . $_POST["USERDIR"] . "/";
				// checking folder existance
		        	if (!is_dir($UserDir))
				{
					if ($ACTION == "CREATE")
					{   
						// if creating file, creating folder first if not exists
    			        		umask(000);
						//creating folder
					        if( !mkdir( $UserDir, 0777 ) ) 
						{
				        		AddLogs($errfile,"Can't create folder: ".$UserDir);
					        	ErrorMessage("Server cat'n create folder for your Voice files...\n Tell about it to System Administrator...");
				        	}
						else 
						{
				        		AddLogs($errfile, "ACTION: ".$GLOBALS['ACTION']."; directory \"".$UserDir."\" doesn't exist");
				         		//exit(NotUpload);
			         		}
          				}
		        	}
				//getting filename of voicefiles received
				$MVfile_name = $UserDir . $_FILES['USERFILE']['name'];
				//checking file existance for APPEND operation
				Addlogs($errfile, "file name is ".$MVfile_name);
				if ($ACTION == "APPEND" && !file_exists($MVfile_name)) 
				{ 
					//file  should exist  for APPEND operation
					AddLogs($errfile, "ACTION: ".$GLOBALS['ACTION']."; file \"".$MVfile_name."\" doesn't exist");
					exit(NotUpload);
				}
				//getting temporary filename of uploaded file
				$tmp_name = $_FILES['USERFILE']['tmp_name'];
				//checking for file to be uploaded
				if( is_uploaded_file($tmp_name) )
				{
					//reading uploaded file
					$fupload = fopen($tmp_name, "rb");
					$contents = fread($fupload, filesize($tmp_name));
					fclose($fupload);
					//Writing uploaded part on disk using APPEND mode or CREATE mode
					//defining mode
					$mode = ($ACTION == "CREATE") ? "wb" : "ab";
					//opening file
					$flocal = fopen($MVfile_name, $mode);
					//writing to file
					if (!(@fwrite($flocal, $contents))) 
					{
						//writing error if writing operation failed
						AddLogs($errfile, "ACTION: ".$GLOBALS['ACTION']."; error writing to file \"".$MVfile_name."\"");
						exit(NotUpload);
					}
					//closing file 
					fclose($flocal);
					//writing log message
					Addlogs($errfile, "ACTION: ".$GLOBALS['ACTION']."; exit ACCEPTED");
					//exit with code "ACCEPTED" - the result HTML page consists of one word - "ACCEPTED"
					exit("ACCEPTED");
				}
			        else 
				{
					//writing error log message
				        AddLogs($errfile,"ACTION: ".$GLOBALS['ACTION']."; Cant'n move uploaded file: ".$_FILES['USERFILE']['tmp_name']." -> ".$MVfile_name);
				        exit(NotUpload);
		        	}
			}
			else
			exit(NotUpload);
		}
		else               // For default
		exit(NotReg);
	}
	else
	exit(NotReg);

//Add log function - opens log file, writes log message into it and closes log file.
function AddLogs($FileName, $LogInf, $LogType = "error")
{
	//making log message
	$str = "[".date("D M d H:i:s Y")."] [".$LogType."] [client ".getenv ("REMOTE_ADDR")."] ";
	//opening log file
	if(file_exists($FileName))//if exists
		$fp = @fopen($FileName,"a");//for appending
	else 
		$fp = @fopen($FileName,"w");//for writing
	//writing message to log file
	@fputs($fp, $str.$LogInf."\r\n");
	//closing log file
	fclose($fp);
}
?>