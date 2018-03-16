<?php
$export = new Export;


if (is_user_logged_in()) {
    if (isset($_POST['download']) && !empty($_POST['tables'])) {
        $username = $_POST["username"];
        $tables   = explode(",", $_POST["tables"]);
        $fullname = $_POST["fullname"];

        $export->export($tables, $username, $fullname);
    }
    
    if (is_user_logged_in()) {
        if (isset($_POST['selected_all_users_data']) && !empty($_POST['selected_all_users_data'])) {
            
            
            $data = stripslashes($_POST['selected_all_users_data']);
            $datain_array = json_decode($data, true);
            
            $zip = new ZipArchive();
            $zip->open('reports/reports.zip', ZipArchive::CREATE);
            
            $all_files_imports = "";
            foreach($datain_array as $t => $value){
                    $export = new Export;
                
                    $username = $value["username"];
                    $tables_data   = explode(",", $value["tables"]);
                    $fullname = $value["fullname"];
                   
                    $export->saveexport($tables_data, $username, $fullname);
                    
                    $filename   = date('y-m-d').'-'.$fullname.'-'.$username.'.xls';
                    $zip->addFile('reports/'.$filename);
                    
            }
            
            $zip->close();
                        
            $file = 'reports/reports.zip';
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Content-Length: '.filesize($file));
            readfile($file);
            unlink($file);
            
            
        }
    }
    
    
    
}


class Export {
    function __construct() {
        global $wpdb, $current_user;
        get_currentuserinfo();

        require_once(get_template_directory().'/php_modules/PHPExcel.php');
        require_once(get_template_directory().'/php_modules/PHPExcel/IOFactory.php');

        $this->db = $wpdb;
        $this->current_user = $current_user;
        $this->objPHPExcel = new PHPExcel();
    }


    private function results($letters, $columns) {
        $results = array();

        foreach ($letters as $i=>$letter) {
            $results[$letter][] = $columns[$i];
        }
        array_walk(
            $results,
            create_function('&$v', '$v = (count($v) == 1)? array_pop($v): $v;')
        );

        return $results;
    }
    
    
    public function export($tables, $username, $fullname) {
        global $wpdb;
        $filename   = date('y-m-d').'-'.$fullname.'-'.$username.'.xls';
        $user_query = "WHERE user='$username'";

        // Set Meta Data
        $this->objPHPExcel->getProperties()
             ->setCreator("user")
             ->setLastModifiedBy("user")
             ->setTitle("Office 2007 XLSX User Family member Document")
             ->setSubject("Office 2007 XLSX User Family member Document")
             ->setDescription("User Family member document for Office 2007 XLSX.")
             ->setKeywords("office 2007 openxml php")
             ->setCategory("User Family member file");
           
           
        foreach ($tables as $i=>&$sheet) {
            $rows    = 0;
            $columns = $wpdb->get_col("DESC $sheet", 0);
            $letters = range('A', 'Z');
            $title   = ucwords(str_replace("royal_","","$sheet"));
            $query   = "SELECT * FROM $sheet WHERE user='$username'";
            $data    = $wpdb->get_results($query, ARRAY_A);
            $results = $this->results($letters, $columns);

            if ($data) {
                /* $error = "Error: the query failed...<pre style='width:700px;word-wrap:break-word;white-space:normal;'>$query</pre>";*/

                // Set worksheet index
                $objWorkSheet = $this->objPHPExcel->createSheet($i);

                // Set worksheet page to 0
                $this->objPHPExcel->setActiveSheetIndex($i);

                // Set headers
                foreach ($results as $column=>$name) {
                    $this->objPHPExcel
                         ->getActiveSheet()
                         ->setCellValue("{$column}1", $name);

                    // Rows
                    while ($rows < count($data)) {
                        $cell = $rows + 2;

                        foreach ($results as $column => $value)
                        $this->objPHPExcel
                             ->getActiveSheet()
                             ->setCellValue($column.$cell, $data[$rows][$value]);
                        $rows++;
                    }
                }

                $objWorkSheet->setTitle("$title");
            }
        }
        
        
        ob_end_clean();
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        ob_end_clean();
        
        

        // Remove blank worksheet
        $this->objPHPExcel->setActiveSheetIndexByName('Worksheet');
        $sheetIndex = $this->objPHPExcel->getActiveSheetIndex();
        $this->objPHPExcel->removeSheetByIndex($sheetIndex);

        // Print Docu
        $this->objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
               

        exit;
    }
    
    
    public function saveexport($tables, $username, $fullname) {
        global $wpdb;
        $filename   = date('y-m-d').'-'.$fullname.'-'.$username.'.xls';
        $user_query = "WHERE user='$username'";

        // Set Meta Data
        $this->objPHPExcel->getProperties()
             ->setCreator("user")
             ->setLastModifiedBy("user")
             ->setTitle("Office 2007 XLSX User Family member Document")
             ->setSubject("Office 2007 XLSX User Family member Document")
             ->setDescription("User Family member document for Office 2007 XLSX.")
             ->setKeywords("office 2007 openxml php")
             ->setCategory("User Family member file");
           
           
        foreach ($tables as $i=>&$sheet) {
            $rows    = 0;
            $columns = $wpdb->get_col("DESC $sheet", 0);
            $letters = range('A', 'Z');
            $title   = ucwords(str_replace("royal_","","$sheet"));
            $query   = "SELECT * FROM $sheet WHERE user='$username'";
            $data    = $wpdb->get_results($query, ARRAY_A);
            $results = $this->results($letters, $columns);

            if ($data) {
                /* $error = "Error: the query failed...<pre style='width:700px;word-wrap:break-word;white-space:normal;'>$query</pre>";*/

                // Set worksheet index
                $objWorkSheet = $this->objPHPExcel->createSheet($i);

                // Set worksheet page to 0
                $this->objPHPExcel->setActiveSheetIndex($i);

                // Set headers
                foreach ($results as $column=>$name) {
                    $this->objPHPExcel
                         ->getActiveSheet()
                         ->setCellValue("{$column}1", $name);

                    // Rows
                    while ($rows < count($data)) {
                        $cell = $rows + 2;

                        foreach ($results as $column => $value)
                        $this->objPHPExcel
                             ->getActiveSheet()
                             ->setCellValue($column.$cell, $data[$rows][$value]);
                        $rows++;
                    }
                }

                $objWorkSheet->setTitle("$title");
            }
        }
        
        
        ob_end_clean();
        
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //header('Content-Disposition: attachment;filename=' . $filename);
        //header('Cache-Control: max-age=0');
        //ob_end_clean();
        
        

        // Remove blank worksheet
        $this->objPHPExcel->setActiveSheetIndexByName('Worksheet');
        $sheetIndex = $this->objPHPExcel->getActiveSheetIndex();
        $this->objPHPExcel->removeSheetByIndex($sheetIndex);

        // Print Docu
        $this->objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
        //$objWriter->save('php://output');
        
        $objWriter->save('reports/'.$filename);       
        //readfile($filePath);
        //$objWriter->save(str_replace(__FILE__,'/reports/'.$filename,__FILE__));

        //exit;
    }
    
}
?>
