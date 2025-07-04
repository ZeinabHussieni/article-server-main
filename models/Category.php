<?php
require_once("Model.php");

class Category extends Model{

    private int $id; 
    private string $name; 
    private string $description; 

    protected static string $table = "categories";

    public function __construct(array $data){
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->description = $data["description"];

    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }
        public function getDescription(): string {
        return $this->description;
    }

    public function setName(string $name){
        $this->name = $name;
    }
    public function setDescription(string $description){
        $this->description = $description;
    }


    public function toArray(){
        return [$this->id, $this->name, $this->description];
    }
    // update() -> non-static function 
    public function updatecategory(mysqli $mysql, $name, $description) : bool {
        $sql=sprintf("update %s set name = ?, description = ? WHERE id = ?", static::$table);

        $query= $mysql-> prepare($sql);

        if(!$query){
            throw new Exception("Prepare Failed: ".$mysql->error);
        }

        $query->bind_param("ssi", $name, $description, $this->id);
        $res= $query->execute();

        if(!$res){
            throw new Exception("Execute Failed: ".$mysql->error);
        }

        $this->name = $name;
        $this->description= $description;
        return true;
    }
    // create() -> static function
    public static function createcategory(mysqli $mysqli, string $name, string $description): bool {
        $sql = sprintf("insert into %s (name, description) VALUES (?,?)", static::$table);

        $stmt = $mysqli->prepare($sql);
        if(!$stmt){
            throw new Exception("Prepare Failed: ".$mysqli->error);
        }

        $stmt->bind_param("ss", $name, $description);

        if (!$stmt->execute()) {
            throw new Exception("Execute Failed: ".$stmt->error);
        }
        return true;
    }

}
