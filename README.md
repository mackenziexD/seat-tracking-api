# seat-tracking-api

api route extension for [SeAT](https://github.com/eveseat/seat) and that creates 2 api's for tracking oprhans (characters in a corporation but not registed on SeAT) and afk (characters that not logged in for ATLEAST 3 months)

## Installation

You can install the package via composer:
```bash
SeAT 4: composer require helious/seat-tracking-api:^4.*
SeAT 5: composer require helious/seat-tracking-api:^5.*
```

Docker
```bash
SeAT 4: SEAT_PLUGINS=helious/seat-tracking-api:^4.*
SeAT 5: SEAT_PLUGINS=helious/seat-tracking-api:^5.*
```

## Example
`/api/v2/tracking/orphans` returns JSON
```json
[
    {
        "name": "EXAMPLE 1",
        "ship": "Retriever",
        "location": "X-9ZZR - Mustang Ranch"
    },
    {
        "name": "EXAMPLE 2",
        "ship": "Retriever",
        "location": "X-9ZZR - Mustang Ranch"
    },
    {
        "name": "EXAMPLE 3",
        "ship": "Retriever",
        "location": "X-9ZZR - Mustang Ranch"
    },
    ...
]
```

`/api/v2/tracking/afk` returns JSON
```json
[
    {
        "name": "EXAMPLE 1",
        "last_login": "2021-09-26 04:41:13",
        "ship": "Retriever",
        "location": "R1O-GN - Z E N S T A R",
        "afk_time": "5 months 3 days 2 hours 9 minutes"
    },
    {
        "name": "EXAMPLE 2",
        "last_login": "2021-09-26 04:41:13",
        "ship": "Retriever",
        "location": "R1O-GN - Z E N S T A R",
        "afk_time": "5 months 3 days 2 hours 9 minutes"
    },
    {
        "name": "EXAMPLE 3",
        "last_login": "2021-09-26 04:41:13",
        "ship": "Retriever",
        "location": "R1O-GN - Z E N S T A R",
        "afk_time": "5 months 3 days 2 hours 9 minutes"
    },
    ...
]
```


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
