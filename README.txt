Ecco come "replicare" questo esempio
------------------------------------

1) Installare Composer (https://getcomposer.org/)

2) Creare una directory per il proprio progetto ed entrare nella directory.

3) Creare il file composer.json con una configurazione simile a quella di questo 
esempio. E' possibile anche usare il comando "composer init" per creare in 
automatico gran parte del file, avendo cura di specificare come requirement 
il package "nategood/httpful". 

4) Lanciare il comando "composer install". Questo scaricherà e installerà tutte 
le dipendenze (Doctrine in primis) nella directory vendor/. In seguito si potrà 
usare il comando "composer update" per aggiornarle.

5) Provare ad accedere al servizio come esemplificato in public/index.php 
(attenzione a specificare correttamente la url del server)
