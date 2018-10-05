# This is a Technical Assessment

This is a drupal site that contains a custom module:
 amazee_assessment


And custom theme:
 amazee


# Requirements

php 7.1

LAMP

drush 9



To get the site working you need to do:

 # Clone the repository

 git clone git@github.com:leydisContre7777/amazee_assessment.git

 # Install all dependencies with composer

 cd drupal
 composer install


 # Create an empty database and import all the configuration files

 Create a sites/default/settings.php file and this line at the end:

 $config_directories['sync'] = '../config/sync';


 create a mysql database

 Import the configuration files using drush

 cd drupal

 drush cim

 drush cr


 # See the application working

 YOUR_DOMAIN/drupal/amazee-example

 In the input you can enter a matemathical expression, for example: 10 + 20 - 30 + 15 * 5

 The application you redirect to show you the result (YOUR_DOMAIN/drupal/amazee-example/result/{result_expression}), which contains some reactjs in the button element.


 #Login into the drupal site and create an article, after the article is been saved you should see
 the title and body field been rendering with graphql code.


 





