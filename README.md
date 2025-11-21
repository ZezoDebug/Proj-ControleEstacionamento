# 🚗 Sistema de Estacionamento em PHP — DDD + Camadas + PSR-4

O **Sistema de Estacionamento** é um projeto educacional em PHP projetado para demonstrar boas práticas de **arquitetura limpa**, incluindo **Domain-Driven Design (DDD)**, separação por camadas, **PSR-4**, aplicação de **regras de negócio puras** e persistência configurável (InMemory ou SQLite).

Desenvolvido para rodar em **XAMPP**, usando **Composer** e sem frameworks externos.

---

> [!IMPORTANT]
> 📜 **Licença**
>
> Projeto criado para fins acadêmicos na disciplina de Design Patterns e Clean Code.  
> Livre para adaptar, modificar e evoluir.

---

## 🎯 Objetivos de Aprendizagem

- Modelar regras de negócio reais usando **DDD (Domain-Driven Design)**.  
- Aplicar **SRP** (princípio da responsabilidade única).  
- Organizar o projeto em camadas: `Domain`, `Application`, `Infrastructure`, `Public`.  
- Usar **PSR-4 Autoload** com Composer.  
- Criar serviços de domínio: cálculo de tarifa, duração, registros.  
- Implementar **repositories** com interface + múltiplas implementações.  
- Separar completamente regras de negócio da infraestrutura.

—

## ✨ Funcionalidades

- **Registrar entrada de veículo**
  - Placa, tipo e horário.
  - Validação básica.
  - Armazenamento no repositório escolhido.

- **Registrar saída**
  - Calcula duração.
  - Calcula valor via tabela de tarifas.
  - Atualiza o registro no repositório.

- **Relatório de faturamento**
  - Total por tipo de veículo.
  - Quantidade de entradas.

—

## ⚙️ Como Executar

### Pré-requisitos
- PHP 8+
- XAMPP
- Composer

### Passos

1. Coloque o projeto na pasta `htdocs`:
  - Armazenamento no repositório escolhido.

- **Registrar saída**
  - Calcula duração.
  - Calcula valor via tabela de tarifas.
  - Atualiza o registro no repositório.

- **Relatório de faturamento**
  - Total por tipo de veículo.
  - Quantidade de entradas.
---

## ✔️ Boas Práticas Aplicadas

### **Domínio Puro**
Regras de tarifa, duração e entidade principal isoladas na camada `Domain`.

### **PSR-4 Autoload**
Namespaces organizados e carregamento automático via Composer.

### **Inversão de Dependência**
A aplicação depende **da interface**, não da implementação do repositório.

### **Separação clara por camadas**
- **Domain** → regras de negócio  
- **Application** → casos de uso  
- **Infrastructure** → detalhes técnicos (SQLite)  
- **Public** → ponto de entrada da aplicação  

---

## Informações Adicionais

- **Nome:** Felipe Souza Garcia | **RA:** 1990279 :man_technologist:
- **Nome:** José Vitor de Almeida Lima | **RA:** 1994104 :man_technologist:
- **Nome:** Daniel Victor Costa | **RA:** 1989218 :man_technologist:

### Informações Acadêmicas
- **Universidade:** UNIMAR - Universidade de Marília :school:
- **Curso:** Analise e Desenvolvimento de Sistemas :mortar_board:
- **Disciplina:** Design Patterns e Clean Code :computer:
- **Docente:** Valdir Amancio Pereira Jr. :man_teacher:


