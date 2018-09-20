# Symfony 4 XML Extractor and Order currency change 

You should implement a simple command line utility, which will load orders and exchange rates
from the following XML files (see next page).
You should:
1. Convert the currency of order (id = 1) into EUR
2. Convert the currency of order (id = 2) into GBP

***
Unfortunately I totally forgot about that last sentence :/ :

"You should output the results in an appropriately structured XML file."
***
>In order to charge customers in their local currencies
As a customer
I need to see prices converted to my chosen currency


## Technical details / Requirements:
 Current project is built using :
- Symfony 4.1 framework
- Docker 

## Installation:
	
Clone the project 

    - git clone https://github.com/TDEBRITO/testCalculator.git
    
    - open .env file in project directory (copy .env.dist and create .env file out of it (in same location) if not exists)
    ( I've left all informations to make it simpler - bad practice )
   
Build and start Docker 

    - go to project directory and run: docker-compose build (if you want to start it with docker) 
    - then run: make-docker up
    
    * Docker is now running
    
You now need to install the project
    
    Enter the docker:
    - docker-compose run php bash
    
    Install the project
    - composer install
    - bin/console doctrine:schema:create
  
    * If you have no error, the project is running on 127.0.0.1 or feeluniquetest.local (add it to your hosts file)
 
Start the fun 
   
    - in a console (in docker) run: bin/console app:write:data
    *this will generate the rates, products and orders
    You now have two orders in you database id:1 and id:2
    
    - go to feeluniquetest.local/[idOfTheOrderYouWant]/show
    * you should see thi information of your order
    
    - at the bottom of the page you can switch currencies.
    
Test, change orders and enjoy :)
Have a wonderful day,
