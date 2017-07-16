<?php
	//For search. will return component name,vendor and image path of components in JSON format
	require_once('config.php');
	include("class_lib.php");
	//for search using component_name
	if(isset($_REQUEST["component_name"]) == true)
		$info = mysqli_query($mysqli, "select component_name,component_id,component_image,vendor_name from component join vendor on component.vendor_id = vendor.vendor_id where component_name LIKE '%". $_REQUEST["component_name"] ."%' order by component.component_id");
	//for search using vendor_name
	elseif(isset($_REQUEST["vendor_name"]) == true)
		$info = mysqli_query($mysqli, "select component_name,component_id,component_image,vendor_name from component join vendor on component.vendor_id = vendor.vendor_id where vendor_name LIKE '%". $_REQUEST["vendor_name"] ."%' order by component.component_id");
		
	$component = array();
	$filteredComponent = array();

	while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
		$comp = new mitComponent($row['component_name'],$row['component_id'],"nr",$row['vendor_name'],$row['component_image'],"nr");	
		array_push($component, $comp);
	}
	
	if(!empty($component)) {
		$tmp = $component[0]->get_name();
		$compView = new ComponentsView();
		array_push($compView->oneComponent, $component[0]);
		for ($i = 1 ; $i < count($component); $i++) {
			if($component[$i]->get_name() == $tmp ) {
				array_push($compView->oneComponent, $component[$i]);
				$tmp = $component[$i]->get_name();
			} else {
				$compView->set_compCount(count($compView->oneComponent)); 
				array_push($filteredComponent, $compView);
				$compView = new ComponentsView();
				array_push($compView->oneComponent, $component[$i]);
				$tmp = $component[$i]->get_name();
			}
		}
			
		$compView->set_compCount(count($compView->oneComponent)); 
		array_push($filteredComponent, $compView);
	}
		
	mysqli_close($mysqli);
	
	$theName;
	$theVendor;
	$theImage;
	$theNumber;
	
	$record_count = 0; //Just to remove ',' from the last record
	//echo output JSON
	echo '{"component_info":[';
	
	foreach($filteredComponent as &$val) {
		$theName = $val->oneComponent[0]->get_name();
		$theVendor = $val->oneComponent[0]->get_vendor_name();
		$theImage = $val->oneComponent[0]->get_image();
		$theNumber = $val->compCount;
		
		//echo in json format
		if($record_count != 0)
			echo ",";
		echo '{"component_name":"' . $theName . '","item_count":"' . $theNumber .'","vendor_name":"' . $theVendor .'","component_image":"' . $theImage.'"}';
		$record_count++;
	}
	
	echo "]}";
?>