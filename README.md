# MVP - Cart Service

## Set up

### Pre requisites
In order to proceed with the instalation, you need to have these packages installed.

- git
- php8.5
- Composer
- Install symfony cli.

### Install

``` bash
git clone https://github.com/RodrigoBattagliero/cart-mvp-assestment.git

cd cart-mvp-assestment/

composer install

php bin/console doctrine:migrations:migrate -y

symfony serve
```

## Usage

### Save data
This endpoint stores data config for products, offers and delivery rules. 

**Endpoint**

```POST api/save-data```

**Request body**
```json
{
  "products": [
    { "name": "Red Widget",   "code": "R01", "price": 32.95 },
    { "name": "Green Widget", "code": "G01", "price": 24.95 },
    { "name": "Blue Widget",  "code": "B01", "price": 7.95 }
  ],
  "delivery_rules": [
        {"rule": "between", "params": [0,49.99], "value": 4.95},
        {"rule": "between", "params": [50,89.99], "value": 2.95},
        {"rule": "more_or_equal", "params": [90], "value": 0.0}
    ],
  "offers": [
        {
            "type": "discount_by_amount",
            "product_trigger": "R01",
            "amount": 2,
            "pay": 1.5
        },
        {
            "type": "discount_by_amount",
            "product_trigger": "G01",
            "amount": 3,
            "pay": 2
        }
    ]
}
```

**Response code**

```201```

### Add item to cart
Increase the amount of items for the product.

**Endpoint**

```PUT api/add-item``` 

**Request body**
```json
{
  "code": "01"
}
```

**Response code**

```201```

### Get data
Returns data store in api/save-data.

**Endpoint**

```GET api/get-data```

**Response**
```json
{
	"product": [
		{
			"id": 25,
			"name": "Red Widget",
			"code": "R01",
			"price": 32.95
		},
		{
			"id": 26,
			"name": "Green Widget",
			"code": "G01",
			"price": 24.95
		},
		{
			"id": 27,
			"name": "Blue Widget",
			"code": "B01",
			"price": 7.95
		}
	],
	"service": [
		{
			"id": 17,
			"type": "discount_by_amount",
			"product": {
				"id": 25,
				"name": "Red Widget",
				"code": "R01",
				"price": 32.95
			},
			"amount": 2,
			"pay": 1.5
		},
		{
			"id": 18,
			"type": "discount_by_amount",
			"product": {
				"id": 26,
				"name": "Green Widget",
				"code": "G01",
				"price": 24.95
			},
			"amount": 3,
			"pay": 2
		}
	],
	"delivery_rules": [
		{
			"id": 25,
			"rule": "between",
			"params": [
				0,
				49.99
			],
			"value": 4.95
		},
		{
			"id": 26,
			"rule": "between",
			"params": [
				50,
				89.99
			],
			"value": 2.95
		},
		{
			"id": 27,
			"rule": "more_or_equal",
			"params": [
				90
			],
			"value": 0
		}
	],
	"cart_items": [
		{
			"id": 7,
			"product": {
				"id": 25,
				"name": "Red Widget",
				"code": "R01",
				"price": 32.95
			},
			"amount": 2
		},
		{
			"id": 8,
			"product": {
				"id": 27,
				"name": "Blue Widget",
				"code": "B01",
				"price": 7.95
			},
			"amount": 1
		}
	]
}
```

### Delete data
Delete data store with api/save-data

**Endpoint**

```DELETE api/delete-data```

**Response**

```code 200```

### Get total
Return the total cost of the cart. This includes offers and delivery rules discount.

**Endpoint**

```GET api/get-total```

**Response**
```json
{
	"total": 0
}
```