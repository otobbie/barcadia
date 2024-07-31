## Getting Started
Follow theses steps to set up the environment and run the application.
1. Fork the backend repository [here](https://github.com/otobbie/barcadia).
2. Fork the frontend repository [here](https://github.com/otobbie/barcadia_front).
3. Clone the forked repository.
    ```bash
    git clone https://github.com/<YOUR-USERNAME>/barcadia
    cd barcadia
    ```
4. Clone the forked repository.
    ```bash
    git clone https://github.com/<YOUR-USERNAME>/barcadia_front
    cd barcadia_front
    ```
5. Run all migrations on the application
   ``` bash
    php artisan migrate
    ```

5. Start laravel application.
    ``` bash
    php artisan serve
    ```
6. Start the http and mysql xampp server or using the UI on Windows or Mac
    ```bash
    xampp http start
    xampp mysql start
    ```
    
7. Go to the frontend location on your domain/localhost on your browser
   ``` http://<YOUR-DOMAIN>/barcadia_front/ ```
