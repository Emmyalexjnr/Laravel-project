<?php 
require_once(LIB_PATH.DS.'database.php');



class DatabaseObject{

protected static $table_name;


//Common Database Methods
	public static function find_all(){
		global $database;
		$result_set = self::find_by_sql("SELECT * FROM " .static::$table_name. " ORDER BY position ASC");
		//$result_set = $database->query("SELECT * FROM users");
		return $result_set;
	}
	
	public static function find_all_pix(){
		global $database;
		$sql = "SELECT * FROM ".static::$table_name. " ";
		$sql .= " ORDER BY position ASC";	
		$result = $database->query($sql);
		$result_set = $result->fetchAll(PDO::FETCH_ASSOC);
		$set = count($result_set);
		//$result_set = $database->num_rows($result_set);
		return $set;
	}


	public static function find_by_id($id=0){
		global $database;
		$result_array = static::find_by_sql("SELECT * FROM "
		.static::$table_name." WHERE id=" .$id." LIMIT 1");		
		return !empty($result_array) ? array_shift($result_array) : false;
	}
 
	public static function find_by_sql($sql=""){
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while($row = $result_set->fetch()){
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	public static function count_all(){
		global $database;
		$sql = "SELECT COUNT(*) FROM ".static::$table_name;
		$result_set = $database->query($sql);	
		$row = $result_set->fetch();
		return array_shift($row);
	}

	private static function instantiate($record){
		$class_name = get_called_class();

		$object = new $class_name;
		foreach ($record as $attribute => $value) {
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	private function has_attribute($attribute){
		$object_vars = $this->attributes();
		//does this $attribute exists in object_vars
		//which returns true or false
		return array_key_exists($attribute, $object_vars);
	}

	public function attributes(){
		$attributes = array();
		foreach (static::$db_fields as $field) {
			if(property_exists($this, $field)){
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;	
	}
	
	
	
	public function create(){
		global $database;
		$attributes = $this->attributes();
		$set = ":".implode(" :", array_keys($attributes));
		$array_set = explode(" ", $set);
		//$array_key = join(", :", array_values($attributes));
		$sql = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES (:";
		$sql .= join(", :", array_keys($attributes));
		$sql .= ")";
		$stmt = $database->prepare($sql);
		if($stmt->execute(array_combine($array_set, array_values($attributes)))){
			$this->id = $database->lastInsertId();
			//$this->id = $database->insert_id();
			return true;
		}else{
			return false;
		}
	}

	public function save(){
		return isset($this->id) ? $this->update_all() : $this->create();
	}

	public function update_all(){
		global $database;
		$attributes = $this->sanitized_attributes();
		$attributes_pairs = array();
		foreach ($attributes as $key => $value) {
			$attributes_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attributes_pairs);
		$sql .= " WHERE id = ".$database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}


	public function update($id){
		global $database;
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= "name = :name, ";
		$sql .= "address = :address, ";
		$sql .= "date_of_birth = :dob, ";
		$sql .= "position = :position, ";
		//$sql .= "created = :created, ";
		$sql .= "updated = :updated ";
		$sql .= " WHERE id = :id";
		
		$stmt = $database->prepare($sql);
		$stmt->bindValue(':name', $this->name);
		$stmt->bindValue(':address', $this->address);
		$stmt->bindValue(':dob', $this->date_of_birth);
		$stmt->bindValue(':position', $this->position);
		//$stmt->bindValue(':created', $this->created);
		$stmt->bindValue(':updated', $this->updated);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return ($stmt->rowCount() == 1) ? true : false;
		//echo $this->name." ".$this->address." ".$this->date_of_birth." ".$this->position." ".$this->updated."<br>";
		//echo $stmt->rowCount();
	}

	
	public function delete(){
		global $database;
		$sql = "DELETE FROM ".static::$table_name." ";
		$sql .= " WHERE id = :id";
		$sql .= " LIMIT 1";
		$stmt = $database->prepare($sql);
		$stmt->execute(array(':id'=>$this->id));
		return ($stmt->rowCount() == 1) ? true : false;
	}

}

?>