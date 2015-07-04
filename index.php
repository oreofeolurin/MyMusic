<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="src/style/index.css" />
<title>My Mysic</title>

<style>

</style>
</head>

<body>

<?php
	
	require_once "library/Models/entries.php";
	
	
	
	
	//Load model class for the table
	$Entries = new Entries(); 
	$columnList = $Entries->getColumnList();
	
	//get filter post
	if(isset($_POST['filter'])){
		$fliterIP = $_POST['ipaddress'];
		$fliterDate = array(
			"from_date" => mktime(0, 59, 59, $_POST['from_month'], $_POST['from_day'], $_POST['from_year']),
			"to_date" => mktime(23, 59, 59, $_POST['to_month'], $_POST['to_day'], $_POST['to_year'])
			);
		$entries = $Entries->getEntryList($fliterIP,$fliterDate);
	}
	else{
		$entries = $Entries->getEntryList();		
	}
	
	
	

?>
<div id="maincontent">
            <div id="maincontentinner">

				<div id="filterPanel">
                    <form action="index.php" method="post"/>
                    	<span>
                       		<input class="filter" name="ipaddress" value="<?php echo (isset($_POST['filter'])) ? $_POST['ipaddress'] : ''  ?>" placeholder="Filter  by IP address" /> 
                        </span>
                        
                        <span>
                            <label>From Date</label>
                            <select name="from_year">
								<?php for($i=2000; $i<=2015; $i++){
                                    if(isset($_POST['filter']) && $i == $_POST['from_year'])
                                        echo('<option value="'.$i.'" selected="selected">' . $i . '</option>');
                                    else 
                                        echo('<option value="'.$i.'">' . $i . '</option>');
                                    
                                    }
                                ?>
                            </select>
                            <select name="from_month">
                            	<?php for($i=1; $i<=12; $i++){
									if(isset($_POST['filter']) && $i == $_POST['from_month'])
                                        echo('<option value="'.$i.'" selected="selected">' . $i . '</option>');
                                    else 
                                        echo('<option value="'.$i.'">' . $i . '</option>');
								}?>
                            </select>
                            <select name="from_day">
                            <?php for($i=1; $i<=31; $i++){
								 if(isset($_POST['filter']) && $i == $_POST['from_day'])
                                        echo('<option value="'.$i.'" selected="selected">' . $i . '</option>');
                                    else 
                                        echo('<option value="'.$i.'">' . $i . '</option>');
								}
							?>
                            </select>
                        </span>
                        
                        <span>
                            <label>To Date</label>
                            <select name="to_year">
                            <?php for($i=2015; $i>=1970; $i--){
								 if(isset($_POST['filter']) && $i == $_POST['to_year'])
                                        echo('<option value="'.$i.'" selected="selected">' . $i . '</option>');
                                  else 
                                       echo('<option value="'.$i.'">' . $i . '</option>');
								
								}?>
                            </select>
                            <select name="to_month">
                            <?php for($i=12; $i>=1; $i--){
								 if(isset($_POST['filter']) && $i == $_POST['to_month'])
                                        echo('<option value="'.$i.'" selected="selected">' . $i . '</option>');
                                    else 
                                        echo('<option value="'.$i.'">' . $i . '</option>');
								}?>
                            </select>
                            <select name="to_day">
                            <?php for($i=31; $i>=1; $i--){
								 if(isset($_POST['filter']) && $i == $_POST['to_day'])
                                   echo('<option value="'.$i.'" selected="selected">' . $i . '</option>');
                                 else 
                                    echo('<option value="'.$i.'">' . $i . '</option>');
								
								}?>
                            </select>
                        </span>
                        
                        
                        <span>
                        	<button name="filter">Filter Search</button>
                        </span>
                     </form>
                    
                 </div>
                
				<?php
                	if(empty($entries))
						echo '<div class="message">No result found  for this query</div>';
					else{
				?>
                <table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con1" width="5%" />
                        <col class="con0" width="10%" />
                        <col class="con1" width="15%" />
                        <col class="con0" width="15%" />
                        <col class="con1" width="10%" />
                        <col class="con0" width="10%"/>
                        <col class="con1" width="10%"/>
                        <col class="con0" width="10%" />
                        <col class="con1" width="15%" />
                    </colgroup>
                    <thead>
                        <tr>
                          	
                            <?php for($i=0;$i<count($columnList);$i++){
								
								echo '<th class="head'.$i%2 .'">'.$columnList[$i]["columnName"].'</th>';
							}
						?>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
							
								foreach( $entries as $entry){
									echo '
									
									<tr class="gradeX">
								  	<td>'.$entry['ID'].'</td>
									<td>'.$entry['TRACKID'].'</td>
									<td>'.$entry['IP_ADDRESS'].'</td>									
									<td>'.$entry['EXPIRY_DATE'].'</td>
									<td>'.$entry['TRANSACTION_ID'].'</td>
									<td>'.$entry['STATUS'].'</td>
									<td>'.$entry['SOURCE'].'</td>
									<td>'.$entry['TYPE'].'</td>
									<td>'.$entry['DOWNLOAD_DATE'].'</td>
									
								</tr>
									';
						}
						?>
                        
                    </tbody>
                </table>
                
                
                <?php } ?>
                
                </div>
                </div>


</body>
</html>
