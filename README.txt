Berikut adalah cara pakai penggunaan API ini.

Saya menggunakan framework laravel, dan Postman dalam pengujian nya

pertama-tama import file sql dengan nama Database.sql (mysql)
kemudian sesuaikan paramete database di file .env

1. Authentication App
   - Create an endpoint with acceptable parameters NIK, Role, and generate password (6 char). After that show it in response.
     Metode GET : localhost:8000/api/task1_1?role=1&password=123456&nik=2022061000000001
     param : role, password, nik
    
   - Create an endpoint with parameters body NIK, Password, then return it in response with body ID, NIK, Role and JWT access token.
     Metode POST : localhost:8000/api/task1_2
     param : - jika menggunakan postman, di tab body isi Key dengan nik & password
             - value masing-masing key di isi sesuai dengan langkah pertama
             - jika berhasil akan keluar token, [Copy Token ini]
             

   - Create an endpoint that can display private claim data if the JWT is valid.
     Metode POST : localhost:8000/api/task1_3
     param : - masuk ke tab headers, kemudian isi key dengan Authorization, value nya di isi token tersebut ditamah dengan "Bearer "
               "Bearer {token}"       
             - jika berhasil akan keluar list semua data user yang didaftarkan,


untuk kurs api nya saya menggunakan https://apilayer.com/ [Free Version]

2. Fetch App
   - Create an endpoint fetching data from resources ( just valid token for get data ) resource ( https://60c18de74f7e880017dbfd51.mockapi.io/api/v1/jabar-digital-services/product )
add new field price IDR for output response, and convert field price from USD to IDR. You can use a tool currency converter like ( https://free.currencyconverterapi.com ). make sure when converting prices, you only hit the url once or rarely. Displays the appropriate return if the JWT Token is invalid 
   Metode GET : localhost:8000/api/task3
   Note : Sudah ditambahkan PriceIDR didalam JSON, yang nilai nya mengambil API  https://apilayer.com/ 
  
   - Create an endpoint aggregation from the resource by ( just valid token and role admin ) resource ( https://60c18de74f7e880017dbfd51.mockapi.io/api/v1/jabar-digital-services/product ) aggregation by ( department, product, price IDR) and order ascending by price Displays the appropriate return if the JWT Token is invalid
   Metode GET : localhost:8000/api/task4
   Note : JSON sudah dikelompokan berdasarkan departement
   
   - Create an endpoint that can display a private claim data if the JWT is valid.
   Metode GET : localhost:8000/api/task3
   Note : -   
