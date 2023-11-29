# MVCCore
> **Tijdsduur:** 10 minuten

# Inhoudsopgave
- [Inhoudsopgave](#inhoudsopgave)
- [Inleiding](#inleiding)
- [MVC](#mvc)
- [MVCCore](#mvccore)

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

- [Application](#application)
- [Container](#container)
- [Router](#router)
- [Controller](#controller)
- [Middleware](#middleware)