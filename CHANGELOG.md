# Changelog

Toutes les évolutions notables de ce paquet sont consignées ici.

Le format suit [Keep a Changelog](https://keepachangelog.com/fr/1.1.0/) et le
versionnement suit [Semantic Versioning](https://semver.org/lang/fr/).

## [Non publié]

### Ajouté

- Façade `Lemlist` et 33 ressources couvrant les 246 opérations non dépréciées
  de la spec OpenAPI lemlist, générées depuis `lemlist-api-v2.json`.
- DTO tolérants pour les réponses décrites par un schéma nommé ; tableau décodé
  pour les réponses décrites de façon anonyme.
- Hiérarchie `LemlistException`, sans référence à la requête signée.
- Respect du quota de 20 requêtes par 2 secondes, rejeu des `429` et des `5xx`
  idempotents, délais d'expiration.
- `Paginator` pour parcourir les collections paginées.
- `Testing\MockLemlist`, double de test sans réseau.
- Générateur (`composer generate`) et récupération de la spec
  (`bin/fetch-openapi.php`).
