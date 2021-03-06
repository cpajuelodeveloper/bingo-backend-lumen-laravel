# play bingo with nodejs

```bash
requires PHP 8.0
```

```git
git clone https://github.com/cpajuelodeveloper/bingo-backend-lumen-laravel.git
```

## set enviroment

```bash
mv env.example .env
```

## install dependencies

```bash
composer install
```

## run tests

```bash
./vendor/bin/phpunit
```

## start local server

```bash
php -S localhost:3000 -t public
```

Go to the browser and open  **localhost:3000** and complete with the following urls.


> ### [GET]
> ## take card [/bingo/cards/take]
+ Response 200 (application/json)
    ```JSON
    {
        "cardNumber": 1,
        "card": [
            [
                11,
                15,
                4,
                2,
                1
            ],
            [
                18,
                20,
                23,
                25,
                30
            ],
            [
                35,
                44,
                "FREE",
                38,
                43
            ],
            [
                56,
                60,
                49,
                48,
                52
            ],
            [
                68,
                64,
                73,
                74,
                75
            ]
        ]
    }
    ````


> ### [GET]
> ## call number[/bingo/call]
+ Response 200 (application/json) 
    ```JSON
    {
        "call": 20,
        "calls": [
            44,
            28,
            31,
            14,
            73,
            70,
            54,
            20
        ]
    }
    ```

> ### [GET]
> ## check winner by card [/bingo/cards/check/1]
+ Response 200 (application/json) 
    ```JSON

    {
        "cardNumber": 1,
        "winner": true,
        "options": [[14,5,9,3,11],[17,16,24,19,26],[37,31,"FREE",39,36],[49,53,57,48,58],[68,71,61,66,69]]
    }

    //error response
    { "error": "card not set"}

    ```

> ### [GET]
> ## check all winners [/bingo/cards/check-all]
+ Response 200 (application/json) 
    ```JSON
    [{
        "cardNumber": 1,
        "winner": true,
        "options": [[14,5,9,3,11],[17,16,24,19,26],[37,31,"FREE",39,36],[49,53,57,48,58],[68,71,61,66,69]]
    },
    {
        "cardNumber": 2,
        "winner": true,
        "options": [[14,5,9,3,11],[17,16,24,19,26],[37,31,"FREE",39,36],[49,53,57,48,58],[68,71,61,66,69]]
    }]

    //errors response
    { "error": "cards not set"}
    ```

> ### [GET]
> ## reset game [/bingo/reset]
+ Response 200 (application/json) 
    ```JSON
    {
        "success": true,
        "message": "game reset"
    }

    //errors response
    {
        "success": false,
        "message": "game already reset"
    }
    ```