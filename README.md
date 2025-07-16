# Fornecedor API

API RESTful para gerenciamento de fornecedores (CRUD + consulta via CNPJ). Desenvolvida com [Laravel](https://laravel.com/).

---

## 🚀 Como executar o projeto

### 1. Clonar o repositório

```bash
git clone https://github.com/seu-usuario/fornecedor-api.git
cd fornecedor-api
```

### 2. Instalar dependências

```bash
composer install
```

### 3. Configurar ambiente

Copie o arquivo `.env.example` e configure suas variáveis:

```bash
cp .env.example .env
```

Atualize as credenciais do banco de dados no arquivo `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fornecedor_api
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Gerar a chave da aplicação

```bash
php artisan key:generate
```

### 5. Rodar as migrações

```bash
php artisan migrate
```

### 6. Rodar o servidor local

```bash
php artisan serve
```

A aplicação estará disponível em `http://localhost:8000`.

---

## 🧪 Endpoints disponíveis

> Prefixo: `/api`

### 🔍 `GET /busca-cnpj/{cnpj}`

Consulta dados públicos do CNPJ usando a [BrasilAPI](https://brasilapi.com.br/).

---

### ➕ `POST /fornecedor`

Cria um novo fornecedor.

**Payload:**

```json
{
    "tipo_documento": "CPF", // ou "CNPJ"
    "documento": "12345678900",
    "nome_fantasia": "Empresa XPTO",
    "razao_social": "XPTO LTDA",
    "email": "contato@empresa.com",
    "telefone": "11999999999",
    "endereco": "Rua Exemplo, 123"
}
```

---

### 📄 `GET /fornecedores`

Lista fornecedores com paginação e filtros opcionais:

**Query params disponíveis:**

-   `nome_fantasia`
-   `razao_social`
-   `documento`
-   `tipo_documento`
-   `order_by`: `nome_fantasia`, `razao_social`, `documento`, `created_at`
-   `per_page`: quantidade por página

---

### 📂 `GET /fornecedor/{id}`

Exibe um fornecedor pelo UUID.

---

### ✏️ `PUT /fornecedor/{id}`

Atualiza os dados de um fornecedor (exceto `documento` e `tipo_documento`).

**Payload semelhante ao POST.**

---

### ❌ `DELETE /fornecedor/{id}`

Remove o fornecedor.

---

## ✅ Requisitos

-   PHP 8.4.10
-   Composer
-   MySQL
-   Laravel 9.52.20

---

## 📌 Observações

-   Os documentos (CPF/CNPJ) são validados conforme o tipo informado.
-   Os campos `documento` e `tipo_documento` não podem ser alterados após a criação.
-   IDs são gerados como UUIDs.
