<?php

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);


//instantiate the program object

//Class to load classes it finds the file when the progrm starts to fail for calling a missing class
class Manage {
    public static function autoload($class) {
        //you can put any file name or directory here
        include $class . '.php';
    }
}

spl_autoload_register(array('Manage', 'autoload'));

//instantiate the program object
$obj = new main();


class main {
    
    public function __construct()
    {
        //print_r($_REQUEST);
        //set default page request when no parameters are in URL
        $pageRequest = 'homepage';
        //check if there are parameters
        if(isset($_REQUEST['page'])) {
            //load the type of page the request wants into page request
            $pageRequest = $_REQUEST['page'];
        }
        //instantiate the class that is being requested
        $page = new $pageRequest;
        
        
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $page->get();
        } else {
            $page->post();
        }
        
    }
    
}

abstract class page {
    protected $html;
    
    public function __construct()
    {
        $this->html .= '<html>';
        $this->html .= '<link rel="stylesheet" href="styles.css">';
        $this->html .= '<body>';
    }
    public function __destruct()
    {
        $this->html .= '</body></html>';
        echo($this->html);
    }
    
    public function get() {
        echo 'default get message';
    }
    
    public function post() {
        print_r($_POST);
    }
}
class htmlTable extends page {

public function get(){
$csvFile=$_REQUEST["filename"];
//echo $csvFile;
$row = 1;
if (($handle = fopen("uploads/".$csvFile, "r")) !== FALSE) {
    
    echo '<table border="1">';
    
    while (($data = fgetcsv($handle)) !== FALSE) {
        $num = count($data);
        if ($row == 1) {
            echo '<thead><tr>';
        }else{
            echo '<tr>';
        }
        
        for ($c=0; $c < $num; $c++) {
            //echo $data[$c] . "<br />\n";
            if(!isset($data[$c])) {
               $value = "&nbsp;";
            }else{
               $value = $data[$c];
            }
            if ($row == 1) {
                echo '<th>'.$value.'</th>';
            }else{
                echo '<td>'.$value.'</td>';
            }
        }
        
        if ($row == 1) {
            echo '</tr></thead><tbody>';
        }else{
            echo '</tr>';
        }
        $row++;
    }
    
    echo '</tbody></table>';
    fclose($handle);
}
}
}
class homepage extends page
{
    
    public function get()
    {
        $form = '<form action="index.php?page=homepage" method="post" enctype="multipart/form-data">';
        echo $form;
        $form = '<input type="file" name="fileToUpload" id="fileToUpload">';
        echo $form;
        $form = '<input type="submit" value="Upload CSV file" name="submit">';
        echo $form;
        $form = '</form> ';
        echo $form;
        $this->html .= '<h1>Upload Form</h1>';
        $this->html .= $form;
        
    }
    
    public function post() {
        uploads::upload();
    }
}

class uploads extends page
{
 public static function upload()
 {
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["tmp_name"]);
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file is a csv file
print_r($_FILES);
if(isset($_POST["submit"])) {
   $fileName=$_FILES["fileToUpload"]["name"];
   move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'uploads/' . $_FILES["fileToUpload"]["name"]);
header("Location: http://web.njit.edu/~hs563/project01/index.php?page=htmlTable&filename=".$_FILES["fileToUpload"]["name"]);
 
}
}
}

?>