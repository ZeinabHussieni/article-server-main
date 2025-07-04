<?php 

require(__DIR__ . "/../models/Article.php");
require_once __DIR__ . '/BaseController.php';
require(__DIR__ . "/../services/ArticleService.php");


class ArticleController extends BaseController {
    
    public function getAllArticles() {
       try {
          if (!isset($_GET["id"])) {
            $articles = Article::all($this->mysqli);
            $articles_array = ArticleService::articlesToArray($articles); 
            $this->respondSuccess($articles_array);
            return;
           }

           $id = $_GET["id"];
           $article = Article::find($this->mysqli, $id)->toArray();
           $this->respondSuccess($article);
           return;

        } catch (Exception $e) {
        $this->error($e->getMessage(), 500);
         }
    }


    public function deleteAllArticles(){
        
        try{
        $article= Article::DeleteAll($this->mysqli);
        $this->respondSuccess($article); 
        }catch(Exception $e){
            $this->error($e->getMessage(), 500);
        }

    }

   public function createArticle() {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

     try {
        if (isset($data['name'], $data['author'], $data['description'], $data['category_id'])) {
            $article = Article::create($this->mysqli, ['name' => $data['name'],
                'author' => $data['author'],
                'description' => $data['description'],
                'category_id' => $data['category_id']
            ]);

            $this->respondSuccess($article);
        } else {
            $this->error("Missing required fields", 400);
        }
        } catch (Exception $e) {
        $this->error($e->getMessage(), 500);
     }
    }

   
    public function DeleteArticle(){
 
        if (isset($_GET["id"])) {
          $id = (int)$_GET["id"];

        try{
        $success = Atricle::delete($this->mysqli, $id);
        $this->respondSuccess($article);
        }catch(Exception $e){
            $this->error($e->getMessage(), 500);
        }
    }}

    public function UpdateArticle(){
        //to fetch data from axois
        $input = file_get_contents('php://input');
        $data = json_decode($input, true); 
         
        try{
        if(isset($data['id'], $data['name'], $data['author'], $data['description'])){
       $id = (int)$data['id'];
       $name = $data['name'];
       $author = $data['author'];
       $description = $data['description'];
       $article = new Article(['id' => $id,'name' => '','author' => '','description' => '']);

       $success = $article->update($this->mysqli, $name, $author, $description, $id);
       $this->respondSuccess($success);    
        }} catch(Exception $e){
         $this->error($e->getMessage(), 500);
        }

    }

    public function getArticlesOfCategoryId(){

        try{
        $id = $_GET["id"];
        $id = (int)$_GET["id"];
        $article = Article::getArticlesbyCategoryId($this->mysqli, $id);
        $this->respondSuccess($article);
        }catch(Exception $e){
         $this->error($e->getMessage(), 500);
        }
    }

    public function getCategoryByArticleId() {
         try {
         if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];
            $category = Article::fetchCategoryByArticleId($this->mysqli, $id);  
            $this->respondSuccess($category);
          } else {
            $this->error("Missing article ID", 400);}
          } catch (Exception $e) {
         $this->error($e->getMessage(), 500);}
    }


}



