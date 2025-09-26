# API de Gerenciamento de Tarefas
Sistema de gerenciamento de tarefas desenvolvido em Lumen (Laravel) com PostgreSQL e MongoDB, executado em containers Docker.

## Funcionalidades

- CRUD completo de tarefas
- Sistema de logs
- Validação de dados
- Filtros avançados para listagem
- Arquitetura em camadas (Controller, Service, Model, DTO)

## Tecnologias

- **Framework:** Lumen (Laravel)
- **Linguagem:** PHP 8.3
- **Banco Principal:** PostgreSQL 15
- **Banco de Logs:** MongoDB 6
- **Container:** Docker 

## Pré-requisitos
Os pré-requisitos para execução do projeto são:
- PHP +8;
- Docker; (Docker Desktop para Windows)
- Docker Compose;

## Executando o projeto

1. **Clone o repositório:**
```bash
git clone https://github.com/gabrieloliveirapimentel/crud-tasks
cd crud-tasks
```
2. **Execute o Docker:**
```bash
# Linux
sudo systemctl start docker 
sudo systemctl docker.service

# Windows/MAC (Docker Desktop)
# Apenas inicie o Docker Desktop
```

3. **Execute o Docker Compose:**
```bash
docker-compose -f docker-compose.yml up -d
```

4. **Execute as migrações (primeira execução):**
```bash
# Linux
docker-compose exec app bash 

# Windows
docker-compose exec app sh

php artisan migrate
```

5. **Execute os seeders (opcional):**
Já dentro do container é possível rodar os seeds.
```bash
php artisan db:seed
```

## Serviços disponíveis
- **API:** http://localhost:8000
- **PostgreSQL:** localhost:5432
- **MongoDB:** localhost:27017

## Credenciais dos bancos
**PostgreSQL:**
- Database: `postgres_schema`
- User: `root`
- Password: `root123`

**MongoDB:**
- Database: `mongo_schema`
- User: `root`
- Password: `root123`

## Endpoints da API
Os endpoints para se utilizar através do Postman estão no arquivo ``Tarefas.postman_collection``, mas podem ser vistos abaixo:

### **Tasks (Tarefas)**
#### Listar todas as tarefas
```
GET /tasks
```

**Query Parameters (opcionais):**
- `status` - Filtrar por nome do status
- `title` - Filtrar por título
- `date` - Filtrar por data (YYYY-mm-dd)

**Resposta de sucesso:**
```json
{
    "success": true,
    "message": "Tarefas listadas com sucesso!",
    "data": [
        {
            "id": 1,
            "uuid": "4e6f7882-2e25-40c7-9000-fa4def0b62a5",
            "title": "Tarefa",
            "description": "Descrição da tarefa",
            "status": "Concluída",
            "updatedAt": "26-09-2025 18:19:11",
            "createdAt": "26-09-2025 18:19:11"
        },
        {
            "id": 2,
            "uuid": "5d2bfc42-bfbb-4bd6-8a3a-0e2e657b2ff0",
            "title": "Tarefa 2",
            "description": "Descrição da tarefa 2",
            "status": "Finalizada",
            "updatedAt": "26-09-2025 18:19:20",
            "createdAt": "26-09-2025 18:19:20"
        },
        {
            "id": 3,
            "uuid": "9301dc55-333b-4a88-b54d-fb538831175b",
            "title": "Tarefa 3",
            "description": "Descrição da tarefa 3",
            "status": "Finalizada",
            "updatedAt": "26-09-2025 18:19:25",
            "createdAt": "26-09-2025 18:19:25"
        },
    ]
}
```

#### Buscar tarefa por ID
```
GET /tasks/{id}
```

**Resposta de sucesso:**
```json
{
    "success": true,
    "message": "Tarefa encontrada com sucesso!",
    "data": {
        "id": 9,
        "uuid": "ade8c720-2c89-431f-b8b1-99e1c611df98",
        "title": "Tarefa",
        "description": "Descrição da tarefa",
        "status": "Pendente",
        "updatedAt": "26-09-2025 18:20:10",
        "createdAt": "26-09-2025 18:19:38"
    }
}
```

#### Criar nova tarefa
```
POST /tasks
```

**Body (JSON):**
```json
{
    "title": "Tarefa",
    "description": "Descrição da tarefa",
    "status": "Concluída"
}
```

**Resposta de sucesso:**
```json
{
  "success": true,
  "message": "Tarefa criada com sucesso!"
}
```

#### Atualizar tarefa
```
PUT /tasks/{id}
```

**Body (JSON):**
```json
{
    "title": "Tarefa",
    "description": "Descrição da tarefa",
    "status": "Pendente"
}
```

**Resposta de sucesso:**
```json
{
    "success": true,
    "message": "Tarefa atualizada com sucesso!"
}
```

#### Deletar tarefa
```
DELETE /tasks/{id}
```

**Resposta de sucesso:**
```json
{
  "success": true,
  "message": "Tarefa deletada com sucesso!"
}
```

---

### **Status das tarefas**
#### Listar todos os status
```
GET /status
```

**Resposta de sucesso:**
```json
{
    "message": "Status listados com sucesso!",
    "data": [
        {
            "id": 1,
            "uuid": "9bd9f85d-a48a-4807-bc08-fee2c2391450",
            "description": "Concluída",
            "updatedAt": "26-09-2025 16:23:30",
            "createdAt": "25-09-2025 20:59:55"
        }
        {
            "id": 2,
            "uuid": "19721b75-d996-4fc1-80d8-4885690abf56",
            "description": "Concluída",
            "updatedAt": "25-09-2025 20:59:55",
            "createdAt": "25-09-2025 20:59:55"
        },
        {
            "id": 3,
            "uuid": "440d1ede-e813-4492-9a0d-a6c9f9c0b6df",
            "description": "Finalizada",
            "updatedAt": "25-09-2025 20:59:55",
            "createdAt": "25-09-2025 20:59:55"
        },
    ]
}
```

#### Buscar status por ID
```
GET /status/{id}
```

**Resposta de sucesso:**
```json
{
    "message": "Status encontrado com sucesso!",
    "data": {
        "id": 1,
        "uuid": "9bd9f85d-a48a-4807-bc08-fee2c2391450",
        "description": "Em andamento",
        "updatedAt": "25-09-2025 20:59:55",
        "createdAt": "25-09-2025 20:59:55"
    }
}
```

#### Criar novo status
```
POST /status
```

**Body (JSON):**
```json
{
  "description": "Pendente"
}
```

**Resposta de sucesso:**
```json
{
  "message": "Status criado com sucesso!"
}
```

#### Atualizar status
```
PUT /status/{id}
```

**Body (JSON):**
```json
{
  "description": "Concluído"
}
```

**Resposta de sucesso:**
```json
{
  "success": true,
  "message": "Status atualizado com sucesso!"
}
```

#### Deletar status
```
DELETE /status/{id}
```

**Resposta de sucesso:**
```json
{
  "success": true,
  "message": "Status deletado com sucesso!"
}
```

---
### **Logs**
#### Listar todos os logs
```
GET /logs
```

**Query Parameters (opcionais):**
- `_id` - Filtrar por ID do log

**Resposta de sucesso:**
```json
{
    "success": true,
    "message": "Logs listados com sucesso!",
    "data": [
        {
            "id": "2b236d9e-970d-4dc6-8204-f1d4685295fc",
            "action": "DELETE",
            "message": "[26-09-2025 15:21:12] Tarefa 'Tarefa 5' foi deletada",
            "oldData": null,
            "newData": null,
            "createdAt": "2025-09-26T18:21:12.173092Z"
        },
        {
            "id": "ef813b48-9594-4487-82e7-228e99da25e1",
            "action": "GET",
            "message": "[26-09-2025 15:20:26] Tarefa 'Tarefa 5' foi visualizada",
            "oldData": null,
            "newData": null,
            "createdAt": "2025-09-26T18:20:26.906308Z"
        },
        {
            "id": "e7a3fc7c-bde6-426f-85f1-b0cd1d07410d",
            "action": "PUT",
            "message": "[26-09-2025 15:20:10] Tarefa 'Tarefa 5' foi atualizada",
            "oldData": {
                "title": "Tarefa 4",
                "description": "Descrição da tarefa 4",
                "idStatus": 2
            },
            "newData": {
                "title": "Tarefa 5",
                "description": "Descrição da tarefa 5",
                "idStatus": 4
            },
            "createdAt": "2025-09-26T18:20:10.822577Z"
        },
        {
            "id": "14ebb85b-ae84-48cb-856a-5d192eeeffa6",
            "action": "POST",
            "message": "[26-09-2025 15:19:11] Tarefa 'Tarefa' foi criada",
            "oldData": null,
            "newData": null,
            "createdAt": "2025-09-26T18:19:11.210398Z"
        }
    ]
}
```

#### Buscar log por ID
```
GET /logs/{id}
```

**Resposta de sucesso:**
```json
{
    "message": "Log encontrado com sucesso!",
    "data": {
        "id": "824f8fba-a793-4880-a619-5555d5f1defb",
        "action": "POST",
        "message": "[26-09-2025 15:19:20] Tarefa 'Tarefa 2' foi criada",
        "oldData": null,
        "newData": null,
        "createdAt": "2025-09-26T18:19:20.344432Z"
    }
}
```

## Tratamento de Erros
Todas as rotas retornam erros padronizados:

**Erro 500 - Erro interno:**
```json
{
  "success": false,
  "message": "Descrição do erro"
}
```

## Comandos Úteis
### Ver logs da aplicação:
```bash
docker logs app
```

### Parar os containers:
```bash
docker-compose down
```

### Remover containers e volumes:
```bash
docker-compose down -v
```

## Estrutura principal

```
crud-tasks/
├── docker-compose.yml          # Configuração do Docker Compose
├── Dockerfile                  # Configuração da imagem Docker
├── README.md                   # Documentação
└── app/                        # Aplicação Lumen
    ├── app/
    │   ├── Http/Controllers/  # Controllers da API
    │   ├── Services/          # Lógica de negócio
    │   ├── Models/            # Modelos Eloquent
    │   ├── DTO/               # Data Transfer Objects
    │   ├── Validation/        # Validadores
    │   └── Helpers/           # Classes auxiliares
    ├── database/
    │   ├── migrations/        # Migrações do banco
    │   └── seeders/           # Seeders
    ├── routes/
    │   └── web.php            # Definição das rotas
    └── public/
        └── index.php          # Ponto de entrada
```