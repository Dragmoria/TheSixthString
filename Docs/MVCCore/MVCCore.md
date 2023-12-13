# MVCCore
> **Leestijd:** 40 minuten

# Inhoudsopgave
- [Inhoudsopgave](#inhoudsopgave)
- [Inleiding](#inleiding)
- [MVC](#mvc)
- [MVCCore](#mvccore-1)

## Inleiding
Voor de webshop zullen wij een vorm van MVC toepassen. We hebben een "package" gemaakt voor MVC. Deze package heet MVCCore. Deze package is wat functionaliteit gebaseerd op Laravel. De bedoeling is doormiddel van deze package het makkelijker is om MVC toe te passen in de webshop.

Er is een demo beschikbaar. Branch Demonstration.

Voor een quick guide kun je kijken naar de [Quick Guide](./QuickGuide.md).

## MVC

Het Model-View-Controller (MVC) patroon is een ontwerppatroon dat wordt gebruikt in softwareontwikkeling om de structuur en organisatie van een applicatie te verbeteren. Het helpt ontwikkelaars om de code beter te organiseren en de onderhoudbaarheid te vergroten.

MVC bestaat uit drie hoofdcomponenten: het Model, de View en de Controller.
1. **Het Model:** Het Model vertegenwoordigt de gegevens en de logica van de applicatie. Het kan bijvoorbeeld de databasegegevens bevatten en de regels voor gegevensvalidatie definiëren. Via het Model worden de gegevens (waaronder de gegevens die op het scherm moeten worden getoond), aan de View gegeven.

2. **De View:** De View is verantwoordelijk voor het weergeven van de gebruikersinterface aan de gebruiker. Het kan HTML-pagina's, formulieren, grafieken, enz. bevatten. De View krijgt gegevens van het Model en toont deze aan de gebruiker.

3. **De Controller:** De Controller fungeert als een tussenpersoon tussen het Model en de View. Het ontvangt gebruikersinvoer van de View en verwerkt deze. De Controller bevat de logica van de applicatie en coördineert de interactie tussen het Model en de View. De Controller zorgt ervoor dat het Model wordt gevuld met data en dat de View (samen met deze data) wordt getoond aan de gebruiker. De Controller is ook het doorgeefluik naar de Services die alle acties op de database uitvoeren.

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
4. [Redirect](#redirect)
5. [Request](#request)
    5.1. [hasPostData](#haspostdata)
    5.2. [getPostData](#getpostdata)
    5.3. [path](#path)
    5.4. [fullUrl](#fullurl)
    5.5. [url](#url)
    5.6. [method](#method)
    5.7. [hasHeader / allHeaders / header](#hasheader--allheaders--header)
    5.8. [hasCookie / allCookies / cookie](#hascookie--allcookies--cookie)
    5.9. [urlQueryParams](#urlqueryparams)
    5.10. [wantsJson](#wantsjson)
6. [PostObject](#postobject)
    6.1 [Flash](#flash)
    6.2 [FlashPostError](#flashposterror)
    6.3 [Old](#old)
    6.4 [OldBody](#oldbody)
    6.5 [OldFiles](#oldfiles)
    6.6 [HasPostErrors](#hasposterror)
    6.7 [GetPostError](#getposterror)
    6.8 [GetPostErros](#getposterrors)
    6.9 [Flush](#flush)
    6.10 [hasFile](#hasfile)
    6.11 [files](#files)
    6.12 [body](#body)
    6.13 [isAjax](#isajax)
    6.14 [isJson](#isjson)
7. [Response](#response)
8. [Controller](#controller)
9. [Middleware](#middleware)
10. [View](#view)
11. [Partial / Component](#partial--component)
    11.1 [Partial](#partial)
    11.2 [Component](#component)
12. [Model](#model)


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
De router class is het deel van de applicatie dat de requests afhandelt. De router kijkt naar het type request en de mogelijk methode die is meegeven om te beslissen welke route hier bij hoort. Daarnaast kijkt die natuurlijk naar het gevraagde pad. / is bijvoorbeeld de index van de website. De router zal dus aan de hand van het pad en het type request zijn geregistreerde routes aflopen om te kijken of er een match is. Als er een match is zal de router de bijbehorende controller aanroepen. Deze zo genaamde `routes` moeten natuurlijk wel geregistreerd worden. Dit kun je doen in de `bootstrapper.php` file. Dit ziet er als volgt uit:
```php
$router = Application::getRouter();

$router->get("/", [HomeController::class, "index"]);
```
Deze actie heeft nu een route geregistreerd voor het pad `/` en voor het type request `GET`. Als er nu een request binnenkomt voor `/` met het type `GET` zal de router de `index` functie van de `HomeController` aanroepen. Deze functie moet dan wel bestaan. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
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

### Redirect
De redirect functie is een globale functie die je kunt gebruiken om gemakkelijk de client te redirecten naar een andere url. Dit zier er als volgt uit:
```php
redirect("/home");
```
Lekker simpel dus.

### Request
- [hasPostData](#haspostdata)
- [getPostData](#getpostdata)
- [path](#path)
- [fullUrl](#fullurl)
- [url](#url)
- [method](#method)
- [hasHeader / allHeaders / header](#hasheader--allheaders--header)
- [PostObject](#postobject)


De request class is een class die de request van de client representeert. Elke keer als de client een url opvraagt of een iets stuurt aan de hand van javascript of een form post, is er een request. Deze request bevat alle belangrijke informatie voor de server om de juiste response terug te sturen. De request class wordt bij `Application::initialize`. Deze instantie wordt vervolgens meegegeven aan de router. De router gebruikt deze request instantie om de juiste route te vinden. Als laatste wordt de request meegegeven naar de controller die wordt aangeroepen. Dit gebeurt aan de hand van de `setRequest()` methode die elke controller heeft. De controller kan dan de request gebruiken om bijvoorbeeld de post data op te halen.

De request class bestaat uit twee delen. De eerste is gewoon het request van de client en de tweede is een `PostObject`, deze bestaat alleen als het request een POST request is. De request class heeft een aantal functies die je kunt gebruiken om informatie op te halen uit het request. 

#### hasPostData
Als je in je controller wilt weten of je request post data heeft kun je het volgende doen:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
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
    public function index(): ?Response {
        $request = $this->currentRequest;
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
    public function index(): ?Response {
        $request = $this->currentRequest;
        $path = $request->path();
        // $path = "/home"
    }
}
```

#### fullUrl
fullUrl geeft de volledige url terug. Dit is inclusief het pad en de query parameters. De volledige url is bij deze url `http://localhost:8080/home?abc=123` `http://localhost:8080/home?abc=123`. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $fullUrl = $request->fullUrl();
        // $fullUrl = "http://localhost:8080/home?abc=123"
    }
}
```

#### url
url geeft alleen de url terug zonder de query params. De url is bij deze url `http://localhost:8080/home?abc=123` `http://localhost:8080/home`. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $url = $request->url();
        // $url = "http://localhost:8080/home"
    }
}
```

#### method
method geeft de methode terug van het request. De methode is bij deze url `http://localhost:8080/home?abc=123` `GET`. Bij een form zoals eerder uitgelegd kan dit ook `POST`, `PUT`, `PATCH` of `DELETE` zijn. Meestal gebruik je deze functie niet in de controller. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $method = $request->method();
        // $method = "GET"
    }
}
```


#### hasHeader / allHeaders / header
Header in deze context is de http header. Deze header bevat informatie over het request. Denk aan de browser die wordt gebruikt of de taal van de browser. Je kunt deze informatie gebruiken om bijvoorbeeld de taal van de website aan te passen. Deze informatie kan belangrijk zijn in de manier waarop je de request afhandelt. De hasHeader functie geeft aan of de header bestaat. De allHeaders functie geeft alle headers terug. De header functie geeft een specifieke header terug. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
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
    public function index(): ?Response {
        $request = $this->currentRequest;
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
    public function index(): ?Response {
        $request = $this->currentRequest;
        $urlQueryParams = $request->urlQueryParams();
        // $urlQueryParams = ["abc" => "123"]
    }
}
```

#### wantsJson
wantsJson geeft aan of de client om een json response vraagt. Dit is handig als je bijvoorbeeld een route hebt die alleen data terug kan geven. Je kunt dan aan de hand van deze functie bepalen of je een json response terug moet geven of een html response. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $wantsJson = $request->wantsJson();
        // $wantsJson = false
        // true ? repond with a JsonResponse
        // false ? respond with a TextResponse
    }
}
```

### PostObject
- [Flash](#flash)
- [FlashPostError](#flashposterror)
- [Old](#old)
- [OldBody](#oldbody)
- [OldFiles](#oldfiles)
- [HasPostErrors](#hasposterror)
- [GetPostError](#getposterror)
- [GetPostErros](#getposterrors)
- [Flush](#flush)
- [hasFile](#hasfile)
- [files](#files)
- [body](#body)
- [isAjax](#isajax)
- [isJson](#isjson)

Dit object wordt alleen aangemaakt wanneer het request een POST request is of als er data aanwezig is in _SESSION Flash. Dit object bevat allerlei informatie over het post request. Daarnaast zijn er wat functies om de post data tijdelijk op te slaan in de sessie. Het nut hiervan kom ik op terug.

#### flash
Deze functie maakt het mogelijk om gemakkelijk de POST data naar de sessie te schrijven. Dit kun je doen op het moment dat je bij je validatie op POST data een probleem tegenkomt en je wilt dat de user de data opnieuw opstuurt. Je wilt dan niet dat de user alles opnieuw moet invullen. Dan kun je de POST data in de sessie op slaan om dit na de redirect weer in de view terug te geven aan de user. Dit ziet er als volgt uit:
```php
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if ($post !== null) {
            // check of data alleen uit nummers bestaat, zo niet flash de data naar de sessie en redirect terug naar de form.
            if(ctype_digit($post->body["age"])) {
                // ...
            } else {
                $post->flash();
                redirect("/SomePostUrl");
            }
        }
    }
}
```

#### flashPostError
Zodra je een validatie error hebt geconstateerd wil je deze natuurlijk ook aan de user laten zien. Dit kun je doen door naast de POST data ook een error te flashen naar de sessie. Dit ziet er als volgt uit:
```php
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if ($post !== null) {
            // check of data alleen uit nummers bestaat, zo niet flash de data naar de sessie en redirect terug naar de form.
            if(ctype_digit($post->body["age"])) {
                // ...
            } else {
                $post->flashPostError("age", "Age must be a number");
                $post->flash();
                redirect("/SomePostUrl");
            }
        }
    }
}
```

#### old
Als je data hebt geflasht voor een redirect wil je deze data ook kunnen terughalen. Dit doe je met een van de old functies. Deze variant geeft je de gehele flash terug. Dit kun je dan gebruiken om de data weer door te geven aan een view. Dit ziet er als volgt uit:
```php  
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if ($post !== null) {
            // check of data alleen uit nummers bestaat, zo niet flash de data naar de sessie en redirect terug naar de form.
            if(ctype_digit($post->body["age"])) {
                // ...
            } else {
                $post->flashPostError("age", "Age must be a number");
                $post->flash();
                redirect("/SomePostUrl");
            }
        }
    }

    public function somePostUrl(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        $old = $post->old();
        // $old = ["body" => ["age" => "abc", "name" => "def"], 
        //         "errors" => ["age" => "Age must be a number"],
        //         "files" => ["files" => [...]]]
        // doe iets met de data.
    }
}
```

#### oldBody
Deze variant geeft je alleen de body terug. Dit kun je dan gebruiken om de data weer door te geven aan een view. Dit ziet er als volgt uit:
```php
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if ($post !== null) {
            // check of data alleen uit nummers bestaat, zo niet flash de data naar de sessie en redirect terug naar de form.
            if(ctype_digit($post->body["age"])) {
                // ...
            } else {
                $post->flashPostError("age", "Age must be a number");
                $post->flash();
                redirect("/SomePostUrl");
            }
        }
    }

    public function somePostUrl(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        $oldBody = $post->oldBody();
        // $oldBody = ["age" => "abc", "name" => "def"]
        // doe iets met de data.
    }
}
```

#### oldFiles
Deze variant geeft je alleen de files terug. Dit kun je dan gebruiken om de data weer door te geven aan een view. Dit ziet er als volgt uit:
```php
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if ($post !== null) {
            // check of data alleen uit nummers bestaat, zo niet flash de data naar de sessie en redirect terug naar de form.
            if(ctype_digit($post->body["age"])) {
                // ...
            } else {
                $post->flashPostError("age", "Age must be a number");
                $post->flash();
                redirect("/SomePostUrl");
            }
        }
    }

    public function somePostUrl(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        $oldFiles = $post->oldFiles();
        // $oldFiles = ["files" => [...]]
        // doe iets met de data.
    }
}
```

#### hasPostErrors
Deze functie geeft aan of er errors zijn geflasht. Dit kun je gebruiken om te bepalen of je een error moet laten zien aan de user. Dit ziet er als volgt uit:
```php
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if ($post !== null) {
            // check of data alleen uit nummers bestaat, zo niet flash de data naar de sessie en redirect terug naar de form.
            if(ctype_digit($post->body["age"])) {
                // ...
            } else {
                $post->flashPostError("age", "Age must be a number");
                $post->flash();
                redirect("/SomePostUrl");
            }
        }
    }

    public function somePostUrl(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if($post->hasPostErrors()) {
            // doe iets met de errors.
        }
    }
}
```

#### getPostError
Deze functie geeft je een specifieke error terug. Dit kun je gebruiken om te bepalen welke error je moet laten zien aan de user. Dit ziet er als volgt uit:
```php
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if ($post !== null) {
            // check of data alleen uit nummers bestaat, zo niet flash de data naar de sessie en redirect terug naar de form.
            if(ctype_digit($post->body["age"])) {
                // ...
            } else {
                $post->flashPostError("age", "Age must be a number");
                $post->flash();
                redirect("/SomePostUrl");
            }
        }
    }

    public function somePostUrl(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if($post->hasPostErrors()) {
            $error = $post->getPostError("age");
            // $error = "Age must be a number"
            // doe iets met de error.
        }
    }
}
```

#### getPostErrors
Deze functie geeft je alle errors terug. Dit kun je gebruiken om te bepalen welke errors je moet laten zien aan de user. Dit ziet er als volgt uit:
```php
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if ($post !== null) {
            // check of data alleen uit nummers bestaat, zo niet flash de data naar de sessie en redirect terug naar de form.
            if(ctype_digit($post->body["age"])) {
                // ...
            } else {
                $post->flashPostError("age", "Age must be a number");
                $post->flashPostError("name", "Name must be a string");
                $post->flash();
                redirect("/SomePostUrl");
            }
        }
    }

    public function somePostUrl(): ?Response {
        $request = $this->currentRequest;
        $post = $request->postObject;
        if($post->hasPostErrors()) {
            $errors = $post->getPostErrors();
            // $errors = ["age" => "Age must be a number", "name" => "Name must be a string"]
            // doe iets met de errors.
        }
    }
}
```

#### flush
Deze functie verwijderd alle geflashte data. Dit kun je gebruiken als je de data niet meer nodig hebt. Handig om dit altijd aan te roepen als je wat hebt gedaan met de geflashte date en je klaar bent.

#### hasFiles
Deze functie geeft aan of er files zijn meegegeven in het request. Dit kun je gebruiken om te bepalen of je iets met de files moet doen. Dit ziet er als volgt uit:
```php
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        if ($request->hasPostData()) {
            $post = $request->postObject;
            if($post->hasFiles()) {
                // doe iets met de files.
            }
        }
    }
}
```

#### files
Deze functie geeft alle files terug. Dit is hetzelfde als de `$_FILES` variabele. Deze array heeft een aparte format die ik hier even wilde laten zien:
```php
Array
(
    [files] => Array
        (
            [name] => Array
                (
                    [0] => file1.jpg
                    [1] => file2.jpg
                )

            [type] => Array
                (
                    [0] => image/jpeg
                    [1] => image/jpeg
                )

            [tmp_name] => Array
                (
                    [0] => /tmp/php/php1h4j1o
                    [1] => /tmp/php/php6hst32
                )

            [error] => Array
                (
                    [0] => 0
                    [1] => 0
                )

            [size] => Array
                (
                    [0] => 98174
                    [1] => 154890
                )
        )
)
```

#### body
Deze functie geeft alleen de body van de POST data terug. Dit is hetzelfde als `$_POST["body"]`. Dit ziet er als volgt uit:
```php
class SomePostController extends Controller {
    public function index(): ?Response {
        $request = $this->currentRequest;
        if ($request->hasPostData()) {
            $post = $request->postObject;
            $body = $post->body;
            // $body = ["age" => "abc", "name" => "def"]
        }
    }
}
```

#### isAjax
Deze functie geeft aan of het request een ajax request is. Dit kun je gebruiken om te bepalen of je een json response moet teruggeven of een text response. Ajax verwacht ook een json response.

#### isJson
Deze functie geeft aan of de client een json response wilt. Dit kun je gebruiken om te bepalen of je een json response moet teruggeven of een text response.

### Response
Wanneer de client aan de server vraagt om data. Of dat nou een pagina of losse data is maakt niet uit. In beide gevallen moet de server een response sturen. De response class is de class die dit representeert. De response wordt aangemaakt in de controller functie die door de router is aangeroepen. De controller functie moet dus een response returnen. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        return new TextResponse();
    } 
}
```
Daarnaast kan je in de controller ook een `$currentResponse` veld zetten met je aangemaakt response maar de voorkeur gaat voor leesbaarheid wel naar `return Response`. Het `$currentResponse` veld is onderdeel van de `Controller` base class. Dit zou er als volgt uit kunnen zien:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $this->currentResponse = new TextResponse();
    } 
}
```

Er zijn een aantal verschillende typen responses gedefineerd in het framework. Deze erver allemaal van de `BaseResponse` class. De `BaseResponse` class implementeerd de `Response` interface voor een groot deel. De enige functie die in de `BaseResponse` class is gemarkeerd als abstract is de `setBody` functie. Deze wordt door de verschillende typen responses geïmplementeerd. De `BaseResponse` class heeft een aantal functies die je kunt gebruiken om de response te manipuleren. Deze functies zijn:
- [send](#send)
- [setStatusCode](#setstatuscode)
- [addHeader(s)](#addheader(s))

#### send
Deze functie wordt eigenlijk alleen in de router gebruikt. Het zal de body en de headers van de response naar de client sturen. Dit zul je zelf niet of bijna niet gebruiken.

#### setStatusCode
Deze functie zet de status code van de response. Dit is in de vorm van `HTTPStatusCode`. Dit kun je gebruiken om aan te geven of de response een succesvolle afhandeling is van het request of niet. Over het algemeen zul je gewoon `HTTPStatusCode::OK` gebruiken en deze wordt dus standaard al gezet en zal alleen anders zijn als je de functie aanroept met een andere statuscode. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): Response {
        $response = new TextResponse("Hello World");
        $response->setStatusCode(HTTPStatusCode::OK);
        return $response;
    } 
}
```

#### addHeader(s)
De addHeader en addHeaders functie zijn hetzelfde maar de een verwacht een array en de ander verwacht een key en value. Deze functies kun je gebruiken om http headers toe te voegen aan je response. Dit gebruik je als volgt:
```php
class HomeController extends Controller {
    public function index(): Response {
        $response = new TextResponse("Hello World");
        $response->addHeader("Content-Type", "text/plain");
        $response->addHeaders(["Content-Type" => "text/plain", ...]);
        return $response;
    } 
}
``` 

Er zijn drie verschillende types response aanwezig in het framework. Deze gebruik je voor verschillende doeleinden. De drie verschillende types zijn:
- [ViewResponse](#viewresponse)
- [TextResponse](#textresponse)
- [JsonResponse](#jsonresponse)

#### ViewResponse
De view response is bedoeld voor routes die in de url balk worden opgegeven. Dit is een response dat een view teruggeeft aan de client. Dit type response wil in de `setBody` functie een `View` instantie hebben. De meeste routes zullen dit type response teruggeven. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): Response {
        $response = new ViewResponse();
        $response->setBody(new View(VIEWS_PATH . "home.php"));
        return $response;
    }
}
```

#### TextResponse
De text response is bedoeld voor routes die geen view teruggeven maar wel data. Dit is een response dat een string teruggeeft aan de client. Dit type response wil in de `setBody` functie een `string` hebben. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): Response {
        $response = new TextResponse();
        $response->setBody("Hello World");
        return $response;
    }
}
```

#### JsonResponse
De json response is bedoeld voor routes die geen view teruggeven maar wel data. Dit is een response dat een json string teruggeeft aan de client. Dit type response wil in de `setBody` functie een `array` hebben. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): Response {
        $response = new JsonResponse();
        $response->setBody(["Hello" => "World"]);
        return $response;
    }
}
```

### Controller
De controller is het deel van de applicatie dat de view en data aan elkaar bind. Elke route heeft een controller. Meerdere routes kunnen wijzen naar dezelfde controller maar zullen dan wel een andere methode aanroepen zoals dit:
```php
$router = Application::getRouter();
$router->get("/", [HomeController::class, "index"]);
$router->get("/Something", [HomeController::class, "something"]);
```
De controller is dus de plek waar de view en de data samenkomen. Elke controller zal de `Controller` class extenden. Deze class heeft een aantal functies die gebruikt worden door de router. Daarom is het zo belangrijk dat je deze altijd extend. De functies die door de router gebruikt worden zijn:
- `setRequest`
De setRequest functie wordt gebruikt om de request van de client door te geven aan de controller. Dit is belangrijk voor de controller om makkelijk toegang te hebben tot alle relevante data afkomstig van de client. 

Elke controller zal een methode hebben die wordt aangeroepen door de router. Deze methode naam heb je gedefineerd in je routes. Neem de voorgaande routers bijvoorbeeld. Daar heeft de `HomeController` als het goed is een `index` en een `something` functie. De `HomeController` zal er dan misschien zo uit zien:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        $response->setBody(new View(VIEWS_PATH . "home.php"));
        return $response;
    }

    public function something(): ?Response {
        $response = new ViewResponse();
        $response->setBody(new View(VIEWS_PATH . "something.php"));
        return $response;
    }
}
```
Daarnaast is het ook mogelijk om wat specialere routes te defineren. Bijvoorbeeld een product. Er zijn een aantal producten aanwezig in het systeem maar je wilt niet voor elk product een aparte route aanmaken. Dan kun je het volgende doen:
```php
$router = Application::getRouter();
$router->get("/product/{id}", [ProductController::class, "index"]);
```
De router zal dan de `index` functie van de `ProductController` aanroepen. Deze functie zal dan een product moeten ophalen aan de hand van het id. Dit id wordt dan meegegeven in de parameters van de controller functie die wordt aangeroepen. Bij deze url `http://localhost:8080/product/1` zal de `index` functie van de `ProductController` worden aangeroepen met het id `1`. Dit ziet er als volgt uit:
```php
class ProductController extends Controller {
    public function index($id): ?Response {
        $product = Product::getById($id);
        $response = new ViewResponse();
        $response->setBody(new View(VIEWS_PATH . "product.php", ["product" => $product]));
        return $response;
    }
}
```

### Middleware
Een middleware is een functie die na het request wordt uitgevoerd. Dit kun je gebruiken om voordat je de controller functie aftrapt eerst te kijken of iemand is geautoriseerd om de controller functie uit te voeren. Dit kun je doen door een middleware te registreren in de router. Dit ziet er als volgt uit:
```php
$router = Application::getRouter();
$router->get("/", [HomeController::class, "index"])->middleware(Authenticate::class, [Roles::Admin->value]);
```
De router zal dan eerst de `Authenticate` middleware uitvoeren en daarna pas de `index` functie van de `HomeController`. De `Authenticate` middleware zal dan eerst kijken of de user is ingelogd en of de user de juiste rol heeft. Als dit niet zo is dan kan de controller verschillende dingen doen. Bijvoorbeeld de user redirecten naar een login pagina. Dit ziet er als volgt uit:
```php
class Authenticate {
    private array $acceptedRoles;

    public function __construct(array $acceptedRoles) {
        $this->acceptedRoles = $acceptedRoles;
    }

    public function handle(): ?HTTPStatusCodes {
        if (!isset($_SESSION["user"]["role"])) {
            redirect('/Login');
            exit;
        }

        if (!in_array($_SESSION["user"]["role"], $this->acceptedRoles)) {
            redirect('/Login');
            exit;
        }

        return null;
    }
}
```
Daarnaast kun je ook kiezen om een `HTTPStatusCodes` terug te geven. Dit is een enum die alle http status codes bevat. Als je een status code teruggeeft zal de router proberen een view te vinden die bij die status code hoort. Als die view niet bestaat zal de router een standaard view laten zien. Dit ziet er als volgt uit:
```php
class Authenticate {
    private array $acceptedRoles;

    public function __construct(array $acceptedRoles) {
        $this->acceptedRoles = $acceptedRoles;
    }

    public function handle(): ?HTTPStatusCodes {
        if (!isset($_SESSION["user"]["role"])) {
            return HTTPStatusCodes::UNAUTHORIZED;
        }

        if (!in_array($_SESSION["user"]["role"], $this->acceptedRoles)) {
            return HTTPStatusCodes::FORBIDDEN;
        }

        return null;
    }
}
```
Als de middleware `null` of `HTTPStatusCode::OK` teruggeeft zal de router wel de controller functie die bij die route hoort uitvoeren.

Zoals je aan het begin zag kun je voor de middleware die je defineert kiezen of je een parameter meegeeft of niet. Als je een parameter meegeeft zal de router deze parameter meegeven aan de constructor van de middleware.

### View
Globaal is een `view` functie beschikbaar. Deze functie kun je gebruiken om gemakkelijker een View object aan te maken. Deze functie geeft je een instantie van de `View` class terug. Deze functie verwacht een pad naar de view en optioneel een array met data voor de view. Het aanroepen van de view functie ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $view = view(VIEWS_PATH . "home.php");
    }
}
```
Meestal zul je dit rechtreeks in de `$response->setBody()` functie zetten. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . "home.php"));
        return $response;
    }
}
```
De view functie kun je chainen om een view te renderen met een layout. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . "home.php")->withLayout(VIEWS_PATH . "Layouts/layout.php"));
        return $response;
    }
}
```
Een `Layout` is een html bestand dat de basis van je website bevat. Dit is bijvoorbeeld de header en de footer. In dit layout bestand bevindt zich altijd het volgende:
```php
<?php echo $content ?>
```
De `$content` variabele is de plek waar de view wordt gerenderd. Dit is dus de plek waar de view wordt ingeladen.

### Partial / Component
Er zijn twee mogelijkheden om blokken HTML los aan te maken en ze in meerdere views te gebruiken. Dit zijn de `Partial` en de `Component`. De `Partial` is een stukje HTML dat je in een view kunt includen. De `Component` is een stukje HTML met zijn eigen mini controller. Die kan dus zelf ook data ophalen.

#### Partial
Een partial is dus een stukje HTML waar geen php in staat. Javascript en CSS kunnen hier wel in. Dit stukje HTML kun je dan in een view includen. Dit ziet er als volgt uit:
```php
<div>
    <?php include VIEWS_PATH . 'Partials/Boring.partial.php' ?>
</div>
```
Dit is dus hoe je een partial in een view plaats. De partial zelf ziet er dan misschien als volgt uit:
```php
<p>This is a boring partial. A partial is usually just some plain html, potentially some js.</p>
```
Partials plaats je in de map `src/App/Content/Views/Partials`. Dit is de standaard locatie voor deze bestanden. Een partial is wel altijd een PHP bestand. En volgt de volgende conventie: `Name.partial.php`. Dit is dus de naam van de partial met `.partial.php` erachter. Dit is om aan te geven dat het een partial is. Dit is niet verplicht maar wel handig voor de leesbaarheid.

#### Component
Een Component is een partial met data. Omdat er data in de HTML moet worden gezet heeft het een kleine controller nodig. Dit is wel een specifieke `Component` controller. De controller van een component extend daarom ook de `Component` class. Dit is een interface die belooft dat er altijd een `get` methode aanwezig is. Deze `get` methode is de methode die de uiteindelijk view teruggeeft. Om een component toe te voegen aan een view moet je eerst de controller van het component aanmaken in de volgende map `src/App/Http/Controller/Components`. Een component controller volgt de volgende conventia: `NameComponent.php`. Dit is dus de naam van de component met `Component.php` erachter. Dit is om aan te geven dat het een component is. Dit is niet verplicht maar wel handig voor de leesbaarheid. Een component controller ziet er als volgt uit:
```php
class ProductComponent implements Component {
    public function get(?array $data): string {
        return view(VIEWS_PATH . "Components/Product.component.php", [
            'id' => $data['id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price']
        ])->render();
    }
}
```
Dit is een component dat de data uit de view die hem toevoegd meekrijgd. De html van dit component ziet er als volgt uit:
```php
<div class="card" style="width: 18rem;" onclick="window.location.href='/Products/<?php echo $id ?>'">
    <div class="card-body">
        <h5 class="card-title">product name: <?php echo $name ?></h5>
        <p class="card-text">product id: <?php echo $id ?></p>
        <p class="card-text">product description: <?php echo $description ?></p>
        <p class="card-text">product price: <?php echo $price ?></p>
    </div>
</div>
```
En moet worden geplaats in de map `src/App/Content/Views/Components`. Dit is de standaard locatie voor deze bestanden. Een component is wel altijd een PHP bestand. En volgt de volgende conventie: `Name.component.php`. Dit is dus de naam van de component met `.component.php` erachter. Dit is om aan te geven dat het een component is. Dit is niet verplicht maar wel handig voor de leesbaarheid. Een component plaats je in een view als volgt:
```php
<div>
    <?php echo component(Http\Controllers\Components\ProductComponent::class, $product) ?>
</div>
```
Omdat de data uit de parent view komt moet je dit meegeven aan de component als parameters. Dit doe je door de data mee te geven als tweede parameter van de component functie. In dit geval was dat `$product`. Dit is een array met de data die de component nodig heeft. Dit moet wel altijd uit key value pairs bestaan. De key is de naam van de variabele die je in de component gebruikt en de value is de waarde van die variabele die je in de component gebruikt.

<br>

De controller van de view geeft dus de data mee aan de view en de view geeft het dan door aan het component. Het component kan ook zelf de data ophalen. Dit ziet er als volgt uit:
```php
class ProductComponent implements Component {
    public function get(?array $data): string {
        $product = Product::getById($data['id']);
        return view(VIEWS_PATH . "Components/Product.component.php", [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price
        ])->render();
    }
}
```
Dit is een component dat de data zelf ophaald. Dit is handig als je een component hebt dat altijd dezelfde data ophaald. Dit is bijvoorbeeld een header of een footer. De HTML die hier bij hoort is hetzelfde als de voorgaande. De manier waarop je dit component in de parent view plaats is wel net iets anders omdat je in dit geval geen data mee hoeft te geven. Dit ziet er als volgt uit:
```php
<div>
    <?php echo component(Http\Controllers\Components\ProductComponent::class) ?>
</div>
```

### Model
Als je data toe voegt aan een view kan dat op meerdere manieren. De snelste manier is om gewoon een array aan data mee te geven zoals dit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();
        $response->setBody(view(VIEWS_PATH . "home.php", ["name" => "John Doe"]));
        return $response;
    }
}
```
Dit is ok met de hoeveelheid data die je in deze situatie mee wilt geven. Maar stel dat je een product wilt meegegeven waar wat meer data bij komt kijken zoals bij onze producten. Dan is het handig om een model te gebruiken. Een model is een class die de data van een `ding` representeert. Dit is handig als dit `ding` veel data heeft die je hier onder kan scharen. Denk aan het product hier heb je:
- Id;
- Name;
- Subtitle;
- Description;
- Active;
- AmountInStock;
- DemoAmountInStock;
- UnitPrice;
- RecommendedUnitPrice;
- SKU;
- BrandId;
- CategoryId;
- Media;
- CreatedOn.

Als je al deze data lost in een array meegeeft aan de view wordt het al snel onoverzichtelijk. Daarnaast is het mogelijk dat je product op meerdere pagina's gaat gebruiken. Dan moet je op meerdere plekken een onoverzichtelijk array meegeven. Om dit overzichtelijk te houden kun je een model gebruiken. Dit ziet er als volgt uit:
```php
class ProductModel {
    int Id;
    string Name;
    string Subtitle;
    string Description;
    bool Active;
    int AmountInStock;
    int DemoAmountInStock;
    float UnitPrice;
    float RecommendedUnitPrice;
    string SKU;
    int BrandId;
    int CategoryId;
    array Media;
    DateTime CreatedOn;
}
```
Dit kun je dan gemakkelijker naar de view meegeven. Als je dan in het model ook nog een slimme methode aanmaakt om de data direct vanuit de data source door kan geven is het helemaal mooi. Bijvoorbeeld iets als dit:
```php
class ProductModel {
    int Id;
    string Name;
    string Subtitle;
    string Description;
    bool Active;
    int AmountInStock;
    int DemoAmountInStock;
    float UnitPrice;
    float RecommendedUnitPrice;
    string SKU;
    int BrandId;
    int CategoryId;
    array Media;
    DateTime CreatedOn;

    public function __construct(int $id) {
        $product = Application::resolve(ProductService::class)->getById($id);
        $this->Id = $product->id;
        $this->Name = $product->name;
        $this->Subtitle = $product->subtitle;
        $this->Description = $product->description;
        $this->Active = $product->active;
        $this->AmountInStock = $product->amountInStock;
        $this->DemoAmountInStock = $product->demoAmountInStock;
        $this->UnitPrice = $product->unitPrice;
        $this->RecommendedUnitPrice = $product->recommendedUnitPrice;
        $this->SKU = $product->sku;
        $this->BrandId = $product->brandId;
        $this->CategoryId = $product->categoryId;
        $this->Media = $product->media;
        $this->CreatedOn = $product->createdOn;
    }
}
```
Nu kun je dit model meegeven aan de view. Dit ziet er als volgt uit:
```php
class HomeController extends Controller {
    public function index(): ?Response {
        $response = new ViewResponse();

        $product = new ProductModel();

        $response->setBody(view(VIEWS_PATH . "home.php", ["product" => $product]));
        return $response;
    }
}
```
In de view kun je nu het volgende doen om de data uit het model te halen:
```php
<div>
    <h1><?php echo $product->Name ?></h1>
    <p><?php echo $product->Description ?></p>
</div>
```