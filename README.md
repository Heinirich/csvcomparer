# Introduction

Just To Entice You, check [here](https://kopokopo.kashhela.com/task1) https://kopokopo.kashhela.com/task1  to see the project. 

Have a look at the screenshots folder. 
Have a look at the main code engine at Core/App/Http/Controllers/ImportController. All Codes as per instructions are listed. 

![alt text](https://raw.githubusercontent.com/Heinirich/csvcomparer/master/screenshots/screenshot1.png)

On my shared server, use transaction_data_1.csv, transaction_data_2.csv or transaction_data_3.csv if you selected
"I know my File Name" Option 

The code will help sort and display transaction.
With the code, one is able to know which transactions are in csv provided as assignment.
It should be noted, the code will read any csv of the same kind as they were attached for this task.


# Where to start
First you have to import the database.
Check database folder and you will get kopokopo.sql as the database.
Give the database any name of your choice and import

Next, Navigate to Core .env. Here, you will change the database credentials. 
Mine are as shown below


```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kopokopo
DB_USERNAME=root
DB_PASSWORD=Darkweb360@'
```

Change you DB Pass, Username and database name.

Next, Navigate to Core/ and run composer install

# Why database?
The data is saved temporarily from csv as saving huge chunks of data to session makes the project lag.

#How to run
Navigate to your serve, for example wamp server
Run localhost/project_folder_name/
If things are okay, The project will run. 


# where do I add CSV files?
Navigate to public/csv folder and add if you dont want to use import module.

# Potential error
1. Invalid DB credentials may make the project not to work. Add them accordingly to .env and it will work like a charm
2. The project is made with php 8. If run with alternative versions, you will be forced to degrade the projects version in composer.json.


For any inquiries Kindly Contact Me at smithheinrich254@gmail.com

Thank you


