# RESTful API for providing PIN codes

## URL
Live at `https://api.vzikmund.cz/` as test environment.

## Authentication
Request verification is based on HTTP header parameter `Api-Key`. 
The value of parameter is introduced to a retailer during implementation process.

You can find test retailers with assigned Api-Keys at the end of this readme. 

Additionally, the request HTTP header must declare `Content-Type` and `Accept` parameters:
```
curl https://api.vzikmund.cz/serial-number/1111/2222 \
-H 'Content-Type: application/json' \
-H 'Accept: application/json' \
-H 'API-Key: secret_api_key'
```


## AVAILABLE METHODS


### New order
`POST /order`

Creates new order. Returns `Receipt` object with HTTP code `200` if 
order was successfully created. 

If order could not be created, it returns `Error` object with a
corresponding HTTP code and description.

All parameters of the new order are mandatory:

| Name        |  Data type  | 
|:------------|:-----------:|
| retailer_id |     int     |
| product_id  |     int     | 
| order_id    |   string    | 

```json
{
    "retailer_id": 6631,
    "product_id": 37930,
    "order_id": "test_1"
}
```


### Query for one order by retailer order ID
`GET /order-id/{retailer_id}/{order_id}`

Order id is clients identifier which was used to create a new order. The method returns
`Receipt` object if order was found by the retailer order ID.

### Query for one order by its serial number
`GET /serial-number/{retailer_id}/{serial_number}`

Serial number is included in every response. It is automatically generated integer number by our system. The method returns
`Receipt` object if order was found by its serial number.

## Return Objects

### Receipt
| Name               |     Data type      | Description              |
|--------------------|:------------------:|--------------------------|
| retailer_id        |        int         | -                        |
| product_id         |        int         | -                        |
| order_id           |       string       | -                        |
| product_name       |       string       | -                        |
| pin                |       string       | -                        |
| serial_number      |        int         | -                        |
| cost               |        int         | Hundredths of a currency |
| currency_code      |        int         | ISO 4217                 |
| recommended_price  | `RecommendedPrice` | -                        |
| redeem_information |       string       | -                        |
| created_at         |     timestamp      | RFC 3339                 |

```json
{
    "retailer_id": 6631,
    "product_id": 37930,
    "order_id": "test_8",
    "product_name": "Steam Wallet Gift Card 10 EUR",
    "pin": "A483-YQKZ-UWKU",
    "serial_number": 833036038,
    "cost": 950,
    "currency_code": 978,
    "recommended_price": [
        {
            "end_price": 1000,
            "currency_code": 978
        }
    ],
    "redeem_information": "If you already have a Steam client, you can activate the product by going to the <b>Library</b> tab in that client and clicking on the <b>+</b> icon at the bottom.\n\nOtherwise, head to www.steampowered.com/wallet. Enter the unique code for your wallet, shown below, and follow the instructions. Funds will be added to your account and you will be redirected to the game page where you will complete your purchase. Have fun!\n\nIf you need help, visit www.steampowered.com/wallet/support\n\nThe sale is made in the name and on behalf of Valve Corporation.",
    "created_at": "2022-04-13T22:35:47+02:00"
}
```

### RecommendedPrice

Holds information about recommended retail price to an end customer.

| Name          | Data type | Description              |
|---------------|:---------:|--------------------------|
| end_price     |    int    | Hundredths of a currency |
| currency_code |    int    | ISO 4217                 |

### Error

| Error code | HTTP code | Description            |
|------------|:---------:|------------------------|
| 0          |    500    | Internal error         |
| 1          |    404    | Resource not found     |
| 2          |    400    | Incorrect request data |
| 3          |    401    | Invalid `Api-Key`      |
| 4          |    403    | Not allowed to order   |

```json
{
    "error": "Association between retailer and product not found",
    "error_code": 1
}
```

## Database data in the test environment
### Products
|  ID   | Name                                | 
|:-----:|-------------------------------------|
| 26420 | Netflix Gift Card 50 EUR            | 
| 37930 | Steam Wallet Gift Card 10 EUR       |
| 59161 | Steam Wallet Gift Card 25 EUR       |
| 68508 | Netflix Gift Card 15 EUR            | 
| 77265 | Playstaion Wallet Gift Card 100 EUR |
| 81320 | Playstaion Wallet Gift Card 10 EUR  |

### Retailers

|  ID  | Name              | Api-Key                   |
|:----:|-------------------|---------------------------|
| 5875 | Gas Station       | api_key_gas_station       |
| 6631 | Supermarket       | api_key_supermarket       |
| 7458 | Convenience Store | api_key_convenience_store |

## Products and retailer association
| ID product | ID retailer | Can be ordered? |
|:----------:|:-----------:|:---------------:|
|   26420    |    7458     |       yes       |
|   37930    |    6631     |       yes       |
|   59161    |    6631     |       yes       |
|   68508    |    6631     |       no        | 
|   68508    |    7458     |       no        |
|   77265    |    5875     |       yes       |
|   81320    |    5875     |       yes       |