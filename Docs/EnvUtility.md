# EnvUtility
> **Tijdsduur:** 2 minuten

Path naar deze library: `src/App/EnvUtility/`

Dit is een utility class die gebruikt kan worden om de .env file uit te lezen. Dit zal het makkelijker maken om een .env in te laden in het project.

## Gebruik

Binnen de huidige versie van de webshop is het niet nodig om deze class zelf nog te initialiseren. Deze setup is al gedaan in bootstrap.php. Echter moet je wel nog een .env file aanmaken in de src map. Dit is je .env file voor de webserver. Mocht je hem toch ergens anders willen plaatsen kan dat maar dan zul je wel het pad naar de .env file moeten aanpassen. Daarnaast zal de webserver hier ook voor moeten zijn ingesteld. Voorkeur dus om dit gewoon in de src map te doen.

> **Opmerking:** $container is een instance van de Container class. Deze class is een onderdeel van de MVCCore namespace. [MVCCore](./MVCCore/MVCCore.md)

Om het pad naar de .env aan te passen ga je naar bootstrap.php en vervang je de volgende regel:

```php
$container->registerClass(EnvHandler::class)->asSingleton()->setResolver(function() {
    return new EnvHandler(BASE_PATH . '/.env');
});

// Vervang BASE_PATH . '/.env' door het pad naar je .env file.
```

## Functies

De EnvUtility class bevat de volgende functies:

### getEnv()

Deze functie geeft de waarde van een environment variabele terug. Deze functie heeft 1 parameter:
Voorbeeld

```php
$envHandler = Application::getContainer()->resolveClass(EnvHandler::class);
$dbPassword = $envHandler->getEnv('MYSQL_PASSWORD');
```