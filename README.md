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

### Como instalar
- Instale o Composer
- Clone o repositório em um servidor php (Wamp ou Xamp).
- Vá até a pasta do reposotório e execute o comando ```$ composer update ```
- Vá até ```config/autoload``` Altere as informações de conexão com o banco de dados dentro do arquivo ```doctrine_orm.local_example.php``` e altere seu nome para ```doctrine_orm.local.php```, removendo o ```_example```
- Volte até a raiz e importe no seu banco de dados o arquivo ```testetbb.sql```
- acesse ```path/name-project/public``` ou crie um virtual host apontando para a pasta public do projeto

# English
### Initial observations
- It was added three fields refering the income (it wasn't clear what the field "rendimento total" meant) in the simulations screen.

	Example: Type of investments
    
    income : 15%, rate : 5%
    
    1. Costumer income = 10%
    2. Agency income = 5%
    3. Total income = 15%
 
 - Remembering that I created one version in Laravel. Laravel is my best framework. Follow the link https://github.com/zatonsoul/testetbb

### How to install
- Install the composer.
- Clone the repository in one php server (Wamp or Xamp).
- Go to the repository folder and run ```$ composer update ```
- Go to folder ```config/autoload``` and change the connection data in archive ```doctrine_orm.local_example.php``` after change the file name for ```doctrine_orm.local.php```, removing the ```_example```
- Back to root folder and import in your database the archive ```testetbb.sql```
- Go to ```localhost/name-project/public``` in your browser or create one virtual host target for public folder of the project
