# Project: ‘Wijnfavorieten’ demo online app

## Doelstellingen

- Zelf je wijnselectie samenstellen: Vul de app met informatie over jouw voorkeuren, zoals smaak, land, streek en prijs in de horeca en prijs in de winkel. Op basis daarvan helpt de app je bij het kiezen van de juiste wijn voor elke gelegenheid.

- Prijzen vergelijken: Voeg zelf informatie toe over de wijnen die je interesseren en vergelijk de prijzen bij verschillende verkopers. Zo vind je altijd de beste deal voor jouw favoriete flessen.

- Je eigen wijnnotities bijhouden: Houd je eigen proefnotities en beoordelingen van wijnen bij, zodat je jouw ervaringen kunt onthouden en kunt uitwisselen met anderen. Jij bepaalt welke wijnen je wilt onthouden en waarom en je kunt zelf in een vrij veld de info vastleggen die je interessant vindt.

Een persoonlijke wijnwensenlijst maken: Stel een lijst samen van wijnen die je in de toekomst wilt proberen of kopen. Voeg notities toe over waarom je geïnteresseerd bent en mogelijke prijsindicaties, zodat je altijd goed voorbereid bent tijdens je volgende wijnaankoop.

- Je persoonlijke waarschuwingslijst maken met wijnen met een lage beoordeling.

## Functioneel ontwerp

- Login.php en Logout.php
Hiermee start en beëindig je je sessie.

- Index.php
Toont per kleur een overzicht van de opgeslagen wijnen in vier overzichten: rood, wit, rosé en mousserend.

- Geeft per wijn een kleine afbeelding en de belangrijkste informatie van elke wijn, zoals merk, naam, winkelprijs en je persoonlijke beoordeling,

- Biedt je de mogelijkheid om per kleur te filteren op verschillende criteria zoals merk, naam, winkelprijs en je persoonlijke beoordeling

- Iedere rij met informatie wordt afgesloten met een icon met tooltip met een link naar de detailpagina per wijn.

- Je hebt buttons om kleuren te kiezen en om wijnen toe te voegen en een button om uit te loggen.

## Detail.php

- Toont de afbeelding en de informatie die je hebt toegevoegd over de geselecteerde wijn, onderverdeeld in merk, naam, kleur, winkelprijs, restaurantprijs, land, streek, verdere informatie die je interessant vond en als laatste je beoordeling op een schaal van 0 tot 5.

- Het biedt je ook buttons waarmee je opties hebt om de wijn aan te passen of te verwijderen. Ook hier heb je de optie om terug te gaan naar index.php met en button of via het logo of om uit te loggen.

## Insert.php

- Mogelijkheid om een nieuwe wijn toe te voegen aan de database en een afbeelding toe te voegen aan de map uploads.
- Je kunt de volgende informatie toevoegen: afbeelding, merk, naam, kleur, winkelprijs, restaurantprijs, land, streek, verdere informatie, die je interessant vindt  en als laatste je beoordeling op een schaal van 0 tot 5.
- Validering van ingevoerde gegevens voordat ze worden toegevoegd aan de database.

## Edit.php

Mogelijkheid om de afbeelding en de bestaande wijninformatie te bewerken.

Validering van gewijzigde gegevens voordat ze worden bijgewerkt in de database

## Hoe kun je de bestanden ophalen voor lokaal gebruik?

Er zijn twee manieren om de benodigde bestanden voor lokaal gebruik op te halen:

### 1. Downloaden via de GitHub UI

- Ga naar de [GitHub-pagina](https://github.com/MdiOstra/wijnfavorieten_app).
- Klik op de groene knop met de tekst "Code".
- Selecteer "Download ZIP".
- Pak de gedownloade ZIP-map uit.

**Open de uitgepakte map:**

- Zoek de uitgepakte map (waarschijnlijk met de naam `wijnfavorieten_app`) op je computer.
- Gebruik Verkenner (Windows) of Finder (Mac) om de map te vinden.
- Open de map in je favoriete teksteditor of geïntegreerde ontwikkelingsomgeving (IDE).

### 2. Via de commandoregel met Git

1. **Open de terminal:**

#### Voor Mac

- Druk op `Command + Spatie` om Spotlight Search te openen.
- Typ "Terminal" en druk op `Enter`. Hierdoor wordt de Terminal-app geopend.

#### Voor Windows

- Druk op `Windows-toets + R` om het venster "Uitvoeren" te openen.
- Typ "cmd" en druk op `Enter`. Hierdoor wordt de Opdrachtprompt geopend.

**Navigeer naar de locatie waar je het project wilt opslaan:**

#### Voor Mac en Windows

- Gebruik het `cd`-commando om naar de gewenste map te navigeren.

     cd pad/naar/gewenste/map

     Vervang "pad/naar/gewenste/map" door het daadwerkelijke pad naar de map waar je het project wilt opslaan.

**Clone de repository:**

[git clone https://github.com/MdiOstra/wijnfavorieten_app.git]

- Met het commando ls kun je zien of je de map wijnfavorieten binnen hebt.

- Met cd wijnfavorieten kun je naar die map.

- met opnieuw 'ls' kun je nu zien dat je alle mappen en bestanden hebt om te kunnen beginnen!

## Waar staat de site online?

[Bezoek de wijnfavorieten](https://mvtalen.nl/wijnfavorieten)

gebruikersnaam: test-user
wachtwoord: w@chtwOOrd

Installeer de database met behulp van wijnfavorieten.sql lokaal of op een domein.

## Toelichting werking scripts

## Naam: index.php

### Functionaliteiten en Buttons

- Het script begint met het controleren van de sessie om te bepalen of een gebruiker is ingelogd. Zo niet, dan wordt de gebruiker doorgestuurd naar de inlogpagina (`login.php`).
- Er wordt gecontroleerd of de query parameter 'kleur' is ingesteld. Zo niet, wordt de gebruiker doorgestuurd naar de hoofdpagina met de kleur 'rood'. Dit om te voorkomen dat je met een lege pagina opent.
- Er zijn verschillende knoppen geïmplementeerd:
  - Knoppen met wijnglazen in de kleur voor het selecteren van de kleur van de wijn.
  - Een + knop voor het toevoegen van nieuwe wijn (`insert.php`).
  - Een knop voor uitloggen (`logout.php`).
  - Via een I -con kun je naar de detailpagina met meer informatie over de wijn.
  - Er is gebruik gemaakt van intuïtieve icons,zodat de app ook mobiel met kleine schermen goed te gebruiken.

### Toepassing van Bootstrap

- Bootstrap wordt toegepast voor het stylen van de navbar, knoppen, tabellen en andere elementen op de pagina.
- Het script gebruikt Bootstrap-klassen zoals `navbar`, `navbar-brand`, `btn`, `btn-group`, `table`, enzovoort.
- De layout is responsief dankzij Bootstrap-gridklassen zoals `col-3`, `col-6`, en `d-flex`.

### Beveiligingstoepassingen

- Sessiebeheer wordt toegepast om de gebruiker te authenticeren en ervoor te zorgen dat alleen ingelogde gebruikers toegang hebben tot de inhoud van de pagina.
- PDO wordt gebruikt voor database-interacties, wat de veiligheid verbetert door het risico op SQL-injectie te verminderen. Prepared statements worden gebruikt bij het uitvoeren van query's om gebruikersinvoer veilig te verwerken.

Het script gaat verder met het renderen van de HTML-content en eindigt met het sluiten van de `<body>` en `<html>` tags, inclusief het toevoegen van de nodige scripts voor Bootstrap-functionaliteit.

## Naam: insert.php

### Uitleg

- Het script maakt het mogelijk om een nieuwe wijn toe te voegen aan de database.
- Er is een formulier met invoervelden voor verschillende eigenschappen van de wijn, zoals merk, naam, kleur, prijzen, land, streek, informatie en rating.
- Een knop om een afbeelding van de wijn te uploaden.
- Een knop voor uitloggen.
- Een knop om zonder invoegen terug te gaan naar index.php. Dit kan ook door op het logo Wijnfavorieten te drukken.

### Verwerking afbeeldingen

Als er een afbeelding is geüpload, dan wordt het volgende uitgevoerd:
    Lees de afbeeldingsgegevens.
    Controleer of het bestandstype wordt ondersteund.
    Resize de afbeelding naar maximaal 320x240 met behoud van aspectverhouding.
    Draai de afbeelding indien nodig op basis van exif-gegevens.
    Sla de geresized afbeelding op met exif-gegevens.
    Genereer een unieke bestandsnaam.
    Sla de afbeelding op in de upload directory met de unieke bestandsnaam en sla de gegevens op in de database.

### Uitleg over het verkleinen en opslaan van afbeeldingen

- `imagecreatetruecolor`: Dit creëert een nieuw true color afbeeldingssamenstellingsobject.
- `imagecopyresampled`: Dit kopieert een rechthoekig gedeelte van de ene afbeelding naar de andere, waarbij de grootte wordt aangepast.
- `imagejpeg`: Dit slaat de afbeelding op als een JPEG-bestand met de opgegeven kwaliteit.

### Bootstrap

- Bootstrap wordt gebruikt voor het stylen van de navbar, knoppen, formulierelementen en andere componenten op de pagina.
- Bootstrap-klassen zoals `navbar`, `btn`, `form-control`, enzovoort worden gebruikt om de interface vorm te geven en responsief te maken.
 Op kleine schermen (xs) wordt het formulier verticaal weergegeven in één kolom.
- Op middelgrote (md) en grote (lg) schermen worden de formulierelementen verdeeld over twee kolommen om het gebruikersgemak te verbeteren.

### Beveiligingstoepassingen met name PDO en HTML-invoerbeveiliging

- PDO wordt gebruikt voor database-interacties, wat de veiligheid verbetert door het risico op SQL-injectie te verminderen. Prepared statements worden gebruikt bij het uitvoeren van query's om gebruikersinvoer veilig te verwerken.
- HTML-invoer wordt beveiligd door de `htmlspecialchars`-functie te gebruiken bij het weergeven van gebruikersinvoer in de HTML-uitvoer. Dit helpt XSS-aanvallen (Cross-Site Scripting) door speciale tekens te neutraliseren.

## naam: edit.php

### Functionaliteiten en knoppen

Het script `edit.php` stelt gebruikers in staat om wijngegevens te bewerken, inclusief het uploaden van afbeeldingen. De belangrijkste functionaliteiten en knoppen zijn:

- Formulier voor het bewerken van wijngegevens, inclusief velden voor merk, naam, kleur, winkelprijs, restaurantprijs, land, streek, informatie en rating.
- Huidige afbeelding van de wijn wordt weergegeven met de mogelijkheid om een nieuwe afbeelding te uploaden.
- Knop "Aanpassen" om de wijzigingen op te slaan.
- Knoppen om terug te gaan naar de hoofdpagina en uit te loggen.

### Afbeeldingen uploaden en verkleinen

- Het script controleert of er een afbeelding is geüpload en verwerkt deze vervolgens. Afbeeldingen kunnen zowel vanaf mobiele apparaten als vanaf computers worden geüpload.
- Afbeeldingen worden verkleind tot maximaal 320x240 pixels om de bestandsgrootte te beperken.
- Exif-gegevens van de originele afbeelding worden indien aanwezig gekopieerd naar de aangepaste afbeelding.
- Geüploade afbeeldingen worden opgeslagen in de map 'uploads' met een unieke bestandsnaam.
In het script kan het oude afbeeldingsbestand worden vervangen door een nieuw bestand wanneer een wijn wordt bewerkt. Hier is hoe het gebeurt:

1. Wanneer het formulier wordt ingediend (`$_SERVER["REQUEST_METHOD"] == "POST"`), wordt gecontroleerd of er een afbeelding is geüpload.

2. Als er een afbeelding is geüpload, wordt deze verwerkt:
   - Het geüploade bestand wordt geopend en verkleind tot een maximale grootte van 320x240 pixels.
   - Eventuele EXIF-gegevens van de originele afbeelding worden behouden en toegepast op de aangepaste afbeelding (bijvoorbeeld rotatie-informatie).
   - Het nieuwe afbeeldingsbestand wordt opgeslagen met een unieke bestandsnaam in de `uploads/` directory.

3. Het nieuwe bestandsnaam wordt vervolgens gekoppeld aan de betreffende wijn in de database door de bestandsnaam bij te werken in de `images` tabel met behulp van een UPDATE SQL-query.

4. Als de update van de afbeeldingsinformatie in de database succesvol is, wordt het oude afbeeldingsbestand verwijderd om ruimte te maken voor het nieuwe bestand. Dit wordt gedaan met behulp van de `unlink()` functie, die het oude afbeeldingsbestand verwijdert als het bestaat.

Samenvattend, bij het bewerken van een wijn in `edit.php`, wordt het oude afbeeldingsbestand vervangen door een nieuw bestand als er een nieuwe afbeelding wordt geüpload. Hierdoor wordt het bestand bijgewerkt in de database en wordt het oude afbeeldingsbestand van de server verwijderd om opslagruimte vrij te maken.

### Gebruik van afbeeldingsfuncties

- `imagecreatetruecolor`: Deze functie wordt gebruikt om een nieuw afbeeldingsbestand met een opgegeven breedte en hoogte te maken.
- `imagecopyresampled`: Hiermee wordt de bronafbeelding naar de doelafbeelding gekopieerd en daarbij geschaald en bijgesneden om de afmetingen van de doelafbeelding te passen.
- `imagejpeg`: Deze functie wordt gebruikt om de aangepaste afbeelding op te slaan als een JPEG-bestand met de opgegeven kwaliteit.

### Toepassing Bootstrap

- Het script maakt gebruik van Bootstrap voor responsief ontwerp.
- Op kleine schermen (xs) wordt het formulier verticaal weergegeven in één kolom.
- Op middelgrote (md) en grote (lg) schermen worden de formulierelementen verdeeld over twee kolommen om het gebruikersgemak te verbeteren.

### Beveiliging met PDO en HTML-invoer

- Het script maakt gebruik van PDO (PHP Data Objects) voor de database-interactie, wat de veiligheid verbetert door het gebruik van prepared statements met gebonden parameters.
- HTML-invoer wordt beveiligd door gebruik te maken van de functie `htmlspecialchars`, wat helpt bij het voorkomen van XSS (Cross-Site Scripting) aanvallen door HTML-tags te converteren naar hun equivalenten.

## naam: detail.php

### Functionaliteiten en toepassing knoppen

Het script `detail.php` biedt de volgende functionaliteiten en knoppen:

- Weergave van gedetailleerde informatie over een specifieke wijn, inclusief afbeelding, naam, merk, kleur, prijzen, land, streek, extra informatie en beoordeling.
- Knop "Bewerken" om de gegevens van de wijn te bewerken.
- Knop "Toevoegen" om een nieuwe wijn toe te voegen.
- Knop "Terug" om terug te gaan naar de hoofdpagina.
- Knop "Verwijderen" om de huidige wijn te verwijderen.
In het script wordt het oude bestand verwijderd bij het verwijderen van een wijn. Dit gebeurt in de sectie waar de delete functionaliteit wordt verwerkt na het indrukken van de delete knop:

```php
if (isset($_POST['delete'])) {
    $wineID = $_POST['wine_id'];
    $deleteWineSQL = "DELETE FROM wines WHERE id = :wineID";
    $deleteImageSQL = "DELETE FROM images WHERE wine_id = :wineID";
    $deleteWineStmt = $conn->prepare($deleteWineSQL);
    $deleteImageStmt = $conn->prepare($deleteImageSQL);
    $deleteWineStmt->bindParam(":wineID", $wineID, PDO::PARAM_INT);
    $deleteImageStmt->bindParam(":wineID", $wineID, PDO::PARAM_INT);
    if ($deleteWineStmt->execute() && $deleteImageStmt->execute()) {
        $imageFilename = $wine['filename'];
        $upload_directory = 'uploads/';
        $imagePath = $upload_directory . $imageFilename;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        echo "<p>Wijn met ID $wineID is succesvol verwijderd.</p>";
        echo "<script>window.location = 'index.php';</script>";
    } else {
        echo "<p>Fout bij het verwijderen van de wijn.</p>";
    }
}
```

In dit gedeelte worden twee SQL queries voorbereid: één om de wijn zelf te verwijderen uit de `wines` tabel, en de andere om de gerelateerde afbeelding(en) te verwijderen uit de `images` tabel. Vervolgens worden de queries uitgevoerd met behulp van `execute()`.

Als de queries met succes worden uitgevoerd, wordt het pad naar het oude afbeeldingsbestand opgebouwd op basis van de gegevens uit de database, en wordt het bestand daadwerkelijk verwijderd met behulp van `unlink()` functie. Deze functie verwijdert het bestand van de server.

Dit proces zorgt ervoor dat het oude afbeeldingsbestand wordt verwijderd wanneer de bijbehorende wijn wordt verwijderd uit de database, waardoor de server wordt opgeruimd en onnodig gebruik van opslagruimte wordt voorkomen.

### Gebruik Bootstrap en ontwerp

Ook hier een responsief ontwerp: De lay-out is responsief en past zich aan op verschillende schermformaten, wat zorgt voor een consistente gebruikerservaring op zowel desktops als mobiele apparaten.

Gebruik van kaarten: De wijninformatie wordt gepresenteerd als cars, waarbij de afbeelding aan de ene kant staat en de tekstuele informatie aan de andere kant en onder elkaar komt op kleine schermen. Dit creëert een visueel aantrekkelijke indeling en maakt het gemakkelijk voor gebruikers om de informatie te scannen.

De knoppen zijn consistent gestyled met het Bootstrap-framework. De toevoeging van pictogrammen (zoals een potlood voor "Bewerken" en een prullenbak voor "Verwijderen") maakt de knoppen intuïtief en gemakkelijk herkenbaar.

Meldingen: Het script maakt gebruik van meldingen om feedback te geven aan de gebruiker, zoals een bericht bij het verwijderen van een wijn.

Achtergrondkleuren: De achtergrondkleuren worden consistent toegepast en dragen bij aan de algehele visuele aantrekkelijkheid van de pagina. De combinatie van een donkere achtergrond met lichte tekst zorgt voor een goed contrast en verbetert de leesbaarheid.

- Bootstrap wordt toegepast voor responsief ontwerp:
- Op kleine schermen (xs) wordt de informatie weergegeven in één kolom.
- Op middelgrote (md) en grote (lg) schermen wordt de informatie verdeeld over twee kolommen voor een betere leesbaarheid.

### Beveiliging door PDO en HTML-invoer

- Het script maakt gebruik van PDO (PHP Data Objects) voor de database-interactie, waardoor SQL-injectie wordt voorkomen.
- HTML-invoer wordt beveiligd door gebruik te maken van de functie `htmlspecialchars`, wat helpt bij het voorkomen van XSS (Cross-Site Scripting) aanvallen door HTML-tags te converteren naar hun equivalenten.

## naam: login.php

### Functionaliteiten + knoppen

- Het script stelt gebruikers in staat om in te loggen op het systeem met behulp van een gebruikersnaam en wachtwoord.
- Het bevat een formulier met invoervelden voor gebruikersnaam en wachtwoord, evenals een knop om in te loggen.
- Wanneer gebruikers proberen in te loggen, worden hun inloggegevens vergeleken met de gegevens in de database.
- Als de inloggegevens correct zijn, wordt de gebruiker doorgestuurd naar de hoofdpagina (`index.php`).
- Als de inloggegevens onjuist zijn, wordt er enkele seconden een foutmelding weergegeven op het scherm.

### Bootstrap toepassing en layout

- Bootstrap wordt toegepast voor de styling en responsiviteit van de pagina.
- Het formulier en de knop voor inloggen worden gestyled met behulp van Bootstrap-klassen, zoals `form-control` voor de invoervelden en `btn` voor de inlogknop.
- De layout is eenvoudig en functioneel, met het inlogformulier gecentreerd op de pagina, omgeven door een achtergrondafbeelding en een vaste navigatiebalk aan de bovenkant.
- De achtergrondafbeelding wordt ingesteld via inline CSS om het volledige scherm te bedekken (`background-size: cover;`).

### Beveiliging met PDO en HTML invoer

- Om de beveiliging te waarborgen, maakt het script gebruik van PDO (PHP Data Objects) voor database-interacties. Dit helpt SQL-injectie-aanvallen te voorkomen door het gebruik van prepared statements.
- In het script worden invoervelden zoals gebruikersnaam en wachtwoord geverifieerd en gesanitized voordat ze worden gebruikt in de databasequery. Dit minimaliseert het risico van XSS (Cross-Site Scripting) aanvallen door schadelijke HTML of scriptcode in te voeren.
- De HTML-output wordt ook gecontroleerd om ervoor te zorgen dat er geen onbedoelde HTML-injectie plaatsvindt, wat de pagina kwetsbaar zou kunnen maken voor aanvallen zoals HTML-injectie.

## naam: logout.php

### Functionaliteiten

- Het script behandelt het uitloggen van gebruikers uit het systeem.
- Als een gebruiker is ingelogd (gecontroleerd via de sessievariabele `$_SESSION["loggedInUser"]`), wordt de sessie vernietigd en wordt de gebruiker uitgelogd.
- Als er geen gebruiker is ingelogd, wordt de gebruiker automatisch doorgestuurd naar de inlogpagina (`login.php`).

### Bootstrap toepassing + layout

- Bootstrap wordt gebruikt voor de styling en layout van de pagina.
- De boodschap die aangeeft dat de gebruiker succesvol is uitgelogd, wordt weergegeven met behulp van Bootstrap-alertklassen, zoals `alert-success`.
- De layout is eenvoudig en centraal uitgelijnd op de pagina, met een achtergrondafbeelding en een vaste navigatiebalk aan de bovenkant.
- Een redirect-meta-tag wordt gebruikt om de gebruiker na 2 seconden automatisch door te sturen naar de inlogpagina (`login.php`).

### Beveiliging met PDO + HTML invoer

- Het script maakt gebruik van PDO voor database-interacties, waardoor SQL-injectie-aanvallen worden voorkomen door middel van prepared statements.
- Er wordt geen externe invoer verwerkt of geaccepteerd in dit script, dus er is geen specifieke HTML-invoerbeveiliging nodig.

## naam: styles.css

De CSS-regels voor `.table-outer-border`, `.content-wrapper`, en verschillende knopelementen voegen aanvullende opmaak toe aan de standaard Bootstrap-stijlen. Bijvoorbeeld, de `.table-outer-border` klasse voegt schaduw en afgeronde hoeken toe aan de tabel.

Sommige CSS-regels, zoals `.icon-hover:hover`, definiëren interactie-effecten zoals het veranderen van de kleur van een pictogram wanneer de muis erover beweegt.

De CSS-regel voor `#fileInput` wordt gebruikt om bij het begin het inputelement te verbergen als er geen afbeelding is, dat gebruikt voor het uploaden van bestanden.

## naam: wijnfavorieten.sql

De database voor de Wijnfavorieten-app bestaat uit drie tabellen: `gebruikers`, `images`, en `wines`. Hier is een overzicht van de structuur en het doel van elke tabel:

1. **gebruikers**: Deze tabel slaat informatie op over gebruikers van de app. Het heeft de volgende kolommen:
   - `id`: De unieke identificator voor elke gebruiker.
   - `username`: De gebruikersnaam van de gebruiker.
   - `wachtwoord`: Het wachtwoord van de gebruiker.

   Deze tabel is belangrijk voor het authenticatieproces van de app. Elke gebruiker heeft een unieke combinatie van gebruikersnaam en wachtwoord nodig om toegang te krijgen tot het systeem.

2. **images**: Deze tabel slaat informatie op over afbeeldingen van wijnen. Het heeft de volgende kolommen:
   - `id`: De unieke identificator voor elke afbeelding.
   - `wine_id`: De verwijzing naar de wijn waar de afbeelding bij hoort.
   - `filename`: De naam van het bestand waarin de afbeelding is opgeslagen.

3. **wines**: Deze tabel bevat details over verschillende wijnen. Het heeft de volgende kolommen:
   - `id`: De unieke identificator voor elke wijn.
   - `merk`: Het merk of de producent van de wijn.
   - `naam`: De naam van de wijn.
   - `kleur`: De kleur van de wijn, opgeslagen als enum ('rood', 'wit', 'rosé', 'mousserend').
   - `wprijs`: De winkelprijs van de wijn.
   - `rprijs`: De restaurantprijs van de wijn.
   - `land`: Het land van herkomst van de wijn.
   - `streek`: De specifieke regio waar de wijn vandaan komt.
   - `info`: Extra informatie over de wijn.
   - `rating`: De beoordeling van de wijn.

   Deze tabel bevat alle relevante informatie over de beschikbare wijnen in de app.

In de Wijnfavorieten-app, wordt ENUM gebruikt voor de kleur kolom in de wines tabel. Dit beperkt de invoer tot slechts vier mogelijke kleuren voor wijnen (rood, wit, rosé, mousserend), waardoor de gegevens gestandaardiseerd en gemakkelijk te begrijpen zijn voor zowel de gebruikers als de ontwikkelaars.
