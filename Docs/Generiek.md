# Generiek
> **Leestijd:** 20 minuten

## Inhoudsopgave
  - [Inhoudsopgave](#inhoudsopgave)
  - [Inleiding](#inleiding)
  - [PHP](#PHP)
  - [Global helper variabelen](#global-helper-variabelen)

## Inleiding
In dit document zullen enige generieke PHP dingen worden besproken. Denk hierbij aan dingen zoals, wat is een Namespace, wat is een class enzovoort. Het doel van dit document is om alle leden van de werkgroep te informeren over bepaalde ideeën die in dit project al zijn toegepast en die we graag voor de rest van het project ook willen gebruiken.

## PHP
De volgende onderwerpen komen hier aan bod:
- [Namespaces](#Namespaces)
- [Classes](#classes)
- [Access modifiers](#access-modifiers)
- [Base classes](#base-classes)
- [Abstract classes](#abstract-classes)
- [Interfaces](#interfaces)

### Namespaces
Een Namespace is voor PHP relatief nieuwe functionaliteit. Een Namespace is een manier om code te groeperen. Dit is handig omdat je zo niet bang hoeft te zijn dat je per ongeluk een functie of class overschrijft. Een Namespace is een soort container voor code. Je kunt een Namespace zien als een map. In deze map kun je dan code plaatsen. Deze code is dan alleen beschikbaar binnen de Namespace. Als je code van buiten de Namespace wilt gebruiken moet je deze importeren. Dit doe je met het `use` keywoord. Dit keywoord zorgt ervoor dat je code van buiten de Namespace kunt gebruiken binnen de Namespace. Dit keywoord moet bovenaan de file staan. Dit is een voorbeeld van een Namespace:
```PHP
Namespace HTTP\Controllers;

use Lib\MVCCore\Controller;
```

Dit is vooral handig voor dit project om gebruik te kunnen maken van de PHP autoloader. Deze autoloader maakt gebruik van Namespaces om de juiste class te vinden. Dit is een voorbeeld van een autoloader die ook in index.PHP staat:
```PHP
spl_autoload_register(function ($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    require_once BASE_PATH . $path . '.PHP';
});
```
Om effectief gebruik te maken van deze autoloader zullen we gaan werken met Classes en Namespaces. Als je een nieuwe class aanmaakt moet je deze in zijn eigen bestand plaatsen. Dit bestand moet dezelfde naam hebben als de class. Dit bestand moet in de juiste Namespace staan. Dit is een voorbeeld van een class. De file waar deze class in staat heet dan dus ook `HomeController.PHP` en staat in de map `HTTP/Controllers`:
```PHP
Namespace HTTP\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home');
    }
}
```
Naast het voordeel van de autoloader kunnen we dit ook gebruiken om code te splitsen zodat we een beter overzicht krijgen van waar wat staat en wat het is. Zo kun je bijvoorbeeld nu alle controllers in de map HTTP/Controllers plaatsen. Als iedereen zich hier aan houdt, zal dit project voor de "klant" vele malen beter te onderhouden zijn.

### Classes
Een class is nog een manier om code te groeperen. Het voorbeeld dat hier vaak voor wordt gegeven is een boek. Een boek heeft bijvoorbeeld altijd een auteur, pagina's en iets van content. Als je dit zou moeten vertalen naar code is het handig als je dan alles bij elkaar hebt wat bij dat object hoort. Dit is een voorbeeld van een class:
```PHP
class Boek {
    private string $auteur;
    private int $paginas;
    private string $content;
}
```
Een class heeft altijd een constructor. Deze is niet altijd zichtbaar in de code maar is er wel altijd. De constructor is een functie die wordt aangeroepen als je een nieuwe instantie van een class maakt. Dit kun je gebruiken om te zorgen dat een class altijd een aantal waarden mee moet krijgen voordat je hem kan aanmaken. Bij het boek moeten we bijvoorbeeld opgeven wie de auteur is en wat de content is. Dit is een voorbeeld van een constructor:
```PHP
class Boek {
    private string $auteur;
    private int $paginas;
    private string $content;

    public function __construct(string $auteur, int $paginas, string $content)
    {
        $this->auteur = $auteur;
        $this->paginas = $paginas;
        $this->content = $content;
    }
}
```
Als je nu een nieuwe instantie van de class wilt maken moet je de constructor aanroepen. Dit doe je door het `new` keywoord te gebruiken. Dit is een voorbeeld van het aanmaken van een nieuwe instantie van de class `Boek`:
```PHP
$boek1 = new Boek('J.K. Rowling', 300, 'Harry Potter');
$boek2 = new Boek('J.R.R. Tolkien', 500, 'Lord of the Rings');
```
Het mooie aan classes is dat je code bij elkaar kan houden. Zo weet je altijd wat een Boek kan en wat een Boek is. Een class kan zijn eigen functies hebben. Deze functies kunnen dan gebruik maken van de waarden die in de class staan. Dit is een voorbeeld van een functie in een class:
```PHP
class Boek {
    private string $auteur;
    private int $paginas;
    private string $content;

    public function __construct(string $auteur, int $paginas, string $content)
    {
        $this->auteur = $auteur;
        $this->paginas = $paginas;
        $this->content = $content;
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }
}
```

### Access modifiers
In de voorbeelden van classes zag je misschien al private en public staan. Dit zijn access modifiers. Er zijn in PHP 3 access modifiers. Deze zijn:
- public
- private
- protected

#### Public
De public access modifier betekend dat dit veld of deze functie door iedereen kan worden aangeroepen als ze bij de instantie van die class kunnen komen. 

#### Private
De private access modifier betekend dat dit veld of deze functie alleen kan worden aangeroepen door de class zelf. Dit betekend dat je deze functie of dit veld niet kan aanroepen van buiten de class. Dit is handig wanneer het een functie is die alleen door de class zelf gebruikt moet worden. Of een waarde die je niet wilt open stellen aan de rest van de applicatie.

#### Protected
De protected access modifier is wat ingewikkelder. In zekere zin is het hetzelfde als private voor alles wat niet de class zelf is maar hier zit nog wel wat extra's bij. Dat kun je verder lezen in [Base classes](#protected-1).

### Base classes
Laat ik vooraf al zeggen dat het niet heel belangrijk is dat je nu al precies weet wat een base classe of abstracte classe is. Je zal dit waarschijnlijk niet heel veel gaan gebruiken. Toch is het belangrijk er iets over te schrijven aangezien het wel is toegepast in de MVCCore Namespace.

Een base classe is een classe zoals het eerder genoemde Boek. Nou kun je je voorstellen dat je verschillende soorten boeken hebt. Maar elk boek heeft een auteur, pagina's en content. Stel nou dat je een verschil maakt tussen een Boek en een LesBoek. Het LesBoek heeft een auteur, pagina's en content. Maar daarnaast heeft het lesboek ook een vak waar het bijhoort. Nou kun je het LesBoek als volgt maken:
```PHP
class LesBoek {
    private string $auteur;
    private int $paginas;
    private string $content;
    private string $vak;

    public function __construct(string $auteur, int $paginas, string $content, string $vak)
    {
        $this->auteur = $auteur;
        $this->paginas = $paginas;
        $this->content = $content;
        $this->vak = $vak;
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }
}
```
Maar nu heb je code gedupliceerd. Dit kan problemen veroorzaken als je bijvoorbeeld een fout vindt in de getAuter functie. Deze pas je dan aan in het LesBoek maar deze blijft dan dezelfde fout hebben in het Boek. Om dit te voorkomen hebben we base classes. Zoals bij het domeinmodel kun je deze overerven. In PHP doe je dat als volgt:
```PHP
class LesBoek extends Boek {
    protected string $vak;

    public function __construct(string $auteur, int $paginas, string $content, string $vak)
    {
        parent::__construct($auteur, $paginas, $content);
        $this->vak = $vak;
    }
}
```
Zoals je ziet heb je nu geen code meer gedupliceerd. Dit zal dat voor genoemde probleem verhelpen. Zo kun je dus een classe structuur opbouwen die je helpt om code te hergebruiken en te voorkomen dat je code dupliceert. Denk eraan dat je voor de auteur in Boek bijvoorbeeld ook een classe kan maken die Auteur heet. Deze erft misschien weer van een Persoon classe. Ga zo maar door.

#### Protected
Nu is het je misschien opgevallen dat je hier dat protected woord weer tegenkomt. Het verschil tussen protected en private merk je pas wanneer je een class gaat overerven. Wanneer het veld in de base class Boek private is kan de LesBoek class er niet bij. Dit is omdat private betekend dat alleen de class zelf erbij kan. Wanneer je protected gebruikt kan de LesBoek class er wel bij. Dit is omdat protected betekend dat de class zelf erbij kan en alle classes die van deze class overerven. Dit is dus een manier om ervoor te zorgen dat je een veld of functie alleen beschikbaar maakt voor classes die van deze class overerven. Echter is protected buiten de class tree nog steeds niet bereikbaar.


### Abstract classes
Een abstract class is iets anders dan een base class. Net als de base class kan een abstracte class velden en functies implementeren. Het grootte verschil is dat je een base class wel kan instantiëren en een abstracte class niet. Stel dat je allerlei type boeken hebt maar je wilt voorkomen dat iemand een boek instantieert van het type Boek. Dan zou je de Boek class abstract kunnen maken. Dit doe je als volgt:
```PHP
abstract class Boek {
    protected string $auteur;
    protected int $paginas;
    protected string $content;

    public function __construct(string $auteur, int $paginas, string $content)
    {
        $this->auteur = $auteur;
        $this->paginas = $paginas;
        $this->content = $content;
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }
}
```
Dit garandeert dat niemand een boek kan maken van het type Boek. Het LesBoek kan deze class nog steeds overerven en deze velden en methoden gebruiken. Verder kun je in een abstracte class ook abstracte functies aanmaken. Een abstracte functie is een functie in een abstracte class die nog geen implementatie heeft maar wel een verplichte functie is voor alle classes die van deze class overerven. Dit is een voorbeeld van een abstracte functie:
```PHP
abstract class Boek {
    protected string $auteur;
    protected int $paginas;
    protected string $content;

    public function __construct(string $auteur, int $paginas, string $content)
    {
        $this->auteur = $auteur;
        $this->paginas = $paginas;
        $this->content = $content;
    }

    abstract public function getAuteur(): string;
}
```
Hier heb ik nu de functie `getAuteur` abstract gemaakt. Dit betekend dat alle classes die van deze class overerven deze functie moeten implementeren. Dit is een voorbeeld van een class die van deze class overerft:
```PHP
class LesBoek extends Boek {
    protected string $vak;

    public function __construct(string $auteur, int $paginas, string $content, string $vak)
    {
        parent::__construct($auteur, $paginas, $content);
        $this->vak = $vak;
    }

    public function getAuteur(): string
    {
        return $this->auteur . " is de auteur van dit lesboek.";
    }
}

class StripBoek extends Boek {
    protected string $tekenaar;

    public function __construct(string $auteur, int $paginas, string $content, string $tekenaar)
    {
        parent::__construct($auteur, $paginas, $content);
        $this->tekenaar = $tekenaar;
    }

    public function getAuteur(): string
    {
        return $this->auteur . " is de auteur van dit stripboek." . $this->tekenaar . " is de tekenaar.";
    }
}
```
Hier kan je zien dat LesBoek en StripBoek allebei een andere implementatie hebben voor de functie `getAuteur`. Dit is handig als je wilt dat een Boek altijd een specifieke functie heeft maar dat het je niet per se uitmaakt hoe deze functie is geïmplementeert in de verschillende types boeken. Het is een klein contract dat je vaststelt dat de rest van de applicatie verteld dat deze groep classes altijd deze functie hebben.

### Interfaces
Een interface gaat nog iets verder dan een abstracte class. Waar een abstracte class zelf nog een implementatie kan hebben voor functies en zijn eigen velden kan hebben heeft een interface dit niet. Een interface is een contract dat je vaststelt voor een groep classes. Dit contract zegt dat alle classes die dit contract ondertekenen een bepaalde functie moeten hebben. Dit is een voorbeeld van een interface:
```PHP
interface BoekInterface {
    public function getAuteur(): string;
}
```
Dit is een interface die zegt dat alle classes die dit contract ondertekenen een functie moeten hebben die `getAuteur` heet en die een string terug geeft. Dit is een voorbeeld van een class die dit contract ondertekend:
```PHP
class Boek implements BoekInterface {
    protected string $auteur;
    protected int $paginas;
    protected string $content;

    public function __construct(string $auteur, int $paginas, string $content)
    {
        $this->auteur = $auteur;
        $this->paginas = $paginas;
        $this->content = $content;
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }
}
```
Nou kan je zelfs nog zeggen dat Boek in dit geval een abstracte class is omdat je wilt dat de `getAuteur` functie per type boek anders kan zijn. Dit is een voorbeeld van een abstracte class die een interface implementeerd:
```PHP
abstract class Boek implements BoekInterface {
    protected string $auteur;
    protected int $paginas;
    protected string $content;

    public function __construct(string $auteur, int $paginas, string $content)
    {
        $this->auteur = $auteur;
        $this->paginas = $paginas;
        $this->content = $content;
    }

    abstract public function getAuteur(): string;
}
```
Interfaces zijn handig voor dingen zoals je database implementatie. Deze database implementatie kan per database anders zijn. MySql werkt toch net anders dan MSSql. Maar toch wil je dat je applicatie op dezelfde manier met de database implementatie kan praten. Dit doe je dan door een interface te maken voor de database. Hier een klein voorbeeld:
```PHP
interface DataBaseInterface {
    public function connect(string $host, string $user, string $password, string $database): void;
    public function query(string $query): array;
}

class MySqlDataBase implements DataBaseInterface {
    private mysqli $connection;

    public function connect(string $host, string $user, string $password, string $database): void
    {
        $this->connection = new mysqli($host, $user, $password, $database);
    }

    public function query(string $query): array
    {
        $result = $this->connection->query($query);

        if ($result === false) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
```

Nou zul je de interface gebruiken om met de database te praten. Dit is een voorbeeld van hoe je dat zou kunnen doen:
```PHP
class Application {
    private DataBaseInterface $database;

    public function __construct(DataBaseInterface $database)
    {
        $this->database = $database;
    }

    public function getProducts(): array
    {
        return $this->database->query('SELECT * FROM products');
    }
}

$application = new Application(new MySqlDataBase());
```
Nu geef je de applicatie een database implementatie mee. Als je deze implementatie zou vervangen door een andere class die de interface implementeert zou de Application class nog steeds werken, mits de implementatie werkt natuurlijk. Dit is handig omdat over de looptijd van je applicatie veel dingen kunnen veranderen en je niet bij elke aanpassing al je code wilt raken. Daardoor is je applicatie flexibel en makkelijker te onderhouden. Het heeft allemaal natuurlijk wel impact op de complexiteit dus gebruik het alleen wanneer je denkt dat het echt nodig is.


## Global helper variabelen
De volgende variabelen zijn globaal beschikbaar in de webshop. Deze zijn allemaal aangemaakt in index.PHP om ervoor te zorgen dat alle paden in de rest van de applicatie kloppen. Deze variabelen zijn:
- BASE_PATH - Het pad naar de root van het project.
    - /var/www/html/App - in docker.
    - /src/App - lokaal.
- VIEWS_PATH - Het pad naar de views map. 
    - /var/www/html/App/Content/Views. - in docker.
    - /src/App/Content/Views. - lokaal.
- RUNTIME_PATH - Het pad naar de runtime map.
    - /var/www/html/App/Runtime. - in docker.
    - /src/App/Runtime. - lokaal.
- COMPONENT_NAMESPACE - De Namespace van de componenten.
    - /var/www/html/App/HTTP/Controllers/Components. - in docker.
    - /src/App/HTTP/Controllers/Components. - lokaal.

> **Opmerking:** Meer over componenten in [MVCCore](./MVCCore/MVCCore.md#components).