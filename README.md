# SIMPLE-REQUEST
Библиотека представляет из себя набор функций для быстрой реализации Rest-api 

Для того чтобы установить на свой проект надо добавть зависимость в composer.json

## Пример установки
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/vakhidAbdulazizov/simple-request"
    }
]
```

Создаем класс метода наследуемся от \Simple\Request\Rest\Method\Method реализовываем обязательные функции

* `getResponseInstance(Request $request, $http_code, $raw)` -  return new JsonResponse($request, $http_code, $raw);
* `getHttpBody()` -  может возвращать из 3 задекларированных классов 
JsonBody(your_object) - для отправки json объектов 
```
new JsonBody(["test"=>"TEST"])
```
UrlBody(your_object) - для отправки информации в урле
```
new UrlBody(["test"=>"TEST"])

```
Combined::combine(принимает n кол-во наследников класса \Simple\Request\Rest\Body\Body) - для отправки комбинированных данных как в урле так и json объекта

```
Combined::combine(
    new UrlBody(['test'=>'test', 'api'=>'v1']),
    new JsonBody(['api'=>'test'])
);
```

* `getHttpUrl()` - возвращает путь куда делать запрос
* `getHttpHeaders()` - возвращает массив заголовков
* `getHttpMethod()` - вовзращает метод запроса

Также есть функция для авторизации runExtra

```
public function runExtra(Request $request)
{
    $request->setUser($this->user)->setPassword($this->password);
}
```

## Пример запроса 
```
$request = \Simple\Request\Rest\Transport\Request::bind(
   (new \Simple\Request\Rest\Method\TestMethod(['TEST'=>'test']))
)-send();

```
Чтобы получить ответ используйте функцию getFormattedData()
```
$answer = $request->getFormattedData();
```

## Пример описанного метода

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
 
