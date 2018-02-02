# Janus

Vous avez des extractions au format CSV d'une base de donnée et vous souhaitez importer ces données dans Drupal 7?
Les outils disponibles dans Janus vous seront utiles.

Ces outils permettent de parser vos fichiers CSV, d'appliquer des modifications sur les données récupérées et enfin de créer des Nodes et des Users en utilisant des champs de type Text, Property, Email, Date, File, Integer, Link, Term Reference et Entity Reference.

*Read this in [English](README.md).*

## Getting Started

### Prérequis

Pour exécuter les scripts il faut avoir installé [Drush](http://www.drush.org/).

Vous devez avoir installé [Composer](https://getcomposer.org) car son Autoloader sera utilisé.

Certains types de champ ne sont pas tous disponible après l'installation par défaut de Drupal 7:

Pour les champs de type Date il faut le module [Date](https://www.drupal.org/project/date).

Pour les champs de type Email il faut le module [Email](https://www.drupal.org/project/email).

Pour les champs de type Link il faut le module [Link](https://www.drupal.org/project/link).

J'ai créer une [feature](Janus/janus_features) afin d'importer les types de contenus et champs d'examples rapidement.
Cela vous permettra de tester le fonctionnement des scripts sans devoir créer manuellement les types de contenu et les champs dans l'administration Drupal.  
Pour pouvoir importer cette feature vous devez avoir installé le module [Features](https://www.drupal.org/project/features).

### Installation

Janus doit être placé dans le repertoire de votre installation Drupal.
Ouvrez un terminal et allez dans le repertoire [Janus](Janus).

```
composer install
```

Vous pouvez alors démarrer l'utilisation de Janus.

## Janus en détails

- Le repertoire [Data](Janus/Data) contient des fichiers d'exemples. C'est dans ce repertoire que vous copierez vos fichiers pour pouvoir importer leurs données dans Drupal 7.
- La classe [CSVParser](Janus/CSVParser.php) vous permettra de parser facilement vos fichiers CSV.
- La classe [Editor](Janus/Editor.php) vous permettra d'appliquer des modifications sur les données CSV récupérées.
- Le repertoire [Generate](Janus/Generate) contient les classes permettant de générer les Nodes et les Users dans Drupal.
- La classe [EntityAssociator](Janus/EntityAssociator.php) vous permettra d'associer des entités entre elles via un champ de type Entity Reference.
- Le repertoire [Scripts](Janus/Scripts) contient des fichiers d'exemple de scripts d'imports utilisant les différents outils de Janus:
    - Le fichier [nodes.php](Janus/Scripts/nodes.php) est un exemple d'utilisation de Janus pour parser des données CSV et générer des Nodes en utilisant des champs de type Text, Property, Email, Date, File, Integer, Link et Term Reference. 
    - Le fichier [users.php](Janus/Scripts/users.php) est un exemple d'utilisation de Janus pour parser des données CSV et générer des users en utilisant des champs de type Text et Property.
    - Le fichier [associateExample1.php](Janus/Scripts/associateExample1.php) est un exemple d'utilisation de Janus pour parser des données CSV, générer des Nodes et utiliser le champ de type Entity Reference pour associer des Nodes entre elles.
    - Le fichier [associateExample2.php](Janus/Scripts/associateExample2.php) est un exemple d'utilisation de Janus pour parser des données CSV et utiliser le champ de type Entity Reference pour associer des Users avec des Nodes.
- Le fichier [runScripts](Janus/runScripts.php) vous permettra de lancer vos scripts d'importation via Drush.

## Utilisation

### 1/ Importer vos données dans Janus

Ajouter vos fichiers CSV dans le repertoire [Data](Janus/Data), vos fichiers PDF, DOC etc dans le repertoire [Data/AttachedFiles](Janus/Data/AttachedFiles).

### 2/ Créer vos scripts d'import

Dans le repertoire [Scripts](Janus/Scripts), vous developperez vos scripts d'imports en utilisant les outils disponibles dans Janus.
Des fichiers d'exemples sont disponibles afin de vous familiariser avec leur utilisation.

### 3/ Paramétrer le script d'execution de vos scripts d'importation

Vous modifierez le fichier [runScripts](Janus/runScripts.php) pour pouvoir utiliser vos fichiers CSV et vos scripts d'import.

### 4/ Exécuter vos scripts d'import

Vous exécuterez enfin le fichier [runScripts](Janus/runScripts.php) via Drush dans le terminal pour lancer l'importation de vos données dans Drupal.

```
drush scr runScripts.php
```

## Exemples

Si vous souhaitez voir rapidement comment fonctionne Janus:
- Installer Drupal 7 avec tous les modules prérequis.
- Installer Janus.
- Importer la [feature janus_features](Janus/janus_features) en utilisant le module [Features](https://www.drupal.org/project/features).
- Exécuter le fichier [runScripts](Janus/runScripts.php) via Drush dans le terminal.

## Auteur

* **Julien Marciliac** - [lewebdejulien.info](https://lewebdejulien.info)

## Licence

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details