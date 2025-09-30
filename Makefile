# Makefile para Sistema de Gestão Econômica

# Cores para output
GREEN = \033[0;32m
YELLOW = \033[1;33m
RED = \033[0;31m
NC = \033[0m # No Color

.PHONY: help install start stop restart logs test queue fresh setup

help:
	@echo "$(YELLOW)=== Sistema de Gestão Econômica ===$(NC)"
	@echo ""
	@echo "$(GREEN)Comandos disponíveis:$(NC)"
	@echo "  $(YELLOW)make install$(NC)    - Instala e configura o projeto pela primeira vez"
	@echo "  $(YELLOW)make start$(NC)      - Inicia os containers"
	@echo "  $(YELLOW)make dev$(NC)        - Inicia o NPM run dev (Hot Reload)"
	@echo "  $(YELLOW)make build$(NC)      - inicia o NPM run build (Produção)"
	@echo "  $(YELLOW)make stop$(NC)       - Para os containers"
	@echo "  $(YELLOW)make restart$(NC)    - Reinicia os containers"
	@echo "  $(YELLOW)make logs$(NC)       - Mostra logs dos containers"
	@echo "  $(YELLOW)make test$(NC)       - Executa os testes"
	@echo "  $(YELLOW)make queue$(NC)      - Inicia o worker de filas"
	@echo "  $(YELLOW)make fresh$(NC)      - Recria o banco com dados de teste"
	@echo "  $(YELLOW)make shell$(NC)      - Acessa o container da aplicação"
	@echo ""

install:
	@echo "$(GREEN)🚀 Instalando o projeto...$(NC)"
	cp .env.example .env
	./vendor/bin/sail up -d --build
	@echo "$(YELLOW)⏳ Aguardando MySQL ficar pronto...$(NC)"
	sleep 30
	./vendor/bin/sail composer install
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate --seed
	./vendor/bin/sail npm install
	./vendor/bin/sail npm run dev &
	@echo "$(GREEN)✅ Instalação concluída!$(NC)"
	@echo "$(YELLOW)🌐 Acesse: http://localhost$(NC)"
	@echo "$(YELLOW)👤 Usuário: admin@adm.com$(NC)"
	@echo "$(YELLOW)🔑 Senha: admadm$(NC)"

start:
	@echo "$(GREEN)▶️ Iniciando containers...$(NC)"
	./vendor/bin/sail up -d

stop:
	@echo "$(RED)⏹️ Parando containers...$(NC)"
	./vendor/bin/sail down

restart: stop start
	@echo "$(YELLOW)🔄 Containers reiniciados$(NC)"

dev:
	./vendor/bin/sail npm run dev

build:
	./vendor/bin/sail npm run build

logs:
	./vendor/bin/sail logs -f

test:
	@echo "$(GREEN)🧪 Executando testes...$(NC)"
	./vendor/bin/sail artisan test

queue:
	@echo "$(YELLOW)👷 Iniciando worker de filas...$(NC)"
	./vendor/bin/sail artisan queue:work

fresh:
	@echo "$(YELLOW)🔄 Recriando banco de dados...$(NC)"
	./vendor/bin/sail artisan migrate:fresh --seed
	@echo "$(GREEN)✅ Banco recriado com dados de teste$(NC)"

shell:
	./vendor/bin/sail shell

db:
	./vendor/bin/sail mysql

status:
	@echo "$(YELLOW)📊 Status dos containers:$(NC)"
	./vendor/bin/sail ps

# Comando padrão
default: help