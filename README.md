# Português


### Obsevações iniciais
- Foi adicionado três campos referente a rendimento(Não ficou claro ao que "rendimento total" se referia) na tela de simulações.

	Exemplo : Tipo de investimento

	Rentabilidade: 15%
	taxa:5%;

	1. Rendimento cliente = 10%
	2. Rendimento da agência = 5%;
	3. Rendimento Total = 15%

- Lembrando que eu também criei uma versão em Laravel que é o framework que eu mais domino. segue o link https://github.com/zatonsoul/testetbb



# English
### Initial observations
- It was added three fields refering the income (it wasn't clear what the field "rendimento total" meant) in the simulations screen.

	Example: Type of investments
    
    income : 15%, rate : 5%
    
    1. Costumer income = 10%
    2. Agency income = 5%
    3. Total income = 15%
 
 - Remembering that I created one version in Laravel. Laravel is my best framework. Follow the link https://github.com/zatonsoul/testetbb

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-tutorial.localhost
        DocumentRoot /path/to/zf2-tutorial/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/zf2-tutorial/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
