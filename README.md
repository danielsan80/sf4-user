# Symfony User

## Introduzione

In questo repository proviamo a creare un nuovo progetto Symfony e a creare
la gestione degli utenti, prima seguendo le indicazioni della documentazione per poi cercare di
separare e rendere indipendenti i vari aspetti.

Successivamente aggiungeremo JWT per l'autenticazione e l'accesso ad un'ipotetica API.

Infine creeremo un nuovo tipo di utenza, il Client, che ha accesso alle API tramite API Key mentre
l'Utente potrà farlo solo tramite form di login.


## Getting started

Copiamo `.env.docker.dist` in `.env` e configuriamolo

```
cp .env.docker.dist .env
vim .env
```
Possiamo impostare per la variabile LOCALHOST un ip compreso tra `127.0.0.1` e `127.0.0.254`,
ad esempio `127.0.0.42`

Non è indispensabile ma non è una cattiva idea impostare questo ip nei propri host dando un nome all'host,
ad esempio `the-answer`:

```
sudo vim /etc/hosts
```

```
# /etc/hosts
...
127.0.0.42   the-answer
...
``` 


Fatto questo possiamo avviare i container con

```
./dc up -d --build
```

ed entrarci con

```
./dc enter
```

> ATTENZIONE: Lo script `dc` copia il contenuto della cartalla `.ssh` dell'utente corrente nel container `php`
in modo che da dentro al container ci si possa connettere via ssh con i server di stage e produzione
identificandosi con le proprie chiavi.
Questo potrebbe non essere gradito se non se ne comprendono le ragioni.

Ci troveremo dento il container nella cartella `/var/www/project/backend`.

Proviamo ad eseguire `sf`, un alias di `bin/console` definito in questo container
```
sf
```

Vedremo la consueta lista dei comandi disponibili.
Dal browser ed impostando l'indirizzo `http://127.0.0.42` oppure `http://the-answer` accederemo alla `Home`.


## Login - Logout

Proviamo ad accedere dal browser impostando l'indirizzo `http://127.0.0.42` oppure `http://the-answer`.

Dovremmo accedere in questo modo alla `Home`.

Possiamo spostarci su `A page` (`http://127.0.0.42/a_page`) cliccando sul link.

Da qui clicchiamo su `Login` (`http://127.0.0.42/login`). Qui potremo inserire `mario@example.com` e `password`
e cliccare su `Sign in`.

Ci ritroveremo loggati e reindirizzati su `A page`. Questo è accaduto perché abbiamo utilizzato `TargetPathTrait`
come da indicazioni della documentazione per memorizzare la pagina sulla quale eravamo prima di spostarci
sulla pagina di Login.

Se ora clicchiamo su `Login` verremo reindirizzati alla `Home` perché siamo già loggati.

Cliccando su `Logout` invece verremo sloggati e potremo ripetere l'operazione.


## Acme vs Symfony stuff

A mio avviso è piuttosto importante tenere separate le nostre cose da quelle di Symfony.
Il nostro codice non deve dipendere in nessun modo dal framework Symfony, magari da alcuni componenti firmati
Symfony si, ma non dal framework.

La directory `src` è la directory del sorgente dell'applicazione fatta con il framework Symfony e tutte le classi
presenti in `src` hanno come radice il namespace `App`.

Le nostre classi invece devono poter avere il nostro namespace (Acme, Study, ...).

Ne consegue che il nostro codice non può stare nella cartella `src` perché quella fa parte del tree di
un'applicazione Symfony ma noi siamo e vogliamo rimanere liberi.

Quindi creiamo una directory `lib` nella quale metteremo il nostro codice che sarà quindi una libreria
usata dall'applicazione Symfony. Quest'ultima dovrà rimanere scheletrica, sarà solo un modo di adattare
il nostro codice alle convenzioni di Symfony.

Creiamo quindi la directory `lib/Study/src` e configuriamo di conseguenza la sezione `autoload` del `composer.json`
```
    ...
    "autoload": {
        "psr-4": {
            "App\\": "src/",
            "Study\\": "lib/Study/src/"
        }
    },
    ...   
```

Quindi nel contesto `Study\User` creeremo l'entità `User` del nostro dominio e un'interfaccia per il suo repository.

Creeremo poi un'implementazione infrastrutturale per poter gestire le entità `User` con Doctrine.

Configuriamo il mapping della nuova entità in `config/doctrine/mapping` e configuriamo
opportunamente `config/packages/doctrine.yaml`.

Facciamo un `sf doctrine:schema:update --force` e ci ritroviamo una tabella `user` vuota nel db (http://127.0.0.42:81).

Creiamo delle fixture per caricare almeno un utente nel db in `src/UserFixtures` ed eseguiamo
`sf doctrine:fixtures:load`

Ora il nostro `User` di Dominio e la sua versione infrastrutturale `DoctrineUser` non dipendono in alcun modo dalla
security di Symfony, e così deve continuare ad essere.

Per usarli con la securty di Symfony quindi creiamo uno `UserProvider` e uno `User` in `src/User`. Questi saranno degli
adapter: il primo adatterà il nostro `UserRepository` allo `UserProvider` di Symfony mentre il secondo
adatterà il nostro `User` alla `UserInterface` di Symfony.

In questo modo `DomainUser` è indipendente, `DoctrineUser` dipende solo da `DomainUser` e `SecurityUser` dipende
solo da `DomainUser`, cioé ignora che stiamo utilizzando Doctrine per la persistenza: Doctrine e Security sono
due dettagli infratrutturali indipendenti.

Il resto si può trovare sulla documentazione di Symfony:
- come aggiornare il file `config/packages/security.yaml` e registrare uno UserProvider
  (Da [qui](https://symfony.com/doc/4.4/security.html#a-create-your-user-class) in poi)
- come creare una login form
  ([Qui](https://symfony.com/doc/4.4/security/form_login_setup.html))
- come usare le Doctrine Fixtures
  (In [questo](https://symfony.com/doc/4.4/security.html#c-encoding-passwords) paragrafo)
- come redirezionare all'ultima pagina visitata dopo il login
  ([Qui](https://symfony.com/doc/4.4/security/form_login_setup.html#redirecting-to-the-last-accessed-page-with-targetpathtrait))

Un'ultima cosa degna di nota al più è come sono stati organizzati i servizi,
rinominando `config/services.yaml` in `config/services_default.yaml` e creando un nuovo file `config/services.yaml` nel quale
si importa `config/services_default.yaml` e il contenuto della cartella `config/services`.





