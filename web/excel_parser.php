<?php


function num2alpha($n)  //數字轉英文(0=>A、1=>B、26=>AA...以此類推)
{
    for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
        $r = chr($n%26 + 0x41) . $r;
    return $r;
}

function alpha2num($a)  //英文轉數字(A=>0、B=>1、AA=>26...以此類推)
{
    $l = strlen($a);
    $n = 0;
    for($i = 0; $i < $l; $i++)
        $n = $n*26 + ord($a[$i]) - 0x40;
    return $n-1;
}

	

function get_day($day)
	{
		$excel_file = "table.xls";

		$tde_start = -1;
		$tde_end = -1;

		require("plugins/phpexcel/PHPExcel/IOFactory.php");
		$objPHPExcel = PHPExcel_IOFactory::createReader("Excel2007"); 
		$objPHPExcel = PHPExcel_IOFactory::load($excel_file);  //設定要讀取的檔案
		$objWorksheet = $objPHPExcel->getSheet(0);  //設定讀取第一個Sheet
		$allColumn = $objWorksheet->getHighestColumn();  //取得最大列號
		$allColumn = alpha2num($allColumn);  //將列號轉成列數
		$allRow = $objWorksheet->getHighestRow();  //取得最大行數

		$m_init_array = array();
		$m_final_array = array();


		for($row = 0; $row < $allRow; $row++){
		        for($column = 0; $column <= $allColumn; $column++){
		                $column_alpha = num2alpha($column);  //將列數轉成列號
		                $m_value = $objWorksheet->getCell($column_alpha.$row)->getCalculatedValue();

		                if(is_numeric($m_value)&&$m_value/10000>1)
		                {
		                	$UNIX_DATE = ($m_value - 25569) * 86400;
		                	$m_value = gmdate("m/d", $UNIX_DATE);
		                }

		                if(stristr($m_value,"替代役")&&$column==0)
		               	{

		               		if($tde_start==-1)
		               		{
		               			$tde_start = $row;
		               		}

		               	}
		               	else if($column==0)
		               	{
		               		if($tde_start!=-1)
		               		{
		               			$tde_end = $row-1;
		               			break;
		               		}
		               	}
		                if($m_value=="")
		                {
		                	$m_init_array[$row][$column] = "白";
		                	
		                }
		                else
		                {
		                	$m_init_array[$row][$column] = $m_value;
		                	
		                }

		                
		        }

		        if($tde_start!=-1&&$tde_end!=-1)
		        {
		        	break;
		        }
		        
		}


			$col_value =33;
			$row_value = $tde_end - $tde_start+2;


			$m_final_array[0][0] = "職稱";
			$m_final_array[0][1] = "姓名";

			for ($col = 2;$col <$col_value;$col++)
			{
				$m_final_array[0][$col] = $col-1;

			}


			for($row = 1; $row < $row_value; $row++){
		        for($column = 0; $column < $col_value; $column++){

		        	$m_final_array[$row][$column]=$m_init_array[$tde_start][$column];
		        	
		        }
		        $tde_start+=1;
		        
		    }

		  $day_array = array_column($m_final_array, $day);

		  $hashtable = array();
		  $counttable = array();
		  $keys = array();

		  for($row = 1;$row<$row_value;$row++)
		  {
		  	if(array_key_exists($day_array[$row],$hashtable))
		  	{
		  		$hashtable[$day_array[$row]]= $hashtable[$day_array[$row]]." ".$m_final_array[$row][1];
		  		$counttable[$day_array[$row]]+=1;
		  	}
		  	else
		  	{
		  		$hashtable[$day_array[$row]]=$m_final_array[$row][1];
		  		$counttable[$day_array[$row]] = 1;
		  		array_push($keys, $day_array[$row]);
		  	}
		  }

		  $tde_count = $row_value-1;
		  $on_count = $tde_count;
		  $of_count = 0;
		  $sleep_array =array("補","of","課","off");
		  $sleep_str="";

		  foreach ($sleep_array as $m_key)
		  {
		  	if(array_key_exists($m_key,$hashtable))
		  	{
		  		$of_count += $counttable[$m_key];
		  		$sleep_str = $sleep_str." ".$hashtable[$m_key];
		  	}
		  }

		  $sleep_str = "休假：".(string)$of_count."人:".$sleep_str;
		  

		  $on_count-=$of_count;

		  $output_str = "替代役共：".$tde_count."人 "."今日上班：".$on_count."人 ".$sleep_str;
		  $output_str2 = "";
		  foreach ($keys as $m_key)
		  {
		  	if($m_key=="補"||$m_key=="of"||$m_key=="課"||$m_key=="off")
		  		continue;
		  	$output_str2=$output_str2.$m_key."：".$hashtable[$m_key];

		  }

		  //echo $output_str;
		  //echo $output_str2;
		  //var_dump($hashtable);

		  return $output_str.$output_str2;


	}

?>