Instruções para executar o software em ambiente local

CONFIGURAÇÃO APLICAÇÃO

1 - Download e instalação do XAMPP 

    https://www.apachefriends.org/xampp-files/7.3.33/xampp-windows-x64-7.3.33-0-VC15-installer.exe

2 - Descompactar o arquivo na pasta htdocs. Por padrão a pasta fica no diretório C:\xampp\htdocs

3 - Executar o XAMPP Control Panel e iniciar o serviço Apache


#CONFIGURAÇÃO BANCO DE DADOS

1 - Download e instalação do SQL Server Express

    https://www.microsoft.com/pt-br/sql-server/sql-server-downloads

2 - Download e instalação do SQL Server Management Studio

    https://docs.microsoft.com/en-us/sql/ssms/download-sql-server-management-studio-ssms?redirectedfrom=MSDN&view=sql-server-ver15

    Clique no link "Free Download for SQL Server Management Studio (SSMS) 18.10"

3 - Após instalação do SSMS, criar um usuário para acesso ao banco de dados

4 - No arquivo "C:\xampp\htdocs\tfg\labsManagement\database\config.php" alterar o 

    DB_HOST para o nome do seu computador\SQLEXPRESS
    DB_USER para "USUÁRIO ESCOLHIDO"
    DB_PASSWORD para "SENHA ESCOLHIDA"

5 - Abrir o  arquivo "C:\xampp\htdocs\tfg\labsManagement\database\BKP_SCHEMA_DATA_TRIGGERS.sql" no SSMS e executar os scripts de criação do banco de dados

6 - Assim que o script de criação do banco finalizar o a aplicação já está disponível para acessar no endereço http://localhost:80

