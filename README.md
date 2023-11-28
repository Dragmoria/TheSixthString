# The Sixth String webshop

## Inhoudsopgave
  - [Inhoudsopgave](#inhoudsopgave)
  - [Inleiding](#inleiding)
  - [Installatie](#installatie)
  - [Configuratie](#configuratie)
  - [Onderdelen](#onderdelen)

## Inleiding

Dit project is een webshop voor een fictief bedrijf genaamd The Sixth String. Dit project is gemaakt als opdracht voor de eerste periode van de opleiding HBO-ICT aan Windesheim Zwolle.

## Requirements

Om deze webshop te kunnen draaien heb je de volgende software nodig:
- Docker https://docs.docker.com/desktop/install/windows-install/

> **Opmerking:** Hoewel Docker niet strikt noodzakelijk is, maakt het gebruik ervan het proces aanzienlijk eenvoudiger.

## Installatie

Om deze starter kit te gebruiken kun je de volgende stappen volgen. Deze stappen zullen een nieuw project aanmaken met de starter kit:

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
```

## Onderdelen

Dit project bevat de volgende onderdelen:
- [Generiek](./docs/Generiek.md) // info over wat al is opgezet in de starter kit.
- [Docker](./docs/Docker.md) // info over de docker setup.
- [Database](./docs/Database/Database.md) // info over de database namespace.
- [MVCCore](./docs/MVCCore/MVCCore.md) // info over de MVCCore namespace.
- [EnvUtility](./docs/EnvUtility.md) // info over de EnvUtility namespace.