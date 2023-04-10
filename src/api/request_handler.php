<?php
class RequestHandler
{
    protected $routes = [];

    public function __construct()
    {
        // Constructor code goes here
    }

    public function get($route, $handler)
    {
        $this->routes['GET'][$route] = $handler;
    }

    public function post($route, $handler)
    {
        $this->routes['POST'][$route] = $handler;
    }

    public function delete($route, $handler)
    {
        $this->routes['DELETE'][$route] = $handler;
    }

    public function handle()
    {
        // Determine the HTTP request method and route
        $method = $_SERVER['REQUEST_METHOD'];
        $route = $_SERVER['REQUEST_URI'];

        // Find the appropriate handler based on the method and route
        $handler = $this->routes[$method][$route] ?? null;

        // If a handler is found, call it and pass in the request and response objects
        if ($handler) {
            $request = $_REQUEST;
            $response = new HttpResponse();
            $handler($request, $response);
        } else {
            // Handle 404 errors if no matching route is found
            $response = new HttpResponse();
            $response->status(404)->send("Not found");
        }
    }
}

// Instantiate the RequestHandler
// $requestHandler = new RequestHandler();

// // Define routes and handlers
// $requestHandler->get('/hello', function ($request, $response) {
//     $response->send("Hello, world!");
// });

// $requestHandler->post('/submit', function ($request, $response) {
//     $name = $request['name'] ?? 'World';
//     $response->send("Hello, {$name}!");
// });

// $requestHandler->delete('/delete', function ($request, $response) {
//     $response->send("This resource has been deleted");
// });

// Call the handle method to process the request and send the response
// $requestHandler->handle();

class HttpResponse
{
    protected $statusCode = 200;
    protected $headers = [];
    protected $body = '';

    public function status($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    public function header($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function send($body)
    {
        $this->body = $body;

        // Set HTTP status code
        http_response_code($this->statusCode);

        // Set headers
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        // Send response body
        echo $this->body;
    }
}
