# cart-api - Shopify
cart-api is a sample online marketplace api created for Shopify by Jehan Wadia.

## Contents

 - User API
 - Product API
 - Cart API

## User API
#### Create API Key:
This endpoint is used to generate a unique API key that lets you access the cart API.

| Type| Endpoint |
|--|--|
| GET | http://jehanwadia.ca/shopify_api/users/create.php |

This endpoint only takes one argument, the type of the output you with to receive from the API call.
|Argument| Possible Values |
|--|--|
| output | json |
Sample API Call:

    http://jehanwadia.ca/shopify_api/users/create.php?output=json
Sample Response:

    {"apikey":"redacted"}

#### Revoke API Key:
This endpoint is used to revoke an existing API key.
| Type| Endpoint |
|--|--|
| GET | http://jehanwadia.ca/shopify_api/users/revoke.php |
This endpoint takes two arguments, the type of the output you with to receive from the API call and the API key that needs to be revoked.
|Argument| Possible Values |
|--|--|
| output | json |
| apikey| [api_key]|
Sample API Call:

    http://jehanwadia.ca/shopify_api/users/revoke.php?output=json&apikey=redacted
Sample Response:

    {"status":"revoked"}
## Product API
#### Get Product Info (single product):
This endpoint is used to get product information.
| Type| Endpoint |
|--|--|
| GET | http://jehanwadia.ca/shopify_api/product/getProduct.php |
This endpoint takes three arguments, the type of the output you with to receive from the API call, your API key, and a product title.
|Argument| Possible Values |
|--|--|
| output | json |
| apikey| [api_key]|
| title| [product_title]|
Sample API Call:

    http://jehanwadia.ca/shopify_api/product/getProduct.php?output=json&apikey=redacted&title=product_title
Sample Response:

    [{"title":"product_title","price":"14.99","inventory_count":"9"}]

#### Get Product Info (all products):
This endpoint is used to get product information.
| Type| Endpoint |
|--|--|
| GET | http://jehanwadia.ca/shopify_api/product/getProduct.php |
This endpoint takes four arguments, the type of the output you with to receive from the API call, your API key, a product title, and whether the product must be in stock.
|Argument| Possible Values |
|--|--|
| output | json |
| apikey| [api_key]|
| title| all|
| instock| true/false|
Sample API Call:

    http://jehanwadia.ca/shopify_api/product/getProduct.php?output=json&apikey=redacted&title=all&instock=true
Sample Response:

    [{"title":"product_1","price":"14.99","inventory_count":"9"}]
Sample API Call:

    http://jehanwadia.ca/shopify_api/product/getProduct.php?output=json&apikey=redacted&title=all&instock=false
Sample Response:

    [{"title":"product_1","price":"14.99","inventory_count":"9"},{"title":"product_2","price":"4.85","inventory_count":"0"}]
## Cart API
#### Create Cart:
This endpoint is used to generate a unique Cart ID that lets you access a specific cart.
| Type| Endpoint |
|--|--|
| GET | http://jehanwadia.ca/shopify_api/cart/create.php |
This endpoint takes two arguments, the type of the output you with to receive from the API call and your API key.
|Argument| Possible Values |
|--|--|
| output | json |
| apikey| [api_key]|
Sample API Call:

    http://jehanwadia.ca/shopify_api/cart/create.php?output=json&apikey=redacted
Sample Response:

    {"cartid":"redacted"}

#### Add Product:
This endpoint is used to add a product to your cart.
| Type| Endpoint |
|--|--|
| GET | http://jehanwadia.ca/shopify_api/cart/addProduct.php |
This endpoint takes four arguments, the type of the output you with to receive from the API call, your API key, the cart id, and product title.
|Argument| Possible Values |
|--|--|
| output | json |
| apikey| [api_key]|
| cartid |[cart_id] (cart must be incomplete)|
| producttitle|[product_title]|
Sample API Call:

    http://jehanwadia.ca/shopify_api/cart/addProduct.php?output=json&apikey=redacted&cartid=redacted&producttitle=product_1
Sample Response:

    {"products":["product_1"],"totalprice":"14.99","status":"incomplete"}

Sample API Call:

    http://jehanwadia.ca/shopify_api/cart/addProduct.php?output=json&apikey=redacted&cartid=redacted&producttitle=product_2
Sample Response:

    {"products":["product_1","product_2"],"totalprice":"19.84","status":"incomplete"}
#### Complete Cart:
This endpoint is used to complete the purchase of a cart.
| Type| Endpoint |
|--|--|
| GET | http://jehanwadia.ca/shopify_api/cart/complete.php |
This endpoint takes three arguments, the type of the output you with to receive from the API call, your API key, and the cart id.
|Argument| Possible Values |
|--|--|
| output | json |
| apikey| [api_key]|
| cartid |[cart_id]|
Sample API Call:

    http://jehanwadia.ca/shopify_api/cart/complete.php?output=json&apikey=redacted&cartid=redacted
Sample Response:

    {"products":["product_1","product_2"],"totalprice":"19.84","status":"complete"}

#### Display Cart:
This endpoint is used to display the contents of a cart.
| Type| Endpoint |
|--|--|
| GET | http://jehanwadia.ca/shopify_api/cart/display.php |
This endpoint takes three arguments, the type of the output you with to receive from the API call, your API key, and the cart id.
|Argument| Possible Values |
|--|--|
| output | json |
| apikey| [api_key]|
| cartid |[cart_id]|
Sample API Call:

    http://jehanwadia.ca/shopify_api/cart/display.php?output=json&apikey=redacted&cartid=redacted
Sample Response:

    {"products":["product_1","product_1"],"totalprice":"19.84","status":"complete"}
