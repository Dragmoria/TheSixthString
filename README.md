# The Sixth String webshop
> **Tijdsduur:** 3 minuten

## Inhoudsopgave
  - [Inhoudsopgave](#inhoudsopgave)
  - [Inleiding](#inleiding)
  - [Installatie](#installatie)
  - [Configuratie](#configuratie)
  - [Onderdelen](#onderdelen)
  - [Git workflow](#git-workflow)

## Inleiding

Dit project is een webshop voor een fictief bedrijf genaamd The Sixth String. Dit project is gemaakt als opdracht voor de eerste periode van de opleiding HBO-ICT aan Windesheim Zwolle.

## Requirements

Om deze webshop te kunnen draaien heb je de volgende software nodig:
- Docker https://docs.docker.com/desktop/install/windows-install/

> **Opmerking:** Hoewel Docker niet strikt noodzakelijk is, maakt het gebruik ervan het proces aanzienlijk eenvoudiger.

## Installatie

Om deze website te gebruiken kun je de volgende stappen volgen. Deze stappen zullen het project opstarten in docker:

1. Downoad de nieuwste release van deze starter kit.
2. Plaats de bestanden waar je het project wilt hebben.
3. Pak de bestanden uit.
4. Check of je inderdaad docker hebt geïnstalleerd.
5. Open een terminal in de root van het project.
6. Voer het volgende commando uit: `docker-compose up -d --build`
7. Wacht tot de docker containers zijn opgestart.
8. Open een browser en ga naar `localhost:8080` voor de webshop of `localhost:8081` voor phpmyadmin.

## Configuratie

Dit project heeft weinig configuratie nodig. De enige configuratie die nodig is, is het aanmaken van een .env die door docker gebruikt wordt om de database in te stellen. De .env file moet in de root van het project staan. De inhoud van de .env file moet er als volgt uitzien:

```env
    MYSQL_PASSWORD=password
    MYSQL_DATABASE=databaseName
    MYSQL_USER=userName

    MYSQL_DATABASE= # Database naam
    MYSQL_USER= # Database root gebruikersnaam
    MYSQL_PASSWORD= # Database root wachtwoord
    MYSQL_EXTERNAL_PORT= # De poort waarop de database bereikbaar is vanaf de host machine
    WEB_HTTP_PORT= # De poort waarop de webserver bereikbaar is vanaf de host machine
    WEB_HTTPS_PORT= # De poort waarop de webserver bereikbaar is vanaf de host machine https
    PHPMYADMIN_EXTERNAL_PORT= # De poort waarop phpmyadmin bereikbaar is vanaf de host machine
    MYSQL_INTERNAL_PORT= # De poort waarop de database bereikbaar is vanaf de docker container
    MYSQL_SERVERNAME= # De naam van de database server ofwel de naam van de docker container vrijwel altijd 'db'
    # Mail configuration
    MAIL_PASSWORD_NOREPLY= # Het wachtwoord van het no-reply email adres
    MAIL_PASSWORD_ADMIN= # Het wachtwoord van het admin email adres
    MAIL_API_KEY= # De api key van de mail server
    MAIL_API_ENCRYPTKEY= # De encryptie key van de mail server
    MAIL_SERVER= # Het ip adres van de externe mail server
    MAIL_WITH_API= # Of de mail server een api gebruikt
```

## Onderdelen

Dit project bevat de volgende onderdelen:
- [Generiek](./Docs/Generiek.md) // info over php en wat globale opzet die al zijn gedaan in het project.
- [Database](./Docs/Database/Database.md) // info over de database namespace.
- [MVCCore](./Docs/MVCCore/MVCCore.md) // info over de MVCCore namespace.
- [EnvUtility](./Docs/EnvUtility.md) // info over de EnvUtility namespace.
- [QuickGuide](./Docs/MVCCore/QuickGuide.md) // een quick guide voor het toevoegen van een nieuwe pagina aan de website.
- [Mailing](./Docs/Mailing.md) // info over het versturen van mails. 

## Git workflow

Dit project maakt gebruik van de volgende git workflow: https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow.

We hebben 1 long term branch genaamd `main`. Deze branch is de branch die live staat. De `main` branch is de enige branch die niet direct aangepast mag worden. Om een nieuwe feature te maken moet er een nieuwe branch gemaakt worden vanaf `main`. Deze branch moet de naam van de feature krijgen. Als de feature klaar is moet er een pull request gemaakt worden van de feature branch naar `main`. Deze pull request moet door een andere developer worden goedgekeurd voordat de feature branch gemerged mag worden met `main`. Als de feature branch is gemerged met `main` kan de feature branch verwijderd worden als dit gewenst is.