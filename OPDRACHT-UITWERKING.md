# Uitwerking
Hieronder beschrijf ik mijn denkwijze wanneer ik de applicatie aan het bouwen ben 

De opdracht heb ik inmiddels gelezen. Ik zie grofweg deze stappen:

1. Migrations en models maken
2. Controllers maken
3. Background worker die database vult
4. Frontend implementatie

Laten we beginnen.

## 1. Migrations and models maken

Ik zie op dit moment dat we 3 soorten entities hebben: Posts, Comments en Authors. De data structuur wordt al gegeven in de jsonplaceholder, dus deze hanteer ik voor Posts en Comments. Ik twijfel of users als Authors moet fungeren, gezien niet elke auteur hoeft in te loggen of toegang heeft tot de applicatie. Voor nu maak ik dan ook een Author aan. 

- `php artisan make:model Authors -mf`
- `php artisan make:model Posts -mf`
- `php artisan make:model Comments -mf`

Gezien comments onder posts hangen, en posts onder authors hangen, is Authors is de basis, dus laten we deze als eerste tabel inrichten. 
De authors zijn nu redelijk simpel, deze kan ik later nog uitbreiden als er meer info nodig is. 
Bij de posts houden we 'author_id' aan in de tabel, zodat we de keys makkelijk kunenn herkennen.

Ik zie nu dat de models en factories plural zijn, dat verander ik.

De migrations en factories zijn nu aangemaakt, zodat we evt. met een seeder de database kunnen vullen (voor testing en voor sanity checks tijdens het bouwen van relaties).

De models moeten nog verder worden ingericht met een paar basis zaken zoals relaties en welke velden invulbaar zijn. De relaties zijn:
- Een author kan meerdere posts hebben
- Een post kan 1 author hebben, en meerdere comments
- Een comment kan 1 post hebben

Ik zie dat de relaties waren gecommit maar nog niet goed gereturnd werden. Deze heb ik aangepast.

## 2. Controllers maken

We hebben de data nu gestructureerd, dus nu gaan we ervoor zorgen dat we aan de voorkant deze posts kunnen zien. Dit doen we door de PostsController aan te maken
- `php artisan make:controller PostsController`
  In de routes/web.php zet ik nu enkel de index en show method neer, omdat we niet willen dat we op de voorkant ook items kunnen aanmaken, aanpassen of verwijderen.
- `Route::get('posts', [PostsController::class, 'index'])->name('posts.index');`
- `Route::get('posts/{post}', [PostsController::class, 'show'])->name('posts.show');`
Ook heb ik nu 2 views voor basis werking om te testen of alles goed gaat.

Extra stap: ik heb nog geen slugs. Het is voor SEO beter leesbaar waar de pagina over gaat als er een slug is dan een id, dus laten we dit aanpassen.
- `php artisan make:migration update_posts_table_add_slug_column`
Naast het toevoegen van de kolom wil ik ook gelijk de data opschonen. Als er een post is zonder een slug, pas deze dan gelijk aan in de database.
Daarnaast update ik ook de postFactory, zodat bij een test of nieuwe setup deze data gelijk werkt.
De slug voegen we toe aan de posts.show zodat dit voortaan de parameter is om de post aan te herkennen

# 3: Background worker die database vult
Tot nu toe heb ik de Factories gebruikt om te vullen, maar we willen dat de data uit de API komt. Laten we een job maken die we kunnen afvuren om deze data op te halen.
- `php artisan make:job ImportPostsJob`
Daarnaast wil ik dit als een commando nu kunnen aanroepen (testing purposes), dus laten we ook een commando maken
- `php artisan make:command ImportFromApi`
Deze vuurt de job af en via de env geef ik aan dat ik dit direct wil laten doen (QUEUE_CONNECTION=sync).
De job doet nu netjes de gehele pagina ophalen en plaatst alle data direct in de databse. Er zijn nu nog 3 issues:
- Het is altijd standaard 100 items
- De database is op dit moment standaard zonder authors, waardoor userId een mis-sync kan hebben
- Posts kunnen (bij het commando opnieuw te draaien) al bestaan, wat een error geeft

Als eerste wil ik niet continue mijn database opnieuw seeden. We pakken de updateOrCreate method en zorgen dat bij bestaande de data wordt geupdate. Daarbij heb ik nu ook een aantal meegegeven, voor als ik minder wil.
Ook willen we de authors en comments kunnen importeren. In plaats van 1 losse job maken we 3 jobs die als een chain worden afgevuurd. Eerst authors, dan posts, dan comments. Zo zijn de relaties ook goed te vinden.
De laatste stap is gelukt, namelijk het abstraheren van dubbele code naar 1 service die we importeren.

## 4. Frontend implementatie
Omdat frontend niet mijn sterkste kant is gebruik ik de livewire scaffolding zodat ik snel vanaf 0 kan beginnen. Ik gebruik een Helper class om te zorgen dat ik code snippets in de frontend kan gebruiken. De views worden bijgewerkt zodat ze een frontje hebben
Voeg een route en method toe om een comment te kunnen maken op een post
Ook translation files toegevoegd.
