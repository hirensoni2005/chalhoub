# Shopfinder module for Magento 2

## Installation

The extension must be installed via `composer`. To proceed, run these commands in your terminal:

```
composer require hsoni/module-shopfinder
php bin/magento module:enable Hsoni_Shopfinder
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## GraphQL
### Create Shop
Creates new Shop query format
```
mutation {
    createShop(
        input:{
            identifier  :"shop-identifier"
            shop_name  :"Shop Name" 
            country  :"US"
            image  :"image.jpg"
            longitude  :"2.232123"
            latitude  :"123232" 
        }
    ){
        shopfinder_id
        identifier 
        shop_name 
        country
        longitude
        latitude
    }
}
```

### Update Shop
Update Shop query format
```
mutation {
    updateShop(
        input:{
            shopfinder_id  :3,
            identifier  :"shop-identifier", 
            shop_name  :"New shop name", 
            country  :"UAE",
            longitude  :"122.232123",
            latitude  :"123.232",   
        }
    ){
        message
    }
}
```

### Delete Shop
Delete shop query format
```
mutation {
    deleteShop(
        shopfinder_id: 10
    ){
        message
    }
}
```

### Fetch All Shops
Get list of all shops
```
{
    shopfinderList(
        pageSize: 10
        pageNo: 1
    ){
        shoplist{
            shopfinder_id
            shop_name
            identifier
            country
            image
            longitude
            latitude
        }
    }
}
```

### Get Particular Shop
Get shop by shopfinder_id or identifier
```
{
    shopfinder(identifier:'shop-identifier') {
        shopfinder_id
        shop_name
        identifier
        country
        image
        longitude
        latitude
    }
}
```
