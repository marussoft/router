# Router

![](https://travis-ci.org/marussoft/router.svg?branch=master)
![](https://scrutinizer-ci.com/g/marussoft/router/badges/quality-score.png?b=master)
![](https://scrutinizer-ci.com/g/marussoft/router/badges/code-intelligence.svg?b=master)

## Роутер позволяет прописывать маршруты для приложений вида:

`Route::get('/categories/edit/{$id}')->where(['id' => 'integer'])->handler('Catalog')->action('CategoryEdit')->name('category.edit')->match();`

## А так же генерировать ссылки с помощью имен маршрутов:

`Url::get('category.edit', ['id' => 1]);`
