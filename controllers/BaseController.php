<?php
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ResponseService.php");

class BaseController {
    protected $mysqli;

    public function __construct() {
        global $mysqli;
        $this->mysqli = $mysqli;
    }

    protected function respondSuccess($data, $status = 200) {
        echo ResponseService::success_response($data, $status);
    }

    protected function error($message, $status = 400) {
        echo ResponseService::error_response($message, $status);
    }
}
