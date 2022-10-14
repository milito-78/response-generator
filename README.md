[![Latest Version on Packagist](https://img.shields.io/packagist/v/milito/response-generator.svg?style=flat-square)](https://packagist.org/packages/milito/response-generator)
[![Total Downloads](https://poser.pugx.org/milito/response-generator/downloads)](https://packagist.org/packages/milito/response-generator)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](https://packagist.org/packages/milito/response-generator)

# Response Generator
## _Json Response Generator for Laravel Projects_
I use this package to make it easier to change the JSON response structure.

## Introduction
Use this package to make more flexible responses.
This package can only be used in Laravel.

## Usage
First install the package via [composer](https://getcomposer.org/) using the following command :
```sh
composer requires milito/response-generator
```
Then import the `MilitoResponseGeneratorServiceProvider` service provider to `config/app.php` file :
```php
<?php

return [
    //....
    
    "providers" => [
        //...
                \Milito\ResponseGenerator\Providers\MilitoResponseGeneratorServiceProvider::class,
        //...
    ]
];
```

Now you can use `MilitoResponseGenerator` facade to generate your responses.
* ```MilitoResponseGenerator::success() : SuccessState``` This is used for success responses.
* ```MilitoResponseGenerator::failed() : FailedState``` This is used for failed responses.

### Example
##### Success Response
This is for success response :
```php
<?php
use Illuminate\Support\Facades\Route;
use Milito\ResponseGenerator\Facades\MilitoResponseGenerator;

Route::get('/', function () {
    return MilitoResponseGenerator::success()
            ->succeeded() // Sets the `Http Status code` field of response to `HTTP_OK` (200).
            ->message("Success response message") // Sets the `message` field of response.
            ->data([
                "body" => "Success response body"
            ]) // Sets the `data` field of response.
            ->send(); // Generates the response as a `json` response.
});
```

The response should be like this :
```json

{
  "message": "Success response message",
  "success": true,
  "code": 200,
  "data": {
    "body": "Success response body"
  }
}
```

##### Failed Response
This is for failed response :
```php
<?php
use Illuminate\Support\Facades\Route;
use Milito\ResponseGenerator\Facades\MilitoResponseGenerator;

Route::get('/', function () {
    return MilitoResponseGenerator::failed()
            ->code(\Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR) // Sets the `Http Status code` field of response to `SERVER_ERROR` (500).
            ->message("Error Response message") // Sets the `message` field of response.
            ->errors(["Yeah this is error"]) // Sets the `error` & the `errors` fields of response.
            ->send(); // Generates the response as a `json` response.
});
```
The response should be like this :
```json
{
  "message": "Error Response message",
  "success": false,
  "code": 500,
  "error": "Yeah this is error",
  "errors": {
    "all": [
      "Yeah this is error"
    ]
  }
}
```
> **Note 1** : If you don't want to show `success`, `code`, or `errors` fields, you can disable them through the config file.

> **Note 2** : If you want to change the position of the fields, you can change it through the config file.

## Docs
#### _Functions & Classes_
Now, how to handle success response. For example, we use facade to start a response, we set response fields step by step.
Now we need to know how to work with these functions and how to generate our success response.

#### Success Response
##### SuccessState
After using```MilitoResponseGenerator::success()``` function to start a success response, we will have an object of `SuccessState` type.
We will have the following functions for `SuccessState` (This is an object) :
| Function | Input | Output | Description |
| ------ | ------ | ---------| ---------|
| code(`int` $code) | `int` status_code | `MessageState` object | Sets Http code (what ever you want) |
| succeeded() | `void` | `MessageState` object |  Sets Http code as **HTTP_OK** code (**200**) |
| created() | `void` | `MessageState` object | Sets Http code as **HTTP_CREATED** code (**201**)|
| accepted() |`void` | `MessageState` object | Sets Http code as **HTTP_ACCEPTED** code (**202**)|
| updated() | `void` | `SendState` object | Sets http code as **HTTP_NO_CONTENT** code and doesn't need a body (**204**)|
> **Note** : If used `updated()` function, it means we need `no content` response. Because of that, the next state is `SendState` to generate the response.

##### MessageState
`MessageState` has these functions :
| Function | Input | Output | Description |
| ------ | ------ | ---------| ---------|
| message(`string` $message) | `string` message | `DataState` object | Sets the `message` field of response |

##### DataState
`DataState` has these functions :
| Function | Input | Output | Description |
| ------ | ------ | ---------| ---------|
| data(`mixed` $data) | `mixed` data | `SendState` object | Sets the `data` field of response |
| send(`array` $headers = []) | `array` headers | `JsonResponse` object | Generates Response. |

> **Note 1** : `mixed` input type because we pass `array` or `object` or `json resources` or etc... to our data function.

> **Note 2** : We can send a response with an empty data.

##### SendState
`SendState` is the last step. After that, we use `send` function to generate a response and return it to client.
| Function | Input | Output | Description |
| ------ | ------ | ---------| ---------|
| send(`array` $headers = []) | `array` headers | `JsonResponse` object | Generates Response. |


#### Failed Response
##### FailedState
After using ```MilitoResponseGenerator::failed()``` function to start a failed response, we will have an object of `FailedState` type.
We will have the following functions for `FailedState` (This is an object) :
| Function | Input | Output | Description |
| ------ | ------ | ---------| ---------|
| code(`int` $code) | `int` status_code | `MessageState` object | Sets the Http code (what ever you want) |

##### MessageState
`MessageState` has these functions :
| Function | Input | Output | Description |
| ------ | ------ | ---------| ---------|
| message(`string` $message) | `string` message | `ErrorState` object | Set `message` field of response |

##### MessageState
`MessageState` has these functions :
| Function | Input | Output | Description |
| ------ | ------ | ---------| ---------|
| errors(`mixed` $errors) | `mixed` message | `DataState` object | Sets the `error` & the `errors (as object)` fields of response |
| send(`array` $headers = []) | `array` headers | `JsonResponse` object | Generates Response. |
> **Note 1** : `mixed` input type because we pass `array` or `object` or `string` or etc... to our errors function.

> **Note 2** : We can generate response without the `error` & the `errors` fields value.

##### DataState
`DataState` has these functions :
| Function | Input | Output | Description |
| ------ | ------ | ---------| ---------|
| data(`mixed` $data) | `mixed` data | `SendState` object | Sets the `data` field of response |
| send(`array` $headers = []) | `array` headers | `JsonResponse` object | Generates Response. |

> **Note 1** : `mixed` input type because we pass `array` or `object` or `json` resources or etc... to our data function.

> **Note 2** : We can send a response with an empty data.

> **Note 3** : Sometimes we need to send data after our request failed. Because of that, we have `DataState` here.

##### SendState
`SendState` is the last step. After that, we use `send` function to generate a response and return it to client.
| Function | Input | Output | Description |
| ------ | ------ | ---------| ---------|
| send(`array` $headers = []) | `array` headers | `JsonResponse` object | Generates Response. |


## Publish config
Use the following command to publish the config file to change the response fields name or makes some fields hidden from the response :
```sh
php artisan vendor:publish --tag=milito-response-config
```

## Test
Use the following command to run tests:
```sh
composer test
```


## License

MIT
