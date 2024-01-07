# Mailing 
> **Leestijd:** 5 minuten

## Inhoudsopgave
- [Inleiding](#inleiding)
- [Mail](#mail)
- [Mailserver](#mailserver)
- [De mails](#demails)

## Inleiding
In dit document zal besproken worden hoe de huidige applicatie mails verstuurd. Aangezien het door de huidige invulling van de infrastructuur lastig was mails te verzenden vanuit skylab is dit zeker een belangrijk onderwerp.

## Mail
Dit hoofdstuk bespreek hoe de mails verstuurd worden en hoe dit is gefaciliteerd in de applicatie. Hiervoor zijn een aantal classen opgezet die dit voor de programmeur afhandelen. 

Om een mail aan te maken maak je gebruik van de `Mail` en `MailTemplate` klassen. Daarnaast heb je een mailtemplate nodig. Dit template is een html bestand in de form van een view. Deze view wordt vervolgens ingevuld met de gegevens die je meegeeft aan de `MailTemplate` class. Zo'n template kan er als volgt uitzien:

```php
<p>
    Er is een contact formulier ingevuld. Beoordeel deze en neem contact op met de klant.
</p>
<p>
    <b>Naam:</b>
    <?= $firstname . " " . $lastname ?><br>
    <b>Email:</b>
    <?= $email ?><br>
    <b>Bericht:</b>
    <?= $message ?><br>
</p>
```

Dit bestand bevindt zich in de MailTemplates map in het project. In dit template zitten een aantal data punten die je moet vullen via php wanneer je de mailtemplate bouwt. Dit doe je als volgt:

```php
$mailTemplate = new MailTemplate(MAIL_TEMPLATES . "ContactFormStore.php", [
    firstname' => $_POST['firstname'],
    lastname' => $_POST['lastname'],
    email' => $_POST['email'],
    message' => $_POST['message']
])
```

Deze class maakt nu een html string voor je aan de je dan aan de mail mee kan geven. Dit doe je als volgt:

```php
$mail = new Mail("info@thesixthstring.store", "Contactformulier ontvangen!", $mailtemplateContactFormStore, MailFrom::NOREPLY, "no-reply@thesixthstring.store");
$mail->send();
```

De Mail class neemt in de constructor een aantal parameters. De eerste parameter is het email adres waar de mail naar toe moet. De tweede parameter is de titel van de mail. De derde parameter is de html string die je hebt aangemaakt met de `MailTemplate` class. De vierde parameter is het email adres van de afzender en de vijfde parameter is de naam van de afzender.

## Mailserver
Omdat we hebben geconstateerd dat het niet mogelijk was op skylab rechtreeks mails te versturen met PHPMailer omdat windesheim waarschijnlijk bepaalde poorten die hiervoor benodigd zijn hebben geblokkeerd. Dit zorgt ervoor dat er geen handshake plaats kan vinden met de smtp server die wij gebruiken. Wij maken gebruik van de smtp server van outlook en dit hadden wij al geheel opgezet dus het leek ons een slecht idee dit compleet om te gooien.

Om het probleem van skylab te omzeilen hebben wij een externe vps opgezet. Dit is een linux server waar wij volledige controle over hebben. Hier hebben wij een tweede php project neergezet die de mails voor ons kan afhandelen. 

Deze server heeft geen domein en wordt bereikt op IP adres. Om een mail te sturen verzenden wij vanuit de webserver een HTTP request naar die tweede server. Dit HTTP request bestaat uit een aantal parameters die de mailserver nodig heeft om de mail te versturen. Deze parameters zijn als volgt:
- `to`: Het email adres waar de mail naar toe moet
- `subject`: De titel van de mail
- `body`: De html string die de mail bevat
- `from`: Het email adres van de afzender
- `fromName`: De naam van de afzender
- `altBody`: De tekstuele versie van de mail
- `key`: Een api key om te verifiëren dat het verzoek van de webserver komt

Aangezien deze mailserver publiek berijkbaar is was het noodzakelijk dat er een vorm van autorisatie op de mail server zit. Dit hebben we opgelost aan de hand van een Api key. Deze key wordt in de body van het HTTP request meegestuurd aan de server. Nu is het erg onveilig om een Api key mee te sturen met een HTTP request omdat dit theoretisch gezien onderschept kan worden. Omdat dit een groot risico is hebben we besloten de Api key die we mee sturen te encrypten. 

De encryptie die we gebruiken is AES-256-CBC. Dit is een encryptie die gebruik maakt van een encryption key en de te encrypten data. Deze encryptie key is een string die wij op de webserver hebben opgeslagen. Deze key is ook op de mailserver opgeslagen. Aan de hand van deze key kan de Api key encrypt en decrypt worden.

Omdat het in dit geval nog steeds mogelijk is de Key te onderscheppen hebben we een tweede beveiliging ingebouwd. Als iemand de encrypted Api key onderschept kunnen ze hem misschien niet lezen maar ze zouden hem bij een nieuw request nog steeds kunnen meesturen. Om hier tegen te beveiligen hebben we aan het eind van de Api key, voordat deze wordt encrypt, een timestamp toegevoegd. Bij het decrypten wordt deze timestamp er uit gehaald. Als het dan blijkt dat de timestamp meer dan dertig seconden oud is wordt het request geweigerd.

Deze constructie is alleen nodig op skylab en daarom is het mogelijk deze hele stap er tussen uit te halen met een ENV variabele. Als deze variabele op true staat wordt de externe server gebruikt. Zo niet dan wordt de mail direct vanuit de webserver verstuurd.