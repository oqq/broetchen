# Broetchen Api


## Ping
/api/ping

#### Response
```json
{
  "ack": "1509189347.978144"
}
```


## Login
POST /api/login
#### Request
```json
{
  "email_address": "eb@oqq.be",
  "password": "123"
}
```

#### Response
```json
{
  "success": true
}
```


## User Data
GET /api/user
#### Response
```json
{
  "user_id": "6bc5fb81-c5e5-422f-b8cd-9cd200b3b86a"
}
```


## Orders
GET /api/orders
> Get orders from current logged in user

#### Response
```json
{
    "_total_items": 1,
    "_links": {
        "self": {
            "href": "http://0.0.0.0:8083/api/orders"
        }
    },
    "_embedded": {
        "order": [
            {
                "order_id": "e9c944d2-70ee-43c8-bd53-14fe8999aa2f",
                "user_id": "186dfa1b-a26d-4f93-ab93-abeede774ca0",
                "service_id": "de951f72-bd2a-4388-a781-2ba72e7d4cec",
                "products": [
                    {
                        "product_id": "de951f72-bd2a-4388-a781-2ba72e7d4cec",
                        "name": "name"
                    }
                ],
                "_links": {
                    "self": {
                        "href": "http://0.0.0.0:8083/api/order/e9c944d2-70ee-43c8-bd53-14fe8999aa2f"
                    }
                }
            }
        ]
    }
}
```

GET /api/order/e9c944d2-70ee-43c8-bd53-14fe8999aa2f

#### Response
```json
{
    "order_id": "e9c944d2-70ee-43c8-bd53-14fe8999aa2f",
    "user_id": "186dfa1b-a26d-4f93-ab93-abeede774ca0",
    "service_id": "de951f72-bd2a-4388-a781-2ba72e7d4cec",
    "products": [
        {
            "product_id": "de951f72-bd2a-4388-a781-2ba72e7d4cec",
            "name": "name"
        }
    ],
    "_links": {
        "self": {
            "href": "http://0.0.0.0:8083/api/order/e9c944d2-70ee-43c8-bd53-14fe8999aa2f"
        }
    }
}
```
