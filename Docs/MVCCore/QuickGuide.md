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

## Wil je een [layout](./MVCCore.md#view) toevoegen aan de view?
Het is handig om een layout te hebben voor je applicatie. Dit is om ervoor te zorgen dat je gemakkelijk alle pagina's dezelfde header en footer kan geven. Daarnaast zul je de layout gebruiken om externe scripts en css libraries in te laden. Als je dit met de layout doet dan hoef je dit maar een keer te defineren.

Om een layout toe te voegen moet je er eerst een maken. De verschillende layouts plaats je in de map `src/App/Content/Views/Layouts`. De layout moet je een naam geven. Bijvoorbeeld `main.layout.php`. De `.layout` is een namig convention die we gebruiken om aan te geven dat het een layout is. Nu je dit hebt gedaan moet je de layout nog vullen met HTML. Dit doe je bijvoorbeeld zo:
```php
<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to My Website</h1>
    </header>

    <main>
        <?php echo $content; ?>
    </main>

    <footer>
        <p>&copy; 2022 My Website. All rights reserved.</p>
    </footer>
    <script src="someScript.js">
</body>
</html>
```
Het stuk met `<?php echo $content; ?>` is waar de verschillende views worden geladen. Om deze layout te gebruiken bij je home view moet je het volgende toevoegen aan je controller:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . 'index.view.php', [
            'name' => 'Jouw naam'
        ])->withLayout(VIEWS_PATH . 'Layouts/main.layout.php'));
        return $response;
    }
}
```
De `withLayout` functie kun je chainen met de view functie. Het verwacht een path naar de layout file. Nu je dit hebt gedaan kun je de pagina bezoeken op `http://localhost:8000/` en zou je jouw naam moeten zien staan.

## Wil je een component toevoegen aan de view?
Het is handig bepaalde stukken HTML die je vaker toe gaat voegen in een component te zetten. Dit kun je dan meerdere keren toevoegen in je view of zelfs in verschillende views. Een component kan of zelf de data ophalen of kan de data mee krijgen van de view waar je hem gebruikt.

Om een component te maken moet je een component view toevoegen en een component controller. De component view voeg je toe in de map `src/App/Content/Views/Components` het bestand volgt dezelfde naming convention als een controller maar dan met `nameComponent.php` in plaats van `nameController.php`. Een component controller moet altijd de `Component` interface implementeren. Dit doe je door het volgende te doen:
```php
class NameComponent implements Component {
    public function get(?array $data): string {
        return view(VIEWS_PATH . 'Components/nameComponent.view.php', [
            'name' => $data['name']
        ])->render();
    }
}
```
De `get` functie geeft de bijbehorende view terug aan de parent view. Je kan kiezen of je data meegeeft vanuit de parent view of niet. Als je dit niet doet dan zal de component controller deze data zelf moeten ophalen.

Als tweede moeten we de view aanmaken die bij dit component hoort. Dit doe je in de map `src/App/Content/Views/Components`. De view moet je een naam geven. Bijvoorbeeld `name.component.php` dit is een namig convention die we gebruiken om aan te geven dat het een component view is. Nu je dit hebt gedaan moet je de view nog vullen met HTML. Dit doe je bijvoorbeeld zo:
```php
<p>Deze pagina is gemaakt door: <?php echo $name ?></p>
```
Nu je dit hebt gedaan kun je de component gebruiken in je view. Om dit in je home view toe te voegen maak je de volgende aanpassing:
```php
<h1>Home</h1>
<p>Dit is de home pagina</p>
<p>Deze pagina is gemaakt door: <?php echo $name ?></p>
<?php echo component(\Http\Controllers\Components\nameComponent::class, "Jarne") ?>
```