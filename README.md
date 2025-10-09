🚀 Desafio Estágio Contaself - Guia de Instalação
Pré-requisitos
XAMPP ou WAMP

Composer

PHPUnit

Git

Insomnia ou Postman

📥 1. Clonar o Projeto

# Abra o terminal/prompt no diretório do XAMPP (C:\xampp\htdocs\)
git clone https://github.com/Doringgg/desafio_estagio_contaself.git
🗄️ 2. Configurar Banco de Dados
2.1 Iniciar Serviços
Abra o XAMPP Control Panel

Inicie o Apache e MySQL

2.2 Criar Banco de Dados

Execute no seu MySQL o script SQL que está em:
backend/src/docs/database.sql

⚙️ 3. Configurar Ambiente PHP
3.1 Instalar Dependências

# No terminal, na pasta do projeto
cd desafio_estagio_contaself
composer install
composer require --dev phpunit/phpunit
3.2 Configurar Conexão com Banco (Se Necessário)
Caso precise alterar a senha ou porta do MySQL, edite o arquivo:
backend/src/database/Database.php

php
private const HOST = 'localhost';      // ou '127.0.0.1'
private const USER = 'root';           // usuário padrão
private const PASSWORD = '';           // ⚠️ EDITE APENAS SE PRECISAR DE SENHA
private const DATABASE = 'escola';     // nome do banco
private const PORT = 3306;             // ⚠️ EDITE SE SUA PORTA MYSQL FOR DIFERENTE

🌐 4. Configurar Servidor Web
4.1 Estrutura de Pastas
Certifique-se que a pasta desafio_estagio_contaself esteja dentro de C:\xampp\htdocs\:

text
C:\xampp\htdocs\
├── desafio_estagio_contaself\
│   ├── backend/
│   ├── prompts/
│   └── README.MD
└── .htaccess

4.2 Configurar .htaccess
Crie um arquivo .htaccess na raiz do htdocs (C:\xampp\htdocs\.htaccess) com:

RewriteEngine on

# ❌ Bloqueia acesso direto à pasta "api"
# F = Forbidden (403), L = Last (interrompe outras regras)
RewriteRule ^api/ - [F,L]

# ❌ Bloqueia acesso direto à pasta "system"
# F = Forbidden (403), L = Last (interrompe outras regras)
RewriteRule ^system/ - [F,L]

# ✅ Redireciona requisições que não são arquivos nem diretórios para app.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ desafio_estagio_contaself/backend/src/utils/api.php

🚀 5. Testar a Aplicação
Base URL: http://localhost/
📝 Endpoints Disponíveis:

Cursos:

POST /cursos (para adicionar um curso novo)
Content-Type: application/json

{
    "cursos": {
        "nome": "Nome do Curso"
    }
}
exemplo de saída:
{
	"success": true,
	"message": "Curso registrado com sucesso",
	"data": {
		"Curso": {
			"id": 12,
			"nome": "Engenharia Da Computação"
		}
	}
}


GET /cursos (para retornar todos os cursos cadastrados)
exemplo de saída:
{
	"success": true,
	"message": "Dados selecionados com sucesso",
	"data": {
		"Cursos": [
			{
				"id": 3,
				"nome": "Administração"
			},
			{
				"id": 5,
				"nome": "Engenharia Mecânica"
			},
			{
				"id": 4,
				"nome": "Medicina"
			}
		]
	}
}


Alunos:

POST /alunos (para adicionar um aluno novo)
Content-Type: application/json

{
    "alunos": {
        "nome": "Nome do Aluno",
        "idade": 25,
        "curso_id": 1
    }
}
exemplo de saída:
{
	"success": true,
	"message": "Aluno registrado com sucesso",
	"data": {
		"Aluno": {
			"id": 18,
			"nome": "Vitor Doring",
			"idade": 22,
			"curso_id": 2,
			"curso_nome": "Ciência da Computação"
		}
	}
}

GET /alunos (para retornar todos os alunos com seus devidos cursos)
exemplo de saída:
{
	"success": true,
	"message": "Dados selecionados com sucesso",
	"data": {
		"Alunos": [
			{
				"id": 14,
				"nome": "Sara Quintanilha",
				"idade": 18,
				"curso_id": 2,
				"curso_nome": "Ciência da Computação"
			},
			{
				"id": 15,
				"nome": "Thiago Diniz",
				"idade": 18,
				"curso_id": 3,
				"curso_nome": "Engenharia da Computação"
			},
			{
				"id": 16,
				"nome": "Vítor Doring",
				"idade": 18,
				"curso_id": 4,
				"curso_nome": "Análise e Desenvolvimento de Sistemas"
			}
		]
	}
}

GET /alunos/1 (Buscar alunos por ID do curso)
exemplo de saída:
{
	"success": true,
	"message": "Dados selecionados com sucesso",
	"data": {
		"Alunos": [
			{
				"id": 2,
				"nome": "Maria Santos",
				"idade": 22,
				"curso_id": 2,
				"curso_nome": "Ciência da Computação"
			},
			{
				"id": 5,
				"nome": "Carlos Lima",
				"idade": 23,
				"curso_id": 2,
				"curso_nome": "Ciência da Computação"
			}
		]
	}
}

GET /alunos/Programação (Buscar alunos por nome do curso)
exemplo de saída:
{
    {
	"success": true,
	"message": "Dados selecionados com sucesso",
	"data": {
		"Alunos": [
			{
				"id": 8,
				"nome": "Vitor Doring",
				"idade": 18,
				"curso_id": 5,
				"curso_nome": "Engenharia Mecânica"
			},
			{
				"id": 9,
				"nome": "Pedro Daniel",
				"idade": 18,
				"curso_id": 5,
				"curso_nome": "Engenharia Mecânica"
			}
		]
	}
}
}

Relatório

GET /relatorio (Para retornar o número de alunos por curso e a média de idade deles)
exemplo de saída:
{
	"success": true,
	"message": "Relatório gerado com sucesso",
	"data": [
		{
			"nome_curso": "Ciência da Computação",
			"total_alunos": 5,
			"media_idade": "27"
		},
        {
			"nome_curso": "ADS",
			"total_alunos": 3,
			"media_idade": "22"
		}
	]
}

Mapa de Uso de IA no Projeto
📊 Resumo de Contribuições da IA
1. Estrutura do Banco de Dados
Prompt: Criação do schema MySQL com duas tabelas

Contribuição: Código SQL completo com tabelas cursos e alunos

Adaptações:

Ajuste de tamanho dos campos VARCHAR

Remoção de timestamps

Chave estrangeira curso_id como NOT NULL

Validação: Execução no MySQL + análise de modelagem

2. Modelagem de Classes (OOP)
Prompts 1 & 2: Getters e Setters para modelos Aluno e Curso

Contribuição: Implementação completa dos métodos de acesso

Adaptações:

Retorno self nos setters

Adição de return $this para method chaining

Validação: Comparação com projetos anteriores + análise de sintaxe

3. Validações e Expressões Regulares
Prompt 3: Regex para nomes de cursos

Contribuição: Expressão regular abrangente

Adaptações: Nenhuma - solução pronta para uso

Validação: Testes em ambientes isolados

4. Consultas e Relatórios
Prompt 4: Query MySQL para relatório de alunos por curso

Contribuição: Consulta com JOIN, COUNT e AVG

Adaptações: Ajuste na formatação da saída

Validação: Execução direta no MySQL + integração na API

5. Validações de Negócio em PHP
Prompt 5: Middleware de validação seguindo padrão do projeto

Contribuição: Código completo com estrutura definida

Adaptações: Personalização de mensagens de erro

Validação: Testes em ambiente isolado + integração na API + testes

Validações Realizadas:
🧪 Testes unitários em ambiente isolado

🔍 Análise comparativa com código existente

🗄️ Execução prática no MySQL

🌐 Integração progressiva na API

📈 Impacto no Desenvolvimento
A IA atuou como assistente técnico especializado, fornecendo:

Aceleração em tarefas repetitivas (getters/setters)

Expertise em domínios específicos (SQL, regex)

Padronização seguindo melhores práticas

Documentação implícita através de código limpo

Resultado: Desenvolvimento mais rápido mantendo qualidade e padrões de código.