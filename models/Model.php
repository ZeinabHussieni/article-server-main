<?php 
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $mysqli, int $id){
        $sql = sprintf("Select * from %s WHERE %s = ?", 
                        static::$table, 
                        static::$primary_key);
        
        $query = $mysqli->prepare($sql);

        if (!$query) {
            throw new Exception("Prepare Failed: " . $mysqli->error);
        }

        $query->bind_param("i", $id);

        if (!$query->execute()) {
            throw new Exception("Execute Failed: ".$query->error);
        }

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    public static function all(mysqli $mysqli){
        $sql = sprintf("Select * from %s", static::$table);
        
        $query = $mysqli->prepare($sql);

        if (!$query) {
            throw new Exception("Prepare Failed: " . $mysqli->error);
        }

        if (!$query->execute()) {
            throw new Exception("Execute Failed: " . $query->error);
        }

        $data = $query->get_result();

        $objects = [];
        while($row = $data->fetch_assoc()){
            $objects[] = new static($row); //creating an object of type "static" / "parent" and adding the object to the array
        }

        return $objects; //we are returning an array of objects!!!!!!!!
    }
        //2- create() -> static function
    public static function create(mysqli $mysqli, array $data): bool {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
     
        $sql = "Insert INTO " . static::$table . " ($columns) VALUES ($placeholders)";
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
          throw new Exception("Prepare Failed: " . $mysqli->error);
        }

        $types = str_repeat("s", count($data)); 
        $stmt->bind_param($types, ...array_values($data));

        if (!$stmt->execute()) {
          throw new Exception("Execute Failed: " . $stmt->error);
        }

        return true;
    }

        //update() -> non-static function 
    public function update(mysqli $mysqli, array $data): bool {
       $set = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));
       $sql = "Update " . static::$table . " SET $set WHERE " . static::$primary_key . " = ?";

       $stmt = $mysqli->prepare($sql);
       if (!$stmt) {
        throw new Exception("Prepare Failed: " . $mysqli->error);
        }

       $types = str_repeat("s", count($data)) . "i"; //always last one is id 
       $values = array_values($data);
       $values[] = $this->{static::$primary_key};

       $stmt->bind_param($types, ...$values);

      if (!$stmt->execute()) {
      throw new Exception("Execute Failed: " . $stmt->error);
      }

      return true;
    }


    //3- delete() -> static function 
    public static function Delete(mysqli $mysqli, $id):bool{
       $sql = sprintf("Delete FROM %s WHERE %s = ?", static::$table, static::$primary_key);

        $query= $mysqli->prepare($sql);
        if (!$query) {
            throw new Exception("Prepare Failed: " . $mysqli->error);
        }

        $query->bind_param("i", $id);

        if (!$query->execute()) {
            throw new Exception("Execute Failed: " . $query->error);
        }
    
    }

    //delete all function
    public static function DeleteAll(mysqli $mysqli):bool{
        $mysql= sprintf("Delete from %s",static::$table);

        $query=$mysqli->prepare($mysql);

        if (!$query) {
            throw new Exception("Prepare Failed: " . $mysqli->error);
        }

        if (!$query->execute()) {
            throw new Exception("Execute Failed: " . $query->error);
        }
        return true;
    }

}



