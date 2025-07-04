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
  

}
