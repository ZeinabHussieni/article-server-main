<?php
require_once("Model.php");

class Article extends Model{

    private int $id; 
    private string $name; 
    private string $author; 
    private string $description; 
    
    protected static string $table = "articles";

    public function __construct(array $data){
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->author = $data["author"];
        $this->description = $data["description"];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function setAuthor(string $author){
        $this->author = $author;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function toArray(){
        return [$this->id, $this->name, $this->author, $this->description];
    }

    //update() -> non-static function 
    public function update(mysqli $mysqli, $name, $author, $description) : bool {
        $sql = sprintf("Update %s SET name = ?, author = ?, description = ? Where id = ?", static::$table);
        $query = $mysqli->prepare($sql);

        if (!$query) {
            throw new Exception("Prepare Failed: " . $mysqli->error);
        }

        $query->bind_param("sssi", $name, $author, $description, $this->id);
        if (!$query->execute()) {
            throw new Exception("Execute Failed: " . $query->error);
        }

        $this->name = $name;
        $this->author = $author;
        $this->description = $description;

        return true;
    }

    
    //get articles with specific category id 
    public static function getArticlesbyCategoryId(mysqli $mysqli, $id) {
        $sql = "Select a.name, a.author, a.description FROM articles AS a JOIN categories AS c 
                ON a.category_id = c.id 
                WHERE a.category_id = ?";

        $query = $mysqli->prepare($sql);
        if (!$query) {
            throw new Exception("Prepare Failed: " . $mysqli->error);
        }

        $query->bind_param("i", $id);
        if (!$query->execute()) {
            throw new Exception("Execute Failed: " . $query->error);
        }

        $results = $query->get_result();
        $articles = [];

        while ($row = $results->fetch_assoc()) {
            $articles[] = $row;
        }
        return $articles;
    }

        //get category with specific article id 
    public static function fetchCategoryByArticleId(mysqli $mysqli, $id) {
        $sql = "Select c.name, c.description FROM categories AS c JOIN articles AS a ON a.category_id = c.id 
                WHERE a.id = ?";

        $query = $mysqli->prepare($sql);
        if (!$query) {
            throw new Exception("Prepare Failed: " . $mysqli->error);
        }

        $query->bind_param("i", $id);
        if (!$query->execute()) {
            throw new Exception("Execute Failed: " . $query->error);
        }

        $result = $query->get_result();
        return $result->fetch_assoc(); 
    }
}
