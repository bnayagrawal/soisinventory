<?php 
class mitComponent {
	
	private $name;
	private $id;
	private $desc;
	private $vendor_name;
	private $image;
	private $year;
	
	public function __construct ($component_name, $component_id, $component_desc, $vendor_name,
	$component_image, $component_year) {
		$this->name = $component_name;
		$this->id = $component_id;
		$this->desc = $component_desc;
		$this->vendor_name = $vendor_name;
		$this->image = $component_image;
		$this->year = $component_year;
	}
	
	function get_name() {
			return $this->name;
	}
	
	function get_id() {
			return $this->id;
	}

	function get_desc() {
			return $this->desc;
	}

	function get_vendor_name() {
			return $this->vendor_name;
	}

	function get_image() {
			return $this->image;
	}	
	
	function get_year() {
			return $this->year;
	}
	
}


class ComponentsView {
	
	public $oneComponent = array();
	public $compCount;
	
	public function __construct () {
		$this->compCount = 0;
	}
	
	public function set_compCount($newCount) {
		$this->compCount = $newCount;
	}
	
}

?>