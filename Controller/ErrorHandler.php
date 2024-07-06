<?php
	class ErrorHandler{
    public static function handleException(Throwable $exception) : void { // Throwable is a class in php that give us access to methods that provide us with info about the error{
	        http_response_code(500); // if you do not add it the error_code will be 200 but we want user to know there is something up through the status code
	        echo json_encode([
	            "code" => $exception->getCode(),
	            "message" => $exception->getMessage(),
	            "line" => $exception->getLine(),
            "file" => $exception->getFile()
        ]);
	    } 
	}
