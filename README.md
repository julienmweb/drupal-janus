# Janus

Do you have CSV files extracted from a database and you want to import these data into Drupal 7?
The tools available in Janus will be helpful for this task.

These tools allow you to parse your CSV files, apply changes to the retrieved data and finally create Nodes and Users using Text, Property, Email, Date, File, Integer, Link, Term Reference and Entity Reference fields.

*Lisez ceci en [Anglais](README.fr.md).*

## Getting Started

### Prerequisite

To execute the scripts you must have [Drush](http://www.drush.org/) installed.

You must have installed [Composer](https://getcomposer.org) because its autoloader will be used.

Some field types are not all available after the default installation of Drupal 7:

For Date fields, you need the [Date module](https://www.drupal.org/project/date).

For Email fields, you need the [Email module](https://www.drupal.org/project/email).

For Link fields, you need the [Link module](https://www.drupal.org/project/link) .

I created a [feature](Janus/janus_features) to import content types and fields example quickly.
This will allow you to test the scripts without having to manually create the content types and fields in Drupal Administration.
In order to import this feature you must have installed the [Features module](https://www.drupal.org/project/features).

### Installation

Janus must be placed in the directory of your Drupal installation.
Open a terminal and go to the [Janus directory](Janus).

```
composer install
```

You can then start using Janus.

## Janus in details

- The [Data directory](Janus/Data) contains sample files. It is in this directory that you will copy your files to import their data into Drupal 7.
- The [CSVParser class](Janus/CSVParser.php) will allow you to easily parse your CSV files.
- The [Editor class](Janus/Editor.php) will allow you to apply changes to the recovered CSV data.
- The [Generate directory](Janus/Generate)  contains the classes for generating Nodes and Users in Drupal.
- The [EntityAssociator class](Janus/EntityAssociator.php) will allow you to associate entities with each other via an Entity Reference field.
- The [Scripts directory](Janus/Scripts) contains sample import script files using the various Janus tools:
    - The [nodes.php file](Janus/Scripts/nodes.php) is an example of using Janus to parse CSV data and generate Nodes using fields of type Text, Property, Email, Date, File, Integer, Link and Term Reference.
    - The [users.php file](Janus/Scripts/users.php) is an example of using Janus to parse CSV data and generate users using Text and Property fields.
    - The [associateExample1.php file](Janus/Scripts/associateExample1.php) is an example of using Janus to parse CSV data, generate Nodes, and use the Entity Reference field to associate Nodes with each other.
    - The [associateExample2.php file](Janus/Scripts/associateExample2.php)  is an example of using Janus to parse CSV data and use the Entity Reference field to associate Users with Nodes.
- The file [runScripts](Janus/runScripts.php) will allow you to launch your import scripts via Drush.

## How to use Janus

### 1/ Importing your Data in Janus

Add your CSV files to the [Data directory](Janus/Data), your PDF files, DOC etc in the [Data/AttachedFiles directory](Janus/Data/AttachedFiles).

### 2/ Creating your import scripts

In the [Scripts directory](Janus/Scripts), you will develop your import scripts using the tools available in Janus.
Sample files are available to familiarize you with their use.

### 3/ Setting the execution script

You will modify the [runScripts file](Janus/runScripts.php) to use your CSV files and import scripts.

### 4/ Executing your import scripts

You will finally run the [runScripts file](Janus/runScripts.php) via Drush in the terminal to start importing your data in Drupal.

```
drush scr runScripts.php
```

## Examples

If you want to quickly how Janus works:
- Install Drupal 7 with all prerequisite modules.
- Install Janus.
- Import the [feature janus_features](Janus/janus_features) using the [Features module](https://www.drupal.org/project/features).
- Run the [runScripts file](Janus/runScripts.php) via Drush in the terminal.

## Author

* ** Julien Marciliac ** - [lewebdejulien.info](https://lewebdejulien.info)

## Licence

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details