# AsiaYo
### API
[API文件連結](https://app.swaggerhub.com/apis/boscannon/exchange/1.0.0#/exchange/post_api_exchange)

### Testing
#### 匯率
```bash
php artisan test
```
### Installing
```bash
cd asiayo

composer install

cp .env .env.example

php artisan key:generate
# 測試資料
php artisan migrate --seed


```
