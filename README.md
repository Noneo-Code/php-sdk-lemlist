# noneo/sdk-lemlist

SDK PHP pour l'API [lemlist](https://developer.lemlist.com/) : les 246
opérations non dépréciées de la spec OpenAPI, réparties en 33 ressources.

Le paquet est **agnostique de tout framework** : il ne dépend ni de Symfony, ni
de Laravel, et s'utilise par simple injection de dépendances.

## Installation

```bash
composer require noneo/sdk-lemlist
```

Requiert PHP `>=8.3`.

## Démarrage

Le client s'instancie avec la seule clé d'API (lemlist > Settings >
Integrations) :

```php
use Noneo\Sdk\Lemlist\Lemlist;

$lemlist = new Lemlist($apiKey);

echo $lemlist->team()->getTeam()->name;

foreach ($lemlist->campaigns()->getManyCampaigns(status: 'running') as $campaign) {
    echo $campaign->_id, ' ', $campaign->name, "\n";
}

$lemlist->leads()->createLeadInCampaign(
    campaignId: 'cam_123',
    email: 'ada@example.com',
    firstName: 'Ada',
    companyName: 'Analytical Engines',
    deduplicate: true,
    additional: ['favoriteColor' => 'bleu'], // variables personnalisées
);
```

Chaque section de la documentation lemlist a son point d'entrée
(`campaigns()`, `leads()`, `contacts()`, `inbox()`, `webhooks()`…), et chaque
méthode porte le titre de l'endpoint dans cette documentation : « Pause
Campaign » se trouve dans `campaigns()->pauseCampaign()`.

**Appelez les méthodes avec des arguments nommés.** Les signatures suivent la
spec : un argument laissé à `null` n'est pas envoyé, et l'ordre des arguments
optionnels peut évoluer avec elle.

### Sous Symfony

Le client se déclare comme n'importe quel service :

```yaml
# config/services.yaml
services:
    Noneo\Sdk\Lemlist\Lemlist:
        arguments:
            $apiKey: '%env(LEMLIST_API_KEY)%'
```

Il s'injecte ensuite par son type, `Noneo\Sdk\Lemlist\Lemlist`.

## Ce que rendent les méthodes

| La spec décrit la réponse…                   | La méthode rend                                 |
|----------------------------------------------|-------------------------------------------------|
| par un schéma nommé (`Campaign`, `Team`…)    | un DTO : `CampaignDto`, `TeamDto`…              |
| par une liste d'un schéma nommé              | une liste de DTO                                |
| de façon anonyme, dans l'endpoint            | le tableau décodé                               |
| pas du tout, ou en JSON *ou* CSV selon `format` | la valeur reçue telle quelle (`mixed`)       |
| en CSV uniquement                            | le texte brut                                   |

Les DTO sont **tolérants** : toutes leurs propriétés sont nullables, et une
valeur absente ou d'un type inattendu devient `null` au lieu de lever — la spec
lemlist n'est pas toujours fidèle à l'API. Le corps d'origine reste disponible
dans `raw`, champs non documentés compris :

```php
$campaign = $lemlist->campaigns()->getCampaign('cam_123');

$campaign->createdAt;          // ?\DateTimeImmutable
$campaign->creator?->userEmail; // objet imbriqué → DTO imbriqué
$campaign->raw['champNonDocumenté'] ?? null;
```

## Pagination

Les endpoints lemlist ne partagent ni leurs paramètres (`offset`, `page`,
`skip`) ni la forme de leur réponse. `Paginator` ne devine donc rien : on lui
donne une fonction qui va chercher une page et en rend les items, il s'arrête à
la première page incomplète.

```php
use Noneo\Sdk\Lemlist\Pagination\Paginator;

// Pagination par offset (ou skip)
$campaigns = Paginator::offset(
    fn (int $offset, int $limit) => $lemlist->campaigns()->getManyCampaigns(offset: $offset, limit: $limit),
);

// Pagination par page (la première vaut 1), items dans une enveloppe
$schedules = Paginator::page(
    fn (int $page, int $limit) => $lemlist->schedules()->getManySchedules(page: $page, limit: $limit)->schedules ?? [],
    limit: 50,
);

foreach ($campaigns as $campaign) {
    // les pages sont chargées au fil de l'itération
}
```

## Erreurs

Tout échec lève une `Noneo\Sdk\Lemlist\Exception\LemlistException` :

| Exception                     | Cas                                             |
|-------------------------------|-------------------------------------------------|
| `BadRequestException`         | 400                                             |
| `UnauthorizedException`       | 401 — clé d'API invalide                        |
| `ForbiddenException`          | 403 — droits ou forfait insuffisants            |
| `NotFoundException`           | 404                                             |
| `ConflictException`           | 409                                             |
| `ValidationException`         | 422                                             |
| `RateLimitException`          | 429, une fois les nouvelles tentatives épuisées |
| `ClientException`             | autre 4xx                                       |
| `ServerException`             | 5xx                                             |
| `RedirectException`           | 3xx — jamais suivi                              |
| `ConnectionException`         | aucune réponse : DNS, TLS, délai dépassé        |
| `UnexpectedResponseException` | succès HTTP, mais corps inexploitable           |

```php
use Noneo\Sdk\Lemlist\Exception\LemlistException;
use Noneo\Sdk\Lemlist\Exception\NotFoundException;

try {
    $lemlist->campaigns()->getCampaign('cam_inconnue');
} catch (NotFoundException) {
    // …
} catch (LemlistException $exception) {
    $exception->status();          // statut HTTP, 0 si aucune réponse
    $exception->getMessage();      // message de lemlist
    $exception->errorCode();       // code structuré, quand lemlist en fournit un
    $exception->responseBody();    // corps brut, tronqué à 2 000 octets
    $exception->responseHeaders(); // Retry-After, X-RateLimit-*…
}
```

Une exception ne retient jamais la requête : la clé d'API ne peut pas fuir
dans un log ou un événement Sentry par ce biais.

## Débit, nouvelles tentatives et délais

lemlist autorise **20 requêtes toutes les 2 secondes** par clé d'API. Le SDK :

- bride son propre débit, en patientant quand le quota est atteint ;
- rejoue un `429` après le délai `Retry-After` annoncé, quelle que soit la
  méthode ;
- rejoue un `5xx` avec un backoff exponentiel, **uniquement** pour `GET`,
  `PUT` et `DELETE` — rejouer un `POST` pourrait créer un doublon ;
- abandonne après 3 nouvelles tentatives (`maxRetries`, `0` pour désactiver) ;
- coupe une requête au bout de 60 s, 10 s pour la connexion.

```php
$lemlist = new Lemlist(
    $apiKey,
    maxRetries: 5,
    requestTimeout: 120.0,
    connectTimeout: 5.0,
);
```

Le compteur de débit vit par défaut en mémoire, donc **par process** — et sous
PHP-FPM, par requête HTTP. Dès que plusieurs process sollicitent lemlist en
parallèle (workers Messenger, commandes concurrentes), partagez-le par un
cache PSR-16 :

```yaml
# config/services.yaml
services:
    lemlist.rate_limit_cache:
        class: Symfony\Component\Cache\Psr16Cache
        arguments: ['@cache.app']

    Noneo\Sdk\Lemlist\Lemlist:
        arguments:
            $apiKey: '%env(LEMLIST_API_KEY)%'
            $rateLimitCache: '@lemlist.rate_limit_cache'
```

## Tester votre intégration

`MockLemlist` simule l'API sans réseau ni symbole Saloon. Il requiert PHPUnit
pour ses assertions.

```php
use Noneo\Sdk\Lemlist\Testing\MockLemlist;

$mock = MockLemlist::create([
    'GET /team' => MockLemlist::json(['_id' => 'tea_1', 'name' => 'Noneo']),
    'POST /campaigns/*/leads/' => MockLemlist::json(['_id' => 'lea_1']),
    'GET /campaigns/cam_inconnue' => MockLemlist::error(404, ['error' => 'Campaign not found']),
]);

$service = new MonService($mock->lemlist());
$service->inscrire('ada@example.com');

$mock->assertSent('POST', '/campaigns/cam_123/leads/');
$mock->assertNotSent('GET', '/team');

// Ce qui est réellement parti :
$request = $mock->requests()[0];
$request->query; // ['deduplicate' => 'true']
$request->body;  // ['email' => 'ada@example.com']
```

Les chemins s'écrivent comme dans la documentation lemlist, `*` servant de
joker. Sans clés, les réponses sont servies dans l'ordre. Une requête à
laquelle rien ne correspond lève `UnexpectedRequestException` ;
`assertNothingElseSent()` signale les appels qu'aucun `assertSent()` n'a
couverts. `MockLemlist::text()` simule un export CSV.

Les DTO se construisent aussi directement, pour vos propres doubles :
`new CampaignDto(name: 'Fixture')`.

## Suivre l'évolution de l'API

Requêtes (`src/Requests`), ressources (`src/Resource`) et DTO (`src/Dto`) sont
**générés** depuis `lemlist-api-v2.json` ; ne les modifiez pas à la main. Le
reste — transport, erreurs, façade, pagination — est écrit à la main.

```bash
php bin/fetch-openapi.php   # télécharge la spec publiée par lemlist
composer generate           # régénère le code
composer check              # tests + PHPStan + format
```

`generator/operations.json` associe chaque opération au nom de sa classe et de
sa méthode. Un nom attribué ne change plus, même si lemlist reformule le résumé
de l'endpoint ; pour renommer une méthode, modifiez ce fichier puis régénérez.
Deux opérations qui produiraient le même nom arrêtent la génération : il faut
alors les départager dans ce même fichier.

Les opérations marquées `deprecated` dans la spec ne sont pas générées.

## Développement

```bash
composer install
composer check   # test + stan + cs
```

- `composer test` — suite unitaire : ni réseau, ni clé d'API. Elle confronte
  notamment chaque opération de la spec au code généré (méthode, chemin,
  paramètres, corps, type de retour) et fait passer les exemples de réponse
  documentés par lemlist dans les DTO.
- `composer stan` — PHPStan niveau `max`.
- `composer cs` — PHP-CS-Fixer (`@Symfony`), en lecture seule.

## Dépendances

Le SDK repose sur [Saloon](https://docs.saloon.dev/) v4, mais en fait un
**détail d'implémentation** : aucune classe publique n'expose de type
`Saloon\*`, et un test par réflexion (`PublicApiSurfaceTest`) le vérifie. Une
montée de version de Saloon ne peut donc pas casser un projet consommateur.

Saloon requiert `guzzlehttp/guzzle`. Un projet Symfony aura donc Guzzle
installé en plus de `symfony/http-client` — les deux coexistent sans conflit.

## Licence

MIT
