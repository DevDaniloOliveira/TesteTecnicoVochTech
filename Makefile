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
	@echo "$(GREEN)🚀 Instalação COMPLETA...$(NC)"

	@echo "$(YELLOW)🔧 Configurando permissões Git...$(NC)"
	-git config --global --add safe.directory '$(PWD)'
	
	@echo "$(YELLOW)📁 Configurando ambiente...$(NC)"
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
		echo "$(GREEN)✅ .env criado a partir do .env.example$(NC)"; \
	else \
		echo "$(YELLOW)📄 .env já existe, mantendo...$(NC)"; \
	fi
	
	@echo "$(YELLOW)📦 Verificando Sail...$(NC)"
	@if [ ! -f vendor/bin/sail ]; then \
		echo "$(YELLOW)🔄 Sail não encontrado. Instalando dependências iniciais...$(NC)"; \
		docker run --rm \
			-v ".:/app" \
			-w /app \
			laravelsail/php84-composer:latest \
			composer install --ignore-platform-reqs; \
		echo "$(GREEN)✅ Dependências iniciais instaladas$(NC)"; \
	fi

	@echo "$(YELLOW)🐳 Buildando e subindo containers Docker...$(NC)"
	./vendor/bin/sail build --no-cache
	./vendor/bin/sail up -d
	
	@echo "$(YELLOW)⏳ Aguardando banco de dados...$(NC)"
	@sleep 20
	
	@echo "$(YELLOW)🔑 Configurando aplicação...$(NC)"
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate --seed
	
	@echo "$(YELLOW)🎨 Instalando e buildando frontend...$(NC)"
	./vendor/bin/sail npm install
	./vendor/bin/sail npm run build

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