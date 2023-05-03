# laravel-vue-blog-app


  

## Laravel + Vue JS Blog Uygulaması

  
Uygulama kapsamında istenilenler;

-   Kullanıcıların kaydolabileceği ve giriş yapabileceği bir sistem  
    
-   Kullanıcıların blog yazıları oluşturabileceği bir sayfa  
    
-   Blog yazılarının listelendiği ve okunabildiği bir sayfa  
    
-   Blog yazılarına yorum yapılabilen bir sayfa  
    
-   Verilerin PHP tarafında bir veritabanından alınması veya güncellenmesi gerekiyor.  
    
-   Vuejs projesi SPA olmalıdır.  

**Bonus**
-   Sayfalama yapıldı.
    
-   Kullanıcılara göre blog listeleme yapıldı.

**Kurulum**
Her ne kadar proje direk docker ile kapsüllenmek istenilse de laravel ile mysql bağlantısı sağlanamamıştır. Bundan dolayı docker ile mysql ve phpmyadmin kurulumu yapılacaktır. Server ve Client kısmı gerekli paketlerin yüklenmesi ile kullanıcının localinde çalışacaktır. 

  Öncelikle bilgisayarınızda [php 8.1,](https://windows.php.net/download#php-8.1) [composer](https://getcomposer.org/) ve [nodejs](https://nodejs.org/en) kurulu olmalıdır.
  
  Daha sonra 

    git clone git@github.com:AR-Life/laravel-vue-blog-app.git
    
    
  

`cd laravel-vue-blog-app` 

`php artisan migrate`

    
    php artisan serve

 


  
`cd resources/js/client`


  
`npm install`


  
`npm start`


[http://localhost:5173](http://localhost:5173) url üzerinden proje yayında olacaktır.
