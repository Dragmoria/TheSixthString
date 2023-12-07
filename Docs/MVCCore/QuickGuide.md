# Quick Guide
> **Tijdsduur:** 5 minuten

Hier een snelle flow van werkzaamheden die je zult/kunt uitvoeren bij het toevoegen van een nieuwe pagina aan de website.

## Basic
### De [Controller](./MVCCore.md#controller)
Als eerste is het handig om te beginnen met het toevoegen van een controller. Dit doe je in het mapje `src/App/Http/Controllers`. Hier komen alle controllers te staan. De naming convention zal zijn dat de controller naam eindigt op `Controller`. Dus bijvoorbeeld `HomeController`. Nu je dit bestand hebt toegevoegd moet je als eerste de namespace van het bestand defineren. Dit doe je door bovenaan het bestand het volgende te zetten:
```php
namespace Http\Controllers;
```
Nu je dit hebt gedaan moet je de controller class defineren. Dit doe je door het volgende te doen:
```php
class HomeController extends Controller {
    // Controller code
}
```
Het is belangrijk dat je altijd de Controller class extend. Dit garandeerd dat de rest van het framework met jouw controller om kan gaan. Nu je dit hebt gedaan kun je beginnen met het toevoegen van de functie die de pagina gaat creeëren. Deze functie kan je noemen wat je wilt. Het is wel handig om er een duidelijke naam voor te bedenken. Bijvoorbeeld `index`. Nu je dit hebt gedaan moet je de functie nog defineren. Dit doe je door het volgende te doen:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        // Controller code
    }
}
```
Voor duidelijkheid heb ik ervoor gekozen een return type aan te geven. Dit is niet per se nodig maar wel handig. Nu je dit hebt gedaan kun je beginnen met het toevoegen van de code die de pagina gaat creeëren. Dit doe je door een [Response](./MVCCore.md#response) object te creeëren. Dit doe je door het volgende te doen:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        // Controller code
    }
}
```
Het `Response` object heeft bijna altijd een body nodig. En aangezien we een view willen toevoegen zullen we dat hier ook moeten doen. Daarom hebben we ook [ViewResponse](./MVCCore.md#viewresponse) gebruikt. Om de body van een `ViewResponse` object te zetten moet je een [View](./MVCCore.md#view) object hebben. Dit krijg je door gebruik te maken van de [View](./MVCCore.md#view) methode. Dit doe je door het volgende te doen:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . 'index.view.php'));
        // Controller code
    }
}
```
Nu je dit hebt gedaan kun je de response returnen. Dit doe je door het volgende te doen:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . 'index.view.php'));
        return $response;
    }
}
```


### De router
Als tweede is het handig om te beginnen met het toevoegen van een route aan de router. Dit doe je in [bootstrapper.php](../../src/App/bootstrapper.php). Hier staan de routes gedefineerd. Om een nieuwe route toe te voegen moet je het volgende toe te voegen.
```php
$router->get('/', [HomeController::class, 'index']);
```
Let wel op dat ook de use statement bovenaan in het bestand toevoegd. Dit doet je editor soms automatisch maar niet altijd.

### De view
Als derde is het handig om een view aan te maken. Dit doe je in de map `src/App/Content/Views`. Zoals je in de controller al hebt gedefineerd moet je de view `index.view.php` noemen. De `.view` is een namig convention die we gebruiken om aan te geven dat het een view is. Nu moet je in de view nog wat HTML toevoegen. Dit doe je bijvoorbeeld zo:
```html
<h1>Home</h1>
<p>Dit is de home pagina</p>
```
Nu je dit hebt gedaan kun je de pagina bezoeken op `http://localhost:8000/`.

## Wil je data toevoegen aan de view?
Als je data wilt toevoegen aan de view moet je eerst de vieuw van hierboven aanpassen. Dit doe je door het volgende te doen:
```html
<h1>Home</h1>
<p>Dit is de home pagina</p>
<p>Deze pagina is gemaakt door: <?php echo $name ?></p>
```
Zoals je ziet hebben we een stukje php in de html gezet. Dit is de manier om data toe te voegen aan een view. De naam van de variabele die je hier hebt aangegeven is belangrijk om te onthouden. Deze moet je namelijk ook gebruiken in de controller. Dit doe je door het volgende te doen:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . 'index.view.php', [
            'name' => 'Jouw naam'
        ]));
        return $response;
    }
}
```
Nu je dit hebt gedaan kun je de pagina bezoeken op `http://localhost:8000/` en zou je jouw naam moeten zien staan.

## Wil je een layout toevoegen aan de view?

## Wil je een component toevoegen aan de view?