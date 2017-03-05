This was made for a Symfony school project.

Members
--------------
* [Margaux Tellier][14] - *Designe*
* [Lucie Zévaco][15] - *Designe*
* [Pierrick Inesta][16] - *Content Manager*
* [Anne Maurice-Péroumal][17] - *Developer*
* [Raphael Ait El Alim][18]- *Developer*
* [Jasmine Ferhaoui][19] - *Developer*

How to install
--------------

```
git clone https://github.com/jadefrh/T2_E19_Symfony.git
cd T2_E19_Symfony-master

php bin/symfony-requirements
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --dump-sql
php bin/console doctrine:schema:update --force
``` 
###Bundles used
--------------

*FOSRestBundle* - API Rest
*FOSUserBunble* - User gestion

[14]: https://github.com/margauxtell
[15]: https://github.com/luciezevaco
[16]: https://github.com/inespie
[17]: https://github.com/annemp
[18]: https://github.com/raphaelaitelalim
[19]: https://github.com/jadefrh