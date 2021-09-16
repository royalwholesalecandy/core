A custom module for [royalwholesalecandy.com](https://royalwholesalecandy.com) (Magento 2). 

## How to install
```
sudo service crond stop
bin/magento maintenance:enable
composer clear-cache
composer require royalwholesalecandy/core:*
rm -rf var/di var/generation generated/*
bin/magento setup:upgrade
bin/magento cache:enable
bin/magento setup:di:compile
redis-cli FLUSHALL
bin/magento cache:clean
rm -rf pub/static/*
bin/magento setup:static-content:deploy \
	--area adminhtml \
	--theme Magento/backend \
	-f en_US
bin/magento setup:static-content:deploy \
	--area frontend \
	--theme Megnor/mag-child \
	--theme Mgs/organie en_US \
	--theme bs_eren/bs_eren3 \
	-f en_US
bin/magento cache:clean
redis-cli FLUSHALL
bin/magento maintenance:disable
sudo service crond start
rm -rf var/log/*
```

## How to upgrade
```
sudo service crond stop
bin/magento maintenance:enable
composer remove royalwholesalecandy/core
composer clear-cache
composer require royalwholesalecandy/core:*
rm -rf var/di var/generation generated/*
bin/magento setup:upgrade
bin/magento cache:enable
bin/magento setup:di:compile
bin/magento cache:clean
redis-cli FLUSHALL
rm -rf pub/static/*
bin/magento setup:static-content:deploy \
	--area adminhtml \
	--theme Magento/backend \
	-f en_US
bin/magento setup:static-content:deploy \
	--area frontend \
	--theme Megnor/mag-child \
	--theme Mgs/organie en_US \
	--theme bs_eren/bs_eren3 \
	-f en_US
bin/magento cache:clean
redis-cli FLUSHALL	
bin/magento maintenance:disable
sudo service crond start
rm -rf var/log/*
```