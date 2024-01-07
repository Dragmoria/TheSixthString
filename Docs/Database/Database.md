# Database

> **Leestijd:** 10 minuten

## Inleiding
In dit document worden de aansluiting van de applicatie op de database, de gebruikte structuur van de code en het gebruik in de applicatie besproken.

## Structuur
We hebben ervoor gekozen om de database gescheiden te houden van de front-end. Hiervoor hebben we de volgende structuur aangehouden:
- DatabaseContext -> deze class leest zelf de benodigde settings (servername, username, password etc) uit en initialiseert daarmee zelf de databaseconnectie (dit gebeurt bij het uitvoeren van elke query).
- BaseDatabaseService -> deze class is de basis voor alle specifieke services, zoals bijvoorbeeld ReviewService, ProductService etc. Deze class bevat een function 'query'; in deze function wordt de connectie naar de database geopend, de query uitgevoerd, de connectie gesloten en vervolgens het resultaat van de query teruggegeven.
- *Service -> deze classes bevatten alle logica om de database aan te roepen voor (zoveel mogelijk) een specifieke tabel
- Entities -> deze classes komen overeen met de tabellen in de database
- - Models -> deze classes bevatten de data die vanuit de Service naar de Controller terug wordt gegeven

## Databaseconnectie
De structuur van het project is zo opgezet, dat een Controller niet rechtstreeks de database aanroept. Technisch gezien is het wel mogelijk, maar het is een stuk netter om vanuit de Controller de juiste Service aan te roepen en die de database aan te laten roepen.

De DatabaseContext leest zelf de settings uit:
```PHP
class DatabaseContext {
    private string $_servername;
    private string $_username;
    private string $_password;
    private string $_database;
    private int $_port;

    function __construct() {
        $envHandler = Application::getContainer()->resolve(EnvHandler::class);

        $this->_servername = $envHandler->getEnv('MYSQL_SERVER');
        $this->_username = $envHandler->getEnv('MYSQL_USER');
        $this->_password = $envHandler->getEnv('MYSQL_PASSWORD');
        $this->_database = $envHandler->getEnv('MYSQL_DATABASE');
        $this->_port = $envHandler->getEnv('MYSQL_PORT');
    }

    public function connect(): \mysqli {
        return new \mysqli($this->_servername, $this->_username, $this->_password, $this->_database, $this->_port);
    }
```
De BaseDatabaseService maakt zelf een nieuwe instantie van de DatabaseContext:
```PHP
class BaseDatabaseService {
    private DatabaseContext $_dbContext;

    function __construct() {
        $this->_dbContext = new DatabaseContext();
    }

    public function query(string $query, int $result_mode = MYSQLI_STORE_RESULT): \mysqli_result|bool {
        $db = $this->_dbContext->connect();
        ...
    }
}
```


De Services overerven van BaseDatabaseService en roepen de function 'query' aan:
```PHP
class CategoryService extends BaseDatabaseService {
    public function getCategories(): array {
        $queryResult = $this->query("select * from category order by parentId")->fetch_all(MYSQLI_ASSOC);
        ...
    }

    ...
}
```
...En de Controller roept de Service aan:
```PHP
class HomeController extends Controller {
    public function index(): ?Response {
        $categoryService = Application::resolve(CategoryService::class);
        $categories = $categoryService->getCategories();

        ...
    }
}
```

De volgorde is dus als volgt: Controller => Service (= BaseDatabaseService) => DatabaseContext => database

## Services
In een Service stel je je query samen, dit is $query:
```PHP
private function getById(int $id): Review {
    $query = 'select top 1 * from review where id = ' . $id;
    $result = $this->query($query);

    return $result->fetch_object(Review::class);
}
```
Daarna voer je de aanroep naar de database uit, dit is $this->query($query);

Het resultaat wordt vervolgens omgezet naar de Entity (want dit sluit precies aan op de tabel in de database). Dit doe je door $result->fetch_object(Entity::class), hiermee wordt de opgehaalde data automatisch gemapped naar de aangegeven Entity.
De Entity wordt niet rechtstreeks naar de Controller teruggegeven, dit wordt gedaan met Models (bijvoorbeeld ReviewModel, ProductModel etc).
De Models bevatten een methode convertToModel die de Entity naar het Model omzet, deze roep je op de volgende manier aan:
```PHP
public function getReviewById(int $id): ReviewModel {
    $review = $this->getById($id);
    $product = $this->query('select prod.* from product prod inner join orderitem items on prod.id = items.productId where items.id = ' . $review->orderItemId . ' limit 1')->fetch_object(Product::class);

    $model = ReviewModel::convertToModel($review);
    $model->product = ProductModel::convertToModel($product);
    return $model;
}
```
Deze methodes zijn als Model::convertToModel aan te roepen, omdat convertToModel een static methode is; dit houdt in dat je geen nieuw object van deze class hoeft te maken om de methode te kunnen gebruiken.

Als je niet 1 resultaat, maar een lijst van resultaten verwacht, gebruik dan niet $this->query(...)->fetch_object(...), maar $this->query(...)->fetch_all(MYSQLI_ASSOC):
```PHP
public function getAllReviewsForProduct(int $productId) {
    $query = "select rev.* from review rev inner join orderitem items on items.Id = rev.orderItemId where items.productId = " . $productId;
    $entities = $this->query($query)->fetch_all(MYSQLI_ASSOC);

    $models = array();
    foreach($entities as $entity) {
        array_push($models, ReviewModel::convertToModel(cast(Review::class, $entity)));
    }

    return $models;
}
```
fetch_all zorgt ervoor dat alle resultaten op worden gehaald en MYSQLI_ASSOC zorgt ervoor dat alles als een associative array terug wordt gegeven, dit is belangrijk voor het omzetten naar de Entity. De function 'cast' zet alles uit 1 array element om naar de aangegeven class, dit aan de hand van de keys (bijvoorbeeld ["id"] => 1 wordt dan gemapped naar $entity->id = 1).

## Models
Deze classes worden aan de Controller teruggegeven en in de View gebruikt; je mag hier zelf dingen aan aanpassen of zelfs nieuwe models maken als de bestaande niet bruikbaar blijkt, let hierbij wel op dat bestaande logica hier niet door kapot gaat.
Let op: een Entity mag je alleen aanpassen als de tabel in de database ook wordt aangepast, anders kan de Entity niet meer automatisch worden gevuld.

