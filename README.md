# 🏢 Sistema de Gestão Econômica

Sistema completo para gestão de grupos econômicos, bandeiras, unidades e colaboradores. Desenvolvido com Laravel, Livewire e Docker.

## ✨ Funcionalidades

- **👥 Gestão Completa**
  - Grupos Econômicos
  - Bandeiras 
  - Unidades
  - Colaboradores

- **📊 Relatórios Avançados**
  - Filtros por hierarquia (Grupo → Bandeira → Unidade)
  - Busca em tempo real
  - Exportação para Excel com filas
  - Estatísticas e métricas

- **🔐 Segurança & Auditoria**
  - Autenticação com Laravel Breeze
  - Sistema de permissões com Spatie
  - Log completo de auditoria
  - Controle de acesso granular

- **🎯 Experiência Moderna**
  - Interface Livewire responsiva
  - Notificações em tempo real
  - Upload com feedback visual
  - Design responsivo

## 🚀 Instalação Rápida

### Pré-requisitos
- Docker e Docker Compose
- Git

### 1. Clone o projeto
```bash
git clone https://github.com/DevDaniloOliveira/TesteTecnicoVochTech.git
cd TesteTecnicoVochTech
```
### 2. Instalação Automática (Recomendado)
```bash
make install
```
## 📋 Comandos Úteis
```bash
make install     #Instala e configura o projeto pela primeira vez
make start       #Inicia os containers
make dev         #Inicia o NPM run dev (Hot Reload)
make build       #inicia o NPM run build (Produção)
make stop        #Para os containers
make restart     #Reinicia os containers
make logs        #Mostra logs dos containers
make test        #Executa os testes
make queue       #Inicia o worker de filas
make fresh       #Recria o banco com dados de teste
make shell       #Acessa o container da aplicação
```
## 👤 Acesso ao Sistema
- Usuário Administrador:
*    Email: admin@adm.com
*    Senha: admadm

## 🏗️ Estrutura do Projeto
    app/
    ├── Livewire/           # Componentes Livewire
    ├── Models/             # Models com auditoria
    ├── Exports/            # Exportações Excel
    ├── Jobs/               # Filas e processos
    └── Rules/              # Validações customizadas

    resources/
    ├── views/livewire/     # Views dos componentes
    └── lang/pt_BR/         # Traduções em português

## 🧪 Testes
```bash
# Executar suite completa de testes
make test

# Testes específicos
./vendor/bin/sail artisan test --filter=EconomicGroupTest
./vendor/bin/sail artisan test --filter=FlagTest
```

## 🔧 Tecnologias Utilizadas
* Backend: Laravel 10+, Livewire 3+, PHP 8.2+

* Frontend: TailwindCSS, Alpine.js, Vite

* Banco: MySQL 8.0

* Cache/Filas: Database

* Container: Docker + Laravel Sail

* Ferramentas: Laravel Excel, Spatie Permissions, Laravel Auditing

## 📊 Funcionalidades Técnicas

    ✅ CRUD Completo - Todas as entidades com validação

    ✅ Relatórios - Filtros hierárquicos e exportação

    ✅ Auditoria - Log completo de todas as ações

    ✅ Filas - Processamento assíncrono para exportação

    ✅ Testes - Suite completa com testes unitários

    ✅ Docker - Ambiente consistente e reproduzível

## 📝 Licença
- Este projeto foi desenvolvido para teste técnico.
