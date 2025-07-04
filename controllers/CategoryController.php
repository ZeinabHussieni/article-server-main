<?php 

require(__DIR__ . "/../models/Category.php");
require_once __DIR__ . '/BaseController.php';
require(__DIR__ . "/../services/CategoryService.php");


class CategoryController extends BaseController {
    
    public function getAllCategories(){
      try{
        if(!isset($_GET["id"])){
            $category = Category::all($this->mysqli);
            $category_array = CategoryService::categoryToArray($category); 
            $this->respondSuccess($category_array);
            return;
        }

        $id = $_GET["id"];
        $category = Category::find($this->mysqli, $id)->toArray();
        $this->respondSuccess($category);
        return;} catch(Exception $e){
          $this-> error($e->getMessage(), 500);
        }
    }

    public function deleteAllCategories(){

        try{
        $category= Category::DeleteAll($this->mysqli);
        $this->respondSuccess($category);
        }catch(Exception $e){
            $this->error($e->getMessage(), 500);
        }

    }

    public function createCategory(){
        //to fetch data from axois
        $input = file_get_contents('php://input');
        $data = json_decode($input, true); 
       try{
        if(isset($data['name'], $data['description'])){
        $name = $data['name'];
        $description = $data['description'];
        $category = Category::create($this->mysqli,$name,$description);
        $this->respondSuccess($category);
        }} catch(Exception $e){
            $this->error($e->getMessage(), 500);
        }

    }
   
    public function DeleteCategory(){
        if (isset($_GET["id"])) {
          $id = (int)$_GET["id"];
        try{
         $success = Category::delete($this->mysqli, $id);
        $this->respondSuccess($success);
        }catch(Exception $e){
            $this->error($e->getMessage(), 500);
        }

    }}

    public function UpdateCategory(){
        //to fetch data from axois
        $input = file_get_contents('php://input');
        $data = json_decode($input, true); 

      try{
        if(isset($data['id'], $data['name'], $data['description'])){
       $id = (int)$data['id'];
       $name = $data['name'];
       $description = $data['description'];
       $category = new Category(['id' => $id,'name' => '', 'description' => '']);

       $success = $category->update($this->mysqli, $name, $description, $id);
       $this->respondSuccess($success);
        }} catch(Exception $e){
         $this->error($e->getMessage(), 500);
        }
        

    }   
}

