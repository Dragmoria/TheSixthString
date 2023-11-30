# MVCCore
> **Tijdsduur:** 1 million billion minuten

# Inhoudsopgave
- [Inhoudsopgave](#inhoudsopgave)
- [Inleiding](#inleiding)
- [MVC](#mvc)
- [MVCCore](#mvccore-1)

## Inleiding
Voor de webshop zullen wij een vorm van MVC toepassen. We hebben een "package" gemaakt voor MVC. Deze package heet MVCCore. Deze package is wat functionaliteit gebaseerd op Laravel. De bedoeling is doormiddel van deze package het makkelijker is om MVC toe te passen in de webshop.

## MVC

Het Model-View-Controller (MVC) patroon is een ontwerppatroon dat wordt gebruikt in softwareontwikkeling om de structuur en organisatie van een applicatie te verbeteren. Het helpt ontwikkelaars om de code beter te organiseren en de onderhoudbaarheid te vergroten.

MVC bestaat uit drie hoofdcomponenten: het Model, de View en de Controller.
1. **Het Model:** Het Model vertegenwoordigt de gegevens en de logica van de applicatie. Het kan bijvoorbeeld de databasegegevens bevatten en de regels voor gegevensvalidatie definiëren. Het Model is verantwoordelijk voor het ophalen, bijwerken en opslaan van gegevens.

2. **De View:** De View is verantwoordelijk voor het weergeven van de gebruikersinterface aan de gebruiker. Het kan HTML-pagina's, formulieren, grafieken, enz. bevatten. De View krijgt gegevens van het Model en toont deze aan de gebruiker.

3. **De Controller:** De Controller fungeert als een tussenpersoon tussen het Model en de View. Het ontvangt gebruikersinvoer van de View en verwerkt deze. Het kan bijvoorbeeld gegevens uit het Model ophalen, deze aanpassen en doorgeven aan de View om te worden weergegeven. De Controller bevat de logica van de applicatie en coördineert de interactie tussen het Model en de View.

Het MVC-patroon bevordert de scheiding van verantwoordelijkheden en maakt het gemakkelijker om wijzigingen aan te brengen in de applicatie. Het maakt het ook mogelijk om verschillende weergaven te maken voor dezelfde gegevens, waardoor de flexibiliteit en herbruikbaarheid van de code wordt vergroot.

Om het MVC-patroon in een applicatie te implementeren, moet je de logica van de applicatie scheiden in de Model-, View- en Controller-componenten. Hiervoor worden vaak frameworks gebruikt maar aangezien we die niet kunnen toepassen voor dit project hebben we onze eigen simpele variant gemaakt.

Het MVC-patroon kan een krachtig hulpmiddel zijn bij het ontwikkelen van software, vooral voor grotere en complexere applicaties. Het helpt bij het organiseren van de code, het verbeteren van de onderhoudbaarheid en het vergemakkelijken van samenwerking tussen ontwikkelaars.

![MVC](https://shreysharma.com/wp-content/uploads/2019/04/mvc.webp)

## MVCCore
De package die we hebben bestaat uit een aantal onderdelen. Ik zal deze onderdelen hier beschrijven en uitleggen wat je er mee kan. Daarna zal ik een stel voorbeelden uitwerken. Vervolgens kun je zelf door de code heen kijken. Elke class en functie heeft een docblock met uitleg.

1. [Application](#application)
2. [Container](#container)
    2.1. [Lifetime](#lifetime)
    2.2. [Interface naar class registratie](#interface-naar-class-registratie)
    2.3. [Resolver](#resolver)
3. [Router](#router)
4. [Request](#request)
    4.1. [hasPostData](#haspostdata)
    4.2. [getPostData](#getpostdata)
    4.3. [path](#path)
    4.4. [fullUrl](#fullurl)
    4.5. [url](#url)
    4.6. [method](#method)
    4.7. [hasHeader / allHeaders / header](#hasheader--allheaders--header)
    4.8. [hasCookie / allCookies / cookie](#hascookie--allcookies--cookie)
    4.9. [urlQueryParams](#urlqueryparams)
    4.10. [wantsJson](#wantsjson)
5. [PostObject](#postobject)
6. [Response](#response)
7. [Controller](#controller)
8. [Middleware](#middleware)

### Application
De application class is het startpunt van de applicatie. Wanneer een request van de client binnenkomt wordt er in bootstrapper.php alles opgezet. Hier hang je services aan de container, voeg je routes toe aan de router en voeg je mogelijk middlewares toe aan de routes. De container en router worden dan allebei aan de Application class gebonden. Hierdoor kun je later op andere plekken in de applicatie de container en router gebruiken.

Als eerste wordt de Application::initialize functie aangeroepen. Deze functie bind de container en router aan de Application class. Daarna wordt er een sessie gestart. De sessie is per client uniek. Als een client al eerder een sessie heeft ontvangen van de server zal de sessie start functie deze sessie uit het automatisch gegeneerde sessie bestand inladen. Als de client nog niet eerder een sessie heeft gekregen zal de server deze aanmaken en naar de client sturen. De sessie kun je gebruiken om data tussen requests op te slaan. Denk aan een winkelwagen, een ingelogde gebruiker of post data. De sessie is een array waar je data in kunt opslaan. Deze data wordt dan opgeslagen in het sessie bestand. De sessie is een globale variabele en is dus overal in de applicatie te gebruiken.

Als laatste wordt in bootstrapper.php de Application::run functie aangeroepen. Deze functie verteld de router dat deze de request moet gaan verwerken.

Het doel van de Application class is dat je door de gehele applicatie altijd bij de router en bij de container kan komen om functies uit te voeren op die classen. Dit is handig omdat je dan niet steeds de router en container mee hoeft te geven aan een functie. Je kunt dan gewoon de Application class meegeven en dan kan de functie zelf de router en container ophalen.

### Container
De container is een class waar je verschillende services kan registreren. Deze services kun je dan later weer ophalen. De container is een globale variabele en is dus overal in de applicatie te gebruiken. 

Een service is een class die je graag op meerdere plekken wilt gebruiken maar je wilt deze class niet steeds weer moeten initialiseren. Je kunt dan de service registreren in de container en dan kun je de service ophalen wanneer je deze nodig hebt. Dit is bijvoorbeeld handig voor je database class. Deze heeft bepaalde data nodig uit een .env bestand zoals de gebruikersnaam en wachtwoord van de database. Je wilt dus niet elke keer weer deze data opnieuw aan de database class geven. Om dit te voorkomen kun je dus de database class registreren in de container. Dit zou er als volgt uit kunnen zien:

```php
$container = Application::getContainer();
$container->register(Database::class);
```

Nu kun je de database class ophalen uit de container. Dit doe je als volgt:

```php
$database = Application::resolve(Database::class);
// of
$container = Application::getContainer();
$database = $container->resolve(Database::class);
```

De manier waarop de Database nu is geregistreerd noemen we een transient. Een transient betekend dat elke keer dat je `resolve(Database::class)` aanroept je een nieuwe instantie krijgt van de `Database` class. Dit is de lifetime van de class.

#### Lifetime
Een lifetime in deze context betekend dus hoe lang de resolved class blijft bestaan. De container in MVCCore ondersteunt twee verschillende lifetimes:
1. Transient
> Transient betekend dat elke keer dat je `resolve(Database::class)` aanroept je een nieuwe instantie krijgt van de `Database` class.
2. Singleton
> Singleton betekend dat elke keer dat je `resolve(Database::class)` aanroept je dezelfde instantie krijgt van de `Database` class. De eerste keer dat je `resolve(Database::class)` aanroept wordt de `Database` class geïnstantieerd en opgeslagen in de container. De volgende keren dat je `resolve(Database::class)` aanroept krijg je dezelfde instantie terug.

Dit kan handig zijn voor bijvoorbeeld een logger class. Je wilt niet elke keer dat je een log wilt maken een nieuwe instantie van de logger class aanmaken. Je wilt dus dat de logger class een singleton is. Dit zou er als volgt uit kunnen zien:

```php
$container = Application::getContainer();
$container->register(Logger::class)->asSingleton();
```
Voor transient is dit niet nodig want standaard is een registratie een transient. Maar als je duidelijk wilt aangeven dat het om een transient gaat kun je dit doen:
```php
$container = Application::getContainer();
$container->register(Logger::class)->asTransient();
```

#### Interface naar class registratie
Soms heb je een interface. Denk bijvoorbeeld aan een database class. Elke implementatie van deze class moet volgens de specificaties een aantal functies hebben. Zoals een `connect` functie. Je wilt dus dat elke implementatie deze functie heeft. Dit forceer je door een interface aan te maken. Deze interface kan er als volgt uitzien.
```php
interface IDatabase {
    public function connect();
}
```
En een mogelijke implementatie als volgt:
```php
class Database implements IDatabase {
    public function connect() {
        // ...
    }
}
```
Wanneer je een interface gebruikt zul je overal waar je de database nodig hebt niet de `Database` class moeten gebruiken maar de `IDatabase` interface. Dit is belangrijk omdat je dat de implementatie kan verwisselen zonder dat de rest van je programma hier last van heeft. Om dit in de container te ondersteunen kun je een interface registreren naar een class. Dit ziet er als volgt uit:
```php
$container = Application::getContainer();
$container->registerInterface(IDatabase::class, Database::class);

$database = Application::resolve(IDatabase::class);
```

#### Resolver
Dit is het laatste wat de MVCCore container ondersteund. Soms heb je een class die in de constructor bepaalde data verwacht. Denk aan de database class die een gebruikersnaam en wachtwoord van de database wilt hebben. 
```php
class Database {
    protected string $username;
    protected string $password;

    public function __construct(string $username, string $password) {
        // ...
    }
}
```
Om dit met je registratie te laten werken moet je een resolver meegeven. Een resolver is een functie die wordt aangeroepen op het moment dat ergens om de geregistreerde class wordt gevraagd. Dit ziet er als volgt uit:
```php
$container = Application::getContainer();
$container->register(Database::class)->asSingleton()->withResolver(function() {
    return new Database("username", "password");
});
```
Standaard heeft elke registratie ook een resolver maar die standaard resolver kan niet omgaan met parameters in de constructor. Als je dus een registratie hebt met een constructor met parameters moet je zelf een resolver meegeven.

### Router
De router class is het deel van de applicatie dat de requests afhandeld. De router kijkt naar het type request en de mogelijk methode die is meegeven om te beslissen welke route hier bij hoort. Daarnaast kijkt die natuurlijk naar het gevraagde pad. / is bijvoorbeeld de index van de website. De router zal dus aan de hand van het pad en het type request zijn geregistreerde routes aflopen om te kijken of er een match is. Als er een match is zal de router de bijbehorende controller aanroepen. Deze zo genaamde `routes` moeten natuurlijk wel geregistreerd worden. Dit kun je doen in de `bootstrapper.php` file. Dit ziet er als volgt uit:
```php
$router = Application::getRouter();

$router->get("/", [HomeController::class, "index"]);
```
Deze actie heeft nu een route geregistreerd voor het pad `/` en voor het type request `GET`. Als er nu een request binnenkomt voor `/` met het type `GET` zal de router de `index` functie van de `HomeController` aanroepen. Deze functie moet dan wel bestaan. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        // ...
    }
}
```
Hoe je een controller maakt en wat je er mee komt iets later aan bod. 

De router ondersteund de volgende request types:
- GET
- POST
- PATCH
- PUT
- DELETE

Get zul je voornamelijk toepassen bij het ophalen van data. Denk aan de view voor een route of producten met een filter. Post zul je voornamelijk toepassen bij het aanmaken van data. Denk aan het aanmaken van een product of het aanmaken van een bestelling. Patch zul je voornamelijk toepassen bij het aanpassen van data. Denk aan het aanpassen van een product of het aanpassen van een bestelling. Put zul je voornamelijk toepassen bij het vervangen van data. Denk aan het vervangen van een product of het vervangen van een bestelling. Delete zul je voornamelijk toepassen bij het verwijderen van data. Denk aan het verwijderen van een product of het verwijderen van een bestelling. 

Put, Patch en Delete worden door html niet ondersteund. Html heeft namelijk alleen GET en POST. Omdat het handig kan zijn op dezelfde url meerdere POST request af te kunnen handelen hebben we dit dus wel nodig. Om in Html een PUT request te maken doen we dan alsvolgt:
```html
<form>
    <input type="hidden" name="_method" value="PUT">
    <!-- ... -->
    <button type="submit">post</button>
</form>
```
De router kijkt dan naar de `_method` post variabele en zal dan de PUT route afhandelen. Dit werkt ook voor PATCH en DELETE. Om een PATCH route te registreren doe je het volgende:
```php
$router = Application::getRouter();

$router->patch("/", [HomeController::class, "patch"]);
```
Om een DELETE route te registreren doe je het volgende:
```php
$router = Application::getRouter();

$router->delete("/", [HomeController::class, "delete"]);
```
Om een PUT route te registreren doe je het volgende:
```php
$router = Application::getRouter();

$router->put("/", [HomeController::class, "put"]);
```
Om een POST route te registreren doe je het volgende:
```php
$router = Application::getRouter();

$router->post("/", [HomeController::class, "post"]);
```
Als de router voor een request path geen registratie kan vinden zal die een 404 error geven. Dit is een error die aangeeft dat de gevraagde pagina niet bestaat. Dit is een error die je zelf kunt opvangen en een mooie pagina voor kunt maken. Deze pagina kun je ook registreren in de router. Dit doe je bijvoorbeeld als volgt:
```php
$router = Application::getRouter();

$router->registerStatusView(404, [ErrorController::class, "notFound"]);
```
Als laatste kun je per route een middleware registreren. Wat een middleware is en hoe je deze toevoegd aan een route wordt later uitgelegd.

### Request
- [hasPostData](#haspostdata)
- [getPostData](#getpostdata)
- [path](#path)
- [fullUrl](#fullurl)
- [url](#url)
- [method](#method)
- [hasHeader / allHeaders / header](#hasheader--allheaders--header)
- [PostObject](#postobject)


De request class is een class die de request van de client representeert. Elke keer als de client een url opvraagt of een iets stuurt aan de hand van javascript of een form post, is er een request. Deze request bevat alle belangrijke informatie voor de server om de juiste response terug te sturen. De request class wordt bij `Application::initialize`. Deze instantie wordt vervolgens meegegeven aan de router. De router gebruikt deze request instantie om de juiste route te vinden. Als laatste wordt de route meegegeven naar de controller die wordt aangeroepen. Dit gebeurt aan de hand van de `setRequest()` methode die elke controller heeft. De controller kan dan de request gebruiken om bijvoorbeeld de post data op te halen.

De request class bestaat uit twee delen. De eerste is gewoon het request van de client en de tweede is een `PostObject`, deze bestaat alleen als het request een POST request is. De request class heeft een aantal functies die je kunt gebruiken om informatie op te halen uit het request. 

#### hasPostData
Als je in je controller wilt weten of je request post data heeft kun je het volgende doen:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        if ($request->hasPostData()) {
            // ...
        }
    }
}
```

#### getPostData
Je kan ook gewoon direct post data ophalen uit het request. Als dit dan niet bestaat krijg je `null` terug, als het er wel is krijg je een PostObject instantie terug. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        $post = $request->getPostData();
        if ($post !== null) {
            // ...
        }
    }
}
```

#### path
path geeft alleen het pad terug. Logisch natuurlijk. Het pad is bij deze url `http://localhost:8080/home?abc=123` `/home`. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        $path = $request->path();
        // $path = "/home"
    }
}
```

#### fullUrl
fullUrl geeft de volledige url terug. Dit is inclusief het pad en de query parameters. De volledige url is bij deze url `http://localhost:8080/home?abc=123` `http://localhost:8080/home?abc=123`. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        $fullUrl = $request->fullUrl();
        // $fullUrl = "http://localhost:8080/home?abc=123"
    }
}
```

#### url
url geeft alleen de url terug zonder de query params. De url is bij deze url `http://localhost:8080/home?abc=123` `http://localhost:8080/home`. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        $url = $request->url();
        // $url = "http://localhost:8080/home"
    }
}
```

#### method
method geeft de methode terug van het request. De methode is bij deze url `http://localhost:8080/home?abc=123` `GET`. Bij een form zoals eerder uitgelegd kan dit ook `POST`, `PUT`, `PATCH` of `DELETE` zijn. Meestal gebruik je deze functie niet in de controller. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        $method = $request->method();
        // $method = "GET"
    }
}
```


#### hasHeader / allHeaders / header
Header in deze context is de http header. Deze header bevat informatie over het request. Denk aan de browser die wordt gebruikt of de taal van de browser. Je kunt deze informatie gebruiken om bijvoorbeeld de taal van de website aan te passen. Deze informatie kan belangrijk zijn in de manier waarop je de request afhandeld. De hasHeader functie geeft aan of de header bestaat. De allHeaders functie geeft alle headers terug. De header functie geeft een specifieke header terug. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        $hasHeader = $request->hasHeader("User-Agent");
        $allHeaders = $request->allHeaders();
        $header = $request->header("User-Agent");
        // $hasHeader = true
        // $allHeaders = ["User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0"]
        // $header = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0"
    }
}
```

#### hasCookie / allCookies / cookie
Een cookie kan van alles zijn. Bij deze website zullen we vooral gebruik maken van de sessie denk ik dus deze functie zul je waarschijnlijk weinig gebruiken. De hasCookie functie geeft aan of de cookie bestaat. De allCookies functie geeft alle cookies terug. De cookie functie geeft een specifieke cookie terug. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        $hasCookie = $request->hasCookie("PHPSESSID");
        $allCookies = $request->allCookies();
        $cookie = $request->cookie("PHPSESSID");
        // $hasCookie = true
        // $allCookies = ["PHPSESSID" => "1234567890"] -> dit is de sessie id en wordt door session_start() al ingeladen
        // $cookie = "1234567890"
    }
}
```
Deze functie is alleen handig als we cookies naar de client zouden sturen voor andere doeleinden. Toch leek het me handig om het in te bouwen voor het geval dat.

#### urlQueryParams
UrlQueryParams geeft alle query parameters terug. Dit zijn de parameters die achter de url staan. Bijvoorbeeld `http://localhost:8080/home?abc=123` `abc=123`. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        $urlQueryParams = $request->urlQueryParams();
        // $urlQueryParams = ["abc" => "123"]
    }
}
```

#### wantsJson
wantsJson geeft aan of de client om een json response vraagt. Dit is handig als je bijvoorbeeld een route hebt die alleen data terug kan geven. Je kunt dan aan de hand van deze functie bepalen of je een json response terug moet geven of een html response. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index() {
        $request = $this->getRequest();
        $wantsJson = $request->wantsJson();
        // $wantsJson = false
        // true ? repond with a JsonResponse
        // false ? respond with a TextResponse
    }
}
```

### PostObject
- [](#)

Dit object wordt alleen aangemaakt wanneer het request een POST request is. Dit object bevat allerlei informatie over het post request. Daarnaast zijn er wat functies om de post data tijdelijk op te slaan in de sessie. Het nut hiervan kom ik op terug.
