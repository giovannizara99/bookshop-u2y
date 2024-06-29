Popolare database

```
php artisan db:seed
```

Aggiungere header a chiamate API (usare API_KEY in file .env)

```
"Api-Access-Key": "chiave API"
```

Per visualizzare correttamente gli errori di validazione, suggerisco di aggiungere l'header nel client con cui si
fanno le chiamate API (es. Postman):

```
"Accept": "application/json"
```
