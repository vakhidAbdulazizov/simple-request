# SIMPLE-REQUEST
Библиотека представляет из себя набор функций для быстрой реализации Rest-api

The library is a set of functions for quick implementation.

Для того чтобы установить на свой проект надо добавть зависимость в composer.json

In order to install on your project, you need to add a dependency to composer.json

## Пример установки

## Setup example
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/vakhidAbdulazizov/simple-request"
    }
]
```

Создаем класс метода наследуемся от \Simple\Request\Rest\Method\Method реализовываем обязательные функции

Create a method class inherit from \Simple\Request\Rest\Method\Method implement required functions


* `getResponseInstance(Request $request, $http_code, $raw)` -  return new JsonResponse($request, $http_code, $raw);
* `getHttpBody()` -  может возвращать из 3 задекларированных классов / It can return from 3 declared classes

JsonBody(your_object) - для отправки json объектов /  for sending json objects
```
new JsonBody(["test"=>"TEST"])
```
UrlBody(your_object) - для отправки информации в урле / for sending information in the url
```
new UrlBody(["test"=>"TEST"])

```
Combined::combine(принимает n кол-во наследников класса \Simple\Request\Rest\Body\Body) - для отправки комбинированных данных как в урле так и json объекта

Combined::combine (accepts n number of children of the \Simple\Request\Rest\Body\Body class) - for sending combined data both in the url and json object


```
Combined::combine(
    new UrlBody(['test'=>'test', 'api'=>'v1']),
    new JsonBody(['api'=>'test'])
);
```

* `getHttpUrl()` - возвращает путь куда делать запрос /  returns the path where to make the request
* `getHttpHeaders()` - возвращает массив заголовков / returns an array of headers
* `getHttpMethod()` - вовзращает метод запроса / returns the request method

Также есть функция для авторизации runExtra

There is also a function for authorization runExtra

```
public function runExtra(Request $request)
{
    $request->setUser($this->user)->setPassword($this->password);
}
```

## Пример запроса 

##  Request example
```
$request = \Simple\Request\Rest\Transport\Request::bind(
   (new \Simple\Request\Rest\Method\TestMethod(['TEST'=>'test']))
)-send();

```
Чтобы получить ответ используйте функцию getFormattedData()

To get a response use the getFormattedData() function
```
$answer = $request->getFormattedData();
```

## Пример описанного метода

## An example of the described method

```
namespace  Simple\Request\Rest\Method;

use Simple\Request\Rest\Body\Combined;
use Simple\Request\Rest\Body\JsonBody;
use Simple\Request\Rest\Body\UrlBody;
use Simple\Request\Rest\Transport\JsonResponse;
use Simple\Request\Rest\Transport\Request;
use Simple\Request\Rest\Transport\Response;

class TestMethod extends Method
{
    protected array $body;

    public function __construct($body)
    {
        $this->body = $body;
    }

    public function getResponseInstance(Request $request, $http_code, $raw): JsonResponse|Response
    {
        return new JsonResponse($request, $http_code, $raw);
    }

    public function getHttpBody(): Combined
    {

        return Combined::combine(
            new UrlBody(['test'=>'test', 'api'=>'v1']),
            new JsonBody(['api'=>'test'])
        );
    }

    public function getHttpUrl(): string
    {
        return 'https://webhook.site/0dedc4f7-c343-463a-aee0-f6a5560353c4';
    }

    public function getHttpHeaders(): array
    {
        return [
            'Content-Type'=>'application/json'
        ];
    }

    public function getHttpMethod(): string
    {
        return Request::POST;
    }

}
```
 
