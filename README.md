# The Sixth String webshop

## Inhoudsopgave
  - [Inhoudsopgave](#inhoudsopgave)
  - [Inleiding](#inleiding)
  - [Installatie](#installatie)
  - [Configuratie](#configuratie)
  - [Onderdelen](#onderdelen)

## Inleiding



## Requirements

Om deze webshop te kunnen draaien heb je de volgende software nodig:
- Docker

> **Opmerking:** Hoewel Docker niet strikt noodzakelijk is, maakt het gebruik ervan het proces aanzienlijk eenvoudiger.

## Installatie

Om deze starter kit te gebruiken kun je de volgende stappen volgen. Deze stappen zullen een nieuw project aanmaken met de starter kit:

1. Downoad de nieuwste release van deze starter kit.
2. Plaats de bestanden waar je het project wilt hebben.
3. Pak de bestanden uit.
4. Open een terminal in de root van het project.
5. Voer het volgende commando uit: 
    ```bash
    bash scripts/CreateNewProject.sh
    ```
6. Volg de instructies op het scherm.

## Configuratie

Dit project heeft weinig configuratie nodig. De enige configuratie die nodig is, is het aanmaken van een .env die door docker gebruikt wordt om de database in te stellen. De .env file moet in de root van het project staan. De inhoud van de .env file moet er als volgt uitzien:

```env
    MYSQL_PASSWORD=password
    MYSQL_DATABASE=databaseName
    MYSQL_USER=userName
```

## Onderdelen

Deze starter kit bevat de volgende onderdelen:
- [Generiek](./docs/Generiek.md) // info over wat al is opgezet in de starter kit.
- [Docker](./docs/Docker.md) // info over de docker setup.
- [Database](./docs/Database/Database.md) // info over de database namespace.
- [MVCCore](./docs/MVCCore/MVCCore.md) // info over de MVCCore namespace.
- [EnvUtility](./docs/EnvUtility.md) // info over de EnvUtility namespace.